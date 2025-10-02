<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funder extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'middle_initial',
        'last_name',
        'preferred_name',
        'type',
        'address',
        'city_town',
        'country',
        'postcode',
        'start_date',
        'branch',
        'mobile',
        'email',
        'notes',
        'fax',
        'other',
        'website',
        'purchase_order_required',
        'is_active',
    ];

    protected $casts = [
        'start_date'                => 'date',
        'purchase_order_required'   => 'boolean',
        'is_active'                 => 'boolean',
    ];
}