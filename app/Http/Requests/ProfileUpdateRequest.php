<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'  => ['required','string','max:255'],
            'email' => ['required','email','max:255', Rule::unique('users')->ignore(auth()->id())],
            'phone' => ['nullable','string','max:25'],
            'avatar'=> ['nullable','image','max:2048'],
        ];
    }
}