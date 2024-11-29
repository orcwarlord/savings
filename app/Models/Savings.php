<?php

namespace App\Models;

use App\Models\Type;
use App\Models\Organisation;
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

    // protected $appends = ['organisation_name', 'type_name'];

    // public function getOrganisationNameAttribute()
    // {
    //     return $this->attributes['organisation_name'] ?? null;
    // }

    // public function getTypeNameAttribute()
    // {
    //     return $this->attributes['type_name'] ?? null;
    // }
}
