<?php

namespace App\Http\Controllers;

use App\Grade;
use Illuminate\Http\Request;

class GradesController extends Controller
{
    public function add(Request $request)
    {
        $grade = Grade::updateOrCreate(['id' => $request->get('id')], $request->all());
        return response([$grade], 200);
    }

    public function getList(Request $request)
    {
        $limit = $request->get('limit');
        $total = $request->get('total');

        $grades = Grade::all();

        return response(['items' => $grades, 'total' => 10], 200);
    }

    public function delete(Request $request)
    {
        $grade = Grade::findOrFail($request->get('id'));
        $grade->delete();

        return response(['message' => 'Grade deleted', 'grade' => $grade], 200);
    }
}
