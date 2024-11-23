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

        // try {
        //     $validated = $request->validate([
        //         'name' => 'required|string|max:255',
        //         'description' => 'nullable|string',
        //         'amount' => 'required|numeric',
        //         'start_date' => 'nullable|date',
        //         'end_date' => 'nullable|date',
        //         'organisation_id' => 'required|exists:organisations,id',
        //         'saver' => 'required|string',
        //         'is_active' => 'required|boolean',
        //         'is_fixed' => 'required|boolean',
        //         'interest_rate' => 'nullable|numeric',
        //         'transfer_id' => 'nullable|exists:savings,id',
        //         'type_id' => 'required|exists:types,id',
        //     ]);

        //     dd($validated);
        // } catch (\Illuminate\Validation\ValidationException $e) {
        //     dd($e->errors());
        // }



        // Savings::create($validated);

        // return redirect()->route('savings.index')->with('success', 'Savings created successfully');
        try {
            // Attempt to create a new saving record
            Savings::create($validated);

            // Redirect with success message if creation succeeds
            return redirect()->route('savings.index')->with('success', 'Savings created successfully');
        } catch (\Exception $e) {
            // Redirect back with error message if creation fails
            return redirect()->route('savings.index')->with('error', 'Failed to create savings. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Savings $savings)
    {
        //
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
    public function update(Request $request, Savings $savings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Savings $savings)
    {
        //
    }


}
