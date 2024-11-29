<?php

namespace App\Http\Controllers;

use App\Models\Type;
use App\Models\Savings;
use App\Models\Organisation;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\SavingsService;
use Illuminate\Support\Facades\DB;

class SavingsController extends Controller
{
    protected $savingsService;

    // Inject the SavingsService instance into the controller via the constructor
    public function __construct(SavingsService $savingsService)
    {
        $this->savingsService = $savingsService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all organisations to populate the dropdown
        $organisations = Organisation::all();
        $types = Type::all();
        // Retrieve all savings for the "Transferred From" dropdown
        $accounts = Savings::all();


        // Get all savings and sort them by end_date, include the organisation name,the user who saved, the type of savings and the amount saved
        $savings = Savings::select('savings.*', 'organisations.name as organisation_name', 'types.name as type_name')
            ->join('organisations', 'savings.organisation_id', '=', 'organisations.id')
            // ->join('users', 'savings.saver', '=', 'users.id')
            ->join('types', 'savings.type_id', '=', 'types.id')
            ->get();


        // $savings = Savings::all()->sortBy('end_date');

        return view('savings.index', compact('savings','organisations','types','accounts'));

        // $totalSavings = $this->savingsService->getTotalSavings();
        // $savingsWithOrganisation = $this->savingsService->getSavingsWithOrganisation();
        // $savingsByUser = $this->savingsService->getSavingsByUser();

        // return view('savings.index', compact('totalSavings', 'savingsWithOrganisation', 'savingsByUser'));
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
        // dd($request->all());


        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'organisation_id' => 'required|exists:organisations,id',
            'saver' => 'required|string',
            'is_active' => 'required|boolean',
            'is_fixed' => 'required|boolean',
            'interest_rate' => 'nullable|numeric',
            'transfer_id' => 'nullable|exists:savings,id',
            'type_id' => 'required|exists:types,id',
        ]);



        // Set `end_date` to null if `is_fixed` is false
        if (!$request->is_fixed) {
            $validated['end_date'] = null;
            // dd($validated['end_date']);
        }



        // dd($validated);

        try {
            // Attempt to create a new saving record
            Savings::create($validated);
            // dd($validated);
            // Redirect with success message if creation succeeds
            return redirect()->route('savings.index')->with('success', 'Savings created successfully');
        } catch (\Exception $e) {
            // dd($e);
            // Redirect back with error message if creation fails
            return redirect()->route('savings.index')->with('error', 'Failed to create savings. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    // public function show($id)
    // {
    //     // Retrieve all organisations to populate the dropdown
    //     $organisations = Organisation::all();
    //     $types = Type::all();
    //     // Retrieve all savings for the "Transferred From" dropdown
    //     $accounts = Savings::all();

    //     $saving = Savings::select('savings.*', 'organisations.name as organisation_name', 'types.name as type_name')
    //     ->join('organisations', 'savings.organisation_id', '=', 'organisations.id')
    //     ->join('types', 'savings.type_id', '=', 'types.id')
    //     ->where('savings.id', $id)
    //     ->firstOrFail(); // Ensures a 404 response if the ID doesn't exist
    //     // Fetch the savings by ID
    //     // $saving = Savings::findOrFail($id);


    //     // Check if the request expects a JSON response
    //     if (request()->wantsJson()) {
    //         dd($saving);
    //         return response()->json($saving);
    //     }

    //     // If not JSON, return a view for standard HTML rendering
    //     return view('savings.show', compact('saving'));
    // }
    // public function show($id)
    // {
    //     // Retrieve all organisations, types, and accounts to populate dropdowns
    //     $organisations = Organisation::all();

    //     $types = Type::all();
    //     $accounts = Savings::all();


    //     // Retrieve the savings record with related organisation and type
    //     // $saving = Savings::with(['organisation', 'type'])->findOrFail($id);
    //     $saving = Savings::select('savings.*', 'organisations.name as organisation_name', 'types.name as type_name')
    //         ->join('organisations', 'savings.organisation_id', '=', 'organisations.id')
    //         ->join('types', 'savings.type_id', '=', 'types.id')
    //         ->where('savings.id', $id)
    //         ->firstOrFail(); // Fetch the record or fail


    //     // Check if the request expects a JSON response
    //     if (request()->wantsJson()) {
    //         return response()->json([...$saving->toArray,'organisation_name' => $saving->organisation_name, 'type_name' => $saving->type_name]); // Return JSON response
    //     }

    //     // Return the view for HTML rendering
    //     return view('savings.show', compact('saving', 'organisations', 'types', 'accounts'));
    // }
    public function show($id)
    {
        $saving = Savings::select('savings.*', 'organisations.name as organisation_name', 'types.name as type_name')
            ->join('organisations', 'savings.organisation_id', '=', 'organisations.id')
            ->join('types', 'savings.type_id', '=', 'types.id')
            ->where('savings.id', $id)
            ->firstOrFail();

        if (request()->wantsJson()) {
            return response()->json([
                ...$saving->toArray(),
                'organisation_name' => $saving->organisation_name, // Include organisation_name explicitly
                'type_name' => $saving->type_name,                // Include type_name explicitly
            ]);
        }

        return view('savings.show', compact('saving'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Savings $savings)
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
            'description' => 'nullable|string',
            'amount' => 'required|numeric',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'organisation_id' => 'required|exists:organisations,id',
            'saver' => 'required|string',
            'is_active' => 'required|boolean',
            'is_fixed' => 'required|boolean',
            'interest_rate' => 'nullable|numeric',
            'transfer_id' => 'nullable|exists:savings,id',
            'type_id' => 'required|exists:types,id',
        ]);

        // Find the organisation or fail
        $savings = Savings::findOrFail($id);

        // Update the organisation with validated data
        $savings->update($validated);

        // return to organisation.index view
        return redirect()->route('savings.index')->with('success', 'Savings updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Savings $saving)
    {
        // Destroy the saving
        $saving->delete();

        return redirect()->route('savings.index')->with('success', 'Savings deleted successfully');

    }
}


