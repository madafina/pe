<?php

namespace App\Http\Controllers;

use App\DataTables\StudyClassDataTable;
use App\Http\Requests\StoreStudyClassRequest;
use App\Http\Requests\UpdateStudyClassRequest;
use App\Models\StudyClass;
use App\Models\Subject; // Import Subject
use App\Models\Tutor;   // Import Tutor
use App\Models\Student;
use Illuminate\Http\Request;

class StudyClassController extends Controller
{
    public function index(StudyClassDataTable $dataTable)
    {
        return $dataTable->render('study_classes.index');
    }
    /**
     * Display the specified resource.
     */
    public function show(StudyClass $studyClass)
    {
        // Eager load relasi yang dibutuhkan untuk efisiensi
        $studyClass->load('students', 'subject.course');

        // 1. Ambil ID program dari kelas yang sedang dilihat
        $classCourseId = $studyClass->subject->course_id;

        // 2. Ambil semua siswa yang sudah terdaftar di kelas ini
        $enrolledStudents = $studyClass->students;

        // 3. Ambil siswa yang bisa ditambahkan:
        //    - Statusnya 'Aktif'
        //    - Terdaftar di program yang SAMA dengan program kelas ini
        //    - Belum masuk ke kelas ini
        $availableStudents = Student::where('status', 'Aktif')
            ->whereHas('registration.coursePrice.course', function ($query) use ($classCourseId) {
                $query->where('id', $classCourseId);
            })
            ->whereDoesntHave('studyClasses', function ($query) use ($studyClass) {
                $query->where('study_class_id', $studyClass->id);
            })
            ->get();

        return view('study_classes.show', compact('studyClass', 'enrolledStudents', 'availableStudents'));
    }

    public function create()
    {
        // Ambil data untuk dropdown
        // $subjects = Subject::orderBy('name')->get();
        $tutors = Tutor::where('is_active', true)->orderBy('name')->get();

        return view('study_classes.create', compact('tutors'));
    }

    public function store(StoreStudyClassRequest $request)
    {
        StudyClass::create($request->validated());
        return redirect()->route('study-classes.index')->with('success', 'Kelas baru berhasil dibuat!');
    }

    public function edit(StudyClass $studyClass)
    {
        $subjects = Subject::orderBy('name')->get();
        $tutors = Tutor::where('is_active', true)->orderBy('name')->get();

        return view('study_classes.edit', compact('studyClass', 'subjects', 'tutors'));
    }

    public function update(UpdateStudyClassRequest $request, StudyClass $studyClass)
    {
        $studyClass->update($request->validated());
        return redirect()->route('study-classes.index')->with('success', 'Data kelas berhasil diperbarui!');
    }

    public function addStudent(Request $request, StudyClass $studyClass)
    {
        $request->validate(['student_id' => 'required|exists:students,id']);

        // Cek apakah siswa sudah ada di kelas ini untuk mencegah error duplikat
        if ($studyClass->students()->where('student_id', $request->student_id)->exists()) {
            return back()->with('error', 'Siswa sudah ada di dalam kelas ini!');
        }

        $studyClass->students()->attach($request->student_id);

        return back()->with('success', 'Siswa berhasil dimasukkan ke dalam kelas!');
    }

    public function removeStudent(StudyClass $studyClass, Student $student)
    {
        $studyClass->students()->detach($student->id);

        return back()->with('success', 'Siswa berhasil dikeluarkan dari kelas!');
    }
}
