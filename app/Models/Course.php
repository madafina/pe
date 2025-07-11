<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    public function coursePrices()
    {
        return $this->hasMany(CoursePrice::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
}
