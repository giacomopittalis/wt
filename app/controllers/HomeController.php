<?php

/**
 * Home Controller
 * 
 * @author 		Sandi Andrian / andrian.sandi@gmail.com
 * @since 		Sep 29, 2014
 **/
class HomeController extends BaseController 
{
	public function dashboard()
	{
		return View::make('home.dashboard');
	}
}