<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyClass extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // public function subject()
    // {
    //     return $this->belongsTo(Subject::class);
    // }
    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'study_class_student');
    }
}
