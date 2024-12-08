<?php

namespace App\Services;

use App\Models\Savings;
use Illuminate\Support\Facades\DB;

class SavingsService
{
    public function getTotalSavings()
    {
        return Savings::sum('amount');
    }

    public function getActiveTotalSavings()
    {
        return Savings::where('is_active', true)->sum('amount');
    }


    public function getSavingsWithOrganisation()
    {
        return Savings::select('savings.*', 'organisations.name as organisation_name')
            ->join('organisations', 'savings.organisation_id', '=', 'organisations.id')
            ->get();
    }

    public function getSavingsByUser()
    {
        return Savings::select('saver', DB::raw('sum(amount) as total'))
            ->groupBy('saver')
            ->where('is_active', true)
            ->get();
    }
}
