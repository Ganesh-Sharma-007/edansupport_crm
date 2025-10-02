<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFunderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'                    => 'required|string|max:100',
            'middle_initial'          => 'nullable|string|max:10',
            'last_name'               => 'nullable|string|max:100',
            'preferred_name'          => 'nullable|string|max:100',
            'type'                    => 'nullable|string|max:50',
            'address'                 => 'nullable|string|max:255',
            'city_town'               => 'nullable|string|max:100',
            'country'                 => 'nullable|string|max:100',
            'postcode'                => 'nullable|string|max:20',
            'start_date'              => 'nullable|date',
            'branch'                  => 'nullable|string|max:100',
            'mobile'                  => 'nullable|string|max:25',
            'email'                   => 'nullable|email|max:100',
            'notes'                   => 'nullable|string|max:500',
            'fax'                     => 'nullable|string|max:25',
            'other'                   => 'nullable|string|max:255',
            'website'                 => 'nullable|url|max:255',
            'purchase_order_required' => 'boolean',
        ];
    }
}