<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	$url = (Input::get('url') != "" ? Input::get('url') : Request::url());

	if($url == base_path())
		$url = URL::route('dashboard');

	//if (Auth::guest()) return Redirect::guest('login');
	if (!Sentry::check())
	{
		Notification::error('You must login to access this site');
		//return Redirect::to('user/login?next='.$url);
		return Redirect::route('login',array('next' => $url));
	}
	//else
	//{
	//	$user = Sentry::getUser();
	//	return Redirect::to('syncro-admin');
	//}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	$url = (Input::get('url') != "" ? Input::get('url') : Request::url());
	//check user first
	$user = Sentry::getUser();

	if(Sentry::check())
	{
		return Redirect::route('dashboard');
	}
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});