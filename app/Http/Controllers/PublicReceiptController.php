<?php
namespace App\Http\Controllers;
use App\Models\Payment;
use Illuminate\Http\Request;

class PublicReceiptController extends Controller
{
    public function show(Payment $payment)
    {
        // Eager load relasi yang dibutuhkan
        $payment->load('invoice.registration.student');
        return view('receipts.show', compact('payment'));
    }
}
