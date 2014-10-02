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
		return View::make('injury-consult.form',array('action' => 'create'));
	}

	public function edit()
	{
		return View::make('injury-consult.form',array('action' => 'edit'));
	}


	//need add validation
	public function store()
	{
		$id = Input::get('id');

		if($id == null)
		{
			HealthConsult::create(array(
									'client_id'				=> Input::get('client_id'),
									'location_id'			=> Input::get('location_id'),
									'employee_id'			=> Input::get('contact_id'),
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
		else
		{

		}
	}
}