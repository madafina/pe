<?php

namespace App\Http\Controllers;

use App\Models\StudyClass;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;

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
   
    public function history(Request $request, StudyClass $studyClass)
    {
        // 1. Ambil semua siswa yang terdaftar di kelas ini, urutkan berdasarkan nama
        $studentsInClass = $studyClass->students()->orderBy('full_name')->get();

        // 2. Ambil semua data presensi untuk kelas ini
        //    Gunakan keyBy untuk membuat pencarian data lebih cepat di view
        $attendances = Attendance::where('study_class_id', $studyClass->id)
            ->get()
            ->keyBy(function ($item) {
                // Buat kunci unik: "studentID_YYYY-MM-DD"
                return $item->student_id . '_' . $item->attendance_date;
            });

        // 3. Buat kolom tanggal HANYA dari tanggal yang ada di catatan presensi
        $dateColumns = Attendance::where('study_class_id', $studyClass->id)
            ->select('attendance_date')
            ->distinct()
            ->orderBy('attendance_date', 'asc')
            ->pluck('attendance_date')
            ->map(fn($date) => (string) $date); // Pastikan formatnya string

        // 4. Kirim semua data yang sudah diolah ke view
        return view('attendances.history', compact('studyClass', 'studentsInClass', 'attendances', 'dateColumns'));
    }
}
