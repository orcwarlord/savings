<?php

namespace App\Http\Controllers;

use App\Models\Organisation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrganisationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $organisations = Organisation::all()->sortBy('name');

        return view('organisation.index', compact('organisations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Open organisation.create view
        return view('organisation.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url',
            'description' => 'nullable|string',
        ]);

        Organisation::create($validated);

        return redirect()->route('organisation.index')->with('success', 'Organisation created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Fetch the organisation by ID
        $organisation = Organisation::findOrFail($id);

        // Check if the request expects a JSON response
        if (request()->wantsJson()) {
            return response()->json($organisation);
        }

        // If not JSON, return a view for standard HTML rendering
        return view('organisation.show', compact('organisation'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Organisation $organisation)
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
            'url' => 'required|url',
            'description' => 'nullable|string',
        ]);

        // Find the organisation or fail
        $organisation = Organisation::findOrFail($id);

        // Update the organisation with validated data
        $organisation->update($validated);

        // return to organisation.index view
        return redirect()->route('organisation.index')->with('success', 'Organisation updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Organisation $organisation)
    {
        // Destroy the organisation
        $organisation->delete();

        return redirect()->route('organisation.index')->with('success', 'Organisation deleted successfully');

    }
}
