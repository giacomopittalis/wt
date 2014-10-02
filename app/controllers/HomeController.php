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
		//get 10 feeds for initial
		$feeds = Feed::select('feeds.*','users.first_name','users.last_name')
					 ->join('users','feeds.user_id','=','users.id')
					 ->orderBy('feeds.created_at','DESC')
					 ->limit(10)
					 ->get();
		return View::make('home.dashboard',array('feeds' => $feeds));
	}
}