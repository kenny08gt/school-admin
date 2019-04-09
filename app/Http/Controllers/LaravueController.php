<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaravueController extends Controller
{
    public function index(Request $request)
    {
        return view('laravue');
    }
}
