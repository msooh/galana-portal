<?php

namespace Modules\Setup\Http\Controllers;

use Modules\Setup\Entities\StationManager;
use Modules\Setup\Entities\Station;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Support\Facades\Hash;

class StationManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stationManagers = User::whereHas('roles', function($query) {
            $query->where('name', 'Station Manager');
        })->get();

        $stations = Station::all();
        //$stationManagers = StationManager::all();
        return view('setup::station_managers.index', compact('stationManagers', 'stations'));
    }

    public function assignStation(Request $request, $managerId)
    {
        $request->validate([
            'station_id' => 'required|exists:stations,id',
        ]);

        $stationManager = User::findOrFail($managerId);

        // Attach the station to the manager with the 'Station Manager' role
        $stationManager->stations()->attach($request->station_id);

        return redirect()->route('station_managers.index')
            ->with('success', 'Station assigned successfully');
    }

    //If Manager is assigned a particular station, then reassign station

    public function reassignStation(Request $request, $id)
    {
        $manager = User::findOrFail($id);
        $newStationId = $request->input('station_id');

        // Update the station assignment
        $manager->managedStations()->sync([$newStationId]);

        return redirect()->route('station_managers.index')->with('success', 'Station reassigned successfully.');
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('setup::station_managers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|string|max:20',
            'password' => 'required|string|min:8',           
        ]);

        // Create the new user
        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->phone_number = $validatedData['phone_number'];
        $user->password = Hash::make($validatedData['password']);
        // Save the dealer
        $user->save();      
        
        // Assign 'Station Manager' role to the user
        $dealerRole = Role::where('name', 'Station Manager')->first();
        if ($dealerRole) {
            $user->roles()->attach($dealerRole->id);
        }
    

        return redirect()->route('station_managers.index')
            ->with('success', 'Station Manager created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StationManager  $stationManager
     * @return \Illuminate\Http\Response
     */
    public function show(StationManager $stationManager)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StationManager  $stationManager
     * @return \Illuminate\Http\Response
     */
    public function edit(StationManager $stationManager)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StationManager  $stationManager
     * @return \Illuminate\Http\Response
     */    

    public function update(Request $request, $id)
    {
        // Find the station manager with the given ID
        $stationManager = User::findOrFail($id);

        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ]);

        // Update the station manager information based on the request data
        $stationManager->update([
            'name' => $request->name,
            'phone_number' => $request->phone,
            'email' => $request->email,
            'updated_by' => auth()->id(),
        ]);

        // Redirect back to the station manager list or desired location
        return redirect()->route('station_managers.index')->with('success', 'Station Manager updated successfully');
        
    }

    public function deactivate($id)
    {
        $stationManager = User::findOrFail($id);
        $stationManager->is_active = false;
        $stationManager->save();

        return redirect()->route('station_managers.index')->with('success', 'Station Manager deactivated successfully');
    }


    public function activate($id)
    {
        $stationManager = User::findOrFail($id);
        $stationManager->is_active = true;
        $stationManager->save();
        
        return redirect()->route('station_managers.index')->with('success', 'Station Manager activated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StationManager  $stationManager
     * @return \Illuminate\Http\Response
     */
    public function destroy(StationManager $stationManager)
    {
        /*$stationManager->delete();

        return redirect()->route('station_managers.index')
            ->with('success', 'Station Manager deleted successfully.');*/
    }
}
