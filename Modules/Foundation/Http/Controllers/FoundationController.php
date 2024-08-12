<?php

namespace Modules\Foundation\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Foundation\Entities\School;
use Modules\Foundation\Entities\Student;
use Modules\Foundation\Entities\Performance;

class FoundationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        // Count of Schools
        $totalSchools = School::count();
        
        // Count of Students
        $totalStudents = Student::count();
        
        // Average Scores of Students
        $averageMidTermScore = Performance::average('mid_mean_score');
        $averageEndTermScore = Performance::average('end_term_mean_score');
        
        // Top Performing School
        $topSchool = School::with(['students.performances'])
            ->get()
            ->sortByDesc(function ($school) {
                $totalScores = $school->students->flatMap(function ($student) {
                    return $student->performances;
                })->pluck('end_term_mean_score');
                return $totalScores->avg();
            })->first();
        $topPerformingSchool = $topSchool ? $topSchool->name : 'N/A';
        $topPerformingSchoolPercentage = $topSchool ? ($topSchool->students->flatMap(function ($student) {
            return $student->performances;
        })->pluck('end_term_mean_score')->avg() / 100) * 100 : 0;
        
        // Additional Data
        $percentageIncrease = $totalStudents ? ($totalStudents / $totalStudents * 100) : 0;
        $percentageChange = $averageEndTermScore ? ($averageEndTermScore / 100 * 100) : 0;
        
        return view('foundation::dashboard', compact(
            'totalSchools',
            'totalStudents',
            'averageMidTermScore',
            'averageEndTermScore',
            'topPerformingSchool',
            'topPerformingSchoolPercentage',
            'percentageIncrease',
            'percentageChange'
        ));
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('foundation::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
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
