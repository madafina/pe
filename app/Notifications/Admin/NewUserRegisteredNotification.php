<?php
namespace App\Notifications\Admin;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NewUserRegisteredNotification extends Notification implements ShouldQueue 
{
    use Queueable;
    protected $newUser;

    public function __construct(User $newUser)
    {
        $this->newUser = $newUser;
    }

    public function via(object $notifiable): array
    {
        return ['database']; // Kirim ke database admin
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => 'Pendaftar baru : ' . $this->newUser->name,
            'url' => route('students.show', $this->newUser->student->id), // Link ke detail siswa
        ];
    }
}