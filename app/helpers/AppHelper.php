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

	public static function getEmployees($first='Select Employee')
	{
		$employees = Employee::orderBy('first_name','ASC')
							 ->get();
		$listArray = array();
		$listArray[0] = $first;
		foreach($employees as $l)
		{
			$listArray[$l->id] = $l->first_name.' '.$l->middle_name.' '.$l->last_name;
		}
		return $listArray;
	}

	public static function getSex()
	{
		return array(
				'0' => 'Select Sex',
				'male' => 'Male',
				'female' => 'Female',
			   );
	}

	public static function getYear($min=17,$max=55,$first='Year',$operator='-')
	{
		$now = \Carbon\Carbon::now()->year;
		$min = $now - $min;
		if($operator == '-')
		{
			$max = $now - $max;
		}
		elseif($operator == '+')
		{
			$max = $now + $max;
		}
		

		$listArray = array();
		$listArray[0] = $first;
		if($operator == '-')
		{
			for($i=$min;$i>=$max;$i--)
			{
				$listArray[$i] = $i;
			}
		}
		elseif($operator == '+')
		{
			for($i=$min;$i<=$max;$i++)
			{
				$listArray[$i] = $i;
			}
		}
		return $listArray;
	}

	public static function getMonth()
	{
		return array(
					'0' => 'Month',
					'01' => 'January',
					'02' => 'February',
					'03' => 'March',
					'04' => 'April',
					'05' => 'May',
					'06' => 'June',
					'07' => 'July',
					'08' => 'August',
					'09' => 'September',
					'10' => 'October',
					'11' => 'November',
					'12' => 'December'
			   );
	}

	public static function getDay()
	{
		$listArray = array();
		$listArray[0] = 'Day';
		for($i=1;$i<=31;$i++)
		{
			if($i<10)
			{
				$ni = '0'.$i;
			}
			else
			{
				$ni = $i;
			}
			$listArray[$ni] = $i;
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

	public static function getContactMethod()
	{
		return array(
				'0' => 'Select Method',
				'1' => 'One to One',
				'2' => 'One to Many'
			   );
	}

	public static function getContactMode()
	{
		return array(
				'0' => 'Select Mode',
				'1' => 'Normal',
				'2' => 'Private'
			   );
	}

	public static function getHealthTopic()
	{
		return array(
				 'activity' 				=> 'Activity',
				 'weight-concerns'			=> 'Weight Concerns',
				 'nutrition'				=> 'Nutrition',
				 'psychological-concern'	=> 'Psychological Concerns',
				 'company-resources'		=> 'Company Resources',
				 'cardiovascular'			=> 'Cardiovascular',
				 'respiratory'				=> 'Respiratory',
				 'internal-conditions'		=> 'Internal Conditions',
				 'gi_disorders'				=> 'GI Disorders',
				 'general-illness'			=> 'General Illness',
				 'sensory'					=> 'Sensory',
				 'disease-states'			=> 'Disease States',
				 'habit-cessation'			=> 'Habit Cessation',
				 'sleep-disorder'			=> 'Sleep Disorder',
				 'skin-disorder'			=> 'Skin Disorder',
				 'other'					=> 'Other'
			   );
	}

	public static function getHealthSOAP()
	{
		return array(
				'soap-notes' 	=> 'SOAP NOTES',
				's-subjective'	=> 'S-Subjective',
				'o-objective'	=> 'O-Objective',
				'a-assessment'	=> 'A-Assessment',
				'p-plan'		=> 'P-Plan'
			   );
	}

	public static function getInjuryTopic()
	{
		return array(
				'general'		=> 'General Conditions',
				'head'			=> 'Head',
				'face'			=> 'Face',
				'neck'			=> 'Neck',
				'shoulders'		=> 'Shoulders',
				'arm'			=> 'Arm',
				'wrist'			=> 'Wrist / Hand',
				'trink'			=> 'Trink / Chest Abs',
				'lumbar-spine'	=> 'Lumbar Spine',
				'hip'			=> 'Hip / Pelvis',
				'sensory'		=> 'Knee',
				'lower-leg'		=> 'Lower Leg',
				'ankle'			=> 'Ankle / Foot'
			   );
	}

	public static function getCreateMenu()
	{
		return array(
				 array
				 (
				 	'href' 	=> URL::route('employee.create'),
				 	'icon' 	=> 'i02',
				 	'text'	=> 'Create Employee'
				 ),
				 array
				 (
				 	'href' 	=> URL::route('contact.create'),
				 	'icon' 	=> 'i03',
				 	'text'	=> 'Create Contact'
				 ),
				 array
				 (
				 	'href' 	=> URL::route('health-consult.create'),
				 	'icon' 	=> 'i04',
				 	'text'	=> 'New Health Consult'
				 ),
				 array
				 (
				 	'href' 	=> URL::route('injury-consult.create'),
				 	'icon' 	=> 'i05',
				 	'text'	=> 'New Injury Consult'
				 ),
				 array
				 (
				 	'href' 	=> URL::route('opportunity-consult.create'),
				 	'icon' 	=> 'i06',
				 	'text'	=> 'New Opportunity Consult'
				 ),
				 array
				 (
				 	'href' 	=> URL::route('proactive-consult.create'),
				 	'icon' 	=> 'i07',
				 	'text'	=> 'New Proactive Consult'
				 ),
				 array
				 (
				 	'href' 	=> URL::route('well-credit-consult.create'),
				 	'icon' 	=> 'i08',
				 	'text'	=> 'New Well Credit Consult'
				 ),
			   );
	}

	public static function getEditMenu()
	{
		return array(
				 array
				 (
				 	'href' 	=> URL::route('employee.edit'),
				 	'icon' 	=> 'i09',
				 	'text'	=> 'Edit Employee'
				 ),
				 array
				 (
				 	'href' 	=> URL::route('employee.delete'),
				 	'icon' 	=> 'i10',
				 	'text'	=> 'Delete Employee'
				 ),
				 array
				 (
				 	'href' 	=> URL::route('contact.close'),
				 	'icon' 	=> 'i11',
				 	'text'	=> 'Close Contact'
				 ),
				 array
				 (
				 	'href' 	=> URL::route('health-consult.edit'),
				 	'icon' 	=> 'i12',
				 	'text'	=> 'Edit Health Consult'
				 ),
				 array
				 (
				 	'href' 	=> URL::route('injury-consult.edit'),
				 	'icon' 	=> 'i13',
				 	'text'	=> 'Edit Injury Consult'
				 ),
				 array
				 (
				 	'href' 	=> URL::route('opportunity-consult.edit'),
				 	'icon' 	=> 'i14',
				 	'text'	=> 'Edit Opportunity Consult'
				 ),
				 array
				 (
				 	'href' 	=> URL::route('proactive-consult.edit'),
				 	'icon' 	=> 'i15',
				 	'text'	=> 'Edit Proactive Consult'
				 ),
				 array
				 (
				 	'href' 	=> URL::route('reports'),
				 	'icon' 	=> 'i16',
				 	'text'	=> 'Export'
				 ),
			   );
	}

	public static function getDateFormatted($date)
	{
		$ndate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$date);
		$date2 = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$date)
							   ->format('Y-m-d');
		$today = \Carbon\Carbon::now()->format('Y-m-d');
		if($date2 == $today)
		{
			return 'Today at '.$ndate->format('g:i A');
		}
		else
		{
			return $ndate->format('jS F Y \a\t g:ia');
		}
	}

	public static function getUserPicture($user_id)
	{
		$identification = UserProfileComponent::where('user_id',$user_id)
											  ->where('name','identification')
											  ->get()
											  ->first();
		return ($identification) ? $identification->value : asset('assets/img/profile.png');
	}
}