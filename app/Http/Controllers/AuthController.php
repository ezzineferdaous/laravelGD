<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // Register
    public function register(Request $request)
    {
        Log::info('start register');

        try {
            // Validation (role_id is not required here)
            $validatedData = $request->validate([
                'username' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'tel' => 'required|string',
                'password' => 'required|string|min:8',
            ]);
            Log::info('validatedData : ', $validatedData);

            // Create user
            $utilisateur = User::create([
                'username' => $validatedData['username'],
                'email' => $validatedData['email'],
                'tel' => $validatedData['tel'],
                'password' => Hash::make($validatedData['password']),
                'role_id' => 2, // Default to 'client' role
            ]);

            // Create a token for the user
            $token = $utilisateur->createToken('authToken')->plainTextToken;

            Log::info('User registered successfully', ['user_id' => $utilisateur->id]);

            return response()->json([
                'message' => 'User registered successfully',
                'user' => $utilisateur,
                'token' => $token, // Include the token in the response
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log validation errors
            Log::error('Validation failed', ['errors' => $e->errors()]);
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);
        } 
    }

    // Login
    public function login(Request $request)
    {
        // Check validation of fields
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Retrieve user by email
        $user = User::where('email', $request->email)->first();

        // Check password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Create token for the user
        $token = $user->createToken('authToken')->plainTextToken;

        // Return only the email and token
        return response()->json([
            'email' => $user->email,
            'token' => $token,
        ]);
    }

   
   
   

}
