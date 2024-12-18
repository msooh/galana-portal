<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
     /**
     * Show the form to create a new role.
     */
    public function create()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('roles.create', compact('roles', 'permissions')); 
    }

    /**
     * Store a newly created role in the database.
     */
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'name' => 'required|string|unique:roles,name|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        // Create role
        Role::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        // Redirect with success message
        return redirect()->back()->with('success', 'Role created successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required|unique:roles,name,' . $id]);

        $role = Role::findOrFail($id);
        $role->update(['name' => $request->name]);

        return redirect()->route('roles.create')->with('success', 'Role updated successfully.');
    }

    public function destroy()
    {
       //
    }
}
