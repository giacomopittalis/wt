<?php

/**
 * Health Consult Controller
 * 
 * @author 		Sandi Andrian / andrian.sandi@gmail.com
 * @since 		Sep 30, 2014
 **/

class HealthConsultController extends BaseController
{
	public function create()
	{
		View::share('page_title','New Health Consult');
		return View::make('health-consult.form',array('action' => 'create'));
	}

	public function edit()
	{
		View::share('page_title','Edit Health Consult');
		return View::make('health-consult.form',array('action' => 'edit'));
	}


	//need add validation
	public function store()
	{
		$id = Input::get('health_consult_id');

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
	            return Redirect::route('health-consult.create')
	            			   ->withInput()
	                           ->withErrors($validator);
			}
			else
			{
				//validation fails
	            return Redirect::route('health-consult.edit')
	            			   ->withInput()
	                           ->withErrors($validator);
			}
        }
        else
        {
			if($id == null)
			{
				HealthConsult::create(array(
										'client_id'				=> Input::get('client_id'),
										'location_id'			=> Input::get('location_id'),
										'employee_id'			=> Input::get('contact_id'),
										'under_medical_care'	=> Input::get('under_medical_care'),
										'info'					=> json_encode(Input::get('info')),
										'topics'				=> (Input::get('topic') != "") ? implode(',',Input::get('topic')) : '',
										'soap'					=> (Input::get('soap') != "") ? implode(',',Input::get('soap')) : '',
										'follow_up'				=> Input::get('follow_up'),
										'notes'					=> Input::get('notes')
									  ));
				//save activity to Feeds
    			Feed::create(array(
	    						'user_id' 	=> Sentry::getUser()->id,
	    						'ftype' 	=> 'create',
	    						'fcomment' 	=> 'create new Health Consult'
	    					 ));
				Notification::success('Health Consult created successfully. <a href="'.URL::route('health-consult.edit').'">You can later access/preview it here</a>');
				return Redirect::route('health-consult.create');
			}
			else
			{
				$hc = HealthConsult::find($id);
				$hc->under_medical_care	= Input::get('under_medical_care');
				$hc->info = json_encode(Input::get('info'));
				$hc->topics = (Input::get('topic') != "") ? implode(',',Input::get('topic')) : '';
				$hc->soap = (Input::get('soap') != "") ? implode(',',Input::get('soap')) : '';
				$hc->follow_up = Input::get('follow_up');
				$hc->notes = Input::get('notes');
				//save activity to Feeds
    			Feed::create(array(
	    						'user_id' 	=> Sentry::getUser()->id,
	    						'ftype' 	=> 'edit',
	    						'fcomment' 	=> 'edit the Health Consult #'.$id
	    					 ));
				Notification::success('Health Consult updated successfully. <a href="'.URL::route('health-consult.edit').'">You can later access/preview it here</a>');
				return Redirect::route('health-consult.edit');
			}
		}
	}


	/**
	 * AJAX
	 **/
	public function ajaxGetData()
	{
		$buff = HealthConsult::where('client_id',Input::get('client_id'))
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