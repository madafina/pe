<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use App\Services\WhatsAppService;

class WhatsAppChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        // Panggil method toWhatsApp dari class notifikasi
        $message = $notification->toWhatsApp($notifiable);

        // Ambil nomor telepon dari user/student
        // Pastikan model User punya relasi student, dan student punya parent_phone_number
        $targetNumber = $notifiable->student->parent_phone_number;

        // Kirim pesan menggunakan service yang sudah ada
        (new WhatsAppService())->sendMessage($targetNumber, $message);
    }
}