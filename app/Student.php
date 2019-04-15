<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $guarded = [];

    public function course()
    {
        return $this->belongsToMany(Course::class, 'student_courses','student_id', 'course_id');
    }

    public function grade()
    {
        return $this->hasOne(Grade::class, 'id','grade_id');
    }
}
