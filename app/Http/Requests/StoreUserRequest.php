<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username'              => 'required|string|max:50|unique:users,name',
            'password'              => 'required|string|min:6|confirmed',
            'email'                 => 'required|email|unique:users,email',
            'pin'                   => 'nullable|string|max:10',
            'title'                 => 'nullable|string|max:20',
            'first_name'            => 'required|string|max:100',
            'last_name'             => 'required|string|max:100',
            'gender'                => 'nullable|in:male,female,other',
            'team'                  => 'nullable|string|max:100',
            'city'                  => 'nullable|string|max:100',
            'postcode'              => 'nullable|string|max:20',
            'latitude'              => 'nullable|numeric',
            'longitude'             => 'nullable|numeric',
            'address_line_1'        => 'nullable|string|max:255',
            'address_line_2'        => 'nullable|string|max:255',
            'support_worker_type'   => 'required|in:branch administrator,employee',
            'branch'                => 'nullable|string|max:100',
            'is_shared'             => 'boolean',
            'is_active'             => 'boolean',
        ];
    }
}