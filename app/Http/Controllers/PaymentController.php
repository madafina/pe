<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use App\Http\Requests\StorePaymentRequest;
use Illuminate\Support\Facades\Auth;
use App\DataTables\PaymentDataTable;
use App\Notifications\PaymentReceivedNotification;
use Illuminate\Support\Facades\DB;
use App\DataTables\TrashedPaymentDataTable;

class PaymentController extends Controller
{
    public function index(PaymentDataTable $dataTable)
    {
        return $dataTable->render('payments.index');
    }

    public function store(StorePaymentRequest $request, Invoice $invoice)
    {
        // Gunakan DB Transaction untuk memastikan semua proses aman
        DB::beginTransaction();
        try {
            $proofPath = null;
            if ($request->hasFile('proof_of_payment')) {
                $proofPath = $request->file('proof_of_payment')->store('payment_proofs', 'public');
            }

            // 1. Buat record pembayaran baru
            $payment = Payment::create([
                'invoice_id' => $invoice->id,
                'amount_paid' => $request->amount_paid,
                'payment_date' => $request->payment_date,
                'notes' => 'Pembayaran dicatat oleh admin. ' . $request->notes,
                'proof_of_payment' => $proofPath,
                'verified_by_id' => Auth::id(),
            ]);

            // 2. Aktifkan siswa jika statusnya masih Non-Aktif
            $student = $invoice->registration->student;
            if ($student->status == 'Non-Aktif') {
                $student->status = 'Aktif';
                $student->save();
            }

            // 3. Cek & update status invoice jika sudah lunas
            $invoice->refresh(); // Ambil data terbaru dari invoice
            if ($invoice->remaining_amount <= 0) {
                $invoice->status = 'Paid';
                $invoice->save();
            }

            // 4. KIRIM NOTIFIKASI KE SISWA
            $studentUser = $student->user;
            if ($studentUser) {
                // Kita gunakan notifikasi yang sama dengan saat approve, karena logikanya sama
                $studentUser->notify(new PaymentReceivedNotification($payment));
            }

            // Jika semua berhasil, commit transaksi
            DB::commit();

            // Kembalikan respons sukses untuk AJAX
            return response()->json(['success' => true, 'message' => 'Pembayaran berhasil dicatat dan notifikasi telah dikirim.']);
        } catch (\Exception $e) {
            // Jika ada error, batalkan semua
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(Payment $payment)
    {
        $payment->delete(); // Ini akan menjadi soft delete
        return response()->json(['success' => true, 'message' => 'Log pembayaran berhasil dihapus.']);
    }

    public function trash(TrashedPaymentDataTable $dataTable)
    {
        return $dataTable->render('payments.trash');
    }

    public function restore($id)
    {
        // Cari data HANYA di dalam 'tong sampah'
        $payment = Payment::onlyTrashed()->findOrFail($id);
        // Kembalikan datanya
        $payment->restore();

        return redirect()->route('payments.trash')->with('success', 'Data pembayaran berhasil dipulihkan.');
    }

    public function resendNotification(Payment $payment)
    {
        try {
            $studentUser = $payment->invoice->registration->student->user;

            if ($studentUser) {
                // Panggil class notifikasi yang sudah kita buat
                $studentUser->notify(new PaymentReceivedNotification($payment));
            }

            return back()->with('success', 'Notifikasi pembayaran untuk ' . $studentUser->name . ' telah berhasil dikirim ulang.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim notifikasi: ' . $e->getMessage());
        }
    }
}
