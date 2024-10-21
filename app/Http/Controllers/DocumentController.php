<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DocumentController extends Controller
{
    // List all documents
    public function index()
    {
        $documents = Document::with(['category', 'user'])->get(); // Eager load relationships
        return response()->json($documents);
    }

    // Show a specific document
    public function show($id)
    {
        $document = Document::with(['category', 'user'])->findOrFail($id);
        return response()->json($document);
    }

    // Create a new document
    public function store(Request $request)
    {
        Log::info("request data: ", $request);
        try {
            // Validate request data
            $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'format' => 'required|string',
            ]);
       

            $document = new Document();
            $document->title = $request->input('title');
            $document->content = $request->input('content');
            $document->format = $request->input('format');

           
        // Handle the document upload
        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $DocumentName = time().'.'.$document->getClientOriginalExtension(); // Create a unique name for the document
            $document->move(public_path('document'), $DocumentName); // Move the document to the public/images directory
            $request['document'] = $DocumentName; // Store the document name in the database
        }
        Log::info("document befor save data: ", $document);

            $document->save();
            Log::info("save succefly");

            return response()->json($document, 201); // Return the created document
        } catch (\Exception $e) {
            Log::error('Error saving document: ' . $e->getMessage());
            return response()->json(['error' => 'There was an error adding the document.'], 500);
        }
    }

    // Update a specific document
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
            'format' => 'sometimes|nullable|string|max:50',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,xls,doc,docx|max:2048', // File validation

        ]);

        $document = Document::findOrFail($id);
        $document->update($request->all());

        return response()->json($document);
    }

    // Delete a specific document
    public function destroy($id)
    {
        $document = Document::findOrFail($id);
        $document->delete();
        return response()->json(null, 204); // 204 No Content
    }
}
