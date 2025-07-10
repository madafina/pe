<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Import Hash
use App\Http\Requests\UpdateStudentProfileRequest;
use App\Models\Attendance;
use App\Models\StudyClass;

class StudentPortalController extends Controller
{
    // di dalam method invoices()
    public function invoices()
    {
        $user = Auth::user();

        // Ambil semua invoice dan muat relasi yang dibutuhkan sekaligus
        $invoices = $user->student->registration->invoices()
            ->with(['payments.verifier', 'paymentSubmissions']) // <-- UBAH INI
            ->get();

        return view('student_portal.invoices', compact('invoices'));
    }

    /**
     * Menampilkan halaman form edit profil siswa.
     */
    public function editProfile()
    {
        $user = Auth::user()->load('student');
        return view('student_portal.profile.edit', compact('user'));
    }

    /**
     * Memproses pembaruan profil siswa.
     */
    public function updateProfile(UpdateStudentProfileRequest $request)
    {
        $validatedData = $request->validated();
        $user = Auth::user();
        $student = $user->student;

        $student->update($validatedData);

        // Update password jika diisi
        if (!empty($validatedData['password'])) {
            $user->update([
                'password' => Hash::make($validatedData['password']),
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Profil berhasil diperbarui!');
    }

    public function myClasses()
    {
        // Ambil user yang sedang login, lalu ambil data siswanya,
        // kemudian ambil semua kelas yang terhubung melalui relasi
        $studyClasses = Auth::user()->student->studyClasses()->with(['subject', 'tutor'])->get();

        return view('student_portal.my_classes', compact('studyClasses'));
    }

    public function showMyClass(StudyClass $studyClass)
    {
        $user = Auth::user();
        $studentId = $user->student->id;

        // Ambil riwayat presensi siswa ini, khusus untuk kelas ini
        $attendances = Attendance::where('study_class_id', $studyClass->id)
            ->where('student_id', $studentId)
            ->orderBy('attendance_date', 'desc')
            ->get();

        // Ambil daftar teman sekelas (selain diri sendiri)
        $classmates = $studyClass->students()
            ->where('student_id', '!=', $studentId)
            ->orderBy('full_name')
            ->get();

        return view('student_portal.show_my_class', compact('studyClass', 'attendances', 'classmates'));
    }
}
