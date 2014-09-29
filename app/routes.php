<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'HomeController@dashboard');
Route::get('dashboard','HomeController@dashboard');

//Employee
Route::get('employee/create', array('as' => 'employee.create', 'uses' => 'EmployeeController@create'));
Route::post('employee/store', array('as' => 'employee.store', 'uses' => 'EmployeeController@store'));