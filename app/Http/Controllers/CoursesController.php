<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoursesController extends Controller
{
  public function add(Request $request)
  {
    $course = Course::updateOrCreate(['id' => $request->get('id')], $request->except('grades'));
    $course->grades()->sync($request->get('grades'));
    return response([$course->load('grades')], 200);
  }

  public function getList(Request $request)
  {
    $limit = $request->get('limit');
    $total = $request->get('total');

    $courses = Course::with('grades')->get();

    return response(['items' => $courses, 'total' => 10], 200);
  }

    public function delete(Request $request)
    {
        $course = Course::findOrFail($request->get('id'));
        $course->delete();

        return response(['message' => 'Course deleted', 'course' => $course], 200);
  }
}
