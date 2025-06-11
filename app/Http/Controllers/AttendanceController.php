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
    /**
     * Menampilkan halaman riwayat presensi.
     */
    public function history(Request $request, StudyClass $studyClass)
    {
        // Eager load relasi untuk efisiensi
        $studyClass->load('students');

        // Ambil data presensi untuk kelas ini
        $attendancesQuery = Attendance::where('study_class_id', $studyClass->id)
            ->with('student') // Ambil juga data siswa
            ->latest('attendance_date'); // Urutkan dari terbaru

        // Terapkan filter tanggal jika ada
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $attendancesQuery->whereBetween('attendance_date', [$request->start_date, $request->end_date]);
        }

        // Ambil hasilnya dan kelompokkan berdasarkan tanggal
        $attendances = $attendancesQuery->get()->groupBy('attendance_date');

        return view('attendances.history', compact('studyClass', 'attendances'));
    }
}
