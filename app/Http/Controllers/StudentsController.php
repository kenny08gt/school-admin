<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;

class StudentsController extends Controller
{
    public function add(Request $request)
    {
        $student = Student::updateOrCreate(['id' => $request->get('id')], $request->except(['courses', 'grade']));
//
//        $student->course()->withTimestamps()->sync($request->get('courses'));

        return response([$student->load('grade')], 200);
    }

    public function getList(Request $request)
    {
        $limit = $request->get('limit');
        $total = $request->get('total');

        $students = Student::with('grade')->get();

        return response(['items' => $students, 'total' => 10], 200);
    }

    public function delete(Request $request)
    {
        $student = Student::where('id', $request->get('id'))->with('grade')->first();
        $student->delete();

        return response(['message' => 'Student deleted', 'student' => $student], 200);
    }
}
