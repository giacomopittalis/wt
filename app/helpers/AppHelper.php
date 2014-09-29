<?php

/**
 * App Helper
 * 
 * @author 		Sandi Andrian / andrian.sandi@gmail.com
 * @since 		Sep 30, 2014
 **/

class AppHelper
{
	public static function getClients()
	{
		$clients = Client::orderBy('name','ASC')
					   	 ->get();
		$listArray = array();
		$listArray[0] = 'Select Client';
		foreach($clients as $c)
		{
			$listArray[$c->id] = $c->name;
		}
		return $listArray;
	}

	public static function getLocations()
	{
		$location = Location::orderBy('name','ASC')
					   	    ->get();
		$listArray = array();
		$listArray[0] = 'Select Location';
		foreach($location as $l)
		{
			$listArray[$l->id] = $l->name;
		}
		return $listArray;
	}

	public static function getSex()
	{
		return array(
				'' => 'Select Sex',
				'male' => 'Male',
				'female' => 'Female',
			   );
	}

	public static function getYear($min=17,$max=55,$first='Year')
	{
		$now = \Carbon\Carbon::now()->year;
		$min = $now - $min;
		$max = $now - $max;

		$listArray = array();
		$listArray[0] = $first;
		for($i=$min;$i>=$max;$i--)
		{
			$listArray[$i] = $i;
		}
		return $listArray;
	}

	public static function getMonth()
	{
		return array(
					'0' => 'Month',
					'january' => 'January',
					'february' => 'February',
					'march' => 'March',
					'april' => 'April',
					'may' => 'May',
					'june' => 'June',
					'july' => 'July',
					'august' => 'August',
					'september' => 'September',
					'october' => 'October',
					'november' => 'November',
					'december' => 'December'
			   );
	}

	public static function getDay()
	{
		$listArray = array();
		$listArray[0] = 'Day';
		for($i=31;$i>=1;$i--)
		{
			$listArray[$i] = $i;
		}
		return $listArray;
	}

	public static function getHireType()
	{
		return array(
				'0' => 'Select Hire Type',
				'permanent' => 'Permanent',
				'contract' => 'Contract',
				'freelance' => 'Freelance'
			   );
	}
}