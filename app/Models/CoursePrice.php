<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursePrice extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
