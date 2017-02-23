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

Route::get('/', array('as' => 'index', 'uses' => 'StudentController@index'));
Route::get('api/student/{id}', array('as' => 'student', 'uses' => 'StudentController@getStudentData'));
Route::get('student/{id}', array('as' => 'student', 'uses' => 'StudentController@detail'));
Route::get('help', array('as' => 'help', 'uses' => 'StudentController@help'));
Route::get('login', array('as' => 'login', 'uses' => 'HomeController@index'));
Route::get('achievement', array('as' => 'achievement', 'uses' => 'AchievementController@view'));

//Routes in this group requires the user to be authenticated
Route::group( ['middleware' => 'auth' ], function()
{

  // Create
  Route::get('create', array('as' => 'create', 'uses' => 'CreateStudentController@view'));
  Route::put('createStudent', 'CreateStudentController@create');
  // Edit
  Route::get('student/edit/{id}', array('as' => 'edit', 'uses' => 'EditStudentController@view'));
  Route::post('editStudent', 'EditStudentController@edit');
  // Delete
  Route::delete('delete/{id}', array('as' => 'delete', 'uses' => 'StudentController@deleteStudent'));
  
});

// Use this test route to view your object retrieved from the database. Testing purposes
Route::get('test', array('as' => 'test', 'uses' => 'StudentController@testget'));
Route::get('{any}', 'StudentController@index');