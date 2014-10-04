<?php

/**
 * User Controller
 * 
 * @author 		Sandi Andrian / andrian.sandi@gmail.com
 * @since 		Oct 1, 2014
 **/

class UserController extends BaseController
{
	public function __construct()
	{
		//\Debugbar::disable();
	}

	public function login()
	{
		return View::make('user.login');
	}

	public function logout()
	{
		//logout
		Sentry::logout();
        return Redirect::route('login');
	}

    public function change_password()
    {
        View::share('page_title','Change Password');
        return View::make('user.change_password');
    }

	public function do_login()
	{
		$rules = array(
		            'email' => array('required', 'email'),
		            'password' => array('required')
		        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) 
        {
            //validation fails
            return Redirect::route('login')->withInput()
                            ->withErrors($validator);
        } 
        else 
        {
            //login using Sentry
            try 
            {
                // Set login credentials
                $credentials = array(
				                    'email' => Input::get('email'),
				                    'password' => Input::get('password'),
				               );

                $user = Sentry::findUserByCredentials($credentials);

                try 
                {
                    $throttle = Sentry::findThrottlerByUserId($user->id);

                    if ($throttle->check()) 
                    {
                        // Try to authenticate the user
                        $user = Sentry::authenticate($credentials, false);
                        //return Redirect::to('user/dashboard');
                        if (Input::get('next') == URL::to('/'))
                            $next = URL::route('dashboard');
                        else
                            $next = Input::get('next');

                        //redirect
                        return Redirect::to($next);
                    }
                } 
                catch (Cartalyst\Sentry\Throttling\UserBannedException $e) 
                {
                    Notification::error('User not found.');
                    return Redirect::route('login');
                }
            } 
            catch (Cartalyst\Sentry\Users\WrongPasswordException $e) 
            {
                Notification::error('Wrong password, try again.');
                return Redirect::route('login');
            } 
            catch (Cartalyst\Sentry\Users\UserNotFoundException $e) 
            {
                Notification::error('User was not found.');
                return Redirect::route('login');
            } 
            catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) 
            {
                Notification::error('User is not activated.');
                return Redirect::route('login');
            }
        }
	}

    public function do_change_password()
    {
        //validation first
        $rules = array(
                    'old_password'         => array('required'),
                    'new_password'         => array('required'),
                    //'confirm_password'     => array()
                 );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) 
        {
            //validation fails
            return Redirect::route('change-password')
                           ->withInput()
                           ->withErrors($validator);
        } 
        else 
        {
             //check user first
            $user = Sentry::getUser();
            $old = Input::get('old_password');
            $new = Input::get('new_password');

            try
            {
                // Login credentials
                $credentials = array(
                    'email'    => $user->email,
                    'password' => $old,
                );

                // Authenticate the user
                $user = Sentry::authenticate($credentials, false);
                $user->password = $new;
                $user->save();
                Notification::success('Password changed successfully.');
                return Redirect::route('change-password');
            }
            catch (Cartalyst\Sentry\Users\WrongPasswordException $e)
            {
                Notification::error('Wrong password, try again.');
                return Redirect::route('change-password');
            }
        }
    }
}