<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Permission;

class PermissionUserController extends Controller
{
    /**
     * Display a listing of the permissions for a specific user.
     *
     * @param  int  $userId
     * @return \Illuminate\Http\Response
     */
    public function index($userId)
    {
        $user = User::findOrFail($userId);
        $permissions = $user->permissions;

        return response()->json([
            'user' => $user->username,
            'permissions' => $permissions
        ], 200);
    }

 
    public function store(Request $request, $userId)
    {
        $request->validate([
            'permission_id' => 'required|exists:permissions,id_permission'
        ]);

        $user = User::findOrFail($userId);
        $permissionId = $request->input('permission_id');

        // Attach the permission to the user
        if ($user->permissions()->where('id_permission', $permissionId)->exists()) {
            return response()->json([
                'message' => 'Permission already assigned to the user.'
            ], 400);
        }

        $user->permissions()->attach($permissionId);

        return response()->json([
            'message' => 'Permission assigned successfully.'
        ], 201);
    }


    public function destroy($userId, $permissionId)
    {
        $user = User::findOrFail($userId);

        if (!$user->permissions()->where('id_permission', $permissionId)->exists()) {
            return response()->json([
                'message' => 'Permission not found for the user.'
            ], 404);
        }

        // Detach the permission from the user
        $user->permissions()->detach($permissionId);

        return response()->json([
            'message' => 'Permission removed successfully.'
        ], 200);
    }
}
