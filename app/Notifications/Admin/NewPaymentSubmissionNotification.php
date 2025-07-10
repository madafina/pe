<?php
namespace App\Notifications\Admin;

use App\Models\PaymentSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewPaymentSubmissionNotification extends Notification implements ShouldQueue 
{
    use Queueable;
    protected $submission;

    public function __construct(PaymentSubmission $submission)
    {
        $this->submission = $submission;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => 'Pembayaran baru (' . $this->submission->user->name . ')',
            'url' => route('admin.payment_verifications.index'), // Link ke halaman verifikasi
        ];
    }
}