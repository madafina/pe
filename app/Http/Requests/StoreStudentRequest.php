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
        $invoice = $this->route('invoice');

        return [
            'amount_paid' => 'required|numeric|min:1|max:' . $invoice->remaining_amount,
            'payment_date' => 'required|date',
            'notes' => 'nullable|string',
            // Tambahkan validasi untuk file bukti
            'proof_of_payment' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // max 2MB
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
