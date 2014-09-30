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
Route::get('dashboard',array('as' => 'dashboard', 'uses' => 'HomeController@dashboard'));

//Employee
Route::get('employee/create', array('as' => 'employee.create', 'uses' => 'EmployeeController@create'));
Route::get('employee/{id}/edit', array('as' => 'employee.edit', 'uses' => 'EmployeeController@edit'));
Route::post('employee/store', array('as' => 'employee.store', 'uses' => 'EmployeeController@store'));

//Contact
Route::get('contact/create', array('as' => 'contact.create', 'uses' => 'ContactController@create'));
Route::post('contact/store', array('as' => 'contact.store', 'uses' => 'ContactController@store'));

//Health Consult
Route::get('health-consult/create', array('as' => 'health-consult.create', 'uses' => 'HealthConsultController@create'));
Route::post('health-consult/store', array('as' => 'health-consult.store', 'uses' => 'HealthConsultController@store'));

//Injury Consult
Route::get('injury-consult/create', array('as' => 'injury-consult.create', 'uses' => 'InjuryConsultController@create'));
Route::post('injury-consult/store', array('as' => 'injury-consult.store', 'uses' => 'InjuryConsultController@store'));

//Opportunity Consult
Route::get('opportunity-consult/create', array('as' => 'opportunity-consult.create', 'uses' => 'OpportunityConsultController@create'));
Route::post('opportunity-consult/store', array('as' => 'opportunity-consult.store', 'uses' => 'OpportunityConsultController@store'));

//Proactive Consult
Route::get('proactive-consult/create', array('as' => 'proactive-consult.create', 'uses' => 'ProactiveConsultController@create'));
Route::post('proactive-consult/store', array('as' => 'proactive-consult.store', 'uses' => 'ProactiveConsultController@store'));

//Well Credit Consult
Route::get('well-credit-consult/create', array('as' => 'well-credit-consult.create', 'uses' => 'WellCreditConsultController@create'));
Route::post('well-credit-consult/store', array('as' => 'well-credit-consult.store', 'uses' => 'WellCreditConsultController@store'));