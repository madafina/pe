<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Jika user punya role admin atau finance, arahkan ke dasbor admin
        if ($user->hasAnyRole(['admin', 'finance'])) {
            return view('dashboard');
        }

        // Jika user punya role student, arahkan ke dasbor siswa
        if ($user->hasRole('student')) {
            // Eager load relasi student untuk ditampilkan di view
            $user->load('student');
            return view('dashboard-siswa', compact('user'));
        }

    }
}