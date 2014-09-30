<?php

/**
 * Injury Consult Controller
 * 
 * @author 		Sandi Andrian / andrian.sandi@gmail.com
 * @since 		Sep 30, 2014
 **/

class InjuryConsultController extends BaseController
{
	public function create()
	{
		return View::make('injury-consult.form');
	}

	public function edit()
	{
		return View::make('injury-consult.form');
	}


	//need add validation
	public function store()
	{
		$health_consult_id = Input::get('health_consult_id');

		HealthConsult::create(array(
								'client_id'				=> Input::get('client_id'),
								'location_id'			=> Input::get('location_id'),
								'employee_id'			=> Input::get('employee_id'),
								'under_medical_care'	=> Input::get('under_medical_care'),
								'info'					=> json_encode(Input::get('info')),
								'topics'				=> implode(',',Input::get('topic')),
								'soap'					=> implode(',',Input::get('soap')),
								'follow_up'				=> Input::get('follow_up'),
								'notes'					=> Input::get('notes')
							  ));
		Notification::success('Health Consult created successfully');
		return Redirect::route('health-consult.create');
	}
}