<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRosterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'start'              => 'required|date',
            'end'                => 'required|date|after:start',
            'shift_hours'        => 'nullable|numeric|min:0',
            'status'             => 'required|in:assigned,cancelled,complete,in-progress',
            'service_user_id'    => 'required|exists:service_users,id',
            'employee_id'        => 'required|exists:employees,id',
            'travel_hours'       => 'nullable|integer|min:0',
            'travel_minutes'     => 'nullable|integer|min:0|max:59',
        ];
    }
}