<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\PaymentSubmission;

class PaymentSubmissionController extends Controller
{
    public function store(Request $request, Invoice $invoice)
    {
        // Hitung nilai minimum (50% dari total tagihan)
        // $minAmount = $invoice->amount * 0.5;
        // Ambil sisa tagihan
        $maxAmount = $invoice->remaining_amount;

        $request->validate([
            // Terapkan aturan min dan max
            'amount' => 'required|numeric|max:' . $maxAmount,
            'proof_path' => 'required|image|max:2048',
            'notes' => 'nullable|string',
        ], [
            // Tambahkan pesan error kustom
            // 'amount.min' => 'Jumlah pembayaran minimal adalah 50% dari total tagihan.',
            'amount.max' => 'Jumlah pembayaran tidak boleh melebihi sisa tagihan.',
            'proof_path.required' => 'Bukti pembayaran wajib diunggah.',
        ]);

        $path = $request->file('proof_path')->store('payment_proofs', 'public');

        $submission = PaymentSubmission::create([
            'invoice_id' => $invoice->id,
            'user_id' => auth()->id(),
            'amount' => $request->amount,
            'proof_path' => $path,
            'notes' => $request->notes,
        ]);

        // KIRIM NOTIFIKASI KE SEMUA ADMIN
        $admins = \App\Models\User::role('admin')->get();
        \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\Admin\NewPaymentSubmissionNotification($submission));


        return back()->with('success', 'Bukti pembayaran berhasil diunggah dan sedang menunggu verifikasi.');
    }
}
