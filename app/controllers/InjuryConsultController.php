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
		View::share('page_title','New Injury Consult');
		return View::make('injury-consult.form',array('action' => 'create'));
	}

	public function edit()
	{
		View::share('page_title','Edit Injury Consult');
		return View::make('injury-consult.form',array('action' => 'edit'));
	}


	//need add validation
	public function store()
	{
		$id = Input::get('id');

		var_dump(json_encode(Input::get('info'))); exit;

		$info = array(
					'general'	=> array(	
									'moi' => ''
								   )		
				);

		$rules = array(
		            'client_id'			=> array('not_in:0'),
		            'location_id'		=> array('not_in:0'),
		            'contact_id' 		=> array('not_in:0'),
		         );


        $validator = Validator::make(Input::all(), $rules);

        if($validator->fails()) 
        {

        	if($id == null)
			{
				//validation fails
	            return Redirect::route('injury-consult.create')
	            			   ->withInput()
	                           ->withErrors($validator);
			}
			else
			{
				//validation fails
	            return Redirect::route('injury-consult.edit')
	            			   ->withInput()
	                           ->withErrors($validator);
			}
        }
        else
        {
			if($id == null)
			{
				InjuryConsult::create(array(
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
								'fcomment' 	=> 'create new Injury Consult'
							 ));
				Notification::success('Injury Consult created successfully. <a href="'.URL::route('injury-consult.edit').'">You can later access/preview it here</a>');
				return Redirect::route('injury-consult.create');
			}
			else
			{
				$ic = InjuryConsult::find($id);
				$ic->under_medical_care = Input::get('under_medical_care');
				$ic->info = json_encode(Input::get('info'));
				$ic->topics = (Input::get('topic') != "") ? implode(',',Input::get('topic')) : '';
				$ic->soap = (Input::get('soap') != "") ? implode(',',Input::get('soap')) : '';
				$ic->follow_up = Input::get('follow_up');
				$ic->notes = Input::get('notes');
				$ic->save();

				//save activity to Feeds
				Feed::create(array(
								'user_id' 	=> Sentry::getUser()->id,
								'ftype' 	=> 'edit',
								'fcomment' 	=> 'edited the Injury Consult #'.$id
							 ));
				Notification::success('Injury Consult edited successfully. <a href="'.URL::route('injury-consult.edit').'">You can later access/preview it here</a>');
				return Redirect::route('injury-consult.edit');
			}
		}
	}

	/**
	 * AJAX
	 **/
	public function ajaxGetData()
	{
		$buff = InjuryConsult::where('client_id',Input::get('client_id'))
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