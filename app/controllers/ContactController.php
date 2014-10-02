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
		return View::make('contact.close');
	}

	public function store()
	{
		$contact_id = Input::get('contact_id');

		$rules = array(
		            'client_id'			=> array('not_in:0'),
		            'location_id'		=> array('not_in:0'),
		            'employee_id'		=> array('not_in:0'),
		            'mode'				=> array('not_in:0'),
		            'method'			=> array('not_in:0'),
		            'employee' 			=> array('not_in:0')
		         );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) 
        {
    		//validation fails
            return Redirect::route('contact.create')
            			   ->withInput()
                           ->withErrors($validator);
        } 
        else 
        {
    		Contact::create(array(
		        				'mode' 			=> Input::get('mode'),
		        				'method'		=> Input::get('method'),
		        				'start'			=> Input::get('year').'-'.Input::get('month').'-'.Input::get('day'),
		        				'client_id' 	=> Input::get('client_id'),
		        				'location_id'	=> Input::get('location_id'),
		        				'employee_id' 	=> Input::get('employee_id')
	        			   ));
       		Notification::success('Contact created successfully. You can later access/preview it here');
       		return Redirect::route('contact.create');
        }
	}

	public function do_close()
	{
		$contact = Contact::find(Input::get('contact_id'));
		if($contact->delete())
		{
			Notification::success('Contact has been closed successfully');
			return Redirect::route('contact.close');
		}
	}

	/**
	 * AJAX 
	 **/
	public function ajaxGetData()
	{
		$contact = Contact::select('contacts.id as id','employees.first_name as first_name','employees.last_name as last_name')
						  ->join('employees','contacts.employee_id','=','employees.id')
						  ->where('contacts.client_id',Input::get('client_id'))
						  ->where('contacts.location_id',Input::get('location_id'))
						  ->get()
						  ->toArray();

		if(count($contact) > 0)
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
								'buff' 		=> $contact 
							  ));
	}
}