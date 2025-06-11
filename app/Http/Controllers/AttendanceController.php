<?php

namespace App\Http\Controllers;

use App\Models\StudyClass;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    // Menampilkan halaman form presensi
    public function create(StudyClass $studyClass)
    {
        // Eager load siswa agar lebih efisien
        $studyClass->load('students');
        return view('attendances.create', compact('studyClass'));
    }

    // Menyimpan data presensi
    public function store(Request $request, StudyClass $studyClass)
    {
        $request->validate([
            'attendance_date' => 'required|date',
            'attendances' => 'required|array',
            'attendances.*.status' => 'required|in:Hadir,Izin,Sakit,Alpa',
        ]);

        foreach ($request->attendances as $studentId => $data) {
            Attendance::updateOrCreate(
                // Kunci untuk mencari data yang sudah ada
                [
                    'study_class_id' => $studyClass->id,
                    'student_id' => $studentId,
                    'attendance_date' => $request->attendance_date,
                ],
                // Data yang akan di-update atau di-create
                [
                    'status' => $data['status'],
                    'notes' => $data['notes'],
                    'recorded_by_id' => Auth::id(),
                ]
            );
        }

        return redirect()->route('study-classes.show', $studyClass->id)
                         ->with('success', 'Presensi untuk tanggal ' . $request->attendance_date . ' berhasil disimpan!');
    }
}