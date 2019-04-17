<?php

use Illuminate\Http\Request;
use App\Laravue\Faker;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/courses', 'CoursesController@getList');
Route::post('/courses/add', 'CoursesController@add');
Route::delete('/courses', 'CoursesController@delete');

Route::post('/grades', 'GradesController@getList');
Route::post('/grades/get', 'GradesController@get');
Route::post('/grades/add', 'GradesController@add');
Route::delete('/grades', 'GradesController@delete');

Route::post('/professors', 'ProfessorsController@getList');
Route::post('/professors/add', 'ProfessorsController@add');
Route::delete('/professors', 'ProfessorsController@delete');

Route::post('/students', 'StudentsController@getList');
Route::post('/students/get', 'StudentsController@get');
Route::post('/students/add', 'StudentsController@add');
Route::delete('/students', 'StudentsController@delete');

Route::post('/scores', 'StudentsController@updateScores');
Route::post('/scores/get', 'StudentsController@getScores');

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
