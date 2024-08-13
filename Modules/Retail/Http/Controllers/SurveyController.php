<?php

namespace Modules\Retail\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Stevebauman\Location\Facades\Location;
use Modules\Retail\Entities\Survey;
use Modules\Retail\Entities\Subcategory;
use Modules\Retail\Entities\Category;
use Modules\Retail\Entities\Response;
use Modules\Retail\Entities\Checklist;
use Modules\Setup\Entities\Station;
use Modules\Retail\Entities\Signature;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Storage;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $surveys = Survey::with('station', 'signatures')->latest()->get();
        $categories = Category::all();
        $subcategories = Subcategory::all();

        return view('retail::surveys.index', compact('surveys', 'categories', 'subcategories'));
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    
    public function create($categoryId)
    {
        $categories = Category::all();
        $category = Category::findOrFail($categoryId);
        $category = Category::with('subcategories.checklists')->findOrFail($categoryId);

        $user = Auth::user();
        
        if ($user->hasRole('Admin') || $user->hasRole('Retail Manager')) {
            // Show all stations for admin and retail manager
            $stations = Station::all();
        } elseif ($user->hasRole('Territory Manager (TM)')) {
            // Show only stations associated with the current user for territory manager
            $stations = $user->stations; 
        } else {
            // Handle other roles or show an empty list
            $stations = collect(); // Empty collection for other roles
        }
       
      
        return view('retail::surveys.checklist', compact('category', 'categories', 'stations'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            // Validate the form data
            $validatedData = $request->validate([
                'station_id' => 'required|exists:stations,id',
                'responses.*.response' => 'required|string',
                'responses.*.comment' => 'nullable|string',
                'attachments.*' => 'nullable|file|image|max:4096',
                'role' => 'required|string|in:Dealer,Station Manager',
                'signature_image' => 'required|string',
                'comment' => 'nullable|string|max:1000',
                'weight' => 'nullable|numeric',
            ]);

            // Get IP and location data
            $ip = $request->ip();
            $location = Location::get($ip);

            // Create a new Survey
            $survey = new Survey([
                'date' => now()->toDateString(),
                'time' => now()->toTimeString(),
                'station_id' => $validatedData['station_id'],
                'created_by' => auth()->user()->id,
                'latitude' => optional($location)->latitude,
                'longitude' => optional($location)->longitude,
            ]);
            $survey->save();

            // Iterate through responses and save them
            foreach ($validatedData['responses'] as $checklistItemId => $response) {
                $newResponse = new Response([
                    'checklist_item_id' => $checklistItemId,
                    'survey_id' => $survey->id,
                    'response' => $response['response'],
                    'comment' => $response['comment'] ?? null,
                ]);

                // Handle file attachment
                if ($attachment = $request->file('attachments.' . $checklistItemId)) {
                    $publicPath = $attachment->store('attachments', 'public');
                    $newResponse->file_path = $publicPath;
                }

                $newResponse->save();
            }

            // Save Signature
            $signatureImage = $validatedData['signature_image'];
            $data = base64_decode(substr($signatureImage, strpos($signatureImage, ',') + 1));
            $filename = uniqid() . '.png';
            Storage::disk('public')->put('signatures/' . $filename, $data);

            $signature = new Signature([
                'survey_id' => $survey->id,
                'role' => $validatedData['role'],
                'signature_image' => 'signatures/' . $filename,
            ]);
            $signature->save();

            // Save optional comment
            if (!empty($validatedData['comment'])) {
                $survey->update(['comment' => $validatedData['comment']]);
            }

            // Calculate total marks
            $totalYes = count(array_filter($validatedData['responses'], fn($response) => $response['response'] === 'Yes'));
            $totalNo = count(array_filter($validatedData['responses'], fn($response) => $response['response'] === 'No'));
            $totalMarks = ($totalYes + $totalNo) ? ($totalYes / ($totalYes + $totalNo)) * 100 : 0;

            $survey->update(['total_marks' => $totalMarks]);

            // Return success message
            return redirect()->back()->with('success', 'Survey submitted successfully!');
        } catch (\Exception $e) {
            // Return error message
            return redirect()->back()->with('error', 'An error occurred while submitting the survey: ' . $e->getMessage());
        }
    }


    public function approve(Request $request, Survey $survey)
    {
        $survey->status = 'approved';
        $survey->approved_by = auth()->user()->id;
        $survey->approved_at = now();
        $survey->save();

        return redirect()->back()->with('success', 'Survey approved successfully.');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
       // return view('retail::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        //return view('retail::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
