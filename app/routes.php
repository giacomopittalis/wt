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

Route::group(array('before'=>'auth'), function()
{
	Route::get('/', 'HomeController@dashboard');
	Route::get('dashboard',array('as' => 'dashboard', 'uses' => 'HomeController@dashboard'));

	/**
	 * Employee's Route
	 **/
	Route::get('employee/create', array('as' => 'employee.create', 'uses' => 'EmployeeController@create'));
	Route::get('employee/edit', array('as' => 'employee.edit', 'uses' => 'EmployeeController@edit'));
	Route::get('employee/delete', array('as' => 'employee.delete', 'uses' => 'EmployeeController@delete'));
	Route::post('employee/delete', array('as' => 'employee.do_delete', 'uses' => 'EmployeeController@do_delete'));
	Route::post('employee/store', array('as' => 'employee.store', 'uses' => 'EmployeeController@store'));

	/**
	 * Employee's AJAX Route
	 **/
	Route::get('employee/ajax/get-employees', array('as' => 'employee.ajax.get-employees', 'uses' => 'EmployeeController@ajaxGetData'));
	Route::get('employee/ajax/get-info', array('as' => 'employee.ajax.get-info', 'uses' => 'EmployeeController@ajaxGetInfo'));

	/**
	 * Contact's AJAX Route
	 **/
	Route::get('contact/create', array('as' => 'contact.create', 'uses' => 'ContactController@create'));
	Route::get('contact/close', array('as' => 'contact.close', 'uses' => 'ContactController@close'));
	Route::post('contact/close', array('as' => 'contact.do_close', 'uses' => 'ContactController@do_close'));
	Route::post('contact/store', array('as' => 'contact.store', 'uses' => 'ContactController@store'));

	/**
	 * Contact's AJAX Route
	 **/
	Route::get('contact/ajax/get-contacts', array('as' => 'contact.ajax.get-contact', 'uses' => 'ContactController@ajaxGetData'));

	//Health Consult
	Route::get('health-consult/create', array('as' => 'health-consult.create', 'uses' => 'HealthConsultController@create'));
	Route::get('health-consult/edit', array('as' => 'health-consult.edit', 'uses' => 'HealthConsultController@edit'));
	Route::post('health-consult/store', array('as' => 'health-consult.store', 'uses' => 'HealthConsultController@store'));

	//Injury Consult
	Route::get('injury-consult/create', array('as' => 'injury-consult.create', 'uses' => 'InjuryConsultController@create'));
	Route::get('injury-consult/edit', array('as' => 'injury-consult.edit', 'uses' => 'InjuryConsultController@edit'));
	Route::post('injury-consult/store', array('as' => 'injury-consult.store', 'uses' => 'InjuryConsultController@store'));

	//Opportunity Consult
	Route::get('opportunity-consult/create', array('as' => 'opportunity-consult.create', 'uses' => 'OpportunityConsultController@create'));
	Route::get('opportunity-consult/edit', array('as' => 'opportunity-consult.edit', 'uses' => 'OpportunityConsultController@edit'));
	Route::post('opportunity-consult/store', array('as' => 'opportunity-consult.store', 'uses' => 'OpportunityConsultController@store'));

	//Proactive Consult
	Route::get('proactive-consult/create', array('as' => 'proactive-consult.create', 'uses' => 'ProactiveConsultController@create'));
	Route::get('proactive-consult/edit', array('as' => 'proactive-consult.edit', 'uses' => 'ProactiveConsultController@edit'));
	Route::post('proactive-consult/store', array('as' => 'proactive-consult.store', 'uses' => 'ProactiveConsultController@store'));

	//Well Credit Consult
	Route::get('well-credit-consult/create', array('as' => 'well-credit-consult.create', 'uses' => 'WellCreditConsultController@create'));
	Route::post('well-credit-consult/store', array('as' => 'well-credit-consult.store', 'uses' => 'WellCreditConsultController@store'));

	//Reports
	Route::get('reports/export', array('as' => 'reports.export', 'uses' => 'ReportsController@export'));

	//Logout
	Route::get('logout', array('as' => 'logout', 'uses' => 'UserController@logout'));
});

Route::group(array('before'=>'guest'), function()
{
	Route::get('login',array('as' => 'login', 'uses' => 'UserController@login'));
	Route::post('login',array('as' => 'do_login', 'uses' => 'UserController@do_login'));
});
