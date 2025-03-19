<?php

namespace Modules\Retail\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Carbon\Carbon;

use Illuminate\Support\Facades\Session;
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
use Modules\Retail\Entities\TemporarySurvey;
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
        $surveys = Survey::with([
            'station:id,name',
            'creator:id,name',
            'approver:id,name',
            'responses' => function ($query) {
                $query->select('id', 'survey_id', 'checklist_item_id');
            },
            'responses.checklistItem:id,sub_category_id',
            'responses.checklistItem.subcategory:id,category_id',
            'responses.checklistItem.subcategory.category:id,name'
        ])
        ->select('id', 'station_id', 'created_by', 'approved_by', 'date', 'time', 'total_marks', 'status', 'comment')
        ->latest()
        ->paginate(20); // Paginate with 20 records per page

        // Fetch categories and subcategories separately to avoid redundant loading
        $categories = Category::with('subcategories:id,category_id')->select('id', 'name')->get();
        $subcategories = Subcategory::with('checklists:id,sub_category_id,name')->select('id', 'category_id', 'name')->get();

        return view('retail::surveys.index', compact('surveys', 'categories', 'subcategories'));

    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    
    public function create($categoryId)
    {
        $categories = Category::all();
        $category = Category::with('subcategories.checklists')->findOrFail($categoryId);
        $user = Auth::user();        
        
        // Fetch stations based on user role
        $stations = match (true) {
            $user->hasRole(['Admin', 'Retail Manager', 'Team Coach', 'Head of Retail']) => Station::all(),
            $user->hasRole('Territory Manager (TM)') => $user->stations,
            default => collect(),
        };
        // Retrieve saved survey responses from the database
        $savedSurvey = TemporarySurvey::where('user_id', $user->id)
            ->where('category_id', $categoryId)
            ->latest()
            ->first();

        // Decode responses
        $savedResponses = $savedSurvey ? json_decode($savedSurvey->responses, true) : [];  
        
            return view('retail::surveys.checklist', compact('category', 'categories', 'stations', 'categoryId', 'savedResponses', 'savedSurvey'));
    }

    public function saveOrSubmit(Request $request)
    {

        try {
            $action = $request->input('action');
            \Log::info("Action received: $action");

            if ($action === 'save') {
                return $this->saveTemporaryResponses($request);
            } elseif ($action === 'submit') {
                return $this->store($request);
            }

            \Log::warning('Invalid action received', ['action' => $action]);
            return back()->withErrors(['error' => 'Invalid action']);
        } catch (\Exception $e) {
            \Log::error('Error in saveOrSubmit action: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'An error occurred while processing your request. Please try again later.'
            ], 500);
        }
    }



    /**
     * Auto Save Responses
     * Temporary save responses to the temporary_surveys
     * */
    // Auto-save survey responses to TemporarySurvey table
    public function saveTemporaryResponses(Request $request)
    {
        \Log::info('Inside saveTemporaryResponses method');
        \Log::info('Received request data:', $request->all());
        try {
            // Validate the incoming request data
            $request->validate([
                'station_id'    => 'nullable|exists:stations,id', 
                'category_name' => 'required|string|exists:categories,name',
                'category_id'   => 'required|exists:categories,id', 
                'responses'     => 'required|array', 
                'responses.*.file'=> 'nullable|file|mimes:jpeg,png,jpg,gif,svg',
                'latitude'      => 'nullable|numeric', 
                'longitude'     => 'nullable|numeric', 
                'signature_image' => 'nullable|string', 
                'role'           => 'nullable|string', 
                'comment'        => 'nullable|string', 
            ]);

            // Get the station and category from the database
            $station = Station::find($request->input('station_id'));
            $category = Category::where('name', $request->input('category_name'))->first();
            if (!$category) {
                \Log::error('Category not found: ' . $request->input('category_name'));
                return response()->json(['error' => 'Invalid category'], 400);
            }

            // Retrieve responses from input
            $responses = $request->input('responses', []);

            // Process file uploads inside responses, if any
            if ($request->hasFile('responses')) {
                foreach ($request->file('responses') as $itemId => $fileData) {
                    if (isset($fileData['file']) && $fileData['file']->isValid()) {
                        // Store the file in the "attachments" directory within the public disk
                        $path = $fileData['file']->store('attachments', 'public');
                        // Save the file path in the responses array
                        $responses[$itemId]['file'] = $path;
                    }
                }
            }

            // Prepare the data for saving
            $data = [
                'user_id'         => Auth::check() ? Auth::id() : null, 
                'responses'       => json_encode($responses), 
                'category_id'     => $category->id, 
                'station_id'      => $request->input('station_id'), 
                'latitude'        => $request->input('latitude'), 
                'longitude'       => $request->input('longitude'), 
                'signature_image' => $request->input('signature_image') ?? null,
                'role'            => $request->input('role') ?? null, 
                'comment'         => $request->input('comment') ?? null, 
            ];
            \Log::info('Data to save:', $data);

            // Update or create a temporary survey record for the user and category
            TemporarySurvey::updateOrCreate(
                [
                    'user_id'     => Auth::check() ? Auth::id() : null, 
                    'category_id' => $category->id ?? null, 
                ],
                $data // The data to be saved
            );
            \Log::info('Survey responses saved successfully');

            return response()->json(['success' => true, 'message' => 'Survey responses saved successfully!']);
    } catch (\Exception $e) {
        // Log the exception for debugging purposes
        \Log::error('Error saving temporary responses: ' . $e->getMessage());

        // Return a user-friendly error response
        return response()->json(['error' => 'An error occurred while saving your survey responses. Please try again later.'], 500);
    }
    }

    public function incompleteSurvey()
    {
        // Retrieve all incomplete surveys for the logged-in user
        $surveys = TemporarySurvey::where('user_id', Auth::id())
                    ->with(['category', 'station']) 
                    ->latest()
                    ->get(); 

        // Retrieve all categories
        $categories = Category::all();

        return view('retail::surveys.incomplete', compact('surveys', 'categories'));
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    protected function createSurvey(array $data)
    {
        try {
            \Log::info('Creating survey', $data);
            return Survey::create([
                'date' => now()->toDateString(),
                'time' => now()->toTimeString(),
                'station_id' => $data['station_id'],
                'created_by' => auth()->id(),
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
            ]);
        } catch (\Exception $e) {
            \Log::error('Error creating survey: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'data' => $data
            ]);
            return response()->json(['error' => 'Failed to create survey.'], 500);
        }
    }

    protected function saveResponses(Survey $survey, array $responses, Request $request)
    {
        foreach ($responses as $index => $response) { 
            $checklistItemId = $response['checklist_item_id'] ?? $index; 

            if (!$checklistItemId) {
                \Log::error("Missing checklist_item_id for response index: $index");
                continue; 
            }

            $checklistItem = Checklist::find($checklistItemId);
            if (!$checklistItem) {
                \Log::error("Checklist item not found for ID: $checklistItemId");
                continue;
            }

            $newResponse = new Response([
                'checklist_item_id' => $checklistItemId,
                'survey_id' => $survey->id,
                'response' => $response['response'],
                'comment' => $response['comment'] ?? null,
                'weight' => $response['weight'] ?? null,
            ]);

            // Ensure files are saved properly
            if ($request->hasFile("responses.$index.file")) {
                $attachment = $request->file("responses.$index.file");
                $fileName = time() . '_' . $attachment->getClientOriginalName();
                $attachment->move(public_path('attachments'), $fileName);
                $newResponse->file_path = 'attachments/' . $fileName;
            }

            $newResponse->save();
            \Log::info("Response saved for checklist_item_id: $checklistItemId, survey_id: {$survey->id}");
        }
    }

    protected function saveSignature(Survey $survey, string $signatureImage, string $role)
    {
        $data = base64_decode(substr($signatureImage, strpos($signatureImage, ',') + 1));
        $filename = uniqid() . '.png';
        $signaturePath = public_path('signatures/' . $filename);
        file_put_contents($signaturePath, $data);

        Signature::create([
            'survey_id' => $survey->id,
            'role' => $role,
            'signature_image' => 'signatures/' . $filename,
        ]);
    }
    protected function sendSurveyReport(Survey $survey, string $surveyType, float $totalMarks)
    {

        $emails = $this->getRecipientEmails($survey->station_id);
        //$emails = collect(['faith.muthoni@galanaenergies.com']);

        if ($emails->isEmpty()) {
            throw new \Exception('No valid recipients found for the survey report.');
        }

        $surveyDetails = [
            'type' => $surveyType,
            'station_name' => $survey->station->name ?? 'Unknown Station',
            'total_marks' => $totalMarks,
            'surveyor' => auth()->user()->name,
            'file_name' => 'survey-report.pdf',
        ];

        $url = route('home');
        try {
            $pdf = Pdf::loadView('emails.survey.pdf', compact('survey', 'surveyDetails'));
            $pdfContent = $pdf->output();
            \Log::info('PDF Generated: ' . (strlen($pdfContent) > 0 ? 'Yes' : 'No'));
        } catch (\Exception $e) {
            \Log::error('PDF Generation Failed: ' . $e->getMessage());
            dd('PDF Error:', $e->getMessage());
        }       
        
        // ✅ Ensure Directory Exists
        $pdfDir = storage_path('app/survey-reports');
        if (!file_exists($pdfDir)) {
            mkdir($pdfDir, 0777, true);
        }

        // Save PDF File
        $pdfPath = $pdfDir . '/survey-report.pdf';
        file_put_contents($pdfPath, $pdfContent);

        // Confirm File is Saved
        if (!file_exists($pdfPath)) {
            \Log::error('PDF file was NOT saved at: ' . $pdfPath);
        } else {
            \Log::info('PDF saved successfully at: ' . $pdfPath);
        }

        Mail::to($emails)->cc([
            'john.muchunu@galanaenergies.com',
            'faith.muthoni@galanaenergies.com',
            'julius.peter@galanaenergies.com',
        ])->send(new SurveyReportMail($surveyDetails, $url, $pdfContent));
    }

    protected function getRecipientEmails($stationId)
    {
        $dealerEmail = User::where('id', function ($query) use ($stationId) {
            $query->select('dealer_id')->from('stations')->where('id', $stationId);
        })->pluck('email')->first();

        $stationEmail = Station::where('id', $stationId)->pluck('email')->first();

        $territoryManagerEmail = User::where('id', function ($query) use ($stationId) {
            $query->select('territory_manager_id')->from('stations')->where('id', $stationId);
        })->pluck('email')->first();

        return collect([$stationEmail, $dealerEmail, $territoryManagerEmail])->filter();
    }
    public function store(Request $request)
    {   
        try {
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
           
            // Create survey
            $survey = $this->createSurvey($validatedData);

            // Save responses
            $this->saveResponses($survey, $validatedData['responses'], $request);

            // Save signature
            $this->saveSignature($survey, $validatedData['signature_image'], $validatedData['role']);

            // Save optional comment
            if (!empty($validatedData['comment'])) {
                $survey->update(['comment' => $validatedData['comment']]);
            }

            // Calculate total marks
            $totalYes = count(array_filter($validatedData['responses'], fn($response) => $response['response'] === 'Yes'));
            $totalNo = count(array_filter($validatedData['responses'], fn($response) => $response['response'] === 'No'));
            $totalMarks = ($totalYes + $totalNo) ? ($totalYes / ($totalYes + $totalNo)) * 100 : 0;
            $survey->update(['total_marks' => $totalMarks]);

            // Delete the incomplete survey records for the user and category
            TemporarySurvey::where('user_id', Auth::id())
            ->where('category_id', $request->input('category_id'))
            ->delete();

            \Log::info("Deleted incomplete surveys for user_id: " . Auth::id() . ", category_id: " . $request->input('category_id'));


            // Send survey report
            $this->sendSurveyReport($survey, $this->getSurveyType($validatedData['responses']), $totalMarks);

            return redirect()->route('surveys.index')->with('success', 'Survey submitted successfully!');
        } catch (\Exception $e) {            
            \Log::error('Survey submission failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while submitting the survey: ' . $e->getMessage());
        }
    }

    protected function getSurveyType(array $responses)
    {
        foreach ($responses as $checklistItemId => $response) {
            $checklistItem = Checklist::find($checklistItemId);
            if ($checklistItem && $checklistItem->subcategory && $checklistItem->subcategory->category) {
                return $checklistItem->subcategory->category->name;
            }
        }
        return 'Unknown';
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
        $survey = Survey::with('responses')->findOrFail($survey_id);
        $category = Category::with('subcategories.checklists')->find($survey->category_id);
        $stations = Station::all();
        
        // Retrieve responses indexed by checklist item ID
        $savedResponses = $survey->responses->keyBy('checklist_id');
        //return view('retail::edit', compact('survey', 'category', 'stations', 'savedResponses'));
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
