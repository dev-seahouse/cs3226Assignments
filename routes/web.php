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

Route::get('/', array('as' => 'index', 'uses' => 'StudentController@index'));
Route::get('api/student/{id}', array('as' => 'student', 'uses' => 'StudentController@getStudentData'));
Route::get('student/{id}', array('as' => 'student', 'uses' => 'StudentController@detail'));
Route::get('help', array('as' => 'help', 'uses' => 'StudentController@help'));
Route::get('login', array('as' => 'login', 'uses' => 'StudentController@login'));