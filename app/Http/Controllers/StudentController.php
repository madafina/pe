<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\CoursePrice;
use App\Models\Registration;
use App\Models\Invoice;
use App\Http\Requests\StoreStudentRequest;
use Illuminate\Support\Facades\DB;
use App\DataTables\StudentDataTable;
use App\Http\Requests\UpdateStudentByAdminRequest;
use App\Models\Course;


class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(StudentDataTable $dataTable)
    {
        // Ambil semua data program untuk filter dropdown
        $courses = Course::orderBy('name')->get();

        // Semua logika tabel sekarang dihandle oleh StudentDataTable
        return $dataTable->render('students.index', compact('courses'));
    }

    public function show(Student $student)
    {
        // Eager load semua relasi yang dibutuhkan untuk halaman detail
        $student->load('registration.coursePrice.course', 'registration.invoices');

        return view('students.show', compact('student'));
    }

    public function create()
    {
        // Kita tidak perlu mengirim $coursePrices lagi
        return view('students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request) // <-- GANTI Request menjadi StoreStudentRequest
    {
        // Validasi sudah otomatis dilakukan oleh StoreStudentRequest
        $validated = $request->validated();

        DB::beginTransaction();
        try {
            // 1. Simpan data siswa
            $student = Student::create([
                'full_name' => $validated['full_name'],
                'education_level' => $validated['education_level'],
                'parent_phone_number' => $validated['parent_phone_number'],
                'address' => $validated['address'],
                'school_origin' => $validated['school_origin'],
                'registration_date' => $validated['registration_date'], // Simpan tanggal dari form
                'status' => 'Non-Aktif',
            ]);

            $coursePrice = CoursePrice::find($validated['course_price_id']);

            // 2. Simpan data pendaftaran
            $registration = Registration::create([
                'student_id' => $student->id,
                'course_price_id' => $coursePrice->id,
                'transaction_date' => now(),
                'initial_payment_status' => 'Unpaid',
            ]);

            // 3. Buat Invoice pertama
            Invoice::create([
                'registration_id' => $registration->id,
                'invoice_number' => 'INV-' . date('Ymd') . '-' . str_pad($registration->id, 5, '0', STR_PAD_LEFT),
                'description' => 'Biaya Pendaftaran Program ' . $coursePrice->course->name,
                'amount' => $coursePrice->price,
                'issue_date' => now(),
                'due_date' => $coursePrice->payment_deadline,
            ]);

            DB::commit();

            return redirect()->route('students.index')->with('success', 'Siswa berhasil didaftarkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan. Error: ' . $e->getMessage());
        }
    }

    public function edit(Student $student)
    {
        // Eager load relasi user agar tidak ada query tambahan
        $student->load('user');
        return view('students.edit', compact('student'));
    }

    public function update(UpdateStudentByAdminRequest $request, Student $student)
    {
        $validatedData = $request->validated();

        // Update data di tabel students
        $student->update($validatedData);

        // Update juga data di tabel users jika ada user yang terhubung
        if ($student->user) {
            $student->user->update([
                'name' => $validatedData['full_name'],
                'email' => $validatedData['email'],
            ]);
        }

        return redirect()->route('students.index')->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function destroy(Student $student)
    {
        try {
            // Ambil user yang terhubung dengan siswa ini
            $user = $student->user;

            // Hapus data siswa (soft delete)
            $student->delete();

            // Jika ada user yang terhubung, hapus juga user tersebut (soft delete)
            if ($user) {
                $user->delete();
            }

            return redirect()->route('students.index')->with('success', 'Data siswa dan akun terkait berhasil dipindahkan ke arsip.');
        } catch (\Exception $e) {
            return redirect()->route('students.index')->with('error', 'Gagal menghapus data.');
        }
    }
}
