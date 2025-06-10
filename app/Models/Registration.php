<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function coursePrice()
    {
        return $this->belongsTo(CoursePrice::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
