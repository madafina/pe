<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentPortalController extends Controller
{
    public function invoices()
    {
        // Ambil user yang sedang login
        $user = Auth::user();
        // Ambil semua invoice yang berhubungan dengan user ini
        // $invoices = $user->student->registration->invoices()->with('payments')->get();
        $invoices = $user->student->registration->invoices()->with(['payments', 'paymentSubmissions'])->get();

        return view('student_portal.invoices', compact('invoices'));
    }
}
