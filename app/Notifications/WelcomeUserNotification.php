<?php

namespace App\Notifications;

use App\Channels\WhatsAppChannel;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeUserNotification extends Notification implements ShouldQueue 
{
    use Queueable;

    protected $user;
    protected $invoice;
    protected $password;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $user, Invoice $invoice, string $password)
    {
        $this->user = $user;
        $this->invoice = $invoice;
        $this->password = $password; // Kita simpan password mentah untuk dikirim
    }

    /**
     * Menentukan channel pengiriman notifikasi.
     */
    public function via(object $notifiable): array
    {
        // Kirim notifikasi selamat datang via Email dan WhatsApp
        return ['mail', WhatsAppChannel::class];
    }

    /**
     * Membuat representasi email dari notifikasi.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $amount = number_format($this->invoice->amount, 0, ',', '.');
        $dueDate = \Carbon\Carbon::parse($this->invoice->due_date)->format('d F Y');

        return (new MailMessage)
                    ->subject('Selamat Bergabung di '. env('APP_NAME') .'!')
                    ->greeting('Halo, ' . $this->user->name . '!')
                    ->line('Selamat! Akun Anda telah berhasil dibuat. Anda sekarang dapat login ke portal siswa kami menggunakan detail berikut:')
                    ->line('**Email:** ' . $this->user->email)
                    ->line('**Password:** ' . $this->password)
                    ->line('---')
                    ->line('Sebagai bagian dari pendaftaran, tagihan pertama Anda telah dibuat:')
                    ->line('**Deskripsi:** ' . $this->invoice->description)
                    ->line('**Jumlah:** Rp ' . $amount)
                    ->line('**Jatuh Tempo:** ' . $dueDate)
                    ->action('Login ke Portal Siswa', route('login'))
                    ->line('Terima kasih telah bergabung dengan kami!');
    }

    /**
     * Membuat representasi WhatsApp dari notifikasi.
     */
    public function toWhatsApp(object $notifiable): string
    {
        $amount = number_format($this->invoice->amount, 0, ',', '.');
        $dueDate = \Carbon\Carbon::parse($this->invoice->due_date)->format('d F Y');
        $studentName = $this->user->name;

        return "Selamat datang di *". env('APP_NAME') ."*, {$studentName}!\n\n" .
               "Akun Anda telah berhasil dibuat. Silakan login dengan:\n" .
               "Email: *{$this->user->email}*\n" .
               "Password: *{$this->password}*\n\n" .
               "Tagihan pertama Anda:\n" .
               "Jumlah: *Rp {$amount}*\n" .
               "Jatuh Tempo: *{$dueDate}*\n\n" .
               "Terima kasih!";
    }
}
