<?php

namespace App\Notifications;

use App\Channels\WhatsAppChannel; // Import channel custom kita
use App\Models\Invoice;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvoicePaidNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $invoice;

    /**
     * Create a new notification instance.
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Menentukan channel pengiriman notifikasi.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [
            'mail',                 // Channel Email
            'database',             // Channel Database
            WhatsAppChannel::class, // Channel WhatsApp
        ];
    }

    /**
     * Membuat representasi email dari notifikasi.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $amount = number_format($this->invoice->amount, 0, ',', '.');
        return (new MailMessage)
                    ->subject('Konfirmasi Pembayaran Lunas - Invoice ' . $this->invoice->invoice_number)
                    ->greeting('Salam, Bapak/Ibu Wali Murid ' . $notifiable->name . '!')
                    ->line('Kami mengonfirmasi bahwa tagihan Anda telah *LUNAS*.')
                    ->line('Detail Tagihan: ' . $this->invoice->description)
                    ->line('Jumlah: Rp ' . $amount)
                    ->action('Lihat Detail Tagihan', url('/student/invoices'))
                    ->line('Terima kasih telah melakukan pembayaran!');
    }

    /**
     * Membuat representasi database dari notifikasi.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'invoice_id' => $this->invoice->id,
            'invoice_number' => $this->invoice->invoice_number,
            'amount' => $this->invoice->amount,
            'message' => 'Pembayaran inv. ' . $this->invoice->invoice_number . ' lunas',
        ];
    }

    /**
     * Membuat representasi WhatsApp dari notifikasi.
     */
    public function toWhatsApp(object $notifiable): string
    {
        $amount = number_format($this->invoice->amount, 0, ',', '.');
        $studentName = $notifiable->student->full_name;

        return "Yth. Bpk/Ibu Wali dari {$studentName},\n\n" .
               "Kami informasikan bahwa tagihan dengan No. Invoice *{$this->invoice->invoice_number}* sejumlah *Rp {$amount}* telah dinyatakan **LUNAS**.\n\n" .
               "Terima kasih atas kepercayaan Anda.\n*".env('APP_NAME')."*";
    }
}