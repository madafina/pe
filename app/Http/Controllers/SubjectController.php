<?php

namespace App\Http\Controllers;

use App\DataTables\SubjectDataTable;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Models\Subject;
use App\Models\Course;

class SubjectController extends Controller
{
    public function index(SubjectDataTable $dataTable)
    {
        $courses = Course::orderBy('name')->get();
        return $dataTable->render('subjects.index', compact('courses'));
    }

    public function create()
    {
        $courses = Course::orderBy('name')->get();
        return view('subjects.create', compact('courses'));
    }

    public function store(StoreSubjectRequest $request)
    {
        Subject::create($request->validated());
        return redirect()->route('subjects.index')->with('success', 'Mata pelajaran baru berhasil ditambahkan!');
    }

    public function edit(Subject $subject)
    {
        $courses = Course::orderBy('name')->get();
        return view('subjects.edit', compact('subject', 'courses'));
    }

    public function update(UpdateSubjectRequest $request, Subject $subject)
    {
        $subject->update($request->validated());
        return redirect()->route('subjects.index')->with('success', 'Data mata pelajaran berhasil diperbarui!');
    }

    public function destroy(Subject $subject)
    {
        // Untuk saat ini kita tidak pakai fungsi hapus
        return redirect()->route('subjects.index');
    }
}
