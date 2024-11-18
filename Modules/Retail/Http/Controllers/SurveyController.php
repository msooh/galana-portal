<?php

namespace Modules\Retail\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\SurveyReportMail; 
use Stevebauman\Location\Facades\Location;
use Modules\Retail\Entities\Survey;
use Modules\Retail\Entities\Subcategory;
use Modules\Retail\Entities\Category;
use Modules\Retail\Entities\Response;
use Modules\Retail\Entities\Checklist;
use Modules\Setup\Entities\Station;
use Modules\Retail\Entities\Signature;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;
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
        // Fetch surveys and their related data
        $surveys = Survey::with(['station', 'creator', 'approver', 'responses.checklistItem.subcategory.category'])
            ->latest()
            ->get();
            

        // Fetch categories and subcategories
        $categories = Category::with('subcategories.checklists')->get();

        // Define subcategories as a flat list or however you need them
        $subcategories = Subcategory::with('checklists')->get(); // Adjust based on your structure

        return view('retail::surveys.index', [
            'surveys' => $surveys,
            'categories' => $categories,
            'subcategories' => $subcategories
        ]);
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
                'responses.*.weight' => 'nullable|numeric|in:1,2,3',
                'responses.*.file' => 'nullable|file|image|max:4096',           
                'role' => 'required|string|in:Dealer,Station Manager',
                'signature_image' => 'required|string',
                'comment' => 'nullable|string|max:1000',           
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
            ]);
    
            // Create a new Survey
            $survey = new Survey([
                'date' => now()->toDateString(),
                'time' => now()->toTimeString(),
                'station_id' => $validatedData['station_id'],
                'created_by' => auth()->user()->id,
                'latitude' => $validatedData['latitude'],
                'longitude' => $validatedData['longitude'],
            ]);
            $survey->save();
    
            // Initialize survey type
            $surveyType = 'Unknown';
    
            // Iterate through responses and save them
            foreach ($validatedData['responses'] as $checklistItemId => $response) {
                $checklistItem = Checklist::find($checklistItemId);
    
                if ($checklistItem) {
                    $subcategory = $checklistItem->subcategory;
                    $category = $subcategory ? $subcategory->category : null;
    
                    if ($category) {
                        $surveyType = $category->name; // Set survey type based on the category name
                    }
                }
    
                $newResponse = new Response([
                    'checklist_item_id' => $checklistItemId,
                    'survey_id' => $survey->id,
                    'response' => $response['response'],
                    'comment' => $response['comment'] ?? null,
                    'weight' => $response['weight'] ?? null,
                ]);
    
                if ($attachment = $request->file('responses.' . $checklistItemId . '.file')) {
                    $publicPath = $attachment->move(public_path('attachments'), $attachment->getClientOriginalName());
                    $newResponse->file_path = 'attachments/' . $attachment->getClientOriginalName();
                }          
    
                $newResponse->save();
            }
    
            // Save Signature in public/signatures directory
            $signatureImage = $validatedData['signature_image'];
            $data = base64_decode(substr($signatureImage, strpos($signatureImage, ',') + 1));
            $filename = uniqid() . '.png';
            $signaturePath = public_path('signatures/' . $filename);
            file_put_contents($signaturePath, $data);
    
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
    
            // Fetch dealer emails      
             $dealerEmail = User::where('id', function ($query) use ($validatedData) {
                $query->select('dealer_id')
                    ->from('stations')
                    ->where('id', $validatedData['station_id']);
            })->pluck('email')->first();
            
             $stationEmail = Station::where('id', $validatedData['station_id'])->pluck('email')->first();
         

             $territoryManagerEmail = User::where('id', function ($query) use ($validatedData) {
                $query->select('territory_manager_id')
                    ->from('stations')
                    ->where('id', $validatedData['station_id']);
            })->pluck('email')->first();
            
            // Recipient Email
            $emails = collect([$stationEmail]);
    
            if ($emails->isEmpty()) {
                throw new \Exception('No valid recipients found for the survey report.');
            }
    
            $surveyDetails = [
                'type' => $surveyType,
                'total_marks' => $totalMarks,
                'surveyor' => auth()->user()->name,
                'file_name' => 'survey-report.pdf',
            ];
    
            $url = route('home');

            // Generate PDF for the survey report
            $pdf = Pdf::loadView('emails.survey.pdf', compact('survey', 'surveyDetails')); 
            $pdfContent = $pdf->output();
    
            // Send email to dealer and retail manager           
            Mail::to($emails)->cc([$territoryManagerEmail, $dealerEmail])->send(new SurveyReportMail($surveyDetails, $url, $pdfContent));
            // Return success message
            return redirect()->route('surveys.index')->with('success', 'Survey submitted successfully!');
            } catch (\Exception $e) {
                \Log::error('Survey submission failed: ' . $e->getMessage());
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
