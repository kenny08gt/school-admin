<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $guarded = [];

    public function grades()
    {
        return $this->belongsToMany(Grade::class, 'grade_courses', 'course_id', 'grade_id');
    }


}
