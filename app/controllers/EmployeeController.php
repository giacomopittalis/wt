<?php

/**
 * Employee Controller
 * 
 * @author 		Sandi Andrian / andrian.sandi@gmail.com
 * @since 		Sep 30, 2014
 **/
class EmployeeController extends BaseController 
{

	public function __construct()
	{

	}

	public function create()
	{
		View::share('page_title', 'Create Employee');
		return View::make('employee.form', array('action' => 'create'));
	}

	public function edit()
	{
		View::share('page_title', 'Edit Employee');
		return View::make('employee.form', array('action' => 'edit'));
	}

	public function delete()
	{
		View::share('page_title', 'Delete Employee');
		return View::make('employee.delete');
	}

	public function store()
	{
		$employee_id = Input::get('employee_id');

		$rules = array(
		            'first_name' 		=> array('required'),
		            'last_name' 		=> array('required'),
		            'sex' 				=> array('not_in:0'),
		            'department' 		=> array('required'),
		            'position' 			=> array('required'),
		            'hire_year' 		=> array('not_in:0'),
		            'health_plan'		=> array('required'),
		            'client_id'			=> array('not_in:0'),
		            'location_id'		=> array('not_in:0')
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
	            return Redirect::route('employee.edit')
	            			   ->withInput()
	                           ->withErrors($validator);
        	}
        } 
        else 
        {
        	//upload file
        	$employee_image = "";
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

        	//dob
        	$day = (substr(Input::get('dob_day'),1) == "0") ? substr(Input::get('dob_day'),1) : Input::get('dob_day');
        	if(Input::get('dob_year') != 0 && Input::get('dob_month') != 0 && $day)
        	{
        		$dob = Input::get('dob_year').'-'.Input::get('dob_month').'-'.$day;
        	}
        	else 
        	{
        		$dob = NULL;
        	}

        	if(Input::get('employee_id') == NULL)
        	{
        		Employee::create(array(
			        				'first_name' 	=> Input::get('first_name'),
			        				'middle_name'	=> Input::get('middle_name'),
			        				'last_name'		=> Input::get('last_name'),
			        				'sex'			=> Input::get('sex'),
			        				'dob'			=> $dob,
			        				'department'	=> Input::get('department'),
			        				'position'		=> Input::get('position'),
			        				'employee_number' => Input::get('employee_number'),
			        				'hire_year'		=> Input::get('hire_year'),
			        				'hire_type'		=> Input::get('hire_type'),
			        				'health_plan' 	=> Input::get('health_plan'),
			        				'image'			=> $employee_image,
			        				'client_id' 	=> Input::get('client_id'),
			        				'location_id'	=> Input::get('location_id')
		        			   ));

        		//save activity to Feeds
        		Feed::create(array(
        						'user_id' 	=> Sentry::getUser()->id,
        						'ftype' 	=> 'create',
        						'fcomment' 	=> 'created new Employee'
        					 ));

           		Notification::success('Employee created successfully. <a href="'.URL::route('employee.edit').'">You can later access/preview it here</a>');
           		return Redirect::route('employee.create');
        	}
        	else
        	{
        		$emp = Employee::find($employee_id);
        		$emp->first_name 	= Input::get('first_name');
        		$emp->middle_name 	= Input::get('middle_name');
        		$emp->last_name		= Input::get('last_name');
        		$emp->sex 			= Input::get('sex');
        		$emp->dob			= $dob;
			    $emp->department	= Input::get('department');
			    $emp->position		= Input::get('position');
			    $emp->employee_number = Input::get('employee_number');
			    $emp->hire_year		= Input::get('hire_year');
			    $emp->hire_type		= Input::get('hire_type');
			    $emp->health_plan 	= Input::get('health_plan');
			    $emp->image 		= $employee_image;
			    $emp->client_id 	= Input::get('client_id');
			    $emp->location_id	= Input::get('location_id'); 
        		$emp->save();

        		//save activity to Feeds
        		Feed::create(array(
        						'user_id' 	=> Sentry::getUser()->id,
        						'ftype' 	=> 'edit',
        						'fcomment' 	=> 'edited the Employee'
        					 ));

        		Notification::success('Employee updated successfully. <a href="'.URL::route('employee.edit').'">You can later access/preview it here</a>');
        		return Redirect::route('employee.edit');
        	}
        }
	}

	public function do_delete()
	{
		$emp = Employee::find(Input::get('employee_id'));
		if($emp->delete())
		{
			//save activity to Feeds
    		Feed::create(array(
    						'user_id' 	=> Sentry::getUser()->id,
    						'ftype' 	=> 'delete',
    						'fcomment' 	=> 'deleted the Employee #'.$emp->id
    					 ));
			Notification::success('Employee has been deleted');
			return Redirect::route('employee.delete');
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

	public function ajaxGetInfo()
	{
		$employee = Employee::where('id',Input::get('id'))
							->get()
							->toArray();
		if($employee)
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
								'buff' 		=> $employee
							  ));

	}
}