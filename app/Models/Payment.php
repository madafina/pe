<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes; 
    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();
        // Saat membuat record baru, otomatis isi kolom uuid
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    public function invoice() { return $this->belongsTo(Invoice::class); }
    public function verifier() { return $this->belongsTo(User::class, 'verified_by_id'); }
}
