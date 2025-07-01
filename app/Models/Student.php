<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function registration()
    {
        return $this->hasOne(Registration::class);
    }
    public function studyClasses()
    {
        return $this->belongsToMany(StudyClass::class, 'study_class_student');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
