<?php

namespace App\Http\Controllers;

use App\DataTables\InvoiceDataTable;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Services\WhatsAppService; 


class InvoiceController extends Controller
{
    public function index(InvoiceDataTable $dataTable)
    {
        return $dataTable->render('invoices.index');
    }

    public function verify(Invoice $invoice) 
    {
        // Pastikan hanya invoice yang belum lunas yang bisa diverifikasi
        if ($invoice->status == 'Unpaid') {
            $invoice->status = 'Paid';
            // Jika perlu, tambahkan logika untuk mencatat tanggal pembayaran
            // $invoice->payment_date = now();
            $invoice->save();

            return response()->json(['success' => true, 'message' => 'Invoice berhasil diverifikasi!']);
        }

        return response()->json(['success' => false, 'message' => 'Invoice ini sudah lunas atau statusnya tidak valid.'], 422);
    }

    public function resendNotification(Invoice $invoice)
    {
        try {
            // 1. Buat isi pesan secara manual di sini
            $studentName = $invoice->registration->student->full_name;
            $parentPhone = $invoice->registration->student->parent_phone_number;
            $amount = number_format($invoice->amount, 0, ',', '.');
            $dueDate = \Carbon\Carbon::parse($invoice->due_date)->format('d F Y');

            $message = "Yth. Bpk/Ibu Wali dari {$studentName},\n\n" .
                       "Ini adalah pengingat untuk tagihan dengan rincian:\n" .
                       "Deskripsi: {$invoice->description}\n" .
                       "Jumlah: Rp {$amount}\n" .
                       "Jatuh Tempo: {$dueDate}\n\n" .
                       "Terima kasih.\n*SIMBIMBEL*";

            // 2. Panggil method sendMessage yang generik
            (new WhatsAppService())->sendMessage($parentPhone, $message);

            return back()->with('success', 'Notifikasi tagihan untuk ' . $invoice->registration->student->full_name . ' telah berhasil dikirim ulang.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim notifikasi: ' . $e->getMessage());
        }
    }
}
