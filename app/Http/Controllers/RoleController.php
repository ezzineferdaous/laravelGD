<?php

namespace App\Http\Controllers;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // Ensure this line is present

class RoleController extends Controller
{
   // Fetch all roles
   public function index()
    {
        return Role::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Create a new role with the validated data
        $role = Role::create([
            'name' => $validatedData['name'],
        ]);

        // Return a response (can be JSON or a redirect depending on the use case)
        return response()->json($role, 201);
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return response()->json($role, 201);
    }
}
