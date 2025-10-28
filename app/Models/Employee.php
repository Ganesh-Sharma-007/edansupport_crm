<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'username',
        'email',
        'password',
        'title',
        'first_name',
        'middle_initial',
        'last_name',
        'date_of_birth',
        'start_date',
        'date_of_termination',
        'preferred_name',
        'address',
        'city',
        'postcode',
        'branch',
        'area',
        'house_no',
        'mobile_no',
        'contracted_hours',
        'tax_code',
        'gender',
        'marital_status',
        'nationality',
        'ethnic_origin',
        'religion',
        'is_salaried',
        'enforce_hours',
        'national_insurance',
        'days_per_week',
        'hours_of_week',
        'drive_status',
        'estimate_hour_pay_date',
        'dbs_in_place',
        'medical_issue',
        'disability',
        'next_of_kin_name',
        'home_address',
        'emergency_contact_no',
        'emergency_contact_email',
        'consent_status',
        'consent_date',
        'is_active',
    ];

    protected $casts = [
        'date_of_birth'           => 'date',
        'start_date'              => 'date',
        'date_of_termination'     => 'date',
        'estimate_hour_pay_date'  => 'date',
        'consent_date'            => 'date',
        'is_salaried'             => 'boolean',
        'enforce_hours'           => 'boolean',
        'disability'              => 'boolean',
        'is_active'               => 'boolean',
    ];

    

    public function documents()
{
    return $this->hasMany(EmployeeDocument::class);
}

    
public function rosters()
{
    return $this->hasMany(Roster::class, 'employee_id');
}

}