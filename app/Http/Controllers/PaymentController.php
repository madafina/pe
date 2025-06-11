<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use App\Http\Requests\StorePaymentRequest;
use Illuminate\Support\Facades\Auth;
use App\DataTables\PaymentDataTable;

class PaymentController extends Controller
{
    public function index(PaymentDataTable $dataTable)
    {
        return $dataTable->render('payments.index');
    }

    public function store(StorePaymentRequest $request, Invoice $invoice)
    {
        $proofPath = null;
        if ($request->hasFile('proof_of_payment')) {
            $proofPath = $request->file('proof_of_payment')->store('payment_proofs', 'public');
        }

        Payment::create([
            'invoice_id' => $invoice->id,
            'amount_paid' => $request->amount_paid,
            'payment_date' => $request->payment_date,
            'notes' => $request->notes,
            'verified_by_id' => Auth::id(),
            'proof_of_payment' => $proofPath,
        ]);

        // --- LOGIKA AKTIVASI SISWA ---
        $student = $invoice->registration->student;
        // Cek jika status siswa masih Non-Aktif
        if ($student->status == 'Non-Aktif') {
            // Ubah menjadi Aktif
            $student->status = 'Aktif';
            $student->save();
        }
        // --- SELESAI LOGIKA AKTIVASI ---

        if ($invoice->fresh()->remaining_amount <= 0) {
            $invoice->status = 'Paid';
            $invoice->save();
        }

        return response()->json(['success' => true, 'message' => 'Pembayaran berhasil dicatat!']);
    }
}
