<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\StudyClassController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CoursePriceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentPortalController; 
use App\Http\Controllers\Admin\PaymentVerificationController;
use App\Http\Controllers\Api\CoursePriceController as ApiCoursePriceController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('role:admin')->group(function () {

    // Route untuk Pendaftaran Siswa
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    Route::get('/students/{student}', [StudentController::class, 'show'])->name('students.show');
    
    Route::resource('course-prices', CoursePriceController::class);
    Route::get('/api/course-prices', [ApiCoursePriceController::class, 'index'])->name('api.course-prices');
    
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
    
    Route::resource('users', UserController::class);
});

Route::middleware('role:finance|admin')->group(function () {
    
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    // Route untuk Invoice
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::post('/invoices/{invoice}/verify', [InvoiceController::class, 'verify'])->name('invoices.verify');
    Route::post('/payments/{invoice}', [PaymentController::class, 'store'])->name('payments.store');
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    
    Route::resource('expenses', ExpenseController::class);
    Route::resource('expense-categories', ExpenseCategoryController::class);
    Route::get('/payment-verifications', [PaymentVerificationController::class, 'index'])->name('admin.payment_verifications.index');

     Route::post('/payment-verifications/{submission}/approve', [PaymentVerificationController::class, 'approve'])->name('payment_verifications.approve');
    Route::post('/payment-verifications/{submission}/reject', [PaymentVerificationController::class, 'reject'])->name('payment_verifications.reject');

});

use App\Http\Controllers\Student\PaymentSubmissionController;

Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/invoices', [StudentPortalController::class, 'invoices'])->name('invoices');
    Route::post('/payment-submissions/{invoice}', [PaymentSubmissionController::class, 'store'])->name('payment_submissions.store');
});

require __DIR__ . '/auth.php';
