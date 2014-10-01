<?php

/**
 * Opportunity Consult Controller
 * 
 * @author 		Sandi Andrian / andrian.sandi@gmail.com
 * @since 		Sep 30, 2014
 **/

class OpportunityConsultController extends BaseController
{
	public function create()
	{
		return View::make('opportunity-consult.form',array('action' => 'create'));
	}

	public function edit()
	{
		return View::make('opportunity-consult.form',array('action'=>'edit'));
	}


	//need add validation
	public function store()
	{
		$health_consult_id = Input::get('health_consult_id');

		OpportunityConsult::create(array(
								'client_id'				=> Input::get('client_id'),
								'location_id'			=> Input::get('location_id'),
								'employee_id'			=> Input::get('employee_id'),
								'under_medical_care'	=> Input::get('under_medical_care'),
								'comment'				=> json_encode(Input::get('comment')),
								'follow_up'				=> Input::get('follow_up'),
								'notes'					=> Input::get('notes')
							  ));
		Notification::success('Opportunity Consult created successfully');
		return Redirect::route('opportunity-consult.create');
	}
}