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
        $selectedDate = \Carbon\Carbon::parse($request->query('date'))->format('m-d');

        $coursePrices = CoursePrice::where(function ($query) use ($selectedDate) {
            $query->where(function ($subQuery) use ($selectedDate) {
                $subQuery->whereRaw('valid_from <= valid_until')->whereRaw('? BETWEEN valid_from AND valid_until', [$selectedDate]);
            })->orWhere(function ($subQuery) use ($selectedDate) {
                $subQuery->whereRaw('valid_from > valid_until')->where(function ($q) use ($selectedDate) {
                    $q->whereRaw('? >= valid_from', [$selectedDate])->orWhereRaw('? <= valid_until', [$selectedDate]);
                });
            });
        })->with('course')->get();

        return response()->json($coursePrices);
    }
}
