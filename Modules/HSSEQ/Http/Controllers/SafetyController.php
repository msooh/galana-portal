<?php

namespace Modules\HSSEQ\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

use Modules\Setup\Entities\Station;
use Modules\Setup\Entities\StationManager;
use Modules\HSSEQ\Entities\Safety;
use Modules\Setup\Entities\Department;
use Modules\HSSEQ\Entities\AccidentType;
use App\Models\User;

use Illuminate\Http\Request;

class SafetyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        if ($user->hasRole('Admin')) {
            // Admin can see all safety reports, ordered by descending date
            $safetyReports = Safety::orderBy('created_at', 'desc')->get();
        } elseif ($user->hasRole('Station Manager')) {
            // Station Manager can only see reports for their stations, ordered by descending date
            $safetyReports = Safety::whereHas('station', function ($query) use ($user) {
                $query->whereHas('managers', function ($subQuery) use ($user) {
                    $subQuery->join('user_roles', 'users.id', '=', 'user_roles.user_id')
                             ->join('roles', 'user_roles.role_id', '=', 'roles.id')
                             ->where('users.id', $user->id)
                             ->where('roles.name', 'Station Manager');
                });
            })->orderBy('created_at', 'desc')->get();
            
        } else {
            // Default case: no safety reports
            $safetyReports = collect();
        }
        
        $departments = Department::all();
        
        $usersByDepartment = User::whereHas('departments', function($query) use ($departments) {
            $query->whereIn('department_id', $departments->pluck('id'));
        })->get()->groupBy('departments.0.id')->toArray();

       

        return view('hsseq::hsseq.index', compact('safetyReports', 'departments', 'usersByDepartment'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user();
    
        if ($user->hasRole(['Hsseq', 'admin', 'Retail Manager'])) {
            // These roles can see all stations
            $stations = Station::all();
        } else {
            // Station Managers and Dealers can only see their own stations
            $stations = Station::where(function($query) use ($user) {
                if ($user->hasRole('Station Manager')) {
                    $query->whereHas('managers', function($q) use ($user) {
                        $q->where('users.id', $user->id);
                    });
                }
                if ($user->hasRole('Dealer')) {
                    $query->orWhere('dealer_id', $user->id);
                }
            })->get();
        }
    
        $managers = User::whereHas('roles', function($query) {
            $query->where('name', 'Station Manager');
        })->get();
        $accidents = AccidentType::all();
        return view('hsseq::hsseq.create', compact('stations','managers', 'accidents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all(), $request->file('police_file'));
        $request->validate([
            'type' => 'required|in:Accident,Incident',
            'station_id' => 'required|exists:stations,id',
            'date' => 'required|date',
            'time' => 'required',
            'comment' => 'required',
            'action' => 'required',
            'accident_type_id' => 'required',
            'slightly_injured' => 'nullable|integer',
            'injured_medical_treatment' => 'nullable|integer',
            'injured_hospitalization' => 'nullable|integer',
            'fatalities' => 'nullable|integer',
            'other_details' => 'nullable',
            'police_report' => 'required',
            'police_file' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:4096',
        ]);
    
        // Create a new Safety instance
        $safety = new Safety([
            'type' => $request->type,
            'station_id' => $request->station_id,
            'date' => $request->date,
            'time' => $request->time,
            'comment' => $request->comment,
            'action' => $request->action,
            'accident_type_id' => $request->accident_type_id,
            'slightly_injured' => $request->slightly_injured,
            'injured_medical_treatment' => $request->injured_medical_treatment,
            'injured_hospitalization' => $request->injured_hospitalization,
            'fatalities' => $request->fatalities,
            'other_details' => $request->other_details,
            'police_report' => $request->police_report,
            'created_by' => auth()->user()->id,
        ]);
    
        // Handle police file attachment
        if ($request->hasFile('police_file')) {
            $policeFile = $request->file('police_file');
            $fileName = time() . '_' . $policeFile->getClientOriginalName();
            $filePath = $policeFile->storeAs('police_files', $fileName, 'public');
            $safety->police_file = $filePath;   
                      
        }
    
        // Save the safety report
        $safety->save();   
       
    
        return redirect()->back()->with('success', 'Safety report created successfully.');
    }


    public function assignTask(Request $request, Safety $report)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'user_id' => 'required|exists:users,id',
        ]);
    
        
        $report->assigned_to = $request->user_id;
        $report->assigned_at = now();
        $report->status = 'In-Progress';
        $report->updated_by = auth()->user()->id;
        $report->save();
        return redirect()->back()->with('success', 'Task assigned successfully.');
    }



    public function pendingSafeties()
    {        
        $userId = Auth::id();
        
        $pendingTasks = Safety::where('status', 'In-Progress')
            ->where('assigned_to', $userId)
            ->get();

        return view('hsseq::tasks.pending_tasks', compact('pendingTasks'));
    }

    public function closeTask(Request $request, $id)
    {
        $request->validate([
            'notes' => 'required|string',
        ]);

        $safety = Safety::findOrFail($id);

        $safety->status = 'Closed';
        $safety->notes = $request->notes;
        $safety->save();

        return redirect()->back()->with('success', 'Task closed successfully.');
    }

    public function closedTasks()
    {
        $closedTasks = Safety::where('assigned_to', auth()->id())
                            ->where('status', 'Closed')
                            ->orderBy('updated_at', 'desc')
                            ->get();

        return view('hsseq::tasks.completed_tasks', compact('closedTasks'));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Safety  $safety
     * @return \Illuminate\Http\Response
     */
    public function show(Safety $safety)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Safety  $safety
     * @return \Illuminate\Http\Response
     */
    public function edit(Safety $safety)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Safety  $safety
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Safety $safety)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Safety  $safety
     * @return \Illuminate\Http\Response
     */
    public function destroy(Safety $safety)
    {
        //
    }
}
