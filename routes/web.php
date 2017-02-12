<?php

/*===================================
=            View routes            =
===================================*/

Route::get('/', array('as' => 'index', 'uses' => 'StudentController@index'));
Route::get('student/{id}', array('as' => 'student', 'uses' => 'StudentController@detail'));
Route::get('help', array('as' => 'help', 'uses' => 'StudentController@help'));
Route::get('login', array('as' => 'login', 'uses' => 'StudentController@login'));

/*==================================
=            API routes            =
==================================*/
Route::get('api/student/{id}', 'StudentController@getStudentData');


// CRUD
// Create
Route::get('create', array('as' => 'create', 'uses' => 'StudentController@create'));
Route::put('createStudent', 'StudentController@createStudent');
// Edit
Route::get('student/edit/{id}', array('as' => 'edit', 'uses' => 'StudentController@edit'));
Route::post('editStudent', 'StudentController@editStudent');
// Delete
Route::delete('delete/{id}', array('as' => 'delete', 'uses' => 'StudentController@deleteStudent'));


