<?php

namespace Modules\Setup\Http\Controllers;

use Modules\Setup\Entities\Station;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Support\Facades\Hash;

class TerritoryManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $territoryManagers = User::whereHas('roles', function($query) {
            $query->where('name', 'Territory Manager (TM)');
        })->get();

        $stations = Station::all();
       
        return view('setup::territory_managers.index', compact('territoryManagers', 'stations'));
    }

    public function assignStation(Request $request, $managerId)
    {
        $request->validate([
            'station_ids' => 'required|array',
            'station_ids.*' => 'exists:stations,id',
        ]);

        $territoryManager = User::findOrFail($managerId);

        // Attach multiple stations to the manager
        $territoryManager->stations()->attach($request->station_ids);

        return redirect()->route('territory_managers.index')
            ->with('success', 'Stations assigned successfully');
    }

    //If Manager is assigned a particular station, then reassign station

    public function reassignStation(Request $request, $managerId)
    {
        $request->validate([
            'station_ids' => 'required|array',
            'station_ids.*' => 'exists:stations,id',
        ]);

        $territoryManager = User::findOrFail($managerId);

        // Update station assignments
        $territoryManager->stations()->sync($request->station_ids);

        return redirect()->route('territory_managers.index')
            ->with('success', 'Stations reassigned successfully.');
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('setup::territory_managers.create');
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
        // Save the TM
        $user->save();      
        
        // Assign 'Territory Manager' role to the user
        $managerRole = Role::where('name', 'Territory Manager (TM)')->first();
        if ($managerRole) {
            $user->roles()->attach($managerRole->id);
        }
    

        return redirect()->route('territory_managers.index')
            ->with('success', 'Territory Manager created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $territoryManager)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StationManager  $stationManager
     * @return \Illuminate\Http\Response
     */
    public function edit(User $territoryManager)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */    

    public function update(Request $request, $id)
    {
        // Find the Territory manager with the given ID
        $territoryManager = User::findOrFail($id);

        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ]);

        // Update the territory manager information based on the request data
        $territoryManager->update([
            'name' => $request->name,
            'phone_number' => $request->phone,
            'email' => $request->email,
            'updated_by' => auth()->id(),
        ]);

        // Redirect back to the territory manager list or desired location
        return redirect()->route('territory_managers.index')->with('success', 'Territory Manager updated successfully');
        
    }

    public function deactivate($id)
    {
        $territoryManager = User::findOrFail($id);
        $territoryManager->is_active = false;
        $territoryManager->save();

        return redirect()->route('territory_managers.index')->with('success', 'Territory Manager deactivated successfully');
    }


    public function activate($id)
    {
        $territoryManager = User::findOrFail($id);
        $territoryManager->is_active = true;
        $territoryManager->save();
        
        return redirect()->route('territory_managers.index')->with('success', 'Territory Manager activated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TerritoryManager  $territoryManager
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $territoryManager)
    {
        /*$territoryManager->delete();

        return redirect()->route('territory_managers.index')
            ->with('success', 'Territory Manager deleted successfully.');*/
    }
}
