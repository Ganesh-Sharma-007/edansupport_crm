<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'customer'   => 'required|exists:service_users,id',
        ];
    }
}