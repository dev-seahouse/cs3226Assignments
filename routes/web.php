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

Auth::routes(); // includes routes for login, register, forget password

Route::get('/', array('as' => 'index', 'uses' => 'ViewController@index'));
Route::get('student/{id}', array('as' => 'student', 'uses' => 'ViewController@detail'));
Route::get('help', array('as' => 'help', 'uses' => 'ViewController@help'));
Route::get('login', array('as' => 'login', 'uses' => 'HomeController@index'));
Route::get('achievement', array('as' => 'achievement', 'uses' => 'ViewController@achievement'));
Route::get('progress', array('as' => 'progress', 'uses' => 'ViewController@progress'));

//API
Route::get('api/student/{id}', 'StudentController@getStudentData');
Route::get('api/progress', 'StudentController@getProgressData');
Route::get('api/progress/{id}', 'StudentController@getProgressDataById');

//Routes in this group requires the user to be authenticated
Route::group( ['middleware' => 'auth' ], function()
{

  // Create
  Route::get('create', array('as' => 'create', 'uses' => 'ViewController@createStudent'));
  Route::put('createStudent', 'CreateStudentController@create');

  //Edit all students
  Route::get('student/edit/all/{section}', array('as' => 'editSection', 'uses' => 'ViewController@editComponent'));
  Route::post('editAllStudent/{section}',  'EditComponentController@edit');

  //Edit single student
  Route::get('student/edit/{id}', array('as' => 'edit', 'uses' => 'ViewController@editStudent'));
  Route::post('editStudent', 'EditStudentController@edit');

  // Delete
  Route::delete('delete/{id}', array('as' => 'delete', 'uses' => 'StudentController@deleteStudent'));
  
});

// Use this test route to view your object retrieved from the database. Testing purposes
Route::get('test', array('as' => 'test', 'uses' => 'StudentController@testget'));

// Catched undefined routes and redirect to index
Route::get('{any}', 'ViewController@index');