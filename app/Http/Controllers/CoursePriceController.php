<?php

namespace App\Http\Controllers;

use App\DataTables\CoursePriceDataTable;
use App\Http\Requests\StoreCoursePriceRequest;
use App\Http\Requests\UpdateCoursePriceRequest;
use App\Models\Course;
use App\Models\CoursePrice;

class CoursePriceController extends Controller
{
    public function index(CoursePriceDataTable $dataTable)
    {
        // Ambil data program untuk filter
        $courses = Course::orderBy('name')->get();
        // Kirim data ke view
        return $dataTable->render('course_prices.index', compact('courses'));
    }

    public function create()
    {
        $courses = Course::orderBy('name')->get();
        return view('course_prices.create', compact('courses'));
    }

    public function store(StoreCoursePriceRequest $request)
    {
        CoursePrice::create($request->validated());
        return redirect()->route('course-prices.index')->with('success', 'Paket harga baru berhasil ditambahkan!');
    }

    public function edit(CoursePrice $coursePrice)
    {
        $courses = Course::orderBy('name')->get();
        return view('course_prices.edit', compact('coursePrice', 'courses'));
    }

    public function update(UpdateCoursePriceRequest $request, CoursePrice $coursePrice)
    {
        $coursePrice->update($request->validated());
        return redirect()->route('course-prices.index')->with('success', 'Data paket harga berhasil diperbarui!');
    }
}
