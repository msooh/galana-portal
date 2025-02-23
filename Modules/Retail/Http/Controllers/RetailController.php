<?php

namespace Modules\Retail\Http\Controllers;

use Modules\Retail\Entities\Survey;
use App\Models\User;
use App\Models\Role;
use Modules\Setup\Entities\Station;
use Modules\Retail\Entities\Category;
use Modules\Setup\Entities\Dealer;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class RetailController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function calculateDashboardData()
    {
        // Get the TM role ID
        $tmRoleId = Role::where('name', 'Territory Manager (TM)')->value('id');

        // Get the current month
        $currentMonth = date('m');

        // Count Territory Managers for the current month
        $currentMonthTMs = User::whereHas('roles', function ($query) {
            $query->where('name', 'Territory Manager (TM)');
        })->whereMonth('created_at', $currentMonth)->count();
        $tmsCount = User::whereHas('roles', function($query) {
            $query->where('name', 'Territory Manager (TM)');
        })->count();
        $tmPercentageChange = $tmsCount > 0 ? ($currentMonthTMs / $tmsCount) * 100 : 0;


        // Calculate other values
        $surveyCount = Survey::count();
        $stationsCount = Station::count();
        $dealersCount =  User::whereHas('roles', function($query) {
            $query->where('name', 'Dealer');
        })->count();
        

        // Calculate visits and visit rate
        $expectedVisits = 2 * $stationsCount; // Assuming 2 visits per station per month
        $visits = Survey::whereMonth('created_at', '=', $currentMonth)->count();
        $visitsPercentage = $expectedVisits > 0 ? ($visits / $expectedVisits) * 100 : 0;
        $visitRatePercentage = $expectedVisits > 0 ? ($visits / $expectedVisits) * 100 : 0;

        // Calculate percentages for new stations, dealers, and users
        $newStations = Station::whereMonth('created_at', '=', $currentMonth)->count();
        $newStationsPercentage = $stationsCount > 0 ? ($newStations / $stationsCount) * 100 : 0;

        $dealers = User::whereHas('roles', function($query) {
            $query->where('name', 'Dealer');
        })->whereMonth('created_at', '=', $currentMonth)->count();
        $dealersPercentage = $dealersCount > 0 ? ($dealers / $dealersCount) * 100 : 0;

        $newUsers = User::whereMonth('created_at', '=', $currentMonth)->count();
        $newUsersPercentage = $newUsers > 0 ? ($newUsers / User::count()) * 100 : 0;

        return [
            'territoryManagersCount' => $tmsCount,
            'tmPercentageChange' => $tmPercentageChange,
            'surveyCount' => $surveyCount,
            'stationsCount' => $stationsCount,
            'dealersCount' => $dealersCount,
            'visits' => $visits,
            'visitsPercentage' => $visitsPercentage,
            'newStations' => $newStations,
            'newStationsPercentage' => $newStationsPercentage,
            'dealers' => $dealers,
            'dealersPercentage' => $dealersPercentage,
            'newUsers' => $newUsers,
            'newUsersPercentage' => $newUsersPercentage,
            'visitRatePercentage' => $visitRatePercentage,
        ];
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
   
    public function index()
    {
        $surveyCounts = [];
        for ($month = 1; $month <= 12; $month++) {
            $surveyCounts[date('F', mktime(0, 0, 0, $month, 1))] = Survey::whereMonth('created_at', $month)->count();
        }

        $dailySurveyReports = Survey::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy(DB::raw('DATE(created_at)')) 
            ->pluck('count', 'date')
            ->toArray();
        $monthlySurveyReports = Survey::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();
        $yearlySurveyReports = Survey::selectRaw('YEAR(created_at) as year, COUNT(*) as count')
            ->groupBy('year')
            ->pluck('count', 'year')
            ->toArray();
        $categories = Category::all();
        $dashboardData = $this->calculateDashboardData();

        $tmVisits = Survey::select('created_by')
            ->with('creator') 
            ->selectRaw('count(*) as total_visits')
            ->groupBy('created_by')
            ->get();

        
        $labels = $tmVisits->map(function ($visit) {
            return $visit->creator ? $visit->creator->name : 'Unknown';
        });
    
        $data = $tmVisits->pluck('total_visits');
    
           
        $surveyUserData = [
            'labels' => $labels,
            'data' => $data,
        ];
    

        return view('retail::dashboard', compact('dashboardData', 'surveyCounts', 'categories', 'surveyUserData', 'dailySurveyReports', 'monthlySurveyReports', 'yearlySurveyReports'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('retail::create');
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
