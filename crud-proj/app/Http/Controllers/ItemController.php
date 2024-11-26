<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    // Create (Store)
    public function store(Request $request)
    {
        try {
            // Validate the request data
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
            ]);
    
            // Create the new item
            $item = Item::create($validated);
    
            // Return a success response
            return response()->json($item, 201);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Create Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to create item'], 500);
        }
    }

    // Read (Index)
    public function index()
    {
        return response()->json(Item::all());
    }

    // Update
    public function update(Request $request, $id)
    {
        try {
            // Validate request data
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
            ]);
    
            // Find the item by ID
            $item = Item::findOrFail($id);
            
            // Update the item
            $item->update($validated);
    
            return response()->json($item, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Item not found'], 404);
        } catch (\Exception $e) {
            // Log the detailed error
            \Log::error('Update Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to update item'], 500);
        }
    }

    // Delete
    public function destroy($id)
    {
        try {
            $item = Item::findOrFail($id);
            $item->delete();
            return response()->json(['message' => 'Item deleted']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Item not found'], 404);
        }
    }

    public function show($id)
    {
        $item = Item::find($id); // Find item by ID

        if ($item) {
            return response()->json($item); // Return the item as JSON
        } else {
            return response()->json(['error' => 'Item not found'], 404);
        }
    }
}