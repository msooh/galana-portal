<?php

namespace Modules\HSSEQ\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

use Modules\HSSEQ\Entities\Safety;
use Modules\HSSEQ\Entities\AccidentType;

class HSSEQController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    
    public function index()
    {
        $totalReports = Safety::count();
        $completedTasks = Safety::where('status', 'Closed')->count();
        $pendingTasks = Safety::where('status', 'pending')->count();
        $inProgressTasks = Safety::where('status', 'In-Progress')->count();
        $highRiskReports = Safety::join('accident_types', 'safeties.accident_type_id', '=', 'accident_types.id')
        ->where('accident_types.rating', 'High')
        ->count();

        $mediumRiskReports = Safety::join('accident_types', 'safeties.accident_type_id', '=', 'accident_types.id')
                ->where('accident_types.rating', 'Medium')
                ->count();

        $lowRiskReports = Safety::join('accident_types', 'safeties.accident_type_id', '=', 'accident_types.id')
            ->where('accident_types.rating', 'Low')
            ->count();

        // Calculate percentages
        $highRiskPercentage = ($highRiskReports / $totalReports) * 100;
        $mediumRiskPercentage = ($mediumRiskReports / $totalReports) * 100;
        $lowRiskPercentage = ($lowRiskReports / $totalReports) * 100;
        $pendingPercentage = ($pendingTasks / $totalReports) * 100;
        $completedPercentage = ($completedTasks / $totalReports) * 100;

         // Daily Reports
        $dailyReports = DB::table('safeties')
            ->select(DB::raw('DATE(date) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw('DATE(date)'))
            ->orderBy(DB::raw('DATE(date)'))
            ->pluck('count', 'date');

        // Monthly Reports
        $monthlyReports = DB::table('safeties')
            ->select(DB::raw('DATE_FORMAT(date, "%Y-%m") as month'), DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw('DATE_FORMAT(date, "%Y-%m")'))
            ->orderBy(DB::raw('DATE_FORMAT(date, "%Y-%m")'))
            ->pluck('count', 'month');

        // Yearly Reports
        $yearlyReports = DB::table('safeties')
            ->select(DB::raw('YEAR(date) as year'), DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw('YEAR(date)'))
            ->orderBy(DB::raw('YEAR(date)'))
            ->pluck('count', 'year');

        return view('hsseq::dashboard', compact('totalReports', 'highRiskReports', 'mediumRiskReports', 
        'lowRiskReports', 'highRiskPercentage', 'mediumRiskPercentage', 'lowRiskPercentage', 
        'inProgressTasks', 'pendingTasks', 'pendingPercentage', 'completedTasks', 'completedPercentage',
        'dailyReports', 'monthlyReports', 'yearlyReports'));    

    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('hsseq::create');
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
        return view('hsseq::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('hsseq::edit');
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
