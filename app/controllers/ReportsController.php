<?php

/**
 * Reports Controller
 * 
 * @author 		Sandi Andrian / andrian.sandi@gmail.com
 * @since 		Sep 30, 2014
 **/

class ReportsController extends BaseController
{
	public function index()
	{
		View::share('page_title', 'Data Export');
		return View::make('report.index');
	}

	public function export()
	{
		View::share('page_title', 'Data Graph');
		return View::make('report.graph');
	}
}