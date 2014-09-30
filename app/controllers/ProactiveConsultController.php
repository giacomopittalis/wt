<?php

/**
 * Proactive Consult Controller
 * 
 * @author 		Sandi Andrian / andrian.sandi@gmail.com
 * @since 		Sep 30, 2014
 **/

class ProactiveConsultController extends BaseController
{
	public function create()
	{
		return View::make('proactive-consult.form');
	}


	//need add validation
	public function store()
	{
		$health_consult_id = Input::get('health_consult_id');

		ProactiveConsult::create(array(
								'client_id'				=> Input::get('client_id'),
								'location_id'			=> Input::get('location_id'),
								'employee_id'			=> Input::get('employee_id'),
								'under_medical_care'	=> Input::get('under_medical_care'),
								'comment'				=> json_encode(array(
																		'type' 		=> Input::get('type'),
																		'comment'	=> Input::get('comment')
																	  )),
								'follow_up'				=> Input::get('follow_up'),
								'notes'					=> Input::get('notes')
							  ));
		Notification::success('Proactive Consult created successfully');
		return Redirect::route('proactive-consult.create');
	}
}