<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ProfessorsController extends Controller
{
    public function add(Request $request)
    {
        $request['password'] = bcrypt($request->get('password'));
        $user = User::updateOrCreate(['id' => $request->get('id')], $request->all());
        return response([$user], 200);
    }

    public function getList(Request $request)
    {
        $limit = $request->get('limit');
        $total = $request->get('total');

        $users = User::where('role', User::PROFESSOR_ROLE)->get();

        return response(['items' => $users, 'total' => 10], 200);
    }
}
