<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    // Display a listing of the permissions
    public function index()
    {
        $permissions = Permission::all();
        return response()->json($permissions);
    }

    // Show the form for creating a new permission
    public function create()
    {
        // You can implement view-based form creation if needed
    }

    // Store a newly created permission in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string'
        ]);

        $permission = Permission::create($request->all());
        return response()->json($permission, 201);
    }

    // Display the specified permission
    public function show($id)
    {
        $permission = Permission::findOrFail($id);
        return response()->json($permission);
    }

    // Show the form for editing the specified permission
    public function edit($id)
    {
        // You can implement view-based form editing if needed
    }

    // Update the specified permission in storage
    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string'
        ]);

        $permission->update($request->all());
        return response()->json($permission);
    }

    // Remove the specified permission from storage
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return response()->json(null, 204);
    }


    public function assignPermission(Request $request, User $user)
    {
        $request->validate([
            'id_permission' => 'required|exists:permissions,id_permission', // Reference 'id_permission'
        ]);
    
        $user->permissions()->attach($request->id_permission); // Assign permission
        return response()->json(['message' => 'Permission assigned successfully.']);
    }
    
    // Revoke a permission from a user
    public function revokePermission(Request $request, User $user)
    {
        $request->validate([
            'id_permission' => 'required|exists:permissions,id_permission', // Reference 'id_permission'
        ]);
    
        $user->permissions()->detach($request->id_permission); // Revoke permission
        return response()->json(['message' => 'Permission revoked successfully.']);
    }
    


}
