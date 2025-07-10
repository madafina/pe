<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentByAdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Asumsi hanya admin yang bisa akses route ini
    }

    public function rules(): array
    {
        $student = $this->route('student');
        $userId = $student->user_id;

        return [
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $userId,
            'parent_phone_number' => 'required|string|max:20',
            'education_level' => 'required|in:Pra-Sekolah,SD,SMP,SMA,Lulus/Umum',
            'status' => 'required|in:Aktif,Non-Aktif,Lulus,Berhenti',
            'address' => 'nullable|string',
            'school_origin' => 'nullable|string',
        ];
    }
}