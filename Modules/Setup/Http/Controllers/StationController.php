<?php

namespace Modules\Setup\Http\Controllers;

use Modules\Setup\Entities\Dealer;
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
        $dealers = Dealer::all();
        $users = User::all();
        $managers = StationManager::all();

        return view('setup::stations.index', compact('stations', 'dealers', 'users', 'managers'));
   
    }

    public function create()
    {
        $dealers = Dealer::where('active', true)->get();
        $managers = StationManager::where('is_active', true)->get();
        $tmRoleId = Role::where('name', 'Territory Manager (TM)')->value('id');

        // Get users with the role ID of "Territory Manager (TM)"
        $territoryManagers = User::whereHas('roles', function ($query) use ($tmRoleId) {
            $query->where('role_id', $tmRoleId);
        })->get();      

        return view('setup::stations.create', compact('dealers', 'territoryManagers', 'managers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'dealer_id' => 'required|exists:dealers,id',
            'territory_manager_id' => 'nullable|exists:users,id',
            'manager_id' => 'nullable|exists:station_managers,id'
        ]);

        $station = new Station();
        $station->name = $request->name;
        $station->location = $request->location;
        $station->dealer_id = $request->dealer_id;
        $station->territory_manager_id = $request->territory_manager_id;
        $station->station_manager_id = $request->manager_id;
        $station->created_by = auth()->id(); 
        $station->updated_by = auth()->id(); 
        $station->save();

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
            'dealer_id' => 'required|exists:dealers,id',
            'territory_manager_id' => 'nullable|exists:users,id',
            'station_manager_id' => 'nullable|exists:station_managers,id'
        ]);

        $station->update([
            'name' => $request->name,
            'location' => $request->location,
            'dealer_id' => $request->dealer_id,
            'territory_manager_id' => $request->territory_manager_id,
            'station_manager_id' => $request->station_manager_id,
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
