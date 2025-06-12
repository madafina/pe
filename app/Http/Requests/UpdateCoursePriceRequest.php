<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCoursePriceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'course_id' => 'required|exists:courses,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'registration_open_date' => 'required|date',
            'registration_close_date' => 'required|date|after_or_equal:registration_open_date',
            'payment_notes' => 'required|string',
            'payment_deadline' => 'required|date',
        ];
    }
}
