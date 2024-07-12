<?php

namespace Modules\Setup\Http\Controllers;

use Modules\Setup\Entities\Company;
use Modules\Setup\Entities\Station;
use Modules\Setup\Entities\StationManager;
use Illuminate\Routing\Controller;
use App\Models\Role;
use App\Models\User;

use Illuminate\Http\Request;

class StationController extends Controller
{
    public function index(Request $request)
    {   
        $stations = Station::all();
        $dealers = User::whereHas('roles', function($query) {
            $query->where('name', 'Dealer');
        })->get();
        $users = User::all();
        $managers = User::whereHas('roles', function($query) {
            $query->where('name', 'Station Manager');
        })->get();
        $tms = User::whereHas('roles', function($query) {
            $query->where('name', 'Territory Manager (TM)');
        })->get();

        $companies = Company::all();

        return view('setup::stations.index', compact('stations', 'dealers', 'users', 'companies', 'managers', 'tms'));
   
    }

    public function create()
    {
        if (!auth()->user()->hasRole('Admin')) {
            abort(403, 'Unauthorized action.');
        }
    
        // Fetch necessary data for station creation form
        $dealers = User::whereHas('roles', function ($query) {
            $query->where('name', 'Dealer')->where('is_active', true);
        })->get();
    
        $territoryManagers = User::whereHas('roles', function ($query) {
            $query->where('name', 'Territory Manager (TM)');
        })->get();
    
        $managers = User::whereHas('roles', function ($query) {
            $query->where('name', 'Station Manager');
        })->get();

        $companies = Company::all();

        return view('setup::stations.create', compact('dealers', 'territoryManagers', 'managers', 'companies'));
    }

    public function store(Request $request)
    {
        // Ensure only admin can access this function
        if (!auth()->user()->hasRole('Admin')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'long' => 'nullable|numeric',
            'lat' => 'nullable|numeric',
            'dealer_id' => 'nullable|exists:users,id',
            'territory_manager_id' => 'nullable|exists:users,id',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'till_number' => 'nullable|string|max:20',
            'company_id' => 'nullable|exists:companies,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'is_active' => 'required|boolean',
        ]);
    
        Station::create($request->all());        

        return redirect()->route('stations.index')
            ->with('success', 'Station created successfully.');
    }

    public function show(Request $request)
    {   
        $stations = Station::all();

        return view('setup::stations.index', compact('stations'));
   
    }

    public function edit(Station $station)
    {
        return view('setup::stations.edit', compact('station'));
    }

    public function update(Request $request, Station $station)
    {        
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'dealer_id' => 'required|exists:users,id',
            'territory_manager_id' => 'nullable|exists:users,id',
            'station_manager_id' => 'nullable|exists:users,id',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'till_number' => 'nullable|string|max:20',
            'company_id' => 'nullable|exists:companies,id',
            'long' => 'nullable|numeric',
            'lat' => 'nullable|numeric',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);
    
        $station->update([
            'name' => $request->name,
            'location' => $request->location,
            'dealer_id' => $request->dealer_id,
            'territory_manager_id' => $request->territory_manager_id,
            'station_manager_id' => $request->station_manager_id,
            'email' => $request->email,
            'phone' => $request->phone,
            'till_number' => $request->till_number,
            'company_id' => $request->company_id,
            'long' => $request->long,
            'lat' => $request->lat,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'updated_by' => auth()->user()->id,
        ]);

        return redirect()->route('stations.index')
            ->with('success', 'Station updated successfully');
    }

    public function destroy(Station $station)
    {
        $station->delete();

        return redirect()->route('stations.index')
            ->with('success', 'Station deleted successfully');
    }

}
