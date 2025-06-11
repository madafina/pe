<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTutorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Izinkan semua user yang login
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'specialization' => 'nullable|string',
        ];
    }
}