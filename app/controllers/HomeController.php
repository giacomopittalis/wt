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
					 ->limit(8)
					 ->get();
		return View::make('home.dashboard',array('feeds' => $feeds));
	}

	/**
	 * AJAX
	 **/
	public function ajaxGetData()
	{
		$page = Input::get('page');
		$offset = $page * 8;
		$buff = Feed::select('feeds.*','users.first_name','users.last_name')
					 ->join('users','feeds.user_id','=','users.id')
					 ->orderBy('feeds.created_at','DESC')
					 ->skip($offset)
					 ->take(8)
					 ->get();



		if(count($buff) > 0)
		{
			$code = '200';
			$status = 'success';

			$i = 0;
			$tmp = array();
			foreach($buff as $b)
			{
				$tmp[$i]['id'] = $b->id;
				$tmp[$i]['first_name'] = $b->first_name;
				$tmp[$i]['last_name'] = $b->last_name;
				$tmp[$i]['ftype'] = $b->ftype;
				$tmp[$i]['fcomment'] = $b->fcomment;
				$tmp[$i]['created_at'] = AppHelper::getDateFormatted($b->created_at);

				$i++;
			}

			$buff = $tmp;
		}
		else
		{
			$code = '404';
			$status = 'not found';
		}

		return Response::json(array(
								'code' 		=> $code,
								'status' 	=> $status,
								'buff' 		=> $buff 
							  ));
	}
}