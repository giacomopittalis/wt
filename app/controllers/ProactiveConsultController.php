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
		View::share('page_title', 'Create Proactive Consult');
		return View::make('proactive-consult.form',array('action'=>'create'));
	}

	public function edit()
	{
		View::share('page_title', 'Edit Proactive Consult');
		return View::make('proactive-consult.form',array('action'=>'edit'));
	}


	//need add validation
	public function store()
	{
		$id = Input::get('proactive_consult_id');

		$rules = array(
		            'client_id'			=> array('not_in:0'),
		            'location_id'		=> array('not_in:0'),
		            'contact_id' 		=> array('not_in:0'),
		         );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) 
        {
        	if($id == null)
			{
				//validation fails
	            return Redirect::route('proactive-consult.create')
	            			   ->withInput()
	                           ->withErrors($validator);
			}
			else
			{
				//validation fails
	            return Redirect::route('proactive-consult.edit')
	            			   ->withInput()
	                           ->withErrors($validator);
			}
        }
        else
        {
			if($id == null)
			{
				ProactiveConsult::create(array(
										'client_id'				=> Input::get('client_id'),
										'location_id'			=> Input::get('location_id'),
										'employee_id'			=> Input::get('contact_id'),
										'under_medical_care'	=> Input::get('under_medical_care'),
										'comment'				=> json_encode(array(
																				'type' 		=> Input::get('type'),
																				'comment'	=> Input::get('comment')
																			  )),
										'follow_up'				=> Input::get('follow_up'),
										'notes'					=> Input::get('notes')
									  ));
				//save activity to Feeds
    			Feed::create(array(
    						'user_id' 	=> Sentry::getUser()->id,
    						'ftype' 	=> 'create',
    						'fcomment' 	=> 'creted new Proactive Consult'
    					 ));

				Notification::success('Proactive Consult created successfully. <a href="'.URL::route('proactive-consult.edit').'">You can later access/preview it here</a>');
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

				//save activity to Feeds
    			Feed::create(array(
	    						'user_id' 	=> Sentry::getUser()->id,
	    						'ftype' 	=> 'edit',
	    						'fcomment' 	=> 'edited the Proactive Consult #'.$pc->id
	    					 ));
				Notification::success('Proactive Consult updated successfully. <a href="'.URL::route('proactive-consult.edit').'">You can later access/preview it here</a>');
				return Redirect::route('proactive-consult.edit');
			}
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