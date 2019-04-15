<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ProfessorsController extends Controller
{
    public function add(Request $request)
    {
        $request['password'] = bcrypt($request->get('password'));
        $user = User::updateOrCreate(['id' => $request->get('id')], $request->except('courses'));

        if($user->role == User::PROFESSOR_ROLE)
            $user->courses()->withTimestamps()->sync($request->get('courses'));

        return response([$user->load('courses')], 200);
    }

    public function getList(Request $request)
    {
        $limit = $request->get('limit');
        $total = $request->get('total');

        $users = User::where('role', User::PROFESSOR_ROLE)->with('courses')->get();

        return response(['items' => $users, 'total' => 10], 200);
    }

    public function delete(Request $request)
    {
        $professor = User::where('role', User::PROFESSOR_ROLE)->where('id', $request->get('id'))->first();
        $professor->delete();

        return response(['message' => 'User deleted', 'professor' => $professor], 200);
    }
}
