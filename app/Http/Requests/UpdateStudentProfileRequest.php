<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Siswa bisa mengubah data ini
            'parent_phone_number' => 'required|string|max:20',
            'address' => 'nullable|string',
            'school_origin' => 'nullable|string',

            // Siswa bisa mengubah password akun mereka
            'password' => 'nullable|confirmed|min:8',
        ];
    }

    public function messages(): array
    {
        return [
            'parent_phone_number.required' => 'Telepon wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Password harus sama.',

        ];
    }
}