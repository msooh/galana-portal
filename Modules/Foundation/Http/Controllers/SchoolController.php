<?php

namespace Modules\Foundation\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Foundation\Entities\School;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $schools = School::all(); 
        return view('foundation::schools.index', compact('schools'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('foundation::schools.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:schools',
            'location' => 'nullable|string|max:255',
        ]);
    
        // Create a new school
        School::create([
            'name' => $request->input('name'),
            'location' => $request->input('location'),
        ]);
    
        // Redirect to the index with a success message
        return redirect()->route('schools.index')->with('success', 'School created successfully.');
    
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        //return view('foundation::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        //return view('foundation::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:schools,name,' . $id,
            'location' => 'nullable|string|max:255',
        ]);
    
        // Find the school and update it
        $school = School::findOrFail($id);
        $school->update([
            'name' => $request->input('name'),
            'location' => $request->input('location'),
        ]);
    
        // Redirect to the index with a success message
        return redirect()->route('schools.index')->with('success', 'School updated successfully.');
    
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $school = School::findOrFail($id); // Find the school by ID or throw a 404 error
        $school->delete();
    
        // Redirect to the index with a success message
        return redirect()->route('schools.index')->with('success', 'School deleted successfully.');
    
    }
}
