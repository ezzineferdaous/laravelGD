<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Public route for user registration
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);



 Route::middleware('auth:sanctum')->group(function () {
    // Permission
    Route::get('/permissions', [PermissionController::class, 'index']);
    Route::post('/permissions', [PermissionController::class, 'store']);
    Route::get('/permissions/{id}', [PermissionController::class, 'show']);
    Route::put('/permissions/{id}', [PermissionController::class, 'update']);
    Route::delete('/permissions/{id}', [PermissionController::class, 'destroy']);
    // Route::post('/permissions/{id}/assign', [PermissionController::class, 'assignPermission']);
    // Route::post('/permissions/{id}/revoke', [PermissionController::class, 'revokePermission']);
    Route::post('/users/{user}/assign-permission', [PermissionController::class, 'assignPermission']);

    // Retirer une permission
    Route::post('/users/{user}/revoke-permission', [PermissionController::class, 'revokePermission']);

    // Categories
    Route::get('/categories', [CategoriesController::class, 'index']);
    Route::post('/categories', [CategoriesController::class, 'store']);
    Route::get('/categories/{id_category}', [CategoriesController::class, 'show']);
    Route::put('/categories/{id_category}', [CategoriesController::class, 'update']);
    Route::delete('/categories/{id_category}', [CategoriesController::class, 'destroy']);

    // Roles
    Route::get('/roles', action: [RoleController::class, 'index']);
    Route::post('/roles', [RoleController::class, 'store']);
    Route::delete('/roles/{id}', [RoleController::class, 'destroy']);

    // Document
    Route::get('/document', [DocumentController::class, 'index']);       // List all documents
    Route::post('/document', [DocumentController::class, 'store']);      // Create a new document
    Route::get('/document/{id}', [DocumentController::class, 'show']);    // Show a specific document
    Route::put('/document/{id}', [DocumentController::class, 'update']);   // Update a specific document
    Route::delete('/document/{id}', [DocumentController::class, 'destroy']); // Delete a specific document


    // user

    Route::get('/user', [UserController::class, 'index']); // Get all users
Route::post('/user', [UserController::class, 'store']); // Create new user
Route::get('/user/{id}', [UserController::class, 'show']); // Get a single user
Route::put('/user/{id}', [UserController::class, 'update']); // Update user
Route::delete('/user/{id}', [UserController::class, 'destroy']); // Delete
});
