<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         
        $this->authorize('Manage Users');
        $roles = Role::all();
        $users = User::all();
        return view('users.index', compact('roles', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $this->authorize('Manage Users');
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('Manage Users');
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|string',
            'password' => 'required|string|min:8',
            'role' => 'required|exists:roles,id', // Ensure the selected role exists in the roles table
        ]);

        // Create the new user
        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->phone_number = $validatedData['phone_number'];
        $user->password = Hash::make($validatedData['password']);
        $user->save();

        // Assign the role to the user
        $role = Role::findOrFail($validatedData['role']); // Find the role by ID
        $user->roles()->attach($role); // Attach the role to the user


        // Redirect back or wherever you want after successful creation
        return redirect()->route('users.index')->with('success', 'User created successfully.');
   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('Manage Users');
        $user = User::findOrFail($id);

        $request->validate([
            'edit_name' => 'required|string|max:255',
            'edit_email' => 'required|email|unique:users,email,'.$user->id,
            'edit_phone' => 'required|string|max:255',
            'edit_role' => 'required|exists:roles,id',
            'edit_password' => 'nullable|string|min:8', // Optional password field
        ]);

        $user->name = $request->edit_name;
        $user->email = $request->edit_email;
        $user->phone_number = $request->edit_phone;
        
        // Update password if provided
        if ($request->edit_password) {
            $user->password = Hash::make($request->edit_password);
        }
        
        // Sync user roles
        $user->roles()->sync([$request->edit_role]);

        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('Manage Users');
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');

    }

    public function deactivate($id)
    {
        $this->authorize('Manage Users');
        $user = User::findOrFail($id);

        $user->is_active = false;
        $user->save();

        return redirect()->route('users.index')->with('success', 'User deactivated successfully.');

    }

    public function activate($id)
    {
        $this->authorize('Manage Users');
        $user = User::findOrFail($id);

        $user->is_active = true;
        $user->save();

        return redirect()->route('users.index')->with('success', 'User activated successfully.');
    }

}
