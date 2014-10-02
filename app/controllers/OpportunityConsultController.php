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

		if($health_consult_id == null)
		{
			OpportunityConsult::create(array(
								'client_id'				=> Input::get('client_id'),
								'location_id'			=> Input::get('location_id'),
								'employee_id'			=> Input::get('employee_id'),
								'under_medical_care'	=> Input::get('under_medical_care'),
								'comment'				=> Input::get('comment'),
								'follow_up'				=> Input::get('follow_up'),
								'notes'					=> Input::get('notes')
							  ));
			Notification::success('Opportunity Consult created successfully');
			return Redirect::route('opportunity-consult.create');
		}
		else
		{
			$oc = OpportunityConsult::find($health_consult_id);
			$oc->under_medical_care = Input::get('under_medical_care');
			$oc->comment 			= Input::get('comment');
			$oc->follow_up 			= Input::get('follow_up');
			$oc->notes 				= Input::get('notes');
			$oc->save(); 

			Notification::success('Opportunity Consult updated successfully');
			return Redirect::route('opportunity-consult.edit');
		}
		
		
	}

	/**
	 * AJAX
	 **/
	public function ajaxGetData()
	{
		$oc = OpportunityConsult::where('client_id',Input::get('client_id'))
						  	    ->where('location_id',Input::get('location_id'))
						  	    ->where('employee_id',Input::get('contact_id'))
						  		->get()
						  		->toArray();

		if(count($oc) > 0)
		{
			$code = '200';
			$status = 'success';
		}
		else
		{
			$code = '404';
			$status = 'not found';
		}

		return Response::json(array(
								'code' 		=> $code,
								'status' 	=> $status,
								'buff' 		=> $oc 
							  ));
	}
}