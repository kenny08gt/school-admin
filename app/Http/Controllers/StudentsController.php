<?php

namespace App\Http\Controllers;

use App\Grade;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentsController extends Controller
{
    public function add(Request $request)
    {
        $student = Student::updateOrCreate(['id' => $request->get('id')], $request->except(['courses', 'grade']));
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

    public function updateScores(Request $request)
    {
        $scores = json_decode($request->get('student'), true);

        foreach ($scores as $key => $score) {
            list($student_id, $course_id) = explode('.', $key);
            DB::insert('INSERT INTO student_courses (student_id, course_id, score, created_at, updated_at) 
                                VALUES (?, ?, ?, ?, ?) 
                                ON DUPLICATE KEY UPDATE student_id = ?, course_id = ?, score = ?, updated_at = ?;',
                array($student_id, $course_id, $score, now(), now(), $student_id, $course_id, $score, now()));
        }

        return response(['message' => 'Success'], 200);
    }

    public function getScores(Request $request)
    {
        $grade  = Grade::findOrFail($request->get('grade_id'));
        $grade->load('courses')->load('students');
        $response = [
            'grade_id' => $grade->id,
            'student' => []
        ];

        foreach ($grade->students as $student) {
            foreach ($grade->courses as $course) {
                $score = DB::select('select score from student_courses where course_id = ? and student_id = ?',
                    array($course->id, $student->id));

                $response['student'][$student->id.'.'.$course->id] = count($score) > 0 ? $score[0]->score : 0;
            }
        }

        return response([$response], 200);
    }
}
