<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $guarded = [];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'grade_courses', 'grade_id', 'course_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'grade_id','id');
    }
}
