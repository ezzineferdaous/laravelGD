<?php



namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // List all users
    public function index()
{
    $users = User::with(['role', 'documents'])->get(); // Eager load relationships
    return response()->json($users);
}

    // Show a specific user
    public function show($id)
    {
        $user = User::with(['role', 'documents'])->findOrFail($id);
        return response()->json($user);
    }

    // Create a new user
    public function store(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id', // Ensure role exists
            'tel' => 'nullable|string|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Hash the password
        $request['password'] = bcrypt($request['password']);

        // Create the user
        $user = User::create($request->all());
        return response()->json($user, 201); // 201 Created
    }

    // Update a specific user
    public function update(Request $request, $id)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'username' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'sometimes|required|string|min:8',
            'role_id' => 'sometimes|required|exists:roles,id',
            'tel' => 'nullable|string|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Find the user
        $user = User::findOrFail($id);
        
        // If the password is being updated, hash it
        if ($request->has('password')) {
            $request['password'] = bcrypt($request['password']);
        }

        $user->update($request->all());
        return response()->json($user);
    }

    // Delete a specific user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(null, 204); // 204 No Content
    }
}

