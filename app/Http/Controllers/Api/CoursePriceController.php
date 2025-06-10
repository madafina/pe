<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CoursePrice;
use Illuminate\Http\Request;

class CoursePriceController extends Controller
{
    public function index(Request $request)
    {
        $request->validate(['date' => 'required|date_format:Y-m-d']);

        $selectedDate = $request->query('date');

        // Cari harga di mana tanggal pendaftaran berada di dalam jendela pendaftaran
        $coursePrices = CoursePrice::where('registration_open_date', '<=', $selectedDate)
            ->where('registration_close_date', '>=', $selectedDate)
            ->with('course')
            ->get();

        return response()->json($coursePrices);
    }
}
