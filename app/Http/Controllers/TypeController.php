<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = Type::all()->sortBy('name');
        // dd($types);
        return view('type.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Type::create($validated);

        return redirect()->route('type.index')->with('success', 'Type created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Fetch the type by ID
        $type = Type::findOrFail($id);
        dd($type);
        // Check if the request expects a JSON response
        // if (request()->wantsJson()) {
        //     return response()->json($type);
        // }

        // // If not JSON, return a view for standard HTML rendering
        // return view('type.show', compact('type'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Type $type)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',

        ]);

        // Find the type or fail
        $type = Type::findOrFail($id);

        // Update the type with validated data
        $type->update($validated);

        // return to type.index view
        return redirect()->route('type.index')->with('success', 'Type updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Type $type)
    {
        $type->delete();
        return redirect()->route('type.index')->with('success', 'Type deleted successfully');
    }
}
