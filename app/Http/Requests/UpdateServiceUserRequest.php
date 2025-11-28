<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateServiceUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // return (new StoreServiceUserRequest)->rules();
        return [
        'type'                   => 'nullable|string|max:50',
        'title'                  => 'nullable|string|max:20',
        'first_name'             => 'sometimes|string|max:100',
        'middle_initial'         => 'nullable|string|max:10',
        'last_name'              => 'sometimes|string|max:100',
        'preferred_name'         => 'nullable|string|max:100',
        'city'                   => 'nullable|string|max:100',
        'country'                => 'nullable|string|max:100',
        'gender'                 => 'nullable|in:male,female,other',
        'marital_status'         => 'nullable|string|max:50',
        'ethnic_origin'          => 'nullable|string|max:50',
        'religion'               => 'nullable|string|max:50',
        'postcode'               => 'nullable|string|max:20',
        'start_date'             => 'nullable|date',
        'date_of_birth'          => 'nullable|date',
        'service_priority'       => 'nullable|string|max:50',
        'branch'                 => 'nullable|string|max:100',
        'care_hours'             => 'nullable|numeric|min:0',
        'visit_duration'         => 'nullable|string|max:50',
        'type_of_service_user'   => 'nullable|string|max:100',
        'address'                => 'nullable|string|max:255',
        'contact_number'         => 'nullable|string|max:25',
        'fax'                    => 'nullable|string|max:25',
        'other'                  => 'nullable|string|max:255',
        'funder_type'            => 'nullable|in:private,public',
        'funder_id'              => 'nullable|exists:funders,id',
        'care_price'             => 'nullable|numeric|min:0',
        'travel_time'            => 'nullable|integer|min:0',
        'is_active'              => 'sometimes|boolean',


    ];
        
    }
}