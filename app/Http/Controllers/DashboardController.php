<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Cek jika user punya role admin atau finance
        if (Auth::user()->hasAnyRole(['admin', 'finance'])) {
            return view('dashboard'); // Arahkan ke dasbor admin
        }
       
        return view('dashboard-siswa'); // Arahkan ke dasbor admin
    }
}