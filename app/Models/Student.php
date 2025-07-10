<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];

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

    public function setFullNameAttribute($value)
    {
        $this->attributes['full_name'] = ucwords(strtolower($value));
    }
}
