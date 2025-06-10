<?php

namespace App\Http\Controllers;

use App\DataTables\InvoiceDataTable;
use Illuminate\Http\Request;
use App\Models\Invoice;


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
}
