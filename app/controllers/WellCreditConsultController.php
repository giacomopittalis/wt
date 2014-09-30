<?php

/**
 * Well Credit Consult Controller
 * 
 * @author 		Sandi Andrian / andrian.sandi@gmail.com
 * @since 		Sep 30, 2014
 **/

class WellCreditConsultController extends BaseController
{
	public function create()
	{
		return View::make('well-credit-consult.form');
	}


	//need add validation
	public function store()
	{
		$health_consult_id = Input::get('health_consult_id');

		WellCreditConsult::create(array(
								'client_id'				=> Input::get('client_id'),
								'location_id'			=> Input::get('location_id'),
								'employee_id'			=> Input::get('employee_id'),
								'under_medical_care'	=> Input::get('under_medical_care'),
								'comment'				=> implode(',',Input::get('comment'))
							  ));
		Notification::success('Well Credit Consult created successfully');
		return Redirect::route('well-credit-consult.create');
	}
}