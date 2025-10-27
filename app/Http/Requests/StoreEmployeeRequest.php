<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username'               => 'required|string|max:50|unique:employees,username',
            // 'password'               => 'required|string|min:6',
            'password'               => 'nullable|string|min:6|confirmed', // 👈 now optional
            'email'                  => 'required|email|unique:employees,email',
            'title'                  => 'nullable|string|max:20',
            'first_name'             => 'required|string|max:100',
            'middle_initial'         => 'nullable|string|max:10',
            'last_name'              => 'required|string|max:100',
            'date_of_birth'          => 'nullable|date',
            'start_date'             => 'nullable|date',
            'date_of_termination'    => 'nullable|date|after_or_equal:start_date',
            'preferred_name'         => 'nullable|string|max:100',
            'address'                => 'nullable|string|max:255',
            'city'                   => 'nullable|string|max:100',
            'postcode'               => 'nullable|string|max:20',
            'branch'                 => 'nullable|string|max:100',
            'area'                   => 'nullable|string|max:100',
            'house_no'               => 'nullable|string|max:50',
            'mobile_no'              => 'nullable|string|max:25',
            'contracted_hours'       => 'nullable|numeric|min:0',
            'tax_code'               => 'nullable|string|max:20',
            'gender'                 => 'nullable|in:male,female,other',
            'marital_status'         => 'nullable|string|max:50',
            'nationality'            => 'nullable|string|max:50',
            'ethnic_origin'          => 'nullable|string|max:50',
            'religion'               => 'nullable|string|max:50',
            'is_salaried'            => 'boolean',
            'enforce_hours'          => 'boolean',
            'national_insurance'     => 'nullable|string|max:30',
            'days_per_week'          => 'nullable|integer|min:0|max:7',
            'hours_of_week'          => 'nullable|numeric|min:0',
            'drive_status'           => 'nullable|in:driver,non-driver',
            'estimate_hour_pay_date' => 'nullable|date',
            'dbs_in_place'           => 'nullable|string|max:50',
            'medical_issue'          => 'nullable|string|max:500',
            'disability'             => 'boolean',
            'next_of_kin_name'       => 'nullable|string|max:100',
            'home_address'           => 'nullable|string|max:255',
            'emergency_contact_no'   => 'nullable|string|max:25',
            'emergency_contact_email'=> 'nullable|email|max:100',
            'consent_status'         => 'nullable|string|max:50',
            'consent_date'           => 'nullable|date',
        ];
    }
}