<?php

namespace Modules\Retail\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Retail\Entities\Survey;
use Modules\Retail\Entities\Subcategory;
use Modules\Retail\Entities\Category;
use Modules\Retail\Entities\Response;
use Modules\Retail\Entities\Checklist;
use Modules\Setup\Entities\Station;
use Modules\Retail\Entities\Signature;

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
    public function create()
    {
        $categoryId = 1;
        $category = Category::with('subcategories.checklists')->findOrFail($categoryId);
        $stations = Station::all();
      
        return view('retail::surveys.checklist', compact('category', 'stations'));
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
                'responses.*' => 'required|in:Yes,No,N/A',
                'attachments.*' => 'nullable|file|image|max:4096', // 2MB max for images
                'role' => 'required|string|in:Dealer,Station Manager',                
                'signature_image' => 'required',// 2MB max for signature images
                'comment' => 'nullable|string|max:1000',
            ]);
    
            // Create a new Survey
            $survey = new Survey();
            $survey->date = now()->toDateString(); // Save current date
            $survey->time = now()->toTimeString(); // Save current time
            $survey->station_id = $validatedData['station_id'];
            $survey->created_by = auth()->user()->id;
            $survey->save();
    
            $surveyId = $survey->id;
    
            // Iterate through responses and save them
            foreach ($validatedData['responses'] as $index => $response) {
                $checklistItemId = $index; // Use $index directly as it corresponds to the checklist item ID
    
                // Handle file upload for each response if needed
                $attachment = $request->file('attachments.' . $index);
    
                // Save the response
                $newResponse = new Response();
                $newResponse->checklist_item_id = $checklistItemId;
                $newResponse->survey_id = $surveyId;
                $newResponse->response = $response;
    
                // If there's an attachment, handle it
                if ($attachment) {
                    // Save attachment to public storage
                    $attachmentPath = $attachment->store('public/attachments');
                    // Get the path without the 'public/' prefix
                    $publicPath = str_replace('public/', '', $attachmentPath);
                    $newResponse->file_path = $publicPath;
                }   
                
                $newResponse->save();
            }
    
            $signature = new Signature();
            $signature->survey_id = $surveyId;
            $signature->role = $validatedData['role'];   
    
            $signatureImage = $validatedData['signature_image'];
    
            // Extract base64 image data
            $data = substr($signatureImage, strpos($signatureImage, ',') + 1);
    
            // Decode base64 data
            $decodedImage = base64_decode($data);
    
            // Generate a unique filename
            $filename = uniqid() . '.png'; 
    
            // Save the decoded image data to storage in public folder
            Storage::disk('public')->put('signatures/' . $filename, $decodedImage);
    
            // Set the path to the saved image
            $signature->signature_image = 'signatures/' . $filename;
    
            $signature->save();            
    
            // Save comment if provided
            if (isset($validatedData['comment'])) {
                $survey->comment = $validatedData['comment'];
                $survey->save();
            }
    
            // Optionally, calculate total marks
            $totalYes = count(array_filter($validatedData['responses'], function ($response) {
                return $response === 'Yes';
            }));
            $totalNo = count(array_filter($validatedData['responses'], function ($response) {
                return $response === 'No';
            }));
            $totalMarks = ($totalYes / ($totalYes + $totalNo)) * 100;
    
            // Update the survey with total marks
            $survey->total_marks = $totalMarks;
            $survey->save();
    
            // Return success message
            return redirect()->back()->with('success', 'Survey submitted successfully!');
        } catch (Exception $e) {
            // Return error message
            return redirect()->back()->with('error', 'An error occurred while submitting the survey.');
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
        return view('retail::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('retail::edit');
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
