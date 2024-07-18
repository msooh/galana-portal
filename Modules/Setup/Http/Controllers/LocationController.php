<?php

namespace Modules\Setup\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Setup\Entities\Location;
use Modules\Setup\Entities\Station;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $locations = Location::all();
        return view('setup::locations.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('setup::locations.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location_details' => 'required|string',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        Location::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'location_details' => $request->location_details,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        return redirect()->route('locations.index')->with('success', 'Location added successfully.');
  
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('setup::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('setup::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Location $location)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location_details' => 'required|string',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $location->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'location_details' => $request->location_details,
            'updated_by' => auth()->id(),
        ]);

        return redirect()->route('locations.index')->with('success', 'Location updated successfully.');
   
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $location->delete();
        return redirect()->route('setup.locations.index')->with('success', 'Location deleted successfully.');
    
    }
}
