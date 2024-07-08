<?php

namespace Modules\Setup\Http\Controllers;

use Modules\Setup\Entities\StationManager;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Role;
use App\Models\User;

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
        //$stationManagers = StationManager::all();
        return view('setup::station_managers.index', compact('stationManagers'));
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
        /*$validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ]);

        $validatedData['created_by'] = auth()->id();        

        StationManager::create($validatedData);

        return redirect()->route('station_managers.index')
            ->with('success', 'Station Manager created successfully.');*/
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
