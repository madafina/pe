<?php

namespace App\Notifications;

use App\Channels\WhatsAppChannel;
use App\Models\Payment; // Gunakan model Payment
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentReceivedNotification extends Notification implements ShouldQueue 
{
    use Queueable;

    protected $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function via(object $notifiable): array
    {
        // Kirim notifikasi cicilan hanya via WA dan Database
        return ['database', WhatsAppChannel::class];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'payment_id' => $this->payment->id,
            'invoice_number' => $this->payment->invoice->invoice_number,
            'amount_paid' => $this->payment->amount_paid,
            'message' => 'Pembayaran Rp ' . number_format($this->payment->amount_paid) . ' diterima.',
        ];
    }

    public function toWhatsApp(object $notifiable): string
    {
        $studentName = $notifiable->student->full_name;
        $amountPaid = number_format($this->payment->amount_paid, 0, ',', '.');
        $paymentDate = \Carbon\Carbon::parse($this->payment->payment_date)->format('d F Y');

        return "Yth. Bpk/Ibu Wali dari {$studentName},\n\n" .
               "Kami telah menerima pembayaran Anda dengan rincian:\n" .
               "Jumlah: *Rp {$amountPaid}*\n" .
               "Tanggal Bayar: *{$paymentDate}*\n\n" .
               "Pembayaran Anda telah kami catat. Terima kasih atas kerja samanya.\n *". env('APP_NAME') ."*";
    }
}
