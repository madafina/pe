<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function invoice() { return $this->belongsTo(Invoice::class); }
    public function verifier() { return $this->belongsTo(User::class, 'verified_by_id'); }
}
