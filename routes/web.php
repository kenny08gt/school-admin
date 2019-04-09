<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//
//Route::get('/', function () {
//    return view('welcome');
//});

Route::post('/courses/add', 'CoursesController@add');

Route::get('/{any}', 'LaravueController@index')->where('any', ".*");
//Route::get('/get', function(){
//  dd('hi');
//});
