<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CoursePrice;
use Illuminate\Http\Request;

class CoursePriceController extends Controller
{
    public function index(Request $request)
    {
        // Validasi request, pastikan ada parameter 'month'
        $request->validate(['month' => 'required|string']);

        // Ambil nama bulan dari request, contoh: "Juli", "Oktober"
        $monthName = $request->query('month');

        // Cari semua harga kursus yang periode masuknya cocok dengan bulan yang dikirim
        $coursePrices = CoursePrice::where('enrollment_period', $monthName)
                                   ->with('course') // Ambil juga data relasi kursusnya
                                   ->get();

        // Kembalikan hasilnya dalam format JSON
        return response()->json($coursePrices);
    }
}