<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'first_name',
        'middle_initial',
        'last_name',
        'preferred_name',
        'city',
        'country',
        'gender',
        'marital_status',
        'ethnic_origin',
        'religion',
        'postcode',
        'start_date',
        'date_of_birth',
        'service_priority',
        'branch',
        'care_hours',
        'visit_duration',
        'type_of_service_user',
        'address',
        'contact_number',
        'fax',
        'other',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'date_of_birth' => 'date',
        'is_active' => 'boolean',
    ];
}