<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Accessor untuk menghitung total bayar secara otomatis
    public function getTotalPaidAttribute()
    {
        return $this->payments()->sum('amount_paid');
    }

    // Accessor untuk menghitung sisa tagihan secara otomatis
    public function getRemainingAmountAttribute()
    {
        return $this->amount - $this->total_paid;
    }

    // Accessor untuk status dinamis berdasarkan perhitungan
    public function getCalculatedStatusAttribute()
    {
        if ($this->remaining_amount <= 0) {
            return 'Paid';
        }
        if ($this->total_paid > 0 && $this->total_paid < $this->amount) {
            return 'Partially Paid';
        }
        if ($this->due_date < now()->toDateString() && $this->remaining_amount > 0) {
            return 'Overdue';
        }
        return 'Unpaid';
    }

    public function paymentSubmissions()
    {
        return $this->hasMany(PaymentSubmission::class);
    }
}
