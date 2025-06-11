<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Api\CoursePriceController;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\StudyClassController;
use App\Http\Controllers\AttendanceController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route untuk Pendaftaran Siswa
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    Route::get('/students/{student}', [StudentController::class, 'show'])->name('students.show');

    // Route untuk Invoice
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::post('/invoices/{invoice}/verify', [InvoiceController::class, 'verify'])->name('invoices.verify');
    Route::post('/payments/{invoice}', [PaymentController::class, 'store'])->name('payments.store');

    // Route untuk API mengambil harga kursus <-- TAMBAHKAN INI
    Route::get('/api/course-prices', [CoursePriceController::class, 'index'])->name('api.course-prices');

    Route::resource('tutors', TutorController::class);
    Route::resource('subjects', SubjectController::class);
    // route manajemen kelas
    Route::resource('study-classes', StudyClassController::class);
    Route::post('/study-classes/{studyClass}/add-student', [StudyClassController::class, 'addStudent'])->name('study-classes.addStudent');
    Route::delete('/study-classes/{studyClass}/remove-student/{student}', [StudyClassController::class, 'removeStudent'])->name('study-classes.removeStudent');
    // route presensi
    Route::get('/study-classes/{studyClass}/attendances', [AttendanceController::class, 'create'])->name('attendances.create');
    Route::post('/study-classes/{studyClass}/attendances', [AttendanceController::class, 'store'])->name('attendances.store');
    Route::get('/study-classes/{studyClass}/attendances/history', [AttendanceController::class, 'history'])->name('attendances.history');
});

require __DIR__ . '/auth.php';
