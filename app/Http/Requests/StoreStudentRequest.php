<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Izinkan semua user yang sudah login untuk membuat request ini
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'full_name' => 'required|string|max:255',
            'parent_phone_number' => 'required|string|max:20',
            'address' => 'nullable|string',
            'school_origin' => 'nullable|string',
            'registration_date' => 'required|date', // Validasi untuk tanggal
            'course_price_id' => 'required|exists:course_prices,id',
        ];
    }


    /**
     * Get the custom validation messages.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'full_name.required' => 'Nama lengkap wajib diisi.',
            'parent_phone_number.required' => 'Nomor HP orang tua wajib diisi.',
            'course_price_id.required' => 'Paket bimbel wajib dipilih.',
            'course_price_id.exists' => 'Paket bimbel yang dipilih tidak valid.',
        ];
    }
}
