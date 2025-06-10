<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CoursePrice;
use Illuminate\Http\Request;

class CoursePriceController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'date' => 'required|date_format:Y-m-d',
            'level' => 'required|string', // Validasi baru
        ]);

        $selectedDate = $request->query('date');
        $selectedLevel = $request->query('level');

        $coursePrices = CoursePrice::whereHas('course', function ($query) use ($selectedLevel) {
            // Filter berdasarkan required_level di tabel courses
            $query->where('required_level', $selectedLevel);
        })
            ->where('registration_open_date', '<=', $selectedDate)
            ->where('registration_close_date', '>=', $selectedDate)
            ->with('course')
            ->get();

        return response()->json($coursePrices);
    }
}
