<?php

namespace Modules\Foundation\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Foundation\Entities\School;
use Modules\Foundation\Entities\Student;
use Modules\Foundation\Entities\Performance;

class PerformanceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $performances = Performance::with('student')->get();
        $students = Student::all();
        return view('foundation::performances.index', compact('performances', 'students'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $students = Student::all();
        return view('foundation::performances.create', compact('students'));        
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'year' => 'required|in:1,2,3,4',
            'term' => 'required|in:1,2,3',
            'mid_mean_score' => 'nullable|numeric|min:0|max:100',
            'mid_term_grade' => 'nullable|string',
            'mid_term_position_number' => 'nullable|numeric',
            'mid_term_position_total' => 'nullable|numeric',
            'end_term_mean_score' => 'nullable|numeric|min:0|max:100',
            'end_term_grade' => 'nullable|string',
            'end_term_position_number' => 'nullable|numeric',
            'end_term_position_total' => 'nullable|numeric',
        ]);
    
        $mid_term_position = $request->mid_term_position_number . ' out of ' . $request->mid_term_position_total;
        $end_term_position = $request->end_term_position_number . ' out of ' . $request->end_term_position_total;
    
        Performance::create([
            'student_id' => $request->student_id,
            'year' => $request->year,
            'term' => $request->term,
            'mid_term_grade' => $request->mid_term_grade,
            'mid_mean_score' => $request->mid_mean_score,
            'mid_term_position' => $mid_term_position,
            'end_term_grade' => $request->end_term_grade,
            'end_term_mean_score' => $request->end_term_mean_score,
            'end_term_position' => $end_term_position,
        ]);

        return redirect()->route('performances.index')->with('success', 'Performance record created successfully.');
    
    }

    public function display()
    {
        $performances = Performance::with('student.school')->get();
        return view('foundation::performances.display', compact('performances'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('foundation::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('foundation::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Performance $performance)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'year' => 'required|in:1,2,3,4',
            'term' => 'required|in:1,2,3',
            'mid_mean_score' => 'nullable|numeric|min:0|max:100',
            'mid_term_grade' => 'nullable|string',
            'mid_term_position_number' => 'nullable|numeric',
            'mid_term_position_total' => 'nullable|numeric',
            'end_term_mean_score' => 'nullable|numeric|min:0|max:100',
            'end_term_grade' => 'nullable|string|max:10',
            'end_term_position_number' => 'nullable|numeric',
            'end_term_position_total' => 'nullable|numeric',
        ]);
    
        $mid_term_position = $request->mid_term_position_number . ' out of ' . $request->mid_term_position_total;
        $end_term_position = $request->end_term_position_number . ' out of ' . $request->end_term_position_total;
    
        $performance->update([
            'student_id' => $request->student_id,
            'year' => $request->year,
            'term' => $request->term,
            'mid_mean_score' => $request->mid_mean_score,
            'mid_term_grade' => $request->mid_term_grade,
            'mid_term_position' => $mid_term_position,
            'end_term_mean_score' => $request->end_term_mean_score,
            'end_term_grade' => $request->end_term_grade,
            'end_term_position' => $end_term_position,
        ]);

        return redirect()->route('performances.index')->with('success', 'Performance record updated successfully.');
   
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
