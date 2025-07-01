<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PaymentSubmissionDataTable;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\PaymentSubmission;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentVerificationController extends Controller
{
    public function index(PaymentSubmissionDataTable $dataTable)
    {
        return $dataTable->render('admin.payment_verifications.index');
    }

    public function approve(PaymentSubmission $submission)
    {
        DB::beginTransaction();
        try {
            // 1. Buat record baru di tabel 'payments'
            $payment = Payment::create([
                'invoice_id' => $submission->invoice_id,
                'amount_paid' => $submission->amount,
                'payment_date' => now()->toDateString(),
                'notes' => 'Pembayaran diverifikasi dari pengajuan siswa. ' . $submission->notes,
                'proof_of_payment' => $submission->proof_path,
                'verified_by_id' => Auth::id(),
            ]);

            // 2. Update status submission menjadi 'approved'
            $submission->update([
                'status' => 'approved',
                'processed_by_id' => Auth::id(),
            ]);

            // 3. Cek & aktifkan siswa jika ini pembayaran pertama
            $student = $submission->invoice->registration->student;
            if ($student->status == 'Non-Aktif') {
                $student->status = 'Aktif';
                $student->save();
            }

            // 4. Cek & update status invoice jika sudah lunas
            $invoice = $submission->invoice->fresh();
            if($invoice->remaining_amount <= 0) {
                $invoice->status = 'Paid';
                $invoice->save();
            }

            // 5. Kirim notifikasi WA ke siswa
            // (new WhatsAppService())->sendPaymentNotification($payment);

            DB::commit();
            return back()->with('success', 'Pembayaran berhasil diapprove!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, PaymentSubmission $submission)
    {
        $request->validate(['rejection_reason' => 'required|string|max:255']);

        $submission->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'processed_by_id' => Auth::id(),
        ]);

        // (Opsional) Kirim notifikasi penolakan ke siswa via WA

        return back()->with('success', 'Pengajuan pembayaran berhasil direject!');
    }
}

