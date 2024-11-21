<?php

use App\Models\Type;
use App\Models\Savings;
use App\Models\Organisation;
use App\Services\SavingsService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrganisationController;

// Route::get('/', function () {
//     $totalSavings = Savings::sum('amount');

//     // get each savings with oraganisation name
//     $savingsWithOrganisation = Savings::select('savings.*', 'organisations.name as organisation_name')
//         ->join('organisations', 'savings.organisation_id', '=', 'organisations.id')
//         ->get();
//     // $savingsWithEndDate = Savings::select('savings.*')
//     //     ->get();

//     $savingsByUser = Savings::select('saver', DB::raw('sum(amount) as total'))
//         ->groupBy('saver')
//         ->get();

//     // dd($savingsWithOrganisation);

//     return view('welcome', compact('totalSavings', 'savingsByUser', 'savingsWithOrganisation'));
// });

Route::get('/organisation/{id}', function ($id) {
    $organisation = Organisation::findOrFail($id);
    return response()->json($organisation);
});
Route::get('/type/{id}', function ($id) {
    $type = Type::findOrFail($id);
    return response()->json($type);
});


Route::get('/', function (SavingsService $savingsService) {
    $totalSavings = $savingsService->getTotalSavings();
    $savingsWithOrganisation = $savingsService->getSavingsWithOrganisation();
    $savingsByUser = $savingsService->getSavingsByUser();

    return view('welcome', compact('totalSavings', 'savingsWithOrganisation', 'savingsByUser'));
});

Route::get('/dashboard', function (SavingsService $savingsService) {
    $totalSavings = $savingsService->getTotalSavings();

    return view('dashboard', compact('totalSavings'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Add middleware('auth') to protect the route




Route::resource('user', UserController::class);

Route::resource('organisation', OrganisationController::class)->middleware('auth');

Route::resource('type', TypeController::class)->middleware('auth');


require __DIR__.'/auth.php';
