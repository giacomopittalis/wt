<?php

/**
 * Contact Controller
 * 
 * @author 		Sandi Andrian / andrian.sandi@gmail.com
 * @since 		Sep 30, 2014
 **/

class ContactController extends BaseController
{
	public function create()
	{
		return View::make('contact.form');
	}

	public function close()
	{

	}

	public function store()
	{
		$contact_id = Input::get('contact_id');

		/*
		$rules = array(
		            'mode' 				=> array('required'),
		            'last_name' 		=> array('required'),
		            'sex' 				=> array('required_if:sex,0'),
		            'department' 		=> array('required'),
		            'position' 			=> array('required'),
		            'employee_number' 	=> array('required'),
		            'hire_year' 		=> array('required_if:hire_year,0'),
		            'health_plan'		=> array('required'),
		            'client_id'			=> array('required_if:client_id,0'),
		            'location_id'		=> array('required_if:location_id,0')
		         );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) 
        {
        	if(Input::get('employee_id') == NULL)
        	{
        		//validation fails
	            return Redirect::route('employee.create')
	            			   ->withInput()
	                           ->withErrors($validator);
        	}
        	else
        	{
        		//validation fails
	            //return Redirect::route('ngadmin.administration.services.edit',array($service_id))
	            //			   ->withInput()
	            //               ->withErrors($validator);
        	}
        } 
        else 
        {
        	if(Input::get('employee_id') == NULL)
        	{
        */
        		Contact::create(array(
			        				'mode' 			=> Input::get('mode'),
			        				'method'		=> Input::get('method'),
			        				'start'			=> Input::get('year').'-'.Input::get('month').'-'.Input::get('day'),
			        				'client_id' 	=> Input::get('client_id'),
			        				'location_id'	=> Input::get('location_id'),
			        				'employee_id' 	=> Input::get('employee_id')
		        			   ));
           		Notification::success('Contact created successfully');
           		return Redirect::route('contact.create');
        /*	
        	}
        	else
        	{
        		$service = Service::find($service_id);
        		$service->name = Input::get('service_name');
        		$service->image = $service_image;
        		$service->save();
        		Notification::success('Employee updated successfully');
        		return Redirect::route('employee.edit',array($employee_id));
        	}
        }
        */
	}
}