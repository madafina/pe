<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Student;
use App\Models\CoursePrice;
use App\Models\Registration;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;
use App\Notifications\WelcomeUserNotification;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Admin\NewUserRegisteredNotification;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }


    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            // Validasi untuk field baru
            'parent_phone_number' => ['required', 'string', 'max:20'],
            'education_level' => ['required', 'in:Pra-Sekolah,SD,SMP,SMA,Lulus/Umum'],
        ]);

        // Gunakan DB Transaction untuk keamanan data
        DB::beginTransaction();
        try {
            // 1. Buat Akun User Baru
            // Kita tidak set role agar defaultnya adalah user biasa
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->assignRole('student');

            // 2. Buat Data Siswa Baru dan hubungkan dengan user
            $student = Student::create([
                'user_id' => $user->id,
                'full_name' => $request->name,
                'education_level' => $request->education_level,
                'parent_phone_number' => $request->parent_phone_number,
                'registration_date' => now(),
                'status' => 'Non-Aktif', // Status awal adalah Non-Aktif
            ]);

            // 3. Cari Paket Harga yang Berlaku Hari Ini
            $today = now()->toDateString();
            $coursePrice = CoursePrice::whereHas('course', function ($query) use ($request) {
                $query->where('required_level', $request->education_level);
            })
                ->where('registration_open_date', '<=', $today)
                ->where('registration_close_date', '>=', $today)
                ->first();

            // 4. Jika ada paket harga yang cocok, buat pendaftaran & invoice
            if ($coursePrice) {
                $registration = Registration::create([
                    'student_id' => $student->id,
                    'course_price_id' => $coursePrice->id,
                    'transaction_date' => now(),
                    'initial_payment_status' => 'Unpaid',
                ]);

                $invoice = Invoice::create([
                    'registration_id' => $registration->id,
                    'invoice_number' => 'INV-' . date('Ymd') . '-' . str_pad($registration->id, 5, '0', STR_PAD_LEFT),
                    'description' => 'Biaya Pendaftaran Program ' . $coursePrice->course->name,
                    'amount' => $coursePrice->price,
                    'issue_date' => now(),
                    'due_date' => $coursePrice->payment_deadline,
                ]);

                // 4. Buat Pendaftaran & Invoice jika ada paket
                $user->notify(new WelcomeUserNotification($user, $invoice, $request->password));
                // KIRIM NOTIFIKASI KE SEMUA ADMIN
                $admins = User::role('admin')->get();
                Notification::send($admins, new NewUserRegisteredNotification($user));
            }

            // Jika semua berhasil, commit transaksi
            DB::commit();

            event(new Registered($user));

            Auth::login($user);

            // return redirect(RouteServiceProvider::HOME);
            return redirect(route('dashboard', absolute: false));
        } catch (\Exception $e) {
            // Jika ada error, batalkan semua
            DB::rollBack();
            // Redirect kembali dengan pesan error
            return back()->withInput()->with('error', 'Terjadi kesalahan saat pendaftaran. Silakan coba lagi. Error: ' . $e->getMessage());
        }
    }
}
