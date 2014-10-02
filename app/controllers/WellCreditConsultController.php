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
		View::share('page_title','New Well Credit Consult');
		return View::make('well-credit-consult.form');
	}


	//need add validation
	public function store()
	{
		$rules = array(
		            'client_id'			=> array('not_in:0'),
		            'location_id'		=> array('not_in:0'),
		            'contact_id' 		=> array('not_in:0'),
		         );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) 
        {
			//validation fails
            return Redirect::route('well-credit-consult.create')
            			   ->withInput()
                           ->withErrors($validator);
        }
        else
        {
			WellCreditConsult::create(array(
									'client_id'				=> Input::get('client_id'),
									'location_id'			=> Input::get('location_id'),
									'employee_id'			=> Input::get('contact_id'),
									'under_medical_care'	=> Input::get('under_medical_care'),
									'comment'				=> (Input::get('comment') != "") ? implode(',',Input::get('comment')) : ''
								  ));
			Notification::success('Well Credit Consult created successfully');
			return Redirect::route('well-credit-consult.create');
		}
	}
}