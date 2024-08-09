<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('Manage Users');
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();

        $permissionGroups = [
            'Dashboard' => $permissions->filter(function ($permission) {
                return $permission->group === 'Dashboard';
            }),
            'User Management' => $permissions->filter(function ($permission) {
                return $permission->group === 'User Management';
            }),
            'Retail Module' => $permissions->filter(function ($permission) {
                return $permission->group === 'Retail Module';
            }),
            // Add more groups as needed
        ];
        return view('permissions.index', compact('roles', 'permissions', 'permissionGroups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('Manage Users');
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        $permissionGroups = Permission::all()->groupBy('group');
        $assignedPermissions = collect();

        // If a role is selected, fetch its permissions
        if ($request->has('role_id')) {
            $role = Role::find($request->input('role_id'));
            if ($role) {
                $assignedPermissions = $role->permissions->pluck('id');
            }
        }
        return view('permissions.create', compact('roles', 'permissions', 'permissionGroups', 'assignedPermissions'));
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
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'group' => 'required|string|max:255',
        ]);

        $permission = new Permission();
        $permission->name = $request->input('name');
        $permission->group = $request->input('group');
        $permission->save();

        return redirect()->back()->with('success', 'Permission created successfully!');
    }

    public function assign(Request $request)
    {
        $this->authorize('Manage Users');
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::find($request->input('role_id'));

        if ($role) {
            // Sync the permissions for the role
            $role->permissions()->sync($request->input('permissions', []));
            return redirect()->back()->with('success', 'Permissions assigned successfully!');
        }

        return redirect()->back()->with('error', 'Role not found!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        //
    }
}
