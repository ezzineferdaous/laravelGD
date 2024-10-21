<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoriesController extends Controller
{
   
    public function index()
    {
        // Fetch all categories
        $categories = Category::all();
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        // Validate the request data
        Log::info("start post category");
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        Log::info("validate post category");

        // Create a new category
        $category = Category::create([
            'name' => $request->name,
        ]);

        return response()->json($category, 201);
    }

    /**
     * Display the specified category.
     *
     * @param  int  $id_category
     * @return \Illuminate\Http\Response
     */
    public function show($id_category)
    {
        // Find the category by its primary key
        $category = Category::find($id_category);

        // If category not found, return 404
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        return response()->json($category);
    }

   
    public function update(Request $request, $id_category)
    {
        
        // Find the category
        $category = Category::find($id_category);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Update the category
        $category->name = $request->name;
        $category->save();

        return response()->json($category);
    }

  
    public function destroy($id_category)
    {
        // Find the category
        $category = Category::find($id_category);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        // Delete the category
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully']);
    }
}
