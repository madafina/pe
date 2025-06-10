<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

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

    public function messages(): array
    {
        return ['amount_paid.max' => 'Jumlah bayar tidak boleh melebihi sisa tagihan.'];
    }
}
