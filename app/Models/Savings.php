<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Savings extends Model
{


    protected $fillable =[
        'name',
        'description',
        'amount',
        'start_date',
        'end_date',
        'organisation_id',
        'saver',
        'category_id',
        'is_active',
        'is_fixed',
        'interest_rate',
        'transfer_id',
        'type_id'
    ];
}
