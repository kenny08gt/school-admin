<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoursesController extends Controller
{
  public function add(Request $request)
  {
    $course = Course::updateOrCreate(['id' => $request->get('id')], $request->all());
    return response([$course], 200);
  }

  public function getList(Request $request)
  {
    $limit = $request->get('limit');
    $total = $request->get('total');

    $courses = Course::all();

    return response(['items' => $courses, 'total' => 10], 200);
  }
}
