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
		return View::make('proactive-consult.form',array('action'=>'create'));
	}

	public function edit()
	{
		return View::make('proactive-consult.form',array('action'=>'edit'));
	}


	//need add validation
	public function store()
	{
		$id = Input::get('id');

		if($id == null)
		{
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
		else
		{
			$pc = ProactiveConsult::find($id);
			$pc->under_medical_care	= Input::get('under_medical_care');
			$pc->comment 			= json_encode(array(
													'type' 		=> Input::get('type'),
													'comment'	=> Input::get('comment')
												  ));
			$pc->follow_up			= Input::get('follow_up');
			$pc->notes				= Input::get('notes');
			$pc->save();
			Notification::success('Proactive Consult updated successfully');
			return Redirect::route('proactive-consult.edit');
		}
	}

	/**
	 * AJAX
	 **/
	public function ajaxGetData()
	{
		$buff = ProactiveConsult::where('client_id',Input::get('client_id'))
						  	    ->where('location_id',Input::get('location_id'))
						  	    ->where('employee_id',Input::get('contact_id'))
						  		->get()
						  		->toArray();

		if(count($buff) > 0)
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
								'buff' 		=> $buff 
							  ));
	}
}