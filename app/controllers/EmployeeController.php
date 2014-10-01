<?php

/**
 * Employee Controller
 * 
 * @author 		Sandi Andrian / andrian.sandi@gmail.com
 * @since 		Sep 30, 2014
 **/
class EmployeeController extends BaseController 
{

	public function create()
	{
		return View::make('employee.form', array('action' => 'create'));
	}

	public function edit()
	{
		return View::make('employee.form', array('action' => 'edit'));
	}

	public function delete()
	{
		
	}

	public function store()
	{
		$employee_id = Input::get('employee_id');

		$rules = array(
		            'first_name' 		=> array('required'),
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
        	//upload file
        	if(Input::hasFile('identification'))
        	{
        		$destinationPath = public_path().'/uploads';
	        	$filename = md5(\Carbon\Carbon::now());
	        	$extension = Input::file('service_image')->getClientOriginalExtension();

	        	//do the upload file
	        	$file = Input::file('service_image')
	        		 		  ->move($destinationPath, $filename.'.'.$extension);
        		$service_image = asset('uploads/'.$filename.'.'.$extension);
        	}
        	else
        	{
        		// if there's image and user dont' upload new image 
        		// then the image should not changed
        		if($employee_id != NULL)
        		{
        			$employee = Employee::find($employee_id);
	        		if($employee->image == "")
	        			$employee_iamge = "";
	        		else
	        			$employee_image = $employee->image;
        		}
        		else
        		{
        			$employee_image = "";
        		}
        		
        	}

        	if(Input::get('employee_id') == NULL)
        	{
        		Employee::create(array(
			        				'first_name' 	=> Input::get('first_name'),
			        				'middle_name'	=> Input::get('middle_name'),
			        				'last_name'		=> Input::get('last_name'),
			        				'sex'			=> Input::get('sex'),
			        				'dob'			=> Input::get('dob_year').'-'.Input::get('dob_month').'-'.Input::get('dob_day'),
			        				'department'	=> Input::get('department'),
			        				'position'		=> Input::get('position'),
			        				'hire_year'		=> Input::get('hire_year'),
			        				'hire_type'		=> Input::get('hire_type'),
			        				'health_plan' 	=> Input::get('health_plan'),
			        				'image'			=> $employee_image,
			        				'client_id' 	=> Input::get('client_id'),
			        				'location_id'	=> Input::get('location_id')
		        			   ));
           		Notification::success('Employee created successfully');
           		return Redirect::route('employee.create');
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
	}

	/**
	 * AJAX 
	 **/
	public function ajaxGetData()
	{
		$employees = Employee::select('id','first_name','middle_name','last_name')
							 ->where('client_id',Input::get('client_id'))
							 ->where('location_id', Input::get('location_id'))
							 ->orderBy('first_name','ASC')
							 ->get()
							 ->toArray();

		if(count($employees) > 0)
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
								'buff' 		=> $employees 
							  ));
	}
}