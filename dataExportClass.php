<?php
	include_once "dbclass.php";
	include_once "crhconsultclass.php";
	include_once "dataQueryclass.php";
    class dataExport extends db{
/*
`OooOOo.                                       
 o     `o                                      
 O      O                            O         
 o     .O                           oOo        
 OOooOO'  .oOo. .oOo. .oOo. `OoOo.   o   .oOo  
 o    o   OooO' O   o O   o  o       O   `Ooo. 
 O     O  O     o   O o   O  O       o       O 
 O      o `OoO' oOoO' `OoO'  o       `oO `OoO' 
                O                              
                o' 

*/
/*
/////
///////////		Metrics    
▒█▀▄▀█ ▒█▀▀▀ ▀▀█▀▀ ▒█▀▀█ ▀█▀ ▒█▀▀█ ▒█▀▀▀█ 
▒█▒█▒█ ▒█▀▀▀ ░▒█░░ ▒█▄▄▀ ▒█░ ▒█░░░ ░▀▀▀▄▄ 
▒█░░▒█ ▒█▄▄▄ ░▒█░░ ▒█░▒█ ▄█▄ ▒█▄▄█ ▒█▄▄▄█ 

*/

	public function createCSV_Metrics($clientID,$dateRange,$locations,$pts = false){ //$pts->Print To Screen
		//declare variables
		$pts=false;
		
		$employeesraw= false;
		$empIDs = false; 
		$emps= false; // indexed by emp id

		$contactsraw =false;
		$conIDs = false;
		$cons = false; // indexed by conid

		$healthmains = false;
		$hcIDs = false;
		$hcs = false; 

		$dbhandle = $this->dbhandleSQLI();

		//$crh = new crhconsult;
		//$hctonee = $crh->gethctonee();

		$dq = new dataQuery;
		///EMPLOYEES
		$employeesraw = $dq->getClientEmployees($clientID,$dateRange,$locations,$dbhandle);
		$emps = $dq->BuildEmployeeArray($employeesraw);
		if($pts){
			echo("<p><b>Employees</b><pre>");
			echo("# of Employees = ".count($emps).'<br>$emps[example] indexed by empid<br>');
			print_r(reset($emps));
			echo("</pre>");
		}
		////CONTACTS
		if($emps){
			$contactsraw = $dq->getEmployeesContacts(array_keys($emps),$dateRange,$dbhandle);  // SQL all emp contacts
			$cons = $dq->BuildContactArray($contactsraw);
			if($pts){
				echo("<p><b>Contacts</b><pre>");
				echo("# of Contacts = ".count($cons).'<br>$cons[example] indexed by conid<br>');
				print_r(reset($cons));
				echo("</pre>");
			}
		}
		/// HEALTH CONSULTS
		$hcdump=false;
		$hcsoap=false;
		if($cons){
			$healthmainsraw = $dq->getContacts_HCIDs(array_keys($cons),$dbhandle); // SQL all Health Consults

			$HCIDtoCONID=false; // indexed by hcid
			foreach($healthmainsraw as $hmrkey => $hmr){
				$HCIDtoCONID[$hmr['id']] = $hmr['conid'];
			}

			if($HCIDtoCONID){
				$healthdumpsraw = $dq->getHCID_dumps(array_keys($HCIDtoCONID),$dbhandle);


				$hcindex = 0;
				foreach($healthdumpsraw as $hckey => $hc){
					if($hc['value'] != ''){
						switch($hc['name']){ // filter only the desired health consult information
							case 'weight':
								$hc['value'] = $this->decode($hc['value']);
								$hcdump[$hcindex] = $hc;
								$hcindex++;
								break;
							case 'bfs': //body fat
								$hc['value'] = $this->decode($hc['value']);
								$hcdump[$hcindex] = $hc;
								$hcindex++;
								break;
							case 'bmi': // metabolic age
								$hc['value'] = $this->decode($hc['value']);
								$hcdump[$hcindex] = $hc;
								$hcindex++;
								break;
							case 'nmxgbC': // smoking
								$hc['value'] = $this->decode($hc['value']);
								$hcdump[$hcindex] = $hc;
								//print_r($hcdump[$hcindex]);
								$hcindex++;
								break;
							default:
								break;
						}
					}
				}
			}
			if($pts){
				echo("<p><b>HCIDtoCONID</b><pre>");
				echo("# of HCIDtoCONID = ".count($HCIDtoCONID).'<br>$HCIDtoCONID[example] <br>');
				print_r(reset($HCIDtoCONID));
				echo("</pre>");

				echo("<p><b>Health Consult HCDUMP Data</b><pre>");
				echo("# of Collected Health Consult 'HCDUMP' Data Elements = ".count($hcdump).'<br>$hcdump[example] indexed by arbitrary value<br>');
				print_r(reset($hcdump));
				echo("</pre>");
				echo("<p>total # of hcdump data elements processed = ");
				echo(count($healthdumpsraw).'<br>');
			}
		}
		$emps = $dq->BuildEmployeeSuperArray($emps,$cons,$HCIDtoCONID,$hcdump);

			/////////					
			///////////////////////////////////////////// Calculate Report Values using $emps array
			///////						
		$totalSustainedWeightLoss = 0; // Total Sustained Weight Loss
		$totalSustainedWeightGain =0;
		$totalEmpsLostWeight=0;
		$totalEmpsGainedWeight=0;
		$totalEmpsWithWeightChangeData=0;
		$netWeightChange=0;

		$totalSustainedBodyFatLoss=0;// Total Sustained Percent of Body Fat Lost
		$totalSustainedBodyFatGain=0;
		$totalEmpsLostBodyFat=0;
		$totalEmpsGainedBodyFat=0;
		$totalEmpsWithBodyFatChangeData=0;
		$netBodyFatChange=0;

		$totalSustainedMetabolicAgeLoss=0;
		$totalSustainedMetabolicAgeGain=0;
		$totalEmpsLostMetabolicAge=0;
		$totalEmpsGainedMetabolicAge=0;
		$totalEmpsWithMetabolicAgeData=0;
		$totalEmpsWithMetabolicAgeChangeData=0;
		$netMetabolicAgeChange=0;

		$totalEmpsQuitTobacco=0; // Total Employees who Quit Tobacco
		$totalEmpsWhoHaveSmoked=0;
		$totalEmpsWhoHaveNotSmoked=0;
		$totalEmpsWithSmokingData=0;

		foreach($emps as $emp){
			$date1=false;
			$date2=false;

			$weight1=false;
			$weight2=false;
			$weightchange =false;
			
			$bodyfat1=false;
			$bodyfat2=false;
			$bodyfatchange=false;

			$metabolicAge1=false;
			$metabolicAge2=false;
			$metabolicAgeChange=false;

			$haveSmoked=false;
			$quitSmoking=false;
			$smokeData=false;

			// HCDUMP
			if(!empty($emp['contacts'])){
				foreach($emp['contacts'] as $con){
					if(!empty($con['hcdump'])){

						foreach($con['hcdump'] as $hc){
							switch($hc['name']){
								case 'weight':
									if($weight1){
										$weight2 = $hc['value'];
									} else {
										$weight1 = $hc['value'];
									}
									break;
								case 'bfs': // body fat segmental
									//print_r($hcd);
									if($bodyfat1){
										$bodyfat2 = $hc['value'];
									} else {
										$bodyfat1 = $hc['value'];
									}
									break;
								case 'bmi':
									if($metabolicAge1){
										$metabolicAge2=$hc['value'];
									} else {
										$metabolicAge1=$hc['value'];
									}
									break;
								case 'nmxgbC': // smoking
									$smokeData=true;
									if($haveSmoked && $hc['value']=='no'){
										$quitSmoking=true;
									}
									if($hc['value'] == 'yes'){
										$haveSmoked=true;
										$quitSmoking=false;
									}
									break;
							}
						}
						//idWt14 = smoking
					}
				}	//END CONTACTS

				//WEIGHT
				if($weight1){
					if($weight2){
						$totalEmpsWithWeightChangeData++;
						$weightchange = round($weight2 - $weight1,2);
						//echo('Weight Change = '.$weightchange.'<br/>&emsp;'.$weight1.' to '.$weight2.' <br>');
						if($weightchange < 0){
							$totalSustainedWeightLoss += $weightchange;
							$totalEmpsLostWeight++;
						}else if($weightchange > 0){
							$totalSustainedWeightGain += $weightchange;
							$totalEmpsGainedWeight++;
						}
						
					}
				}
				//BODY FAT
				if($bodyfat1){
					if($bodyfat2){
						$totalEmpsWithBodyFatChangeData++;
						$bodyfatchange = round($bodyfat2 - $bodyfat1,2);
						//echo('Body Fat Segmental Change = '.$bodyfatchange.'<br/>&emsp;'.$bodyfat1.' to '.$bodyfat2.' <br>');
						if($bodyfatchange < 0){
							$totalSustainedBodyFatLoss += $bodyfatchange;
							$totalEmpsLostBodyFat++;
						}else if($bodyfatchange > 0){
							$totalSustainedBodyFatGain += $bodyfatchange;
							$totalEmpsGainedBodyFat++;
						}
						
					}
				}
				//Metabolic AGE
				if($metabolicAge1){
					$totalEmpsWithMetabolicAgeData++;
					if($metabolicAge2){
						$totalEmpsWithMetabolicAgeChangeData++;
						$metabolicAgeChange = round($metabolicAge2 - $metabolicAge1,2);
						//echo('Metabolic Age Change = '.$metabolicAgeChange.'<br/>&emsp;'.$metabolicAge1.' to '.$metabolicAge2.' <br>');
						if($metabolicAgeChange < 0){
							$totalSustainedMetabolicAgeLoss += $metabolicAgeChange;
							$totalEmpsLostMetabolicAge++;
						}else if($metabolicAgeChange > 0){
							$totalSustainedMetabolicAgeGain += $metabolicAgeChange;
							$totalEmpsGainedMetabolicAge++;
						}
						
					}
				}
				//SMOKING
				if($smokeData){
					$totalEmpsWithSmokingData++;
					if($haveSmoked){
						$totalEmpsWhoHaveSmoked++;
						if($quitSmoking){
							$totalEmpsQuitTobacco++;	
						}
					} else {
						$totalEmpsWhoHaveNotSmoked++;
					}
				}
			}
		}//END EMPLOYEE

		$netWeightChange = $totalSustainedWeightLoss + $totalSustainedWeightGain;
		$netBodyFatChange = $totalSustainedBodyFatLoss + $totalSustainedBodyFatGain;
		$netMetabolicAgeChange = $totalSustainedMetabolicAgeLoss +$totalSustainedMetabolicAgeGain;
		if($pts){
			echo('<pre>');	
			echo("<br/><br/>");
			echo("Total Employees Queried = ".count($emps));

			echo("<br/><br/>");
			echo('Total Weight Lost = '.-$totalSustainedWeightLoss."<br>");
			echo('Total Employees Who Lost Weight = '.$totalEmpsLostWeight."<br>");
			echo('Total Weight Gain = '.$totalSustainedWeightGain."<br>");
			echo('Total Employees Who Gained Weight = '.$totalEmpsGainedWeight."<br>");
			echo('Total Employees with Weight Change Data = '.$totalEmpsWithWeightChangeData."<br/>");
			echo('Net Weight Change = '.$netWeightChange."<br/>");

			echo("<br/><br/>");
			echo('Total Body-Fat Lost = '.-$totalSustainedBodyFatLoss."<br>");
			echo('Total Employees Who Lost Body-Fat = '.$totalEmpsLostBodyFat."<br>");
			echo('Total Body-Fat Gain = '.$totalSustainedBodyFatGain."<br>");
			echo('Total Employees Who Gained Body-Fat = '.$totalEmpsGainedBodyFat."<br>");
			echo('Total Employees with Body-Fat Change Data = '.$totalEmpsWithBodyFatChangeData."<br/>");
			echo('Net Body-Fat Change = '.$netBodyFatChange."<br/>");

			echo("<br/><br/>");
			echo('Total Metabolic-Age Lost = '.-$totalSustainedMetabolicAgeLoss."<br>");
			echo('Total Employees Who Lost Metabolic-Age = '.$totalEmpsLostMetabolicAge."<br>");
			echo('Total Metabolic-Age Gain = '.$totalSustainedMetabolicAgeGain."<br>");
			echo('Total Employees Who Gained Metabolic-Age = '.$totalEmpsGainedMetabolicAge."<br>");
			echo('Total Employees with Metabolic-Age Change Data = '.$totalEmpsWithMetabolicAgeChangeData."<br/>");
			echo('Total Employees with Any Metabolic-Age Data = '.$totalEmpsWithMetabolicAgeData."<br/>");
			echo('Net Metabolic-Age Change = '.$netMetabolicAgeChange."<br/>");

			echo('<br/><br/>');
			echo('Total Employees Who Are Recorded Having Not Smoked = '.$totalEmpsWhoHaveNotSmoked."<br>");
			echo('Total Employees Who Have Smoked = '.$totalEmpsWhoHaveSmoked."<br>");
			echo('Total Employees Who Quit Smoking = '.$totalEmpsQuitTobacco."<br>");
			echo('Total Employees with Smoking Data = '.$totalEmpsWithSmokingData."<br/>");
			echo('</pre>');	
		}
		/////// BUILD CSV
		$clientName = $this->getClientName($clientID,$dbhandle);
		$today = getdate();
		if($dateRange['useDateRange']){
			$csvFileName = $clientName."-Metrics-".$dateRange['startMonth']."-".$dateRange['startDay']."-".$dateRange['startYear']."-TO-".$dateRange['endMonth']."-".$dateRange['endDay']."-".$dateRange['endYear']."__".$today['year']."_".$today['month']."_".$today['mday'];
		}else{
			$csvFileName = $clientName."-Metrics_".$today['year']."_".$today['month']."_".$today['mday'];
		}

		$csvText = $clientName."\n";
		$csvText .= "Report Type,Metrics\n";
		if($dateRange['useDateRange']){
			$csvText .= "FOR,".$dateRange['startMonth']."/".$dateRange['startDay']."/".$dateRange['startYear'].",TO,".$dateRange['endMonth']."/".$dateRange['endDay']."/".$dateRange['endYear']."\n";
		}
		if($locations['useLocations']){
			$csvText .= "FOR LOCATIONS,";
			foreach($locations['ids'] as $lockey => $loc){
				if($lockey == 0){
					$csvText .= $loc."\n";
				}else{
					$csvText .= " ,".$loc."\n";
				}
			}
		}
		$csvText .="\n";

		$csvText .= 'Total Sustained Weight Lost:,'.-$totalSustainedWeightLoss." Pounds\n";
		$csvText .= 'Total Combined Sustained % Body Fat Lost:,'.-$totalSustainedBodyFatLoss."%\n";
		$csvText .= 'Total Metabolic Years Lost:,'.$totalSustainedMetabolicAgeLoss." Years\n";
		$csvText .= 'Total Employees Who Quit Tobacco:,'.$totalEmpsQuitTobacco."\n";

		///// EXTRA DATA
		$csvText .= "\n\n\n";
		$csvText .= 'Total Sustained Weight Lost = ,'.-$totalSustainedWeightLoss." Pounds\n";
		$csvText .= 'Total Employees Who Lost Weight = ,'.$totalEmpsLostWeight."\n";
		$csvText .= 'Total Sustained Weight Gain = ,'.$totalSustainedWeightGain." Pounds\n";
		$csvText .= 'Total Employees Who Gained Weight = ,'.$totalEmpsGainedWeight."\n";
		$csvText .= 'Total Employees with Weight Change Data = ,'.$totalEmpsWithWeightChangeData."\n";
		$csvText .= 'Net Weight Change = ,'.$netWeightChange." Pounds\n";
		$csvText .= "\n";
		$csvText .='Total Sustained Body-Fat Lost = ,'.-$totalSustainedBodyFatLoss."%\n";
		$csvText .='Total Employees Who Lost Body-Fat = ,'.$totalEmpsLostBodyFat."\n";
		$csvText .='Average Lost Among Losers = ,'.round(-$totalSustainedBodyFatLoss/$totalEmpsLostBodyFat,2)."%\n";
		$csvText .='Total Body-Fat Gain = ,'.$totalSustainedBodyFatGain."%\n";
		$csvText .='Total Employees Who Gained Body-Fat = ,'.$totalEmpsGainedBodyFat."\n";
		$csvText .='Average Gained Among Gainers = ,'.round($totalSustainedBodyFatGain/$totalEmpsGainedBodyFat,2)."%\n";
		$csvText .='Total Employees with Body-Fat Change Data = ,'.$totalEmpsWithBodyFatChangeData."\n";
		$csvText .='Net Body-Fat Change = ,'.$netBodyFatChange."%\n";
		$csvText .="\n";
		$csvText .= 'Total Metabolic Years Lost = ,'.$totalSustainedMetabolicAgeLoss." Years\n";
		$csvText .= 'Total Employees Who Lost Metabolic-Age = ,'.$totalEmpsLostMetabolicAge."\n";
		$csvText .= 'Total Metabolic-Age Gain = ,'.$totalSustainedMetabolicAgeGain." Years\n";
		$csvText .= 'Total Employees Who Gained Metabolic-Age = ,'.$totalEmpsGainedMetabolicAge."\n";
		$csvText .= 'Total Employees with Metabolic-Age Change Data = ,'.$totalEmpsWithMetabolicAgeChangeData."\n";
		$csvText .= 'Total Employees with Any Metabolic-Age Data = ,'.$totalEmpsWithMetabolicAgeData."\n";
		$csvText .= 'Net Metabolic-Age Change = ,'.$netMetabolicAgeChange." Years\n";
		$csvText .= "\n";
		$csvText .= 'Total Employees Who Are Recorded Having Not Smoked = ,'.$totalEmpsWhoHaveNotSmoked."\n";
		$csvText .= 'Total Employees Who Have Smoked = ,'.$totalEmpsWhoHaveSmoked."\n";
		$csvText .= 'Total Employees Who Quit Smoking = ,'.$totalEmpsQuitTobacco."\n";
		$csvText .= 'Total Employees with Smoking Data = ,'.$totalEmpsWithSmokingData."\n";

		$csvReturn =  array ( 'name' => $csvFileName , 'csv' => $csvText , );
		return $csvReturn;
	}


/*
/////
///////////		Injury Consult Topics
▀█▀ ▒█▄░▒█ ░░░▒█ ▒█░▒█ ▒█▀▀█ ▒█░░▒█ 　 ▒█▀▀█ ▒█▀▀▀█ ▒█▄░▒█ ▒█▀▀▀█ ▒█░▒█ ▒█░░░ ▀▀█▀▀ 　 ▀▀█▀▀ ▒█▀▀▀█ ▒█▀▀█ ▀█▀ ▒█▀▀█ ▒█▀▀▀█ 
▒█░ ▒█▒█▒█ ░▄░▒█ ▒█░▒█ ▒█▄▄▀ ▒█▄▄▄█ 　 ▒█░░░ ▒█░░▒█ ▒█▒█▒█ ░▀▀▀▄▄ ▒█░▒█ ▒█░░░ ░▒█░░ 　 ░▒█░░ ▒█░░▒█ ▒█▄▄█ ▒█░ ▒█░░░ ░▀▀▀▄▄ 
▄█▄ ▒█░░▀█ ▒█▄▄█ ░▀▄▄▀ ▒█░▒█ ░░▒█░░ 　 ▒█▄▄█ ▒█▄▄▄█ ▒█░░▀█ ▒█▄▄▄█ ░▀▄▄▀ ▒█▄▄█ ░▒█░░ 　 ░▒█░░ ▒█▄▄▄█ ▒█░░░ ▄█▄ ▒█▄▄█ ▒█▄▄▄█ 

*/

	public function createCSV_InjuryConsultTopics($clientID,$dateRange,$locations,$dev = false){
 		$start = time();

		$dbhandle = $this->dbhandleSQLI();
		$clientName = $this->getClientName($clientID,$dbhandle);
		$topics = $this->getTopics();
		$today = getdate();

		$dq = new dataQuery;
		///EMPLOYEES
		$employeesraw = $dq->getClientEmployees($clientID,$dateRange,$locations,$dbhandle);
		$emps = $dq->BuildEmployeeArray($employeesraw);
		if($dev){
			echo("<p><b>Employees</b><pre>");
			echo("# of Employees = ".count($emps).'<br>$emps[example] indexed by empid<br>');
			print_r(reset($emps));
			echo("</pre>");
		}
		////CONTACTS
		if($emps){
			$contactsraw = $dq->getEmployeesContacts(array_keys($emps),$dateRange,$dbhandle);  // SQL all emp contacts
			$cons = $dq->BuildContactArray($contactsraw);
			if($dev){
				echo("<p><b>Contacts</b><pre>");
				echo("# of Contacts = ".count($cons).'<br>$cons[example] indexed by conid<br>');
				print_r(reset($cons));
				echo("</pre>");
			}
		}
		//Injury Consults
		if($cons){
			$injurymainsraw = $dq->getContacts_ICIDs(array_keys($cons),$dbhandle); // SQL all Injury Consults
			$ICS = $dq->BuildInjuryConsultArray($injurymainsraw,true,false,$dbhandle);
			if($dev){
				echo"<pre>HERE ARE THE ICDUMPS FROM MY UBER FUNCTION!!!<br><br>";
				print_r($ICS['dump']);
				echo"</pre>";
				echo"<pre>AND HERE ARE THE ICIDtoCONIDs FROM MY UBER FUNCTION!!!<br><br>";
				print_r($ICS['ICIDtoCONID']);
				echo"</pre>";
			}
		}
		$emps = $dq->BuildEmployeeSuperArray($emps,$cons,false,false,false,$ICS['ICIDtoCONID'],$ICS['dump'],false);
		if($dev){
				echo"<pre>HERE ARE THE EMPS FROM MY UBER FUNCTION!!!<br><br>";
				print_r($emps);
				echo"</pre>";
			}



		//exit();
		// CALCULATE
		$intialProgramStartDate;

		$totalContacts = 0;
		$totalInjuryConsults = 0;
		$totalEmployees = count($emps);
		$totalEmployeesWithContacts = 0;

		$injuryConsultTopics = array();

		$contactDateRange = array();

		foreach( $emps as $empkey => $emp ){	
			//$emp = $this->stripCommas($emp);
			if( !empty($emp['contacts']) ) {
				$totalEmployeesWithContacts++;
			}
			foreach( $emp['contacts'] as $conkey => $con ){
				$contactDateRange = $this->updateDateRange($con['dat'],$contactDateRange);
				$totalContacts++;
				//$con = $this->stripCommas($con);
				if( !empty($con['icdump']) ){
					$totalInjuryConsults++;
					foreach( $con['icdump'] as $icdumpkey => $icdump ){
						if(substr($icdump['name'],0,2) == 'nm'){
							$t="";
							if($icdump['value'] != 'no' && $icdump['value'] != ''){
								for($x=0; $x < count($topics); $x++ ){
									if($icdump['name'] == $topics[$x]['tname']){
										$t = $topics[$x]['topic'];
										if( isset($injuryConsultTopics[$t]) ){
											$injuryConsultTopics[$t] = $injuryConsultTopics[$t] + 1;
										}else{
											$injuryConsultTopics[$t] = 1;
										}
										break;
									} 
								}
							}
						}
					}
				}
			}
		}
		$end = time();
		/*
		echo('Total Employees = '.$totalEmployees.'<br/>');
		echo('Total Employees with Contacts = '.$totalEmployeesWithContacts.'<br/>');
		echo('Total Contacts = '.$totalContacts.'<br/>');
		echo('Total Consults = '.$totalConsults.'<br/>');
		echo('<br/>');
		print_r($reportingPeriod);
		echo('<br/>');
		echo($start.'---,'.$end.'   Total Time = '. ($end - $start) );
		*/

		// BUILD CSV
		if($dateRange['useDateRange']){
			$csvFileName = $clientName."-Injury-Consult-Topics-".$dateRange['startMonth']."-".$dateRange['startDay']."-".$dateRange['startYear']."-TO-".$dateRange['endMonth']."-".$dateRange['endDay']."-".$dateRange['endYear']."__".$today['year']."_".$today['month']."_".$today['mday'];
		}else{
			$csvFileName = $clientName."-Injury-Consult-Topics_".$today['year']."_".$today['month']."_".$today['mday'];
		}

		$csvText = $clientName."\n";
		$csvText .= "Report Type,Injury Consult Topics\n";
		if($dateRange['useDateRange']){
			$csvText .= "FOR DATES,".$dateRange['startMonth']."/".$dateRange['startDay']."/".$dateRange['startYear'].",TO,".$dateRange['endMonth']."/".$dateRange['endDay']."/".$dateRange['endYear']."\n";
		}
		if($locations['useLocations']){
			$csvText .= "FOR LOCATIONS,";
			foreach($locations['ids'] as $lockey => $loc){
				if($lockey == 0){
					$csvText .= $loc."\n";
				}else{
					$csvText .= " ,".$loc."\n";
				}
			}
		}
		$csvText .="\n";
		$csvText .= 'Total Injury Consults,'.$totalInjuryConsults."\n";
		$csvText .= 'Injury Consult Topics,Frequency,Ranking'."\n";
		arsort($injuryConsultTopics);
		$ranking = 1;
		$tieNumber = 1;
		$last='';
		foreach( $injuryConsultTopics as $key => $ict ){
			if($last == $ict){
				$csvText .= $key .','.$ict.','.($ranking-$tieNumber)."\n";
				$tieNumber++;
			}else {
				$csvText .= $key .','.$ict.','.$ranking."\n";
				$tieNumber=1;
			}
			$last = $ict;
			$ranking++;
		}
		if($dev){
			$csvText .= "\n\nTotal Time,". ($end - $start);
		}
		$csvReturn =  array ( 'name' => $csvFileName , 'csv' => $csvText , );
		return $csvReturn;
 	}

					///////////////////////////////ALtered InJuRy ToPiCs!
	public function createCSV_InjuryConsultTopics____OLD($clientID,$dateRange,$locations,$dev = false){
	 		$start = time();
			$totalContacts = 0;
			$totalInjuryConsults = 0;
			$injuryConsultTopics = array();
			$totalEmployees = 0;
			$totalEmployeesWithContacts = 0;
			$intialProgramStartDate;
			$contactDateRange = array();
			$dbhandle = $this->dbhandleSQLI();
			$clientName = $this->getClientName($clientID,$dbhandle);
			$topics = $this->getTopics();
			$today = getdate();
			if($dateRange['useDateRange']){
				$csvFileName = $clientName."-Injury-Consult-Topics-".$dateRange['startMonth']."-".$dateRange['startDay']."-".$dateRange['startYear']."-TO-".$dateRange['endMonth']."-".$dateRange['endDay']."-".$dateRange['endYear']."__".$today['year']."_".$today['month']."_".$today['mday'];
			}else{
				$csvFileName = $clientName."-Injury-Consult-Topics_".$today['year']."_".$today['month']."_".$today['mday'];
			}
			$employee = $this->getClientEmployees($clientID,$dateRange,$dbhandle,true);
			foreach( $employee as $key => $e ){	
				$totalEmployees++;	
				$e = $this->stripCommas($e);
				$contacts = $this->getEmployeeContacts($e['ID'],$dateRange,$dbhandle,true);
				if( !empty($contacts) ) {
					$totalEmployeesWithContacts++;
				}
				foreach( $contacts as $key => $ct ){
					if($ct != null){
						$contactDateRange = $this->updateDateRange($ct['dat'],$contactDateRange);
						$totalContacts++;
						$ct = $this->stripCommas($ct);
						$ct['location'] = $this->getLocation($ct['locid']);
						$ct['location'] = $this->stripCommas($ct['location']);
						$consults = $this->getInjuryConsultTopics($ct['id'],$dbhandle,false);
						//print_r($consults);
						/*
						if(isset($consults['soap'])){
							$totalInjuryConsults++;
							foreach( $consults['soap'] as $key => $ic ){
								//print_r($ic);
								//echo('<br/>');
								//if($ic['value'] != 'no'){
								if( isset($injuryConsultTopics[$ic['name']]) ){
									$injuryConsultTopics[$ic['name']] = $injuryConsultTopics[$ic['name']] + 1;
								}else{
									$injuryConsultTopics[$ic['name']] = 1;
								}
							}
						}*/
						if(isset($consults['dump'])){
							$totalInjuryConsults++;
							foreach( $consults['dump'] as $key => $ic ){
								//if($ic['value'] != 'no'){
								/*
								if( $ic['name'] == 'bp' ){
									echo('<br/>');
									echo('BODYPART!!! '.$ic['name'].' : '.$ic['value']);
								}else{
									//echo('  '.$ic['name'].' : '.$ic['value']);
								}
								if($ic['value'] != 'no' &&  $ic['value'] != ''){
									echo('<br/>');
									print_r($ic);
								}
								*/
								if(substr($ic['name'],0,2) == 'nm'){
									$t="";
									if($ic['value'] != 'no' && $ic['value'] != ''){
										for($x=0; $x < count($topics); $x++ ){
											if($ic['name'] == $topics[$x]['tname']){
												$t = $topics[$x]['topic'];
												if( isset($injuryConsultTopics[$t]) ){
													$injuryConsultTopics[$t] = $injuryConsultTopics[$t] + 1;
												}else{
													$injuryConsultTopics[$t] = 1;
												}
												break;
											} 
										}
									}
								}
							}
						}
					}
				}

			}
			$end = time();
			/*
			echo('Total Employees = '.$totalEmployees.'<br/>');
			echo('Total Employees with Contacts = '.$totalEmployeesWithContacts.'<br/>');
			echo('Total Contacts = '.$totalContacts.'<br/>');
			echo('Total Consults = '.$totalConsults.'<br/>');
			echo('<br/>');
			print_r($reportingPeriod);
			echo('<br/>');
			echo($start.'---,'.$end.'   Total Time = '. ($end - $start) );
			*/
			$csvText = $clientName."\n";
			$csvText .= "Report Type,Injury Consult Topics\n";
			if($dateRange['useDateRange']){
				$csvText .= "FOR,".$dateRange['startMonth']."/".$dateRange['startDay']."/".$dateRange['startYear'].",TO,".$dateRange['endMonth']."/".$dateRange['endDay']."/".$dateRange['endYear']."\n";
			}
			$csvText .="\n";
			$csvText .= 'Total Injury Consults,'.$totalInjuryConsults."\n";
			$csvText .= 'Injury Consult Topics,Frequency,Ranking'."\n";
			arsort($injuryConsultTopics);
			$ranking = 1;
			$tieNumber = 1;
			$last='';
			foreach( $injuryConsultTopics as $key => $ict ){
				if($last == $ict){
					$csvText .= $key .','.$ict.','.($ranking-$tieNumber)."\n";
					$tieNumber++;
				}else {
					$csvText .= $key .','.$ict.','.$ranking."\n";
					$tieNumber=1;
				}
				$last = $ict;
				$ranking++;
			}
			$csvText .= "\n\nTotal Time,". ($end - $start);
			$csvReturn =  array ( 'name' => $csvFileName , 'csv' => $csvText , );
			return $csvReturn;
	 		}
/*
/////
///////////		Proactive Consult Topics 
▒█▀▀█ ▒█▀▀█ ▒█▀▀▀█ ░█▀▀█ ▒█▀▀█ ▀▀█▀▀ ▀█▀ ▒█░░▒█ ▒█▀▀▀ 　 ▒█▀▀█ ▒█▀▀▀█ ▒█▄░▒█ ▒█▀▀▀█ ▒█░▒█ ▒█░░░ ▀▀█▀▀ 　 ▀▀█▀▀ ▒█▀▀▀█ ▒█▀▀█ ▀█▀ ▒█▀▀█ ▒█▀▀▀█ 
▒█▄▄█ ▒█▄▄▀ ▒█░░▒█ ▒█▄▄█ ▒█░░░ ░▒█░░ ▒█░ ░▒█▒█░ ▒█▀▀▀ 　 ▒█░░░ ▒█░░▒█ ▒█▒█▒█ ░▀▀▀▄▄ ▒█░▒█ ▒█░░░ ░▒█░░ 　 ░▒█░░ ▒█░░▒█ ▒█▄▄█ ▒█░ ▒█░░░ ░▀▀▀▄▄ 
▒█░░░ ▒█░▒█ ▒█▄▄▄█ ▒█░▒█ ▒█▄▄█ ░▒█░░ ▄█▄ ░░▀▄▀░ ▒█▄▄▄ 　 ▒█▄▄█ ▒█▄▄▄█ ▒█░░▀█ ▒█▄▄▄█ ░▀▄▄▀ ▒█▄▄█ ░▒█░░ 　 ░▒█░░ ▒█▄▄▄█ ▒█░░░ ▄█▄ ▒█▄▄█ ▒█▄▄▄█ 

*/

	public function createCSV_ProactiveConsultTopics($clientID,$dateRange,$locations,$dev = false){

		$start = time();
		$dbhandle = $this->dbhandleSQLI();


		$dq = new dataQuery;
		///EMPLOYEES
		$employeesraw = $dq->getClientEmployees($clientID,$dateRange,$locations,$dbhandle);
		$emps = $dq->BuildEmployeeArray($employeesraw);
		if($dev){
			echo("<p><b>Employees</b><pre>");
			echo("# of Employees = ".count($emps).'<br>$emps[example] indexed by empid<br>');
			print_r(reset($emps));
			echo("</pre>");
		}
		////CONTACTS
		if($emps){
			$contactsraw = $dq->getEmployeesContacts(array_keys($emps),$dateRange,$dbhandle);  // SQL all emp contacts
			$cons = $dq->BuildContactArray($contactsraw);
			if($dev){
				echo("<p><b>Contacts</b><pre>");
				echo("# of Contacts = ".count($cons).'<br>$cons[example] indexed by conid<br>');
				print_r(reset($cons));
				echo("</pre>");
			}
		}
		//Proactive Consults
		if($cons){
			$proactivemainsraw = $dq->getContacts_PCIDs(array_keys($cons),$dbhandle); // SQL all Injury Consults
			if($dev){
				echo"<pre>AND HERE ARE THE proactivemainsraw  FROM ZE UBER FUNCTION!!!<br><br>";
				print_r($proactivemainsraw);
				echo"</pre>";
			}
			$PCS = $dq->BuildProactiveConsultArray($proactivemainsraw,true,false,$dbhandle);
			if($dev){
				echo"<pre>HERE ARE THE PCS FROM ZE UBER FUNCTION!!!<br><br>";
				print_r($PCS);
				echo"</pre>";
			}
		}
		$emps = $dq->BuildEmployeeSuperArray($emps,$cons,false,false,false,false,false,false,$PCS['PCIDtoCONID'],$PCS['dump'],false);
		if($dev){
			echo"<pre>HERE ARE THE EMPS FROM ZE UBER FUNCTION!!!<br><br>";
			print_r($emps);
			echo"</pre>";
		}
 		
		$totalContacts = 0;
		$totalProactiveConsults = 0;
		$totalPCwTopic =0;
		$proactiveConsultTopics = array();

		$totalEmployees = count($emps);
		
		$totalEmployeesWithContacts = 0;
		$intialProgramStartDate;
		$contactDateRange = array();

		$clientName = $this->getClientName($clientID,$dbhandle);
		$topics = $this->getTopics();

		foreach( $emps as $empkey => $emp ){	
			$totalEmployees++;	
			//$emp = $this->stripCommas($emp);
			if( !empty($emp['contacts']) ) {
				$totalEmployeesWithContacts++;
			}
			foreach( $emp['contacts'] as $conkey => $con ){
				$contactDateRange = $this->updateDateRange($con['dat'],$contactDateRange);
				$totalContacts++;
				//$con = $this->stripCommas($con);
				if( !empty($con['pcdump'])){
					$totalProactiveConsults++;
					foreach( $con['pcdump'] as $pcdumpkey => $pcdump ){
						if( $pcdump['name'] == 'sel' && $pcdump['value'] != '0' ) {
							$totalPCwTopic++;
							//echo('<br/>SEL = ');
							//echo($pc['value']."<br/>");
							if( isset($proactiveConsultTopics[$pcdump['value']]) ){
								$proactiveConsultTopics[$pcdump['value']] = $proactiveConsultTopics[$pcdump['value']] + 1;
							}else{
								$proactiveConsultTopics[$pcdump['value']] = 1;
							}
						}
					}
				}
			}
		}
		$end = time();

		//BUILD CSV
		$today = getdate();
		if($dateRange['useDateRange']){
			$csvFileName = $clientName."-Proactive-Consult-Topics-".$dateRange['startMonth']."-".$dateRange['startDay']."-".$dateRange['startYear']."-TO-".$dateRange['endMonth']."-".$dateRange['endDay']."-".$dateRange['endYear']."__".$today['year']."_".$today['month']."_".$today['mday'];
		}else{
			$csvFileName = $clientName."-Proactive-Consult-Topics_".$today['year']."_".$today['month']."_".$today['mday'];
		}

		$csvText = $clientName."\n";
		$csvText .= "Report Type,Proactive Consult Topics\n";
		if($dateRange['useDateRange']){
			$csvText .= "FOR,".$dateRange['startMonth']."/".$dateRange['startDay']."/".$dateRange['startYear'].",TO,".$dateRange['endMonth']."/".$dateRange['endDay']."/".$dateRange['endYear']."\n";
		}
		if($locations['useLocations']){
			$csvText .= "FOR LOCATIONS,";
			foreach($locations['ids'] as $lockey => $loc){
				if($lockey == 0){
					$csvText .= $loc."\n";
				}else{
					$csvText .= " ,".$loc."\n";
				}
			}
		}
		$csvText .="\n";
		$csvText .= 'Total Proactive Consults,'.$totalProactiveConsults."\n";
		$csvText .= 'Total Proactive Consults with a Topic,'.$totalPCwTopic."\n";
		$csvText .= 'Proactive Consult Topics,Frequency,Rank'."\n";
		arsort($proactiveConsultTopics);
		$ranking = 1;
		$tieNumber = 1;
		$last='';
		foreach( $proactiveConsultTopics as $key => $pct ){
			if($last == $pct){
				$csvText .= $key .','.$pct.','.($ranking-$tieNumber)."\n";
				$tieNumber++;
			}else {
				$csvText .= $key .','.$pct.','.$ranking."\n";
				$tieNumber=1;
			}
			$last = $pct;
			$ranking++;
		}
		$csvText .= "\n\nTotal Time,". ($end - $start);
		$csvReturn =  array ( 'name' => $csvFileName , 'csv' => $csvText , );
		return $csvReturn;
 	}
    public function createCSV_ProactiveConsultTopics____OLD($clientID,$dateRange){
 		$start = time();
		$totalContacts = 0;
		$totalProactiveConsults = 0;
		$totalPCwTopic =0;
		$proactiveConsultTopics = array();
		$totalEmployees = 0;
		$totalEmployeesWithContacts = 0;
		$intialProgramStartDate;
		$contactDateRange = array();
		$dbhandle = $this->dbhandleSQLI();
		$clientName = $this->getClientName($clientID,$dbhandle);

		$today = getdate();
		if($dateRange['useDateRange']){
			$csvFileName = $clientName."-Proactive-Consult-Topics-".$dateRange['startMonth']."-".$dateRange['startDay']."-".$dateRange['startYear']."-TO-".$dateRange['endMonth']."-".$dateRange['endDay']."-".$dateRange['endYear']."__".$today['year']."_".$today['month']."_".$today['mday'];
		}else{
			$csvFileName = $clientName."-Proactive-Consult-Topics_".$today['year']."_".$today['month']."_".$today['mday'];
		}
		$employee = $this->getClientEmployees($clientID,$dateRange,$dbhandle,true);

		foreach( $employee as $key => $e ){	
			$totalEmployees++;	
			$e = $this->stripCommas($e);
			$contacts = $this->getEmployeeContacts($e['ID'],$dateRange,$dbhandle,true);
			if( !empty($contacts) ) {
				$totalEmployeesWithContacts++;
			}
			foreach( $contacts as $key => $ct ){
				if($ct != null){
					$contactDateRange = $this->updateDateRange($ct['dat'],$contactDateRange);
					$totalContacts++;
					$ct = $this->stripCommas($ct);
					$ct['location'] = $this->getLocation($ct['locid']);
					$ct['location'] = $this->stripCommas($ct['location']);
					$consults = $this->getProactiveConsultTopics($ct['id'],$dbhandle,false);
					if(isset($consults['dump'])){
						$totalProactiveConsults++;
						foreach( $consults['dump'] as $key => $pc ){
							if( $pc['name'] == 'sel' && $pc['value'] != '0' ) {
								$totalPCwTopic++;
								//echo('<br/>SEL = ');
								//echo($pc['value']."<br/>");
								if( isset($proactiveConsultTopics[$pc['value']]) ){
									$proactiveConsultTopics[$pc['value']] = $proactiveConsultTopics[$pc['value']] + 1;
								}else{
									$proactiveConsultTopics[$pc['value']] = 1;
								}
							}
						}
					}
				}
			}
		}
		$end = time();
		$csvText = $clientName."\n";
		$csvText .= "Report Type,Proactive Consult Topics\n";
		if($dateRange['useDateRange']){
			$csvText .= "FOR,".$dateRange['startMonth']."/".$dateRange['startDay']."/".$dateRange['startYear'].",TO,".$dateRange['endMonth']."/".$dateRange['endDay']."/".$dateRange['endYear']."\n";
		}
		$csvText .="\n";
		$csvText .= 'Total Proactive Consults,'.$totalProactiveConsults."\n";
		$csvText .= 'Total Proactive Consults with a Topic,'.$totalPCwTopic."\n";
		$csvText .= 'Proactive Consult Topics,Frequency,Rank'."\n";
		arsort($proactiveConsultTopics);
		$ranking = 1;
		$tieNumber = 1;
		$last='';
		foreach( $proactiveConsultTopics as $key => $pct ){
			if($last == $pct){
				$csvText .= $key .','.$pct.','.($ranking-$tieNumber)."\n";
				$tieNumber++;
			}else {
				$csvText .= $key .','.$pct.','.$ranking."\n";
				$tieNumber=1;
			}
			$last = $pct;
			$ranking++;
		}
		$csvText .= "\n\nTotal Time,". ($end - $start);
		$csvReturn =  array ( 'name' => $csvFileName , 'csv' => $csvText , );
		return $csvReturn;
 	}

/*
/////
///////////		Health Consult Topics BACKUP                           
*/

    public function createCSV_HealthConsultTopicsBACKUP($clientID,$dateRange){

    	//Total Number of Health Consults
    	//Topics and Times Discussed Ordered by Rank

 		$start = time();
		$totalContacts = 0;
		$totalhealthdumps = 0;
		
		$healthConsultTopics = array();
		$uniqueHealthTopics = 0;

		$totalEmployees = 0;
		$totalEmployeesWithContacts = 0;
		$intialProgramStartDate;
		$contactDateRange = array();
		
		$dbhandle = $this->dbhandleSQLI();

		$clientName = $this->getClientName($clientID,$dbhandle);

		$today = getdate();
		if($dateRange['useDateRange']){
			$csvFileName = $clientName."-Health-Consult-Topics-".$dateRange['startMonth']."-".$dateRange['startDay']."-".$dateRange['startYear']."-TO-".$dateRange['endMonth']."-".$dateRange['endDay']."-".$dateRange['endYear']."__".$today['year']."_".$today['month']."_".$today['mday'];
		}else{
			$csvFileName = $clientName."-Health-Consult-Topics_".$today['year']."_".$today['month']."_".$today['mday'];
		}

		//print_r($clientName);
		//echo $clientName;


		$employee = $this->getClientEmployees($clientID,$dateRange,$dbhandle,true);

		foreach( $employee as $key => $e ){	
			//echo("Employee: ".$e['firstName']);
			$totalEmployees++;	
			$e = $this->stripCommas($e);

			$contacts = $this->getEmployeeContacts($e['ID'],$dateRange,$dbhandle,true);

			if( !empty($contacts) ) {
				$totalEmployeesWithContacts++;
			}

			//echo('<br/><br/>');
			foreach( $contacts as $key => $ct ){
			//
				if($ct != null){
					//echo("--Contact<br/>");
					$contactDateRange = $this->updateDateRange($ct['dat'],$contactDateRange);

					$totalContacts++;

					$ct = $this->stripCommas($ct);
					$ct['location'] = $this->getLocation($ct['locid']);
					$ct['location'] = $this->stripCommas($ct['location']);

					$consults = $this->getContactConsults($ct['id'],$dbhandle,false,'health');
					//print_r($consults);
					//echo('<br/><br/>');
					if(isset($consults['health'])){
						$totalhealthdumps++;
						//echo("----Has health Consult :". $totalhealthdumps."<br/>");
						foreach( $consults['health'] as $key => $hc ){
							//if($hc['value'] != 'no'){ // if health topic found add 1 if it doesn't exist create it and add 1
							if( isset($healthConsultTopics[$hc['name']]) ){
								$healthConsultTopics[$hc['name']] = $healthConsultTopics[$hc['name']] + 1;
							}else{
								$healthConsultTopics[$hc['name']] = 1;
								$uniqueHealthTopics++;
							}
							//print_r($hc);
							//echo('<br/>');
							//}
						}
					}else{
						//echo("----no Health consults<br/>");
					}
				}
			}


		}
	
		//foreach( $healthConsultTopics as $key => $hct ){
		//	$healthConsultTopics[$key] = rand(1,3000);
		//}
		$end = time();
		//$healthConsultTopics['nonTiedValue'] = 50;
		/*
		echo('Total Employees = '.$totalEmployees.'<br/>');
		echo('Total Employees with Contacts = '.$totalEmployeesWithContacts.'<br/>');
		echo('Total Contacts = '.$totalContacts.'<br/>');
		echo('Total Consults = '.$totalConsults.'<br/>');
		echo('<br/>');
		print_r($reportingPeriod);
		echo('<br/>');	
		echo($start.'---,'.$end.'   Total Time = '. ($end - $start) );
		*/
		$csvText = $clientName."\n";
		$csvText .= "Report Type,Health Consult Topics\n";
		if($dateRange['useDateRange']){
			$csvText .= "FOR,".$dateRange['startMonth']."/".$dateRange['startDay']."/".$dateRange['startYear'].",TO,".$dateRange['endMonth']."/".$dateRange['endDay']."/".$dateRange['endYear']."\n";
		}
		$csvText .="\n";
		$csvText .= 'Total Health Consults,'.$totalhealthdumps."\n";
		$csvText .="\n";
		$csvText .= 'General Health Consult Topics,Frequency,Ranking'."\n";
		arsort($healthConsultTopics);
		$ranking = 1;
		$tieNumber = 1;
		$last='';
		foreach( $healthConsultTopics as $key => $hct ){
			if($last == $hct){ // if the last entry and this entry tie in frequency
				$csvText .= $key .','.$hct.','.($ranking-$tieNumber)."\n";
				$tieNumber++;
			}else {
				$csvText .= $key .','.$hct.','.$ranking."\n";
				$tieNumber=1;
			}
			$last = $hct;
			$ranking++;
		}
		$csvText .= "\n\nTotal Time,". ($end - $start);
		$csvReturn =  array ( 'name' => $csvFileName , 'csv' => $csvText , );
		return $csvReturn;
 	}
/*
/////
///////////		Health Consult Topics
▒█░▒█ ▒█▀▀▀ ░█▀▀█ ▒█░░░ ▀▀█▀▀ ▒█░▒█ 　 ▒█▀▀█ ▒█▀▀▀█ ▒█▄░▒█ ▒█▀▀▀█ ▒█░▒█ ▒█░░░ ▀▀█▀▀ 　 ▀▀█▀▀ ▒█▀▀▀█ ▒█▀▀█ ▀█▀ ▒█▀▀█ ▒█▀▀▀█ 
▒█▀▀█ ▒█▀▀▀ ▒█▄▄█ ▒█░░░ ░▒█░░ ▒█▀▀█ 　 ▒█░░░ ▒█░░▒█ ▒█▒█▒█ ░▀▀▀▄▄ ▒█░▒█ ▒█░░░ ░▒█░░ 　 ░▒█░░ ▒█░░▒█ ▒█▄▄█ ▒█░ ▒█░░░ ░▀▀▀▄▄ 
▒█░▒█ ▒█▄▄▄ ▒█░▒█ ▒█▄▄█ ░▒█░░ ▒█░▒█ 　 ▒█▄▄█ ▒█▄▄▄█ ▒█░░▀█ ▒█▄▄▄█ ░▀▄▄▀ ▒█▄▄█ ░▒█░░ 　 ░▒█░░ ▒█▄▄▄█ ▒█░░░ ▄█▄ ▒█▄▄█ ▒█▄▄▄█ 

*/

    public function createCSV_HealthConsultTopics($clientID,$dateRange,$locations,$dev = false){

	
    	$start = time();
    	$dbhandle = $this->dbhandleSQLI();


		$dq = new dataQuery;
		///EMPLOYEES
		$employeesraw = $dq->getClientEmployees($clientID,$dateRange,$locations,$dbhandle);
		$emps = $dq->BuildEmployeeArray($employeesraw);
		if($dev){
			echo("<p><b>Employees</b><pre>");
			echo("# of Employees = ".count($emps).'<br>$emps[example] indexed by empid<br>');
			print_r(reset($emps));
			echo("</pre>");
		}
		////CONTACTS
		if($emps){
			$contactsraw = $dq->getEmployeesContacts(array_keys($emps),$dateRange,$dbhandle);  // SQL all emp contacts
			$cons = $dq->BuildContactArray($contactsraw);
			if($dev){
				echo("<p><b>Contacts</b><pre>");
				echo("# of Contacts = ".count($cons).'<br>$cons[example] indexed by conid<br>');
				print_r(reset($cons));
				echo("</pre>");
			}
		}
		//Health Consults
		if($cons){
			$healthmainsraw = $dq->getContacts_HCIDs(array_keys($cons),$dbhandle); // SQL all Injury Consults
			if($dev){
				echo"<pre>AND HERE ARE THE healthmainsraw  FROM ZE UBER FUNCTION!!!<br><br>";
				print_r($healthmainsraw);
				echo"</pre>";
			}
			$HCS = $dq->BuildHealthConsultArray($healthmainsraw,true,false,$dbhandle);
			if($dev){
				echo"<pre>HERE ARE THE HCS FROM ZE UBER FUNCTION!!!<br><br>";
				print_r($HCS);
				echo"</pre>";
			}
		}
		$emps = $dq->BuildEmployeeSuperArray($emps,$cons,$HCS['HCIDtoCONID'],$HCS['dump'],false,false,false,false,false,false,false);
		if($dev){
			echo"<pre>HERE ARE THE EMPS FROM ZE UBER FUNCTION!!!<br><br>";
			print_r($emps);
			echo"</pre>";
		}

		//echo"<pre>HERE ARE THE EMPS FROM ZE UBER FUNCTION!!!<br><br>";
		//print_r($emps);
		//echo"</pre>";


//EXIT();
		$clientName = $this->getClientName($clientID,$dbhandle);

		$totalContacts = 0;

		$healthConsultTopics = array();
		$uniqueHealthTopics = 0;
		$totalhealthconsults=0;
		
		$totalEmployeesWithContacts = 0;
		$intialProgramStartDate;
		$contactDateRange = array();
		
		$topics = $this->getTopics('health');
		$subtopics = $this->getsubtopics('health');
		$TOPICS = array();

		for($x=0;$x< count($topics);$x++){
			$TOPICS[$topics[$x]['tname']] = $topics[$x]['topic'];
		}
		$SUBTOPICS = array();
		for($x=0;$x< count($topics);$x++){
			$SUBTOPICS[$subtopics[$x]['sname']] = $subtopics[$x]['subtopic'];
		}

		$totalEmployees = count($emps);
		foreach( $emps as $empkey => $emp ){
			//$e = $this->stripCommas($e);
			//echo("<h1>".$emp['fname']." ".$emp['lname']."</h1>,");
			if( !empty($emp['contacts']) ) {
				$totalEmployeesWithContacts++;
			}
			foreach( $emp['contacts'] as $conkey => $con ){
				$contactDateRange = $this->updateDateRange($con['dat'],$contactDateRange);
				$totalContacts++;
				//$con = $this->stripCommas($con);
				if( !empty($con['hcdump'])){
					$totalhealthconsults++;
					foreach( $con['hcdump'] as $hcdumpkey => $hcdump ){
						if( substr($hcdump['name'],0,2)=="nm" && $hcdump['value']!="no" && $hcdump['value']!=""){
							if( isset($TOPICS[$hcdump['name']]) ){
								//echo("<br/>".$TOPICS[$hc['name']]);
								if( isset($healthConsultTopics[$TOPICS[$hcdump['name']]]) ){
									$healthConsultTopics[$TOPICS[$hcdump['name']]] = $healthConsultTopics[$TOPICS[$hcdump['name']]] + 1;
								}else{
									$healthConsultTopics[$TOPICS[$hcdump['name']]] = 1;
									$uniqueHealthTopics++;
								}
							}elseif( isset($SUBTOPICS[$hcdump['name']]) ){
								//echo("<br/>".$SUBTOPICS[$hc['name']]);
								if( isset($healthConsultTopics[$SUBTOPICS[$hcdump['name']]]) ){
									$healthConsultTopics[$SUBTOPICS[$hcdump['name']]] = $healthConsultTopics[$SUBTOPICS[$hcdump['name']]] + 1;
								}else{
									$healthConsultTopics[$SUBTOPICS[$hcdump['name']]] = 1;
									$uniqueHealthTopics++;
								}
							}
						}
					}
				}
			}
		}
		$end = time();

		// BUILD CSV
		$today = getdate();
		if($dateRange['useDateRange']){
			$csvFileName = $clientName."-Health-Consult-Topics-".$dateRange['startMonth']."-".$dateRange['startDay']."-".$dateRange['startYear']."-TO-".$dateRange['endMonth']."-".$dateRange['endDay']."-".$dateRange['endYear']."__".$today['year']."_".$today['month']."_".$today['mday'];
		}else{
			$csvFileName = $clientName."-Health-Consult-Topics_".$today['year']."_".$today['month']."_".$today['mday'];
		}
		$csvText = $clientName."\n";
		$csvText .= "Report Type,Health Consult Topics\n";
		if($dateRange['useDateRange']){
			$csvText .= "FOR,".$dateRange['startMonth']."/".$dateRange['startDay']."/".$dateRange['startYear'].",TO,".$dateRange['endMonth']."/".$dateRange['endDay']."/".$dateRange['endYear']."\n";
		}
		if($locations['useLocations']){
			$csvText .= "FOR LOCATIONS,";
			foreach($locations['ids'] as $lockey => $loc){
				if($lockey == 0){
					$csvText .= $loc."\n";
				}else{
					$csvText .= " ,".$loc."\n";
				}
			}
		}
		$csvText .="\n";
		$csvText .= 'Total Health Consults,'.$totalhealthconsults."\n";
		$csvText .="\n";
		$csvText .= 'General Health Consult Topics,Frequency,Ranking'."\n";
		arsort($healthConsultTopics);
		$ranking = 1;
		$tieNumber = 1;
		$last='';
		foreach( $healthConsultTopics as $key => $hct ){
			if($last == $hct){ // if the last entry and this entry tie in frequency
				$csvText .= $key .','.$hct.','.($ranking-$tieNumber)."\n";
				$tieNumber++;
			}else {
				$csvText .= $key .','.$hct.','.$ranking."\n";
				$tieNumber=1;
			}
			$last = $hct;
			$ranking++;
		}
		$csvText .= "\n\nTotal Time,". ($end - $start);
		$csvReturn =  array ( 'name' => $csvFileName , 'csv' => $csvText , );
		return $csvReturn;
 	}
/*
/////
/////		Executive Summary
/////                               
*/

	public function createCSV_ExecutiveSummary($clientID,$dateRange){
		// $clientID : ID of client ; $dateRange : an array holding values about the daterange and whether to use it
		$start = time();
		$totalContacts = 0;
		$totalConsults = 0;
		$totalhealthdumps = 0;
		$totalInjuryConsults = 0;
		$totalOpportunityConsults = 0;
		$totalProactiveConsults = 0;
		$totalWellnessConsults = 0;

		//GROUPS e.g. contact(,h,h,h,h,h,h,i,i,i,i) =2 consultGROUPS ; contact(h,h,i,o) = 3 consultGROUPS
		$totalConsultsGROUPS = 0;
		$totalhealthdumpsGROUPS = 0;
		$totalInjuryConsultsGROUPS = 0;
		$totalOpportunityConsultsGROUPS = 0;
		$totalProactiveConsultsGROUPS = 0;
		$totalWellnessConsultsGROUPS = 0;

		$totalEmployees = 0;
		$totalEmployeesWithContacts = 0;
		$totalEmpInScreenings = 0;	// not yet used // had a contact in the time period
		$totalEmpInWellGuide = 0; // not yet used // is an employee in the time period
		$intialProgramStartDate;
		$contactDateRange = array();
		
		$dbhandle = $this->dbhandleSQLI();

		$clientName = $this->getClientName($clientID,$dbhandle);
		// print info regarding selected date range
		$today = getdate();
		if($dateRange['useDateRange']){
			$csvFileName = $clientName."-Executive_Summary-".$dateRange['startMonth']."-".$dateRange['startDay']."-".$dateRange['startYear']."-TO-".$dateRange['endMonth']."-".$dateRange['endDay']."-".$dateRange['endYear']."__".$today['year']."_".$today['month']."_".$today['mday'];
		}else{
			$csvFileName = $clientName."-Executive_Summary_".$today['year']."_".$today['month']."_".$today['mday'];
		}
		$employee = $this->getClientEmployees($clientID,$dateRange,$dbhandle,true);
		foreach( $employee as $key => $e ){	
			$totalEmployees++;
			if($e['status'] == 'active'){
				$totalEmpInWellGuide++;
			}
			$e = $this->stripCommas($e);
			//echo"<br/><br/>";print_r($e['firstName']);echo"<br/>";
			//participating in screening == all employes with contacts?
			//participating in wellguide? == all employees with wellness consults??
			$contacts = $this->getEmployeeContacts($e['ID'],$dateRange,$dbhandle,true);
			if( !empty($contacts) ) {
				$totalEmployeesWithContacts++;
				//echo("&nbsp;&nbsp;".$contacts[0]['contype']."<br/>");
				//echo"&nbsp;&nbsp;Employee has contacts: TEwC:".$totalEmployeesWithContacts."<br/>";
			}else{
				//echo"&nbsp;&nbsp;NO contacts: TEwC:".$totalEmployeesWithContacts."<br/>";
			}
			foreach( $contacts as $key => $ct ){
				if($ct != null){
					//check if the date is a max or min and update the range to reflect if it is
					$contactDateRange = $this->updateDateRange($ct['dat'],$contactDateRange);
					$totalContacts++;
					//echo($ct['dat']." ".$ct['contype']);echo (" TC:".$totalContacts."<br/>");
					$ct = $this->stripCommas($ct);
					//SQL to get location - SPEED should hold all locations in an array and collect them once
					$ct['location'] = $this->getLocation($ct['locid']);
					$ct['location'] = $this->stripCommas($ct['location']);
					//SQL gather consults for that contact
					$consults = $this->getContactConsults($ct['id']);
					if(isset($consults['health'])){
						$totalhealthdumpsGROUPS++;
						for($x = 0; $x<count($consults['health']); $x++ ){
							$totalhealthdumps++;
							//echo("Health Consult :".$consult['health'][$hci]['name']." ".$consult['health'][$hci]['value']."<br/>");
							//$csvText .= (",,Health Consult,".$consult['health'][$hci]['name'].",".$consult['health'][$hci]['value']."\n");
						}
					}
					if(isset($consults['injury'])){
						$totalInjuryConsultsGROUPS++;
						for($x = 0; $x<count($consults['injury']); $x++ ){
							$totalInjuryConsults++;
							//echo("Injury Consult :".$consult['injury'][$ici]['name']."<br/>");
							//$csvText .= (",,Injury Consult,".$consult['injury'][$ici]['name'].",".$consult['injury'][$ici]['value']."\n");
						}
					}
					if(isset($consults['opportunity'])){
						$totalOpportunityConsultsGROUPS++;
						for($x = 0; $x<count($consults['opportunity']); $x++ ){
							$totalOpportunityConsults++;
							//echo("Opportunity Consult :".$consult['opportunity'][$oci]['name']."<br/>");
							//$csvText .= (",,Opportunity Consult,".$consult['opportunity'][$oci]['name'].",".$consult['opportunity'][$oci]['value']."\n");
						}
					}
					if(isset($consults['proactive'])){
						$totalProactiveConsultsGROUPS++;
						for($x = 0; $x<count($consults['proactive']); $x++ ){
							$totalProactiveConsults++;
							//echo("Proactive Consult :".$consult['proactive'][$oci]['name']."<br/>");
							//$csvText .= (",,Proactive Consult,".$consult['proactive'][$oci]['name'].",".$consult['proactive'][$oci]['value']."\n");
						}
					}
					if(isset($consults['wellness'])){
						$totalWellnessConsultsGROUPS++;
						for($x = 0; $x<count($consults['wellness']); $x++ ){
							$totalWellnessConsults++;
							//echo("Wellness Consult :".$consult['wellness'][$oci]['name']."<br/>");
							//$csvText .= (",,Wellness Consult,".$consult['wellness'][$oci]['name'].",".$consult['wellness'][$oci]['value']."\n");
						}
					}
				}
			}
		} /* End foreach Employee*/
		

		$totalConsults = $totalhealthdumps+$totalInjuryConsults+$totalOpportunityConsults+$totalProactiveConsults+$totalWellnessConsults;
		$totalConsultsGROUPS = $totalhealthdumpsGROUPS+$totalInjuryConsultsGROUPS+$totalOpportunityConsultsGROUPS+$totalProactiveConsultsGROUPS+$totalWellnessConsultsGROUPS;
		$end = time();
		/*
		echo('Total Employees = '.$totalEmployees.'<br/>');
		echo('Total Employees with Contacts = '.$totalEmployeesWithContacts.'<br/>');
		echo('Total Contacts = '.$totalContacts.'<br/>');
		echo('Total Consults = '.$totalConsults.'<br/>');

		echo('<br/>');
		print_r($reportingPeriod);
		echo('<br/>');
		
		echo($start.'---,'.$end.'   Total Time = '. ($end - $start) );
		*/
		$csvText = $clientName."\n";
		$csvText .= "Report Type,Executive Summary\n";
		if($dateRange['useDateRange']){
			$csvText .= "FOR,".$dateRange['startMonth']."/".$dateRange['startDay']."/".$dateRange['startYear'].",TO,".$dateRange['endMonth']."/".$dateRange['endDay']."/".$dateRange['endYear']."\n";
		}
		$csvText .="\n";

		//$csvText .= 'Contact Date Range within Reporting Period,'.$contactDateRange['low']['m']."/".$contactDateRange['low']['d']."/".$contactDateRange['low']['y']." - ".$contactDateRange['high']['m']."/".$contactDateRange['high']['d']."/".$contactDateRange['high']['y']."\n";		
		if($dateRange['useDateRange']){
			$csvText .= "Reporting Period,".$dateRange['startMonth']."/".$dateRange['startDay']."/".$dateRange['startYear']." - ".$dateRange['endMonth']."/".$dateRange['endDay']."/".$dateRange['endYear']."\n";
		}else{
			$csvText .= "Reporting Period,"."All Records\n";
		}
		$csvText .= 'Contact Date Range for Wellguide Contacts,'.$contactDateRange['low']['m']."/".$contactDateRange['low']['d']."/".$contactDateRange['low']['y']." - ".$contactDateRange['high']['m']."/".$contactDateRange['high']['d']."/".$contactDateRange['high']['y']."\n";
		$csvText .= 'Total Employees Participating in Screenings,'.$totalEmployeesWithContacts."\n";
		$csvText .= 'Total Employees Participating in WellGuide,'.$totalEmpInWellGuide."\n";
		$csvText .= 'Total Contacts,'.$totalContacts."\n";
		$csvText .= 'Average Contacts per Participating Employee,'.( round($totalContacts/$totalEmployeesWithContacts, 2) )."\n";
		$csvText .= 'Total Consults,'.$totalConsultsGROUPS."\n";
		$csvText .= 'Average Consults per Participating Employee,'.( round($totalConsultsGROUPS/$totalEmployeesWithContacts, 2) )."\n";
		//$csvText .= "\n\nTotal Time,". ($end - $start);


		$csvReturn =  array ( 'name' => $csvFileName , 'csv' => $csvText , );
		return $csvReturn;
	}
/*
/////
/////		Participation by Location
/////                               
*/
	public function createCSV_ParticipationByLocation($clientID,$dateRange){

	    $contactTotal = 0;
	    $proactiveConsultTotal = 0;
	    $healthConsultTotal = 0;
	    $injuryConsultTotal = 0;
	    $opportunityConsultTotal = 0;
	    $wellnessConsultTotal = 0;

	    // GET Client Locations
		$dbhandle = $this->dbhandleSQLI();
		if ($dbhandle){
			$dbfound = $this->dbfound();
			if ($dbfound){
				// GET Client Name
				$tablename = "client";
				$tableExists = $this->tableExists($tablename);
				if ($tableExists){
					$sql = "SELECT `$tablename`.`clname` FROM `$this->db`.`$tablename` WHERE `$tablename`.`id` = '$clientID'";
					$result = mysqli_query($dbhandle, $sql);
					if ($result){
						if (mysqli_num_rows($result) > 0){
							$row = mysqli_fetch_row($result);
							$clientName = $this->decode($row[0]);
							$csvText = $clientName."\n";
							$today = getdate();
							//$csvFileName = $clientName."-Participation_by_Location-".$today['year']."_".$today['month']."_".$today['mday'];
							if($dateRange['useDateRange']){
								$csvFileName = $clientName."-Participation_by_Location-".$dateRange['startMonth']."-".$dateRange['startDay']."-".$dateRange['startYear']."-TO-".$dateRange['endMonth']."-".$dateRange['endDay']."-".$dateRange['endYear']."__".$today['year']."_".$today['month']."_".$today['mday'];
							}else{
								$csvFileName = $clientName."-Participation_by_Location-Complete_".$today['year']."_".$today['month']."_".$today['mday'];
							}
						}
						else{
							$ret[0] = "0";
						}
					}
				}
				$csvText .= "Report Type,Participation By Location\n";
				if($dateRange['useDateRange']){
					$csvText .= "FOR,".$dateRange['startMonth']."/".$dateRange['startDay']."/".$dateRange['startYear'].",TO,".$dateRange['endMonth']."/".$dateRange['endDay']."/".$dateRange['endYear'];
					$csvText .= ("\n");
				}
				$csvText .= "\nLocation Name,# of Employees, # of Contacts, Contacts Per Employee, First Contact Date, Last Contact Date\n";
				// Print KEY into CSV 
				/*
				*/
				// Get Client Locations
				$tablename = "clientloc";
				$tableExists = $this->tableExists($tablename);
				if ($tableExists){
					$sql = "SELECT `$tablename`.* FROM `$this->db`.`$tablename` WHERE `$tablename`.`clid` = '$clientID'";
					$result = mysqli_query($dbhandle, $sql);
					if ($result){
						if (mysqli_num_rows($result) > 0){
							for ( $i = 0; $i < mysqli_num_rows($result); $i++ ){
								$row = mysqli_fetch_assoc($result);
								$location[$i] = array(
									"ID"=>$row['id'],
									"Name"=>$this->decode($row['locid']),
								);
							}
						}
						// print location
						for ($i = 0; $i < count($location); $i++ ){
							$csvText .= $location[$i]['Name'].",";
							// get contacts by location
							$tablename = "contact";
							$tableExists = $this->tableExists($tablename);
							if ($tableExists){
								$locid = $location[$i]['ID'];
								//$csvText .= "Location ID:,".$locid."\n";
								//
								//
								// Get Contacts for each Location
								$contact = array();
								$contactNumber = 0;
								$sql = "SELECT `$tablename`.* FROM `$this->db`.`$tablename` WHERE `$tablename`.`locid` = '$locid'";
								$result = mysqli_query($dbhandle, $sql);
								if ($result){
									if (mysqli_num_rows($result) > 0){
										for ( $y = 0; $y < mysqli_num_rows($result); $y++ ){
											$row = mysqli_fetch_assoc($result);

											// if using the Daterange check it first to see if it applies
											if($dateRange['useDateRange']){
												if ( $this->checkDateRange($this->decode($row['dat']),$dateRange) ){
													$contact[$contactNumber] = array(
														"ID"=>$row['id'],
														"clientID"=>$row['clid'],
														"username"=>$this->decode($row['uname']),
														"employeeID"=>$row['empid'],
														"contactType"=>$this->decode($row['contype']),
														"date"=>$this->decode($row['dat']),
														"status"=>$this->decode($row['status']),
														"locationID"=>$row['locid'],
													);
													$contactNumber++;
												}
												// otherwise let it go
											} else {
												$contact[$contactNumber] = array(
													"ID"=>$row['id'],
													"clientID"=>$row['clid'],
													"username"=>$this->decode($row['uname']),
													"employeeID"=>$row['empid'],
													"contactType"=>$this->decode($row['contype']),
													"date"=>$this->decode($row['dat']),
													"status"=>$this->decode($row['status']),
													"locationID"=>$row['locid'],
												);
												$contactNumber++;
											}
										}
									}
								}
								// find min date and max date // casting to int removes preceeeding zeros

								//  get employees for location
								////
								//
								//
								// do this tomorowj
								//
								//
								$tablename = "employee"; // employee?
								$tableExists = $this->tableExists($tablename);
								if ($tableExists){
									$locid = $location[$i]['ID'];
									
									$employee = array();
									$employeeNumber = 0;
									$sql = "SELECT `$tablename`.* FROM `$this->db`.`$tablename` WHERE `$tablename`.`locid` = '$locid'";
									$result = mysqli_query($dbhandle, $sql);
									if ($result){
										if (mysqli_num_rows($result) > 0){
											for ( $y = 0; $y < mysqli_num_rows($result); $y++ ){
												$row = mysqli_fetch_assoc($result);
												if( $this->decode($row['status']) == 'active' ) {
													if($dateRange['useDateRange']){
														if ( $this->checkHireDateisinRange($this->decode($row['hyear']),$dateRange) ){
															$employee[$employeeNumber] = array(
																"ID"=>$row['id'],
																"firstName"=>$this->decode($row['fname']),
																"lastName"=>$this->decode($row['lname']),
																"dateofbirth"=> $this->decode($row['dob']),
																"gender"=> $this->decode($row['gender']),
																"department"=> $this->decode($row['dept']),
																"hireyear"=> $this->decode($row['hyear']),
																"profileimagepath"=> $this->decode($row['imgpath']),
																"status"=> $this->decode($row['status']),
															);
															//$csvText .= "\n".$employee[$employeeNumber]['hireyear'].",";
															//$csvText .= $this->checkHireDateisinRange($this->decode($row['hyear']),$dateRange);
															$employeeNumber++;
														}
													} else {
														$employee[$employeeNumber] = array(
															"ID"=>$row['id'],
															"firstName"=>$this->decode($row['fname']),
															"lastName"=>$this->decode($row['lname']),
															"dateofbirth"=> $this->decode($row['dob']),
															"gender"=> $this->decode($row['gender']),
															"department"=> $this->decode($row['dept']),
															"hireyear"=> $this->decode($row['hyear']),
															"profileimagepath"=> $this->decode($row['imgpath']),
															"status"=> $this->decode($row['status']),
														);
														//$csvText .= "\n".$employee[$employeeNumber]['hireyear'].",";
														$employeeNumber++;
													}
													
												}
												
												

											}
											// 
																						//
										}
									}
								}
								// / get employess for location
								//

								// this finds the first and last date in the returned set of contacts
								for ($y = 0; $y < count($contact); $y++ ){
									if($y == 0){
										list($min['month'], $min['day'], $min['year']) = split("/", $contact[0]['date']);
										$min['month'] = (int)$min['month'];
										$min['day'] = (int)$min['day'];
										$min['year'] = (int)$min['year'];
										list($max['month'], $max['day'], $max['year']) = split("/", $contact[0]['date']);
										$max['month'] = (int)$max['month'];
										$max['day'] = (int)$max['day'];
										$max['year'] = (int)$max['year'];
									}
									list($month, $day, $year) = split("/", $contact[$y]['date']);
									$month = (int)$month;
									$day = (int)$day;
									$year = (int)$year;
									//check min
									if( $year <= $min['year'] ){
										if( $year == $min['year'] ){
											if ( $month < $min['month']){
												$min['month'] = $month;
												$min['day'] = $day;
												$min['year'] = $year;
											}
											if( $month == $min['month']){
												if( $day < $min['day'] ){
													$min['month'] = $month;
													$min['day'] = $day;
													$min['year'] = $year;
												}
											}
										} else { // if year < min[year]
											$min['month'] = $month;
											$min['day'] = $day;
											$min['year'] = $year;
										}
									} 
									//check max
									if( $year >= $min['year'] ){
										if( $year == $min['year'] ){
											if ( $month > $min['month']){
												$max['month'] = $month;
												$max['day'] = $day;
												$max['year'] = $year;
											}
											if( $month == $max['month']){
												if( $day > $max['day'] ){
													$max['month'] = $month;
													$max['day'] = $day;
													$max['year'] = $year;
												}
											}
										} else { // if year > max[year]
											$max['month'] = $month;
											$max['day'] = $day;
											$max['year'] = $year;
										}
									}
								} 
								// End find the first and last date in the returned set of contacts
								if($contactNumber > 0){
									//$csvText .= "\nDate Range for Location";
									//$csvText .= "\n".$min['month']."/".$min['day']."/".$min['year'].",".$max['month']."/".$max['day']."/".$max['year']."\n";
									$csvText .= $employeeNumber.",".$contactNumber.",".round($contactNumber/$employeeNumber, 2).",".$min['month']."/".$min['day']."/".$min['year'].",".$max['month']."/".$max['day']."/".$max['year']."\n";
								} else {
									$csvText .= $employeeNumber.",no contacts\n";
								}
								// print contacts/contact summary for the location
								for ($y = 0; $y < count($contact); $y++ ){
									//$csvText .= "conid: ".$contact[$y]['ID'].",locid: ".$contact[$y]['locationID'].",empid: ".$contact[$y]['employeeID'].",Date: ".$contact[$y]['date'].",".$contact[$y]['contactType'].",\n";
								}	
								//
							}
						} /// end for 'location'
					}
				}
			}
		}
		$csvReturn =  array ( 'name' => $csvFileName , 'csv' => $csvText , );
		return $csvReturn;
	}
/*
/////
/////		Test Function
/////                               
*/
 		public function Test($clientID,$dateRange){

 			$dbhandle = $this->dbhandleSQLI();
 			$clientName = $this->getClientName($clientID,$dbhandle);
 			echo($clientName);

 			/* Get CLIENT EMPLOYEES
 			$employee = $this->getClientEmployees($clientID,$dateRange);

 			foreach( $employee as $key => $e){
 				$employee[$key] = $this->stripCommas($e);
 				echo("<br/><br/>".$key.'<br/>');
 				print_r($employee[$key]);
 				echo ('<br/>'.$employee[$key]['hireyear']);
 			}

 			//print_r($employee);
 			//echo "Paased the foreach loop";
			*/
			$csvText = 'this,is,the,first,line';
			$csvReturn =  array ( 'name' => 'filename' , 'csv' => $csvText , );
			return $csvReturn;
 		}



/*
/////
/////		Full Employee Report
/////                               
*/
 		public function createCSV_FullEmployeeReport($clientID,$dateRange){   // using external functions for data retrieval

 			$start = time();
    		$dbhandle = $this->dbhandleSQLI();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){

			// GET Client Name
					$clientName = $this->getClientName($clientID,$dbhandle);

					$csvText = $clientName."\n";
					// GenerateTitle
					$today = getdate();
					if($dateRange['useDateRange']){
						$csvFileName = $clientName."-Full_Employee_Report-".$dateRange['startMonth']."-".$dateRange['startDay']."-".$dateRange['startYear']."-TO-".$dateRange['endMonth']."-".$dateRange['endDay']."-".$dateRange['endYear']."__".$today['year']."_".$today['month']."_".$today['mday'];
					}else{
						$csvFileName = $clientName."-Full_Employee_Report-Complete_".$today['year']."_".$today['month']."_".$today['mday'];
					}

					$csvText .= "Report Type,Full Employee Report\n";
					if($dateRange['useDateRange']){
						$csvText .= "FOR,".$dateRange['startMonth']."/".$dateRange['startDay']."/".$dateRange['startYear'].",TO,".$dateRange['endMonth']."/".$dateRange['endDay']."/".$dateRange['endYear'];
						$csvText .= ("\n");
					}
					// Print KEY into CSV
					$csvText .= ("\n");
					$csvText .= ("KEY,\n");
					$csvText .= ("EMPLOYEE LINES,\n");
					$csvText .= ("First Name,Last Name,Date of Birth,Gender,Department,Year Hired,Status,\n");
					$csvText .= ("CONTACT LINES,\n");
					$csvText .= (",Date of Contact,Location Name,Username,Contact Type,Status,\n");
					$csvText .= ("CONSULT LINES,\n");
					$csvText .= (",,Consult Type,Name,Value,\n");
					$csvText .= ("\n");
					$csvText .= ("\n");

			// Get Client Employees
					$employee = $this->getClientEmployees($clientID,$dateRange,$dbhandle,true);

					foreach( $employee as $key => $e ){		
						$e = $this->stripCommas($e);
						//echo("<br/><br/>".$key."<br/>");
						//print_r($e);
						// Print EMPLOYEE into CSV
						$csvText .= ($e['firstName'].",".$e['lastName'].",".$e['dateofbirth'].",".$e['gender'].",".$e['department'].",".$e['hireyear'].",".$e['status']."\n");
						
			// Get Contacts
						$contacts = $this->getEmployeeContacts($e['ID'],$dateRange,$dbhandle,true);
						//echo('<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA<br/><br/>');
						//print_r($contacts);
						foreach ( $contacts as $key => $c ){
							$c = $this->stripCommas($c);
							$c['location'] = $this->getLocation($c['locid']);
							$c['location'] = $this->stripCommas($c['location']);
							// Print CONTACT into CSV
							$csvText .= (",".$c['dat'].",".$c['location']['locid'].",".$c['uname'].",".$c['contype'].",".$c['status']."\n");


					// Get Consults
							$consult = $this->getContactConsults($c['id'],$dbhandle,true);

							if(isset($consult['health'])){
								for($hci = 0; $hci<count($consult['health']); $hci++ ){
									$csvText .= (",,Health Consult,".$consult['health'][$hci]['name'].",".$consult['health'][$hci]['value']."\n");
								}
							}
							if(isset($consult['injury'])){
								for($ici = 0; $ici<count($consult['injury']); $ici++ ){
									$csvText .= (",,Injury Consult,".$consult['injury'][$ici]['name'].",".$consult['injury'][$ici]['value']."\n");
								}
							}
							if(isset($consult['opportunity'])){
								for($oci = 0; $oci<count($consult['opportunity']); $oci++ ){
									$csvText .= (",,Opportunity Consult,".$consult['opportunity'][$oci]['name'].",".$consult['opportunity'][$oci]['value']."\n");
								}
							}
							if(isset($consult['proactive'])){
								for($oci = 0; $oci<count($consult['proactive']); $oci++ ){
									$csvText .= (",,Proactive Consult,".$consult['proactive'][$oci]['name'].",".$consult['proactive'][$oci]['value']."\n");
								}
							}
							if(isset($consult['wellness'])){
								for($oci = 0; $oci<count($consult['wellness']); $oci++ ){
									$csvText .= (",,Wellness Consult,".$consult['wellness'][$oci]['name'].",".$consult['wellness'][$oci]['value']."\n");
								}
							}
						}
						$csvText .= "\n";
					}
				}
			}
			$end = time();
			$csvText .= "\nStart,".$start.',END,'.$end.',Total Time,'. ($end - $start);

			$csvReturn =  array ( 'name' => $csvFileName , 'csv' => $csvText , );
			return $csvReturn;
    	}

/*
/////
/////		Contact and Consult Overview
/////                               
*/
    	public function createCSV_ContactConsultOverviewBACKUP($clientID,$dateRange){

    	    $contactTotal = 0;
    	    $proactiveConsultTotal = 0;
    	    $healthConsultTotal = 0;
    	    $injuryConsultTotal = 0;
    	    $opportunityConsultTotal = 0;
    	    $wellnessConsultTotal = 0;

    	    		//GROUPS e.g. contact(,h,h,h,h,h,h,i,i,i,i) =2 consultGROUPS ; contact(h,h,i,o) = 3 consultGROUPS
			$totalConsultsGROUPS = 0;
			$totalhealthdumpsGROUPS = 0;
			$totalInjuryConsultsGROUPS = 0;
			$totalOpportunityConsultsGROUPS = 0;
			$totalProactiveConsultsGROUPS = 0;
			$totalWellnessConsultsGROUPS = 0;

    		$dbhandle = $this->dbhandleSQLI();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					// GET Client Name
					$tablename = "client";
					$tableExists = $this->tableExists($tablename);
					if ($tableExists){
						$sql = "SELECT `$tablename`.`clname` FROM `$this->db`.`$tablename` WHERE `$tablename`.`id` = '$clientID'";
						$result = mysqli_query($dbhandle, $sql);
						if ($result){
							if (mysqli_num_rows($result) > 0){
								$row = mysqli_fetch_row($result);
								$clientName = $this->decode($row[0]);
								$csvText = $clientName."\n";
								$today = getdate();
								$csvFileName = $clientName."-Total_Contacts_By_Consult_Type-".$today['year']."_".$today['month']."_".$today['mday'];
							}
							else{
								$ret[0] = "0";
							}
						}
					}
					$csvText .= "Report Type,Contact and Consult Overview\n";
					if($dateRange['useDateRange']){
						$csvText .= "FOR,".$dateRange['startMonth']."/".$dateRange['startDay']."/".$dateRange['startYear'].",TO,".$dateRange['endMonth']."/".$dateRange['endDay']."/".$dateRange['endYear'];
						$csvText .= ("\n");
					}
					// Print KEY into CSV 

					// Get Client Employees
					$tablename = "employee";
					$tableExists = $this->tableExists($tablename);
					if ($tableExists){
						$sql = "SELECT `$tablename`.* FROM `$this->db`.`$tablename` WHERE `$tablename`.`clid` = '$clientID'";
						$result = mysqli_query($dbhandle, $sql);
						if ($result){
							if (mysqli_num_rows($result) > 0){
								for ( $i = 0; $i < mysqli_num_rows($result); $i++ ){
									$row = mysqli_fetch_assoc($result);
									$employee = array(
										"ID"=>$row['id'],
										//"firstName"=>$this->decode($row['fname']),
										//"lastName"=>$this->decode($row['lname']),
										//"dateofbirth"=> $this->decode($row['dob']),
										//"gender"=> $this->decode($row['gender']),
										//"department"=> $this->decode($row['dept']),
										//"hireyear"=> $this->decode($row['hyear']),
										//"profileimagepath"=> $this->decode($row['imgpath']),
										//"status"=> $this->decode($row['status']),
									);
									$employee = $this->stripCommas($employee);
									// Print EMPLOYEE into CSV
									//$csvText .= ($employee['firstName'].",".$employee['lastName'].",".$employee['dateofbirth'].",".$employee['gender'].",".$employee['department'].",".$employee['hireyear'].",".$employee['status']."\n");
									//echo("Employee - ".$employee['firstName']." ".$employee['lastName']."<br/>");
									// CONTACTS LOOP
									$contacts = $this->getEmployeeContacts($employee['ID'],$dateRange);
							
									//
									for($contactIndex = 0; $contactIndex < count($contacts); $contactIndex++ ){
										if($contacts != null){
											$contactTotal++;

											$contacts[$contactIndex] = $this->stripCommas($contacts[$contactIndex]);
											$contacts[$contactIndex]['location'] = $this->getLocation($contacts[$contactIndex]['locid']);
											$contacts[$contactIndex]['location'] = $this->stripCommas($contacts[$contactIndex]['location']);
											// Print CONTACT into CSV
											//$csvText .= (",".$contacts[$contactIndex]['dat'].",".$contacts[$contactIndex]['location']['locid'].",".$contacts[$contactIndex]['uname'].",".$contacts[$contactIndex]['contype'].",".$contacts[$contactIndex]['status']."\n");
											// QUERY for CONSULTS
											//echo("&nbsp;&nbsp;&nbsp;&nbsp;Contact ".($contactIndex+1)." ID = ");
											//echo($contacts[$contactIndex]['id']."<br/>");
											// CONSULTS LOOP
											$consult = $this->getContactConsults($contacts[$contactIndex]['id']);
											//
											//echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br/>");
											//print_r($consult);
											//echo("<br/>");
											if(isset($consult['health'])){
												for($hci = 0; $hci<count($consult['health']); $hci++ ){
													$healthConsultTotal++;
													//echo("Health Consult :".$consult['health'][$hci]['name']." ".$consult['health'][$hci]['value']."<br/>");
													//$csvText .= (",,Health Consult,".$consult['health'][$hci]['name'].",".$consult['health'][$hci]['value']."\n");
												}
											}
											if(isset($consult['injury'])){
												for($ici = 0; $ici<count($consult['injury']); $ici++ ){
													$injuryConsultTotal++;
													//echo("Injury Consult :".$consult['injury'][$ici]['name']."<br/>");
													//$csvText .= (",,Injury Consult,".$consult['injury'][$ici]['name'].",".$consult['injury'][$ici]['value']."\n");
												}
											}
											if(isset($consult['opportunity'])){
												for($oci = 0; $oci<count($consult['opportunity']); $oci++ ){
													$opportunityConsultTotal++;
													//echo("Opportunity Consult :".$consult['opportunity'][$oci]['name']."<br/>");
													//$csvText .= (",,Opportunity Consult,".$consult['opportunity'][$oci]['name'].",".$consult['opportunity'][$oci]['value']."\n");
												}
											}
											if(isset($consult['proactive'])){
												for($oci = 0; $oci<count($consult['proactive']); $oci++ ){
													$proactiveConsultTotal++;
													//echo("Proactive Consult :".$consult['proactive'][$oci]['name']."<br/>");
													//$csvText .= (",,Proactive Consult,".$consult['proactive'][$oci]['name'].",".$consult['proactive'][$oci]['value']."\n");
												}
											}
											if(isset($consult['wellness'])){
												for($oci = 0; $oci<count($consult['wellness']); $oci++ ){
													$wellnessConsultTotal++;
													//echo("Wellness Consult :".$consult['wellness'][$oci]['name']."<br/>");
													//$csvText .= (",,Wellness Consult,".$consult['wellness'][$oci]['name'].",".$consult['wellness'][$oci]['value']."\n");
												}
											}
										}
									}
								}
							}
							else{
								$ret[0] = "0";
							}
						}
					}
				}
			}
			$consultsTotal = $proactiveConsultTotal+$healthConsultTotal+$injuryConsultTotal+$opportunityConsultTotal+$wellnessConsultTotal;
			$csvText .= "\nTotal Contacts,".$contactTotal."\n";
			$csvText .= "Total Consults,".$consultsTotal."\n";
			$csvText .= "Consult Type,Total Number,% of Total\n";
			$csvText .= "Proactive Consults,".$proactiveConsultTotal.",".round( ($proactiveConsultTotal/$consultsTotal)*100 )."%\n";
			$csvText .= "Health Consults,".$healthConsultTotal.",".round( ($healthConsultTotal/$consultsTotal)*100 )."%\n";
			$csvText .= "Injury Consults,".$injuryConsultTotal.",".round( ($injuryConsultTotal/$consultsTotal)*100 )."%\n";
			$csvText .= "Opportunity Consults,".$opportunityConsultTotal.",".round( ($opportunityConsultTotal/$consultsTotal)*100 )."%\n";

			$csvReturn =  array ( 'name' => $csvFileName , 'csv' => $csvText , );
			return $csvReturn;
    	} // can pretty much get rid of
/*
/////
/////		Contact and Consult Overview REBOOT
/////                               
*/
    	public function createCSV_ContactConsultOverview($clientID,$dateRange){

    	    $contactTotal = 0;
    	    $proactiveConsultTotal = 0;
    	    $healthConsultTotal = 0;
    	    $injuryConsultTotal = 0;
    	    $opportunityConsultTotal = 0;
    	    $wellnessConsultTotal = 0;

    	    		//GROUPS e.g. contact(,h,h,h,h,h,h,i,i,i,i) =2 consultGROUPS ; contact(h,h,i,o) = 3 consultGROUPS
			$totalConsultsGROUPS = 0;
			$totalhealthdumpsGROUPS = 0;
			$totalInjuryConsultsGROUPS = 0;
			$totalOpportunityConsultsGROUPS = 0;
			$totalProactiveConsultsGROUPS = 0;
			$totalWellnessConsultsGROUPS = 0;

			$dbhandle = $this->dbhandleSQLI();
			$clientName = $this->getClientName($clientID,$dbhandle);
			$csvText = $clientName."\n";
			$today = getdate();
			$csvFileName = $clientName."-Total_Contacts_By_Consult_Type-".$today['year']."_".$today['month']."_".$today['mday'];

			$csvText .= "Report Type,Contact and Consult Overview\n";
			if($dateRange['useDateRange']){
				$csvText .= "FOR,".$dateRange['startMonth']."/".$dateRange['startDay']."/".$dateRange['startYear'].",TO,".$dateRange['endMonth']."/".$dateRange['endDay']."/".$dateRange['endYear'];
				$csvText .= ("\n");
			}
 			$employee = $this->getClientEmployees($clientID,$dateRange,$dbhandle,true);
			foreach( $employee as $key => $e ){	
				//$employee = $this->stripCommas($employee);
				// Print EMPLOYEE into CSV
				//$csvText .= ($employee['firstName'].",".$employee['lastName'].",".$employee['dateofbirth'].",".$employee['gender'].",".$employee['department'].",".$employee['hireyear'].",".$employee['status']."\n");
				//echo("Employee - ".$employee['firstName']." ".$employee['lastName']."<br/>");
				// CONTACTS LOOP
				$contact = $this->getEmployeeContacts($e['ID'],$dateRange,$dbhandle,true);
				foreach( $contact as $ckey => $c ){
					if($c != null){
						$contactTotal++;
						//echo("CT:".$contactTotal." ".$c['contype']." ".$c['dat']."<br/>");
						$c = $this->stripCommas($c);
						$c['location'] = $this->getLocation($c['locid']);
						$c['location'] = $this->stripCommas($c['location']);
						// Print CONTACT into CSV
						//$csvText .= (",".$contacts[$contactIndex]['dat'].",".$contacts[$contactIndex]['location']['locid'].",".$contacts[$contactIndex]['uname'].",".$contacts[$contactIndex]['contype'].",".$contacts[$contactIndex]['status']."\n");
						// QUERY for CONSULTS
						//echo("&nbsp;&nbsp;&nbsp;&nbsp;Contact ".($contactIndex+1)." ID = ");
						//echo($contacts[$contactIndex]['id']."<br/>");
						// CONSULTS LOOP
						$consult = $this->getContactConsults($c['id']);
						//
						//echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br/>");
						//print_r($consult);
						//echo("<br/>");
						if(isset($consult['health'])){
							$totalhealthdumpsGROUPS++;
							//echo("&nbsp:&nbsp;HC:".$totalhealthdumpsGROUPS."<br/>");
							for($hci = 0; $hci<count($consult['health']); $hci++ ){
								$healthConsultTotal++;
								//echo("Health Consult :".$consult['health'][$hci]['name']." ".$consult['health'][$hci]['value']."<br/>");
								//$csvText .= (",,Health Consult,".$consult['health'][$hci]['name'].",".$consult['health'][$hci]['value']."\n");
							}
						}
						if(isset($consult['injury'])){
							$totalInjuryConsultsGROUPS++;
							//echo("&nbsp:&nbsp;IC:".$totalInjuryConsultsGROUPS."<br/>");
							for($ici = 0; $ici<count($consult['injury']); $ici++ ){
								$injuryConsultTotal++;
								//echo("Injury Consult :".$consult['injury'][$ici]['name']."<br/>");
								//$csvText .= (",,Injury Consult,".$consult['injury'][$ici]['name'].",".$consult['injury'][$ici]['value']."\n");
							}
						}
						if(isset($consult['opportunity'])){
							$totalOpportunityConsultsGROUPS++;
							//echo("&nbsp:&nbsp;OC:".$totalOpportunityConsultsGROUPS."<br/>");
							for($oci = 0; $oci<count($consult['opportunity']); $oci++ ){
								$opportunityConsultTotal++;
								//echo("Opportunity Consult :".$consult['opportunity'][$oci]['name']."<br/>");
								//$csvText .= (",,Opportunity Consult,".$consult['opportunity'][$oci]['name'].",".$consult['opportunity'][$oci]['value']."\n");
							}
						}
						if(isset($consult['proactive'])){
							$totalProactiveConsultsGROUPS++;
							//echo("&nbsp:&nbsp;PC:".$totalProactiveConsultsGROUPS."<br/>");
							for($oci = 0; $oci<count($consult['proactive']); $oci++ ){
								$proactiveConsultTotal++;
								//echo("Proactive Consult :".$consult['proactive'][$oci]['name']."<br/>");
								//$csvText .= (",,Proactive Consult,".$consult['proactive'][$oci]['name'].",".$consult['proactive'][$oci]['value']."\n");
							}
						}
						if(isset($consult['wellness'])){
							$totalWellnessConsultsGROUPS++;
							//echo("&nbsp:&nbsp;WC:".$totalWellnessConsultsGROUPS."<br/>");
							for($oci = 0; $oci<count($consult['wellness']); $oci++ ){
								$wellnessConsultTotal++;
								//echo("Wellness Consult :".$consult['wellness'][$oci]['name']."<br/>");
								//$csvText .= (",,Wellness Consult,".$consult['wellness'][$oci]['name'].",".$consult['wellness'][$oci]['value']."\n");
							}
						}
					}
				}
			}
			$consultsTotal = $proactiveConsultTotal+$healthConsultTotal+$injuryConsultTotal+$opportunityConsultTotal+$wellnessConsultTotal;
			$totalConsultsGROUPS = $totalhealthdumpsGROUPS+$totalInjuryConsultsGROUPS+$totalOpportunityConsultsGROUPS+$totalProactiveConsultsGROUPS+$totalWellnessConsultsGROUPS;
			$csvText .= "\nTotal Contacts,".$contactTotal."\n";
			$csvText .= "Total Consults,".$totalConsultsGROUPS."\n";
			$csvText .= "Consult Type,Total Number,% of Total\n";
			$csvText .= "Proactive Consults,".$totalProactiveConsultsGROUPS.",".round( ($totalProactiveConsultsGROUPS/$totalConsultsGROUPS)*100 )."%\n";
			$csvText .= "Health Consults,".$totalhealthdumpsGROUPS.",".round( ($totalhealthdumpsGROUPS/$totalConsultsGROUPS)*100 )."%\n";
			$csvText .= "Injury Consults,".$totalInjuryConsultsGROUPS.",".round( ($totalInjuryConsultsGROUPS/$totalConsultsGROUPS)*100 )."%\n";
			$csvText .= "Opportunity Consults,".$totalOpportunityConsultsGROUPS.",".round( ($totalOpportunityConsultsGROUPS/$totalConsultsGROUPS)*100 )."%\n";

			$csvReturn =  array ( 'name' => $csvFileName , 'csv' => $csvText , );
			return $csvReturn;
    	}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    	public function createCSV_ContactMethodOverview($clientID,$dateRange,$mode = 'normal'){
    	    $contactTotal = 0;
    	    $contactTypes = array(
    	    	'oneonone'=>0,
    	    	'telephonic'=>0,
    	    	'email'=>0,
    	    	'group'=>0,
    	    );
    		$dbhandle = $this->dbhandleSQLI();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					// GET Client Name
					$tablename = "client";
					$tableExists = $this->tableExists($tablename);
					if ($tableExists){
						$sql = "SELECT `$tablename`.`clname` FROM `$this->db`.`$tablename` WHERE `$tablename`.`id` = '$clientID'";
						$result = mysqli_query($dbhandle, $sql);
						if ($result){
							if (mysqli_num_rows($result) > 0){
								$row = mysqli_fetch_row($result);
								$clientName = $this->decode($row[0]);
								$csvText = $clientName."\n";
								$today = getdate();
								$csvFileName = $clientName."-Total_Contacts_By_Consult_Type-".$today['year']."_".$today['month']."_".$today['mday'];
							}
							else{
								$ret[0] = "0";
							}
						}
					}
					$csvText .= "Report Type,Contact Methods Overview\n";
					if($dateRange['useDateRange']){
						$csvText .= "FOR,".$dateRange['startMonth']."/".$dateRange['startDay']."/".$dateRange['startYear'].",TO,".$dateRange['endMonth']."/".$dateRange['endDay']."/".$dateRange['endYear'];
						$csvText .= ("\n");
					}
					// Print KEY into CSV 
					// Get Client Employees
					$tablename = "employee";
					$tableExists = $this->tableExists($tablename);
					if ($tableExists){
						$sql = "SELECT `$tablename`.* FROM `$this->db`.`$tablename` WHERE `$tablename`.`clid` = '$clientID'";
						$result = mysqli_query($dbhandle, $sql);
						if ($result){
							if (mysqli_num_rows($result) > 0){
								for ( $i = 0; $i < mysqli_num_rows($result); $i++ ){
									$row = mysqli_fetch_assoc($result);
									$employee = array(
										"ID"=>$row['id'],
										//"firstName"=>$this->decode($row['fname']),
										//"lastName"=>$this->decode($row['lname']),
										//"dateofbirth"=> $this->decode($row['dob']),
										//"gender"=> $this->decode($row['gender']),
										//"department"=> $this->decode($row['dept']),
										//"hireyear"=> $this->decode($row['hyear']),
										//"profileimagepath"=> $this->decode($row['imgpath']),
										//"status"=> $this->decode($row['status']),
									);
									$employee = $this->stripCommas($employee);

									// CONTACTS LOOP
									$contacts = $this->getEmployeeContacts($employee['ID'],$dateRange);
							
									foreach( $contacts as $contact){
										$contactTotal++;
										$ctname = $contact['contype'];
										//echo($contact['contype']);
										//echo('<br/>');
										if( array_key_exists($ctname,$contactTypes) ){
											$contactTypes[$ctname]++;
										} else{
											$contactTypes[$ctname] = 1;
										}
									}
									/*
									for($contactIndex = 0; $contactIndex < count($contacts); $contactIndex++ ){
										if($contacts != null){
											$contactTotal++;
											$contacts[$contactIndex] = $this->stripCommas($contacts[$contactIndex]);
											$contacts[$contactIndex]['location'] = $this->getLocation($contacts[$contactIndex]['locid']);
											$contacts[$contactIndex]['location'] = $this->stripCommas($contacts[$contactIndex]['location']);
											
											
										}
									}
									*/
								}
							}
							else{
								$ret[0] = "0";
							}
						}
					}
					//echo('<br/><br/><br/><br/><br/><br/><br/><br/><br/>AAAAAAAAAAAAAA<br/><br/><br/>');
					//print_r($contactTypes);
				}
			}
			
			$csvText .= "\nContact Method,Total,% Total\n";
			$csvText .= "Total Contacts,".$contactTotal."\n";

			foreach($contactTypes as $contactType => $total){
				//echo ('<br/>'.$contactType.' = '.$total);
				$csvText .= $contactType.','.$total.','.round( ($total/$contactTotal)*100 )."% \n";
			}

			//$csvText .= "Proactive Consults,".$proactiveConsultTotal.",".round( ($proactiveConsultTotal/$consultsTotal)*100 )."%\n";
			//$csvText .= "Health Consults,".$healthConsultTotal.",".round( ($healthConsultTotal/$consultsTotal)*100 )."%\n";
			//$csvText .= "Injury Consults,".$injuryConsultTotal.",".round( ($injuryConsultTotal/$consultsTotal)*100 )."%\n";
			//$csvText .= "Opportunity Consults,".$opportunityConsultTotal.",".round( ($opportunityConsultTotal/$consultsTotal)*100 )."%\n";

			$csvReturn =  array ( 'name' => $csvFileName , 'csv' => $csvText , );
			return $csvReturn;
    	}




/*

o.OOOo.                             OOooOoO                                                 
 O    `o                            o                                 o                     
 o      O          O                O                             O                         
 O      o         oOo               oOooO                        oOo                        
 o      O .oOoO'   o   .oOoO'       O       O   o  'OoOo. .oOo    o   O  .oOo. 'OoOo. .oOo  
 O      o O   o    O   O   o        o       o   O   o   O O       O   o  O   o  o   O `Ooo. 
 o    .O' o   O    o   o   O        o       O   o   O   o o       o   O  o   O  O   o     O 
 OooOO'   `OoO'o   `oO `OoO'o       O'      `OoO'o  o   O `OoO'   `oO o' `OoO'  o   O `OoO' 
                                                                                            
*/

////////// Health Consult Functions
 	public function getContact_hcid($contactID,$dbhandle = false){
		if($dbhandle == false){
			$dbhandle = $this->dbhandleSQLI();
		}
		$hcid = false;
		if ($this->dbfound()){
			$tablename = "hcmain";
			if ($this->tableExists($tablename)){
				// Get ID numbers for Consults 
				$sql = "SELECT `$tablename`.* FROM `$this->db`.`$tablename` WHERE `$tablename`.`conid` = '$contactID'";
				$result = mysqli_query($dbhandle, $sql);
				if ($result){
					if (mysqli_num_rows($result) > 0){
						for ( $i = 0; $i < mysqli_num_rows($result); $i++ ){ 
							$row = mysqli_fetch_assoc($result);
							$hcid[$i]=$row['id'];
							//$id = $healthConsult[$i]['id'];
						}
					}
				}
			}
		}
		return $hcid;
	}
	public function getHCID_metrics($hcid,$dbhandle = false){
		if($dbhandle == false){
			$dbhandle = $this->dbhandleSQLI();
		}
		$hcid = false;
		if ($this->dbfound()){
			$tablename = "hcdump";
			if ($this->tableExists($tablename)){
				// Get ID numbers for Consults 
				$sql = "SELECT `$tablename`.* FROM `$this->db`.`$tablename` WHERE `$tablename`.`hcid` = '$hcid' AND `$tablename`.`name` = `weight`";
				$result = mysqli_query($dbhandle, $sql);
				if ($result){
					if (mysqli_num_rows($result) > 0){
						for ( $i = 0; $i < mysqli_num_rows($result); $i++ ){ 
							$row = mysqli_fetch_assoc($result);
							$metrics[$i]=$row;
							//$id = $healthConsult[$i]['id'];
						}
					}
				}
			}
		}
		return $metrics;
	}

//
// Get Contact Consults // Get all consults associated with a Contact Event
//
	public function getContactConsults($contactID,$dbhandle = false,$tableExists = false,$type = false,$getDUMP=false){
		if($dbhandle == false){
			$dbhandle = $this->dbhandleSQLI();
		}
		$dbfound = $this->dbfound();
		if ($dbfound){
			if(!$type || $type == 'health'){
				// Health Consults
				$tablename = "hcmain";
				$tablename2 = "hcsoap";
				$tablename3 = "hcdump";
				$tableExists = $this->tableExists($tablename);
				$tableExists2 = $this->tableExists($tablename2);
				if ($tableExists){
					// Get ID numbers for Consults 
					$sql = "SELECT `$tablename`.* FROM `$this->db`.`$tablename` WHERE `$tablename`.`conid` = '$contactID'";
					$result = mysqli_query($dbhandle, $sql);
					if ($result){
						if (mysqli_num_rows($result) > 0){
							for ( $i = 0; $i < mysqli_num_rows($result); $i++ ){ 
								$row = mysqli_fetch_assoc($result);
								$healthConsult[$i]=$row;
								$id = $healthConsult[$i]['id'];
								if ($tableExists2){
									// Look up consult details from ID number
									$sql = "SELECT `$tablename2`.* FROM `$this->db`.`$tablename2` WHERE `$tablename2`.`hcid` = '$id'";
									$result = mysqli_query($dbhandle, $sql);
									if ($result){
										if (mysqli_num_rows($result) > 0){
											for ( $i = 0; $i < mysqli_num_rows($result); $i++ ){ 
												$healthConsult[$i] = mysqli_fetch_assoc($result);
												$healthConsult[$i]['value'] = $this->decode($healthConsult[$i]['value']);
											}
										}
									}
								}
								if($getDUMP){
									if ($this->tableExists($tablename3)){
										$sql = "SELECT `$tablename3`.* FROM `$this->db`.`$tablename3` WHERE `$tablename3`.`icid` = '$id'";
										$result = mysqli_query($dbhandle, $sql);
										if ($result){
											if (mysqli_num_rows($result) > 0){
												for ( $i = 0; $i < mysqli_num_rows($result); $i++ ){ 
													$row = mysqli_fetch_assoc($result);
													$healthConsultDUMP[$i]=$row;
													$healthConsultDUMP[$i]['value'] = $this->decode($healthConsultDUMP[$i]['value']);
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
			if(!$type || $type == 'injury'){
				//INJURY
				$tablename = "icmain";
				$tablename2 = "icsoap";
				$tablename3 = "icdump";
				$tableExists = $this->tableExists($tablename);
				$tableExists2 = $this->tableExists($tablename2);
				$tableExists3 = $this->tableExists($tablename3);
				if ($tableExists){
					$sql = "SELECT `$tablename`.* FROM `$this->db`.`$tablename` WHERE `$tablename`.`conid` = '$contactID'";
					$result = mysqli_query($dbhandle, $sql);
					if ($result){
						if (mysqli_num_rows($result) > 0){
							for ( $i = 0; $i < mysqli_num_rows($result); $i++ ){ 
								$injuryConsult[$i] = mysqli_fetch_assoc($result);
								$id = $injuryConsult[$i]['id'];
								if ($tableExists2){
									$sql = "SELECT `$tablename2`.* FROM `$this->db`.`$tablename2` WHERE `$tablename2`.`icid` = '$id'";
									$result = mysqli_query($dbhandle, $sql);
									if ($result){
										if (mysqli_num_rows($result) > 0){
											for ( $i = 0; $i < mysqli_num_rows($result); $i++ ){ 
												$row = mysqli_fetch_assoc($result);
												$injuryConsult[$i]=$row;
												$injuryConsult[$i]['value'] = $this->decode($injuryConsult[$i]['value']);
											}
										}
									}
								}
								if ($tableExists3){
									$sql = "SELECT `$tablename3`.* FROM `$this->db`.`$tablename3` WHERE `$tablename3`.`icid` = '$id'";
									$result = mysqli_query($dbhandle, $sql);
									if ($result){
										if (mysqli_num_rows($result) > 0){
											for ( $i = 0; $i < mysqli_num_rows($result); $i++ ){ 
												$row = mysqli_fetch_assoc($result);
												$injuryConsultDUMP[$i]=$row;
												$injuryConsultDUMP[$i]['value'] = $this->decode($injuryConsultDUMP[$i]['value']);
											}
										}
									}
								}
							}
						}
					}
				}
			}
			if(!$type || $type == 'opportunity'){
				//Opportunity
				$tablename = "ocmain";
				$tablename2 = "ocdump";
				$tableExists = $this->tableExists($tablename);
				$tableExists2 = $this->tableExists($tablename2);
				if ($tableExists){
					$sql = "SELECT `$tablename`.* FROM `$this->db`.`$tablename` WHERE `$tablename`.`conid` = '$contactID'";
					$result = mysqli_query($dbhandle, $sql);
					if ($result){
						if (mysqli_num_rows($result) > 0){
							for ( $i = 0; $i < mysqli_num_rows($result); $i++ ){
								$row = mysqli_fetch_assoc($result);
								$opportunityConsult[$i]=$row;
								$id = $opportunityConsult[$i]['id'];
								if ($tableExists2){
									$sql = "SELECT `$tablename2`.* FROM `$this->db`.`$tablename2` WHERE `$tablename2`.`ocid` = '$id'";
									$result = mysqli_query($dbhandle, $sql);
									if ($result){
										if (mysqli_num_rows($result) > 0){
											for ( $i = 0; $i < mysqli_num_rows($result); $i++ ){ 
												$row = mysqli_fetch_assoc($result);
												$opportunityConsult[$i]=$row;
												$opportunityConsult[$i]['value'] = $this->decode($opportunityConsult[$i]['value']);
											}
										}
									}
								}
							}
						}
					}
				}
			}
			if(!$type || $type == 'proactive'){
				//Proactive
				$tablename = "pcmain";
				$tablename2 = "pcdump";
				$tableExists = $this->tableExists($tablename);
				$tableExists2 = $this->tableExists($tablename2);
				if ($tableExists){
					$sql = "SELECT `$tablename`.* FROM `$this->db`.`$tablename` WHERE `$tablename`.`conid` = '$contactID'";
					$result = mysqli_query($dbhandle, $sql);
					if ($result){
						if (mysqli_num_rows($result) > 0){
							for ( $i = 0; $i < mysqli_num_rows($result); $i++ ){ 
								$proactiveConsult[$i] = mysqli_fetch_assoc($result);
								$id = $proactiveConsult[$i]['id'];
								if ($tableExists2){
									$sql = "SELECT `$tablename2`.* FROM `$this->db`.`$tablename2` WHERE `$tablename2`.`pcid` = '$id'";
									$result = mysqli_query($dbhandle, $sql);
									if ($result){
										if (mysqli_num_rows($result) > 0){
											for ( $i = 0; $i < mysqli_num_rows($result); $i++ ){ 
												$row = mysqli_fetch_assoc($result);
												$proactiveConsult[$i]=$row;
												$proactiveConsult[$i]['value'] = $this->decode($proactiveConsult[$i]['value']);
											}
										}
									}
								}
							}
						}
					}
				}
			}
			if(!$type || $type == 'wellness'){
				//Wellness
				$tablename = "wcmain";
				$tablename2 = "wcdump";
				$tableExists = $this->tableExists($tablename);
				$tableExists2 = $this->tableExists($tablename2);
				if ($tableExists){
					$sql = "SELECT `$tablename`.* FROM `$this->db`.`$tablename` WHERE `$tablename`.`conid` = '$contactID'";
					$result = mysqli_query($dbhandle, $sql);
					if ($result){
						if (mysqli_num_rows($result) > 0){
							for ( $i = 0; $i < mysqli_num_rows($result); $i++ ){ 
								$row = mysqli_fetch_assoc($result);
								$wellnessConsult[$i]=$row;
								$id = $wellnessConsult[$i]['id'];
								if ($tableExists2){
									$sql = "SELECT `$tablename2`.* FROM `$this->db`.`$tablename2` WHERE `$tablename2`.`wcid` = '$id'";
									$result = mysqli_query($dbhandle, $sql);
									if ($result){
										if (mysqli_num_rows($result) > 0){
											for ( $i = 0; $i < mysqli_num_rows($result); $i++ ){ 
												$row = mysqli_fetch_assoc($result);
												$wellnessConsult[$i]=$row;
												$wellnessConsult[$i]['value'] = $this->decode($wellnessConsult[$i]['value']);
											}
										}
									}
								}
							}
						}
					}
				}
			}
			//
			if(isset($healthConsult)){
				$consult['health'] = $healthConsult;
			}
			if(isset($healthConsultDUMP)){
				$consult['healthDUMP'] = $healthConsultDUMP;
			}
			if(isset($injuryConsult)){
				$consult['injury'] = $injuryConsult;
			}
			if(isset($injuryConsultDUMP)){
				$consult['injuryDUMP']= $injuryConsultDUMP;
			}
			if(isset($opportunityConsult)){
				$consult['opportunity'] = $opportunityConsult;
			}
			if(isset($proactiveConsult)){
				$consult['proactive'] = $proactiveConsult;
			}
			if(isset($wellnessConsult)){
				$consult['wellness'] = $wellnessConsult;
			}
		}
		if(isset($consult)){
			return $consult;
		}
		else{
			return 0;	
		}
    }
//////////////////////////////////////////////////////INJURY CONSULT TOPICS
    	public function getInjuryConsultTopics($contactID,$dbhandle = false,$tableExists = false){
			if($dbhandle == false){
				$dbhandle = $this->dbhandleSQLI();
			}
			$dbfound = $this->dbfound();
			if ($dbfound){
				//INJURY
				$tablename = "icmain";
				$tablename2 = "icsoap";
				$tablename3 = "icdump";
				$tableExists = $this->tableExists($tablename);
				$tableExists2 = $this->tableExists($tablename2);
				$tableExists3 = $this->tableExists($tablename3);
				if ($tableExists){
					$sql = "SELECT `$tablename`.* FROM `$this->db`.`$tablename` WHERE `$tablename`.`conid` = '$contactID'";
					$result = mysqli_query($dbhandle, $sql);
					if ($result){
						if (mysqli_num_rows($result) > 0){
							for ( $i = 0; $i < mysqli_num_rows($result); $i++ ){ 
								$injuryConsult[$i] = mysqli_fetch_assoc($result);
								$id = $injuryConsult[$i]['id'];
								if ($tableExists2){
									$sql = "SELECT `$tablename2`.* FROM `$this->db`.`$tablename2` WHERE `$tablename2`.`icid` = '$id'";
									$result = mysqli_query($dbhandle, $sql);
									if ($result){
										if (mysqli_num_rows($result) > 0){
											for ( $i = 0; $i < mysqli_num_rows($result); $i++ ){ 
												$row = mysqli_fetch_assoc($result);
												$injuryConsult[$i]=$row;
												$injuryConsult[$i]['value'] = $this->decode($injuryConsult[$i]['value']);
											}
										}
									}
								}
								if ($tableExists3){
									$sql = "SELECT `$tablename3`.* FROM `$this->db`.`$tablename3` WHERE `$tablename3`.`icid` = '$id'";
									$result = mysqli_query($dbhandle, $sql);
									if ($result){
										if (mysqli_num_rows($result) > 0){
											for ( $i = 0; $i < mysqli_num_rows($result); $i++ ){ 
												$row = mysqli_fetch_assoc($result);
												$injuryConsultDUMP[$i]=$row;
												$injuryConsultDUMP[$i]['value'] = $this->decode($injuryConsultDUMP[$i]['value']);
											}
										}
									}
								}
							}
						}
					}
				}
			}

			if(isset($injuryConsult)){
				$consult['soap'] = $injuryConsult;
			}
			if(isset($injuryConsultDUMP)){
				$consult['dump']= $injuryConsultDUMP;
			}
		
			if(isset($consult)){
				return $consult;
			}
			else{
				return 0;	
			}
		}
//////////////////////////////////////////////////////PROACTIVE CONSULT TOPICS
    	public function getProactiveConsultTopics($contactID,$dbhandle = false,$tableExists = false){
			if($dbhandle == false){
				$dbhandle = $this->dbhandleSQLI();
			}
			$dbfound = $this->dbfound();
			if ($dbfound){
				//Proactive
				$tablename = "pcmain";
				$tablename2 = "pcsoap";
				$tablename3 = "pcdump";
				$tableExists = $this->tableExists($tablename);
				$tableExists2 = $this->tableExists($tablename2);
				$tableExists3 = $this->tableExists($tablename3);
				if ($tableExists){
					$sql = "SELECT `$tablename`.* FROM `$this->db`.`$tablename` WHERE `$tablename`.`conid` = '$contactID'";
					$result = mysqli_query($dbhandle, $sql);
					if ($result){
						if (mysqli_num_rows($result) > 0){
							for ( $i = 0; $i < mysqli_num_rows($result); $i++ ){ 
								$pCon[$i] = mysqli_fetch_assoc($result);
								$id = $pCon[$i]['id'];
								if ($tableExists2){
									$sql = "SELECT `$tablename2`.* FROM `$this->db`.`$tablename2` WHERE `$tablename2`.`pcid` = '$id'";
									$result = mysqli_query($dbhandle, $sql);
									if ($result){
										if (mysqli_num_rows($result) > 0){
											for ( $i = 0; $i < mysqli_num_rows($result); $i++ ){ 
												$row = mysqli_fetch_assoc($result);
												$pCon[$i]=$row;
												$pCon[$i]['value'] = $this->decode($pCon[$i]['value']);
											}
										}
									}
								}
								if ($tableExists3){
									$sql = "SELECT `$tablename3`.* FROM `$this->db`.`$tablename3` WHERE `$tablename3`.`pcid` = '$id'";
									$result = mysqli_query($dbhandle, $sql);
									if ($result){
										if (mysqli_num_rows($result) > 0){
											for ( $i = 0; $i < mysqli_num_rows($result); $i++ ){ 
												$row = mysqli_fetch_assoc($result);
												$pConDUMP[$i]=$row;
												$pConDUMP[$i]['value'] = $this->decode($pConDUMP[$i]['value']);
											}
										}
									}
								}
							}
						}
					}
				}
			}

			if(isset($pCon)){
				$consult['soap'] = $pCon;
			}
			if(isset($pConDUMP)){
				$consult['dump']= $pConDUMP;
			}
			if(isset($consult)){
				return $consult;
			}
			else{
				return 0;	
			}
		}
//////////////////////////////////////////////////////HEALTH CONSULT TOPICS
    	public function getHealthConsultTopics($contactID,$dbhandle = false,$tableExists = false){
			if($dbhandle == false){
				$dbhandle = $this->dbhandleSQLI();
			}
			$dbfound = $this->dbfound();
			if ($dbfound){
				//Proactive
				$tablename = "hcmain";
				$tablename2 = "hcsoap";
				$tablename3 = "hcdump";
				$tableExists = $this->tableExists($tablename);
				$tableExists2 = $this->tableExists($tablename2);
				$tableExists3 = $this->tableExists($tablename3);
				if ($tableExists){
					$sql = "SELECT `$tablename`.* FROM `$this->db`.`$tablename` WHERE `$tablename`.`conid` = '$contactID'";
					$result = mysqli_query($dbhandle, $sql);
					if ($result){
						if (mysqli_num_rows($result) > 0){
							for ( $i = 0; $i < mysqli_num_rows($result); $i++ ){ 
								$hCon[$i] = mysqli_fetch_assoc($result);
								$id = $hCon[$i]['id'];
								if ($tableExists2){
									$sql = "SELECT `$tablename2`.* FROM `$this->db`.`$tablename2` WHERE `$tablename2`.`hcid` = '$id'";
									$result = mysqli_query($dbhandle, $sql);
									if ($result){
										if (mysqli_num_rows($result) > 0){
											for ( $i = 0; $i < mysqli_num_rows($result); $i++ ){ 
												$row = mysqli_fetch_assoc($result);
												$hCon[$i]=$row;
												$hCon[$i]['value'] = $this->decode($hCon[$i]['value']);
											}
										}
									}
								}
								if ($tableExists3){
									$sql = "SELECT `$tablename3`.* FROM `$this->db`.`$tablename3` WHERE `$tablename3`.`hcid` = '$id'";
									$result = mysqli_query($dbhandle, $sql);
									if ($result){
										if (mysqli_num_rows($result) > 0){
											for ( $i = 0; $i < mysqli_num_rows($result); $i++ ){ 
												$row = mysqli_fetch_assoc($result);
												$hConDUMP[$i]=$row;
												$hConDUMP[$i]['value'] = $this->decode($hConDUMP[$i]['value']);
											}
										}
									}
								}
							}
						}
					}
				}
			}

			if(isset($hCon)){
				$consult['soap'] = $hCon;
			}
			if(isset($hConDUMP)){
				$consult['dump']= $hConDUMP;
			}
			if(isset($consult)){
				return $consult;
			}
			else{
				return 0;	
			}
		}
/////////////////////////////////////////////////////////////////////TOPICS TOPICS TOPICS
		public function gettopics($type="",$dbhandle = false){
			$ret = array();
			$constypeid = false;
			switch($type){
				case 'health':
					$constypeid = 1;
					break;
				case 'injury':
					$constypeid = 2;
					break;
				default:
					break;
			}
			$active = "active";
			if(!$dbhandle){
				$dbhandle = $this->dbhandle();
			}
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "topic";
					$tex = $this->tex($tablename);
					if ($tex){
						if(!$constypeid){
							$sql = "SELECT * FROM `$this->db`.`$tablename` WHERE `$tablename`.`status` = '$active'";
						}else{
							$sql = "SELECT * FROM `$this->db`.`$tablename` WHERE `$tablename`.`constypeid` = '$constypeid' AND `$tablename`.`status` = '$active'";
						}
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$i = 0;
								while ($resarr = mysql_fetch_assoc($result)){
									$ret[$i]['id'] = $resarr['id'];
									$ret[$i]['topic'] = $resarr['topic'];
									$ret[$i]['ttype'] = $resarr['ttype'];
									$ret[$i]['tname'] = $resarr['tname'];
									$ret[$i]['tid'] = $resarr['tid'];
									$ret[$i]['tclass'] = $resarr['tclass'];
									$i++;
								}
							}
						}
					}
				}
			}
			return $ret;
		}
		
		public function getsubtopics($type="",$topicid = false){
			$ret = array();
			$constypeid = false;
			switch($type){
				case 'health':
					$constypeid = 1;
					break;
				case 'injury':
					$constypeid = 2;
					break;
				default:
					break;
			}
			$active = "active";
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "subtopic";
					$tex = $this->tex($tablename);
					if ($tex){
						if($topicid){
							if(!$constypeid){//get all types
								if(!$topicid){
									$sql = "SELECT * FROM `$this->db`.`$tablename` WHERE `$tablename`.`status` = '$active'";
								}else{
									$sql = "SELECT * FROM `$this->db`.`$tablename` WHERE `$tablename`.`topicid` = '$topicid' AND `$tablename`.`status` = '$active'";
								}
							}else{
								if(!$topicid){
									$sql = "SELECT * FROM `$this->db`.`$tablename` WHERE `$tablename`.`constypeid` = '$constypeid' AND `$tablename`.`status` = '$active'";
								}else{
									$sql = "SELECT * FROM `$this->db`.`$tablename` WHERE `$tablename`.`constypeid` = '$constypeid' AND `$tablename`.`topicid` = '$topicid' AND `$tablename`.`status` = '$active'";
								}
							}
							$result = mysql_query($sql, $dbhandle);
							if ($result){
								if (mysql_num_rows($result) > 0){
									$i = 0;
									while ($resarr = mysql_fetch_assoc($result)){
										$ret[$i]['id'] = $resarr['id'];
										$ret[$i]['subtopic'] = $resarr['subtopic'];
										$ret[$i]['stype'] = $resarr['stype'];
										$ret[$i]['sname'] = $resarr['sname'];
										$ret[$i]['sid'] = $resarr['sid'];
										$ret[$i]['sclass'] = $resarr['sclass'];
										$i++;
									}
								}
							}
						}else{
							$sql = "SELECT * FROM `$this->db`.`$tablename` WHERE `$tablename`.`constypeid` = '$constypeid' AND `$tablename`.`status` = '$active'";
							$result = mysql_query($sql, $dbhandle);
							if ($result){
								if (mysql_num_rows($result) > 0){
									$i = 0;
									while ($resarr = mysql_fetch_assoc($result)){
										$ret[$i]['id'] = $resarr['id'];
										$ret[$i]['subtopic'] = $resarr['subtopic'];
										$ret[$i]['stype'] = $resarr['stype'];
										$ret[$i]['sname'] = $resarr['sname'];
										$ret[$i]['sid'] = $resarr['sid'];
										$ret[$i]['sclass'] = $resarr['sclass'];
										$i++;
									}
								}
							}
						}
					}
				}
			}
			return $ret;
		}

/////////////////////////////////////////////////////////////////////////////////////////////





// get the contacts associated with an employee
    	public function getEmployeeContacts($employeeID,$dateRange,$dbhandle=false,$tableExists=false){
    		$contacts = array();
    		if($dbhandle == false){
				$dbhandle = $this->dbhandleSQLI();
			}
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					// GET Client Name
					$tablename = "contact";
					if($tableExists==false){
						$tableExists = $this->tableExists($tablename);	
					}
					if ($tableExists){
						$sql = "SELECT `$tablename`.* FROM `$this->db`.`$tablename` WHERE `$tablename`.`empid` = '$employeeID'";
						$result = mysqli_query($dbhandle, $sql);
						if ($result){
							if (mysqli_num_rows($result) > 0){
								if($dateRange['useDateRange']){
									$contactCount = 0;
									for ( $i = 0; $i < mysqli_num_rows($result); $i++ ){
										$row = mysqli_fetch_assoc($result);
										$date = $this->decode($row['dat']);

										if( $this->checkDateRange($date,$dateRange) ){ // include contact if within range
											$contacts[$contactCount]=$row; // id,clid,locid,empid
											$contacts[$contactCount]['uname'] = $this->decode($contacts[$contactCount]['uname']);
											$contacts[$contactCount]['contype'] = $this->decode($contacts[$contactCount]['contype']);
											$contacts[$contactCount]['status'] = $this->decode($contacts[$contactCount]['status']);
											$contacts[$contactCount]['dat'] = $this->decode($contacts[$contactCount]['dat']);
											$contactCount++;
										}												
									}
								}else{
									for ( $i = 0; $i < mysqli_num_rows($result); $i++ ){ 
										$row = mysqli_fetch_assoc($result);
										$contacts[$i]=$row;
										$contacts[$i]['uname'] = $this->decode($contacts[$i]['uname']);
										$contacts[$i]['contype'] = $this->decode($contacts[$i]['contype']);
										$contacts[$i]['status'] = $this->decode($contacts[$i]['status']);
										$contacts[$i]['dat'] = $this->decode($contacts[$i]['dat']);
										//$date = $contacts[$i]['dat'].split('/');											
									}
								}
							} /*else { "NO Contacts" }*/
						}
					}
				}
			}
			if(isset($contacts)){
				return $contacts;
			}
			else{
				return 0;	
			}
    	}

    	public function getLocation($locationID){
    		$dbhandle = $this->dbhandle();
    		$tablename = "clientloc";
			$tableExists = $this->tableExists($tablename);
			$location = "";
			//echo("getLocation(".$locationID.")<br/>");
			if ($tableExists){
				$sql = "SELECT `$tablename`.* FROM `$this->db`.`$tablename` WHERE `$tablename`.`id` = '$locationID'";
				$result = mysql_query($sql, $dbhandle);
				//echo($result);
				if ($result){
					if (mysql_num_rows($result) > 0){
						//for ( $i = 0; $i < mysql_num_rows($result); $i++ ){
						//Take the first result - there should not be more than one
						$row = mysql_fetch_assoc($result);
						//echo ($locationID."<br/>");
						//print_r($row);
						$location=$row;
						$location['locid'] = $this->decode($location['locid']);
						$location['street'] = $this->decode($location['street']);
						$location['city'] = $this->decode($location['city']);
						$location['zip'] = $this->decode($location['zip']);
						$location['state'] = $this->decode($location['state']);
						$location['status'] = $this->decode($location['status']);

						$location = $this->stripCommas($location);
						//echo($location['locid']."<br/>");
							//print_r($contacts[$i]);
							//echo("<br/>");
						//}
					}
				}
			}
			return $location;
    	}
    		// get Client Employees
    	public function getClientEmployees($clientID,$dateRange,$dbhandle = false,$tableExists = false){
    		$employee = array();
    		$tablename = "employee";
    		if($dbhandle != false){
    		$dbhandle = $this->dbhandleSQLI();
    		}
    		if ($tableExists != true){
    			$tableExists = $this->tableExists($tablename);
    		}
			if ($tableExists){
				$sql = "SELECT `$tablename`.* FROM `$this->db`.`$tablename` WHERE `$tablename`.`clid` = '$clientID'";
				$result = mysqli_query($dbhandle, $sql);
				if ($result){
					if (mysqli_num_rows($result) > 0){
						$employeeNumber = 0;
						for ( $i = 0; $i < mysqli_num_rows($result); $i++ ){
							$row = mysqli_fetch_assoc($result);
							if($dateRange['useDateRange']){
								$year = $this->decode($row['hyear']);
								if( $this->checkHireDateisinRange($year,$dateRange) ){
									$employee[$employeeNumber] = array(
										"ID"=>$row['id'],
										"firstName"=>$this->decode($row['fname']),
										"lastName"=>$this->decode($row['lname']),
										"dateofbirth"=> $this->decode($row['dob']),
										"gender"=> $this->decode($row['gender']),
										"department"=> $this->decode($row['dept']),
										"hireyear"=> $this->decode($row['hyear']),
										"profileimagepath"=> $this->decode($row['imgpath']),
										"status"=> $this->decode($row['status']),
									);
									$employeeNumber++;
								}
							}else{
								$employee[$i] = array(
									"ID"=>$row['id'],
									"firstName"=>$this->decode($row['fname']),
									"lastName"=>$this->decode($row['lname']),
									"dateofbirth"=> $this->decode($row['dob']),
									"gender"=> $this->decode($row['gender']),
									"department"=> $this->decode($row['dept']),
									"hireyear"=> $this->decode($row['hyear']),
									"profileimagepath"=> $this->decode($row['imgpath']),
									"status"=> $this->decode($row['status']),
								);
							}
							//$employee[$i] = $this->stripCommas($employee[$i]);
						}
					}
				}
			}
			return $employee;
		}


		public function getClientName($clientID,$dbhandle){
			//$dbhandle = $this->dbhandleSQLI();
			$clientName = false;
			$tablename = "client";
			$tableExists = $this->tableExists($tablename);
			if ($tableExists){
				$sql = "SELECT `$tablename`.`clname` FROM `$this->db`.`$tablename` WHERE `$tablename`.`id` = '$clientID'";
				$result = mysqli_query($dbhandle, $sql);
				if ($result){
					if (mysqli_num_rows($result) > 0){
						$row = mysqli_fetch_row($result);
						$clientName = $this->decode($row[0]);
					}
				}
			}
			return $clientName;
		}

/*

O       o           o                      OOooOoO                                                 
o       O       o  O  o                    o                                 o                     
O       o   O      o       O               O                             O                         
o       o  oOo     O      oOo              oOooO                        oOo                        
o       O   o   O  o  O    o   O   o       O       O   o  'OoOo. .oOo    o   O  .oOo. 'OoOo. .oOo  
O       O   O   o  O  o    O   o   O       o       o   O   o   O O       O   o  O   o  o   O `Ooo. 
`o     Oo   o   O  o  O    o   O   o       o       O   o   O   o o       o   O  o   O  O   o     O 
 `OoooO'O   `oO o' Oo o'   `oO `OoOO       O'      `OoO'o  o   O `OoO'   `oO o' `OoO'  o   O `OoO' 
                                   o                                                               
                                OoO'                                                               
*/



		public function stripCommas($array){
    		//accepts an array and removes all commas replacing them with - or whatever ya want to put there
    		//print_r($array);
    		if(is_array($array)){
	    		$keys = array_keys($array);
	    		//echo("<br/>keys = ");
	    		//print_r($keys);
	    		$length = count($keys);
	    		for($i=0; $i<$length; $i++ ){
	    			//echo("<br/>key".$i." = ");
	    			//echo($keys[$i]);
	    			//echo("<br/>array".$i." = ");
	    			//echo($array[$keys[$i]]);
	    			$array[$keys[$i]] = str_replace ( "," , "-" , $array[$keys[$i]] );
	    		}
	    		//echo("<br/><br/>");
	    		//print_r($array);
    		}
    		return $array;
    	}

    	public function checkDateRange($date,$dateRange){
    		// Returns True if date is within range
			//provide date in format m/d/y
			list($month, $day, $year) = split("/", $date);
			$month = (int)$month;
			$day = (int)$day;
			$year = (int)$year;
			$fails = false;
			if ($year >= $dateRange['startYear'] && $year <= $dateRange['endYear']){
				//if year is within B-E
				if($year ==  $dateRange['startYear'] ){
					//Y=B
					if($month >= $dateRange['startMonth']){
						if($month == $dateRange['startMonth']){
							if($day >= $dateRange['startDay']){
								// start < contactDate
							}else{
								$fails = true;
							}
						}
					}else{
						$fails = true;
					}
				}
				if($year ==  $dateRange['endYear'] ){
					if($month <= $dateRange['endMonth']){
						if($month == $dateRange['endMonth']){
							if($day <= $dateRange['endDay']){
								// end > contactDate
							}else{
								$fails = true;
							}
						}
					}else{
						$fails = true;
					}
				}
			}else{
				$fails = true;
			}

			if($fails){
				return false;
			} else {
				return true;
			}											
		}

		public function checkHireDateisinRange($year,$dateRange){
			// Returns true if an employee was hired(the provided date) occurs before the end of the date range IE if they were employed at any point in the range
			// some employee hire dates are entered in 'xx' some in 'xxxx' - this filters them out and compares accordingly
			$year = (int)$year;
			if($year < 100){ // if year was sloppily entered in 2 digit format
				if($year >= 50){ // safe to assume the 2digit year is from the 1900s
					$year = $year + 1900;
				}elseif($year < 50 ){ // safe to assume the 2 digit year is from the 2000s
					$year = $year + 2000;
				}
			} 

			if( $year <= $dateRange['endYear']){
				return true;
			} else{
				return false;
			}
		}



		public function updateDateRange($date,$range = false){
			// accepts a date and a range - compares if there date exceeds eitehr boundary and overwrites it if so - then returns it
			// $range in format array keys - 'd' 'm' 'y'
			list($month, $day, $year) = split("/", $date);
			$month = (int)$month;
			$day = (int)$day;
			$year = (int)$year;
			if(!$range || empty($range) ){
				$range['low'] = array(
					'd' => $day,
					'm' => $month,
					'y' => $year,
				);
				$range['high']= array(
					'd' => $day,
					'm' => $month,
					'y' => $year,
				);
			}else{
				$l = $range['low'];
				$h = $range['high'];
				$higher = false;
				$lower = false;

				//check higher
				if ($year > $h['y']){
					$higher =true;
				}elseif($year == $h['y']){
					if($month > $h['m']){
						$higher = true;
					}elseif($month == $h['m']){
						if($day > $h['d']){
							$higher = true;
						}
					}
				}
				//check lower
				if ($year < $l['y']){
					$lower =true;
				}elseif($year == $l['y']){
					if($month < $l['m']){
						$lower = true;
					}elseif($month == $l['m']){
						if($day < $l['d']){
							$lower = true;
						}
					}
				}

				if($higher){
					$range['high']= array(
						'd' => $day,
						'm' => $month,
						'y' => $year,
					);
				}
				if($lower){
					$range['low']= array(
						'd' => $day,
						'm' => $month,
						'y' => $year,
					);
				}

			}

			return $range;
		}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		public function cleaninput($input){
			$ret = "";
			$q = ENT_NOQUOTES;
			
			$ret = trim($input);
			$ret = htmlspecialchars($ret, $q);
			
			return $ret;
		}
		
		public function printyear(){
			$cyear = date("Y");
			$syear = $cyear - 80;
			$xyear = $cyear - 1;
			
			print "<select name=\"year\" id=\"sel4\" onchange=\"daysl();\">";
				print "<option value=\"0\">Year</option>";
				for ($i = $syear; $i <= $xyear; $i++){
					print "<option value=\"".$i."\">".$i."</option>";
				}
				print "<option value=\"".$cyear."\" selected=\"selected\">".$cyear."</option>";
			print "</select>";
			
			return $cyear;
		}
		
		public function printmonth(){
			$montharr = array();
			
			$montharr[0]['name'] = "Month";
			$montharr[0]['value'] = "0";
			$montharr[1]['name'] = "January";
			$montharr[1]['value'] = "01";
			$montharr[2]['name'] = "February";
			$montharr[2]['value'] = "02";
			$montharr[3]['name'] = "March";
			$montharr[3]['value'] = "03";
			$montharr[4]['name'] = "April";
			$montharr[4]['value'] = "04";
			$montharr[5]['name'] = "May";
			$montharr[5]['value'] = "05";
			$montharr[6]['name'] = "June";
			$montharr[6]['value'] = "06";
			$montharr[7]['name'] = "July";
			$montharr[7]['value'] = "07";
			$montharr[8]['name'] = "August";
			$montharr[8]['value'] = "08";
			$montharr[9]['name'] = "September";
			$montharr[9]['value'] = "09";
			$montharr[10]['name'] = "October";
			$montharr[10]['value'] = "10";
			$montharr[11]['name'] = "November";
			$montharr[11]['value'] = "11";
			$montharr[12]['name'] = "December";
			$montharr[12]['value'] = "12";
			
			$curmonth = date("m");
			
			print "<select name=\"month\" id=\"sel5\" onchange=\"daysl();\">";
				foreach ($montharr as $value){
					if ($value['value'] == $curmonth){
						print "<option value=\"".$value['value']."\" selected=\"selected\">".$value['name']."</option>";
					}
					else{
						print "<option value=\"".$value['value']."\">".$value['name']."</option>";
					}
				}
			print "</select>";
		}

		public function printcurdays(){
			$cyear = date("Y");
			$cmonth = date("m");
			$cday = date("d");
			$ndays = $this->getdays($cyear, $cmonth);
			
			print "<select name=\"day\" id=\"sel6\">";
				print "<option value=\"0\">Day</option>";
				for ($i = 1; $i <= $ndays; $i++){
					if ($i == $cday){
						print "<option value=\"".$i."\" selected=\"selected\">".$i."</option>";
					}
					else{
						print "<option value=\"".$i."\">".$i."</option>";
					}
				}
			print "</select>";
		}
		
		public function printyear1(){
			$cyear = date("Y");
			$syear = $cyear - 80;
			
			print "<select name=\"hyear\" id=\"sel9\" >";
				print "<option value=\"0\">Year</option>";
				for ($i = $syear; $i <= $cyear; $i++){
					print "<option value=\"".$i."\">".$i."</option>";
				}
			print "</select>";
		}
		
		private function isleap($year){
			$ret = date('L', mktime(0, 0, 0, 1, 1, $year));
			return $ret;
		}
		
		private function getdays($year, $month){
			$ret = 0;
			
			if ($month == "0" || $year == "0"){
				$ret = 0;
			}
			else{
				if ($month == "01" || $month == "03" || $month == "05" || $month == "07" || $month == "08" || $month == "10" || $month == "12"){
					$ret = 31;
				}
				else{
					if ($month == "04" || $month == "06" || $month == "09" || $month == "11"){
						$ret = 30;
					}
					else{
						if ($month == "02"){
							$isleap = $this->isleap($year);
							if ($isleap){
								$ret = 29;
							}
							else{
								$ret = 28;
							}
						}
					}
				}
			}
			return $ret;
		}
		
		public function printdays($year, $month){
			$days = $this->getdays($year, $month);
			
			if ($days == 0){
				print "<select name=\"day\" id=\"sel6\">";
					print "<option value=\"0\">Day</option>";
				print "</select>";
			}
			else{
				print "<select name=\"day\" id=\"sel6\">";
					print "<option value=\"0\">Day</option>";
					for ($i = 1; $i <= $days; $i++){
						print "<option value=\"".$i."\">".$i."</option>";
					}
				print "</select>";
			}
		}

		private function getcurclientlist(){
    		$ret = array();
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "client";
					$tex = $this->tex($tablename);
					if ($tex){
						$deleted = "deleted";
						$edeleted = $this->encode($deleted);
						$sql = "SELECT `$tablename`.`id`,  `$tablename`.`clname` FROM `$this->db`.`$tablename` WHERE `$tablename`.`status` != '$edeleted'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$i = 0;
								while ($resarr = mysql_fetch_assoc($result)){
									$ret[$i]['clid'] = $resarr['id'];
									$ret[$i]['clname'] = $this->decode($resarr['clname']);
									$i++;
								}
							}
							else{
								$ret[0] = "0";
							}
						}
					}
				}
			}
			return $ret;
    	}
		
		private function getlinkedclientlist(){
			$ret = array();
			
			$admin = "admin";
			$eadmin = $this->encode($admin);
			$guide = "guide";
			$eguide = $this->encode($guide);
			
			$curclientlist = $this->getcurclientlist();
			
			$suname = $_SESSION['uname'];
			$priv = $_SESSION['priv'];
			
			if ($priv == $eadmin){
				$ret = $curclientlist;
			}
			else{
				if ($priv == $eguide){
					$dbhandle = $this->dbhandle();
					if ($dbhandle){
						$dbfound = $this->dbfound();
						if ($dbfound){
							$tablename = "egr";
							$tex = $this->tex($tablename);
							if ($tex){
								$i = 0;
								foreach ($curclientlist as $value){
									$clid = $value['clid'];
									$sql = "SELECT `$tablename`.`uname` FROM `$this->db`.`$tablename` WHERE `$tablename`.`clid` = '$clid'";
									$result = mysql_query($sql, $dbhandle);
									if ($result){
										if (mysql_num_rows($result) > 0){
											while ($resarr = mysql_fetch_assoc($result)){
												if (in_array($suname, $resarr)){
													$ret[$i] = $value;
													$i++;
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
			return $ret;
		}

		public function printlinkedclientlist(){
			$res = $this->getlinkedclientlist();
			
			if (empty($res)){
				print "<select name=\"lc\" id=\"sel1\" tabindex=\"1\" >";
					print "<option value =\"0\">Select Client</option>";
				print "</select>";
			}
			else{
				print "<select name=\"lc\" id=\"sel1\" tabindex=\"1\" onChange = \"getloc();\">";
					print "<option value =\"0\">Select Client</option>";
					foreach ($res as $value){
						print "<option value=\"".$value['clid']."\">".$value['clname']."</option>";
					}
				print "</select>";
			}
		}
		
		private function getcurloclist($clid){
			$ret = array();
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "clientloc";
					$tex = $this->tex($tablename);
					if ($tex){
						$active = "active";
						$eactive = $this->encode($active);
						$sql = "SELECT `$tablename`.`id`, `$tablename`.`locid` FROM `$this->db`.`$tablename` WHERE `$tablename`.`clid` = '$clid' AND `$tablename`.`status` = '$eactive'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$i = 0;
								while ($resarr = mysql_fetch_assoc($result)){
									$ret[$i]['id'] = $resarr['id'];
									$ret[$i]['locid'] = $this->decode($resarr['locid']);
									$i++;
								}
							}
						}
					}
				}
			}
			return $ret;
		}
		
		public function printcurloclist($clid){
			
			if ($clid == "0"){
				print "<select name=\"lid\" id=\"sel2\" tabindex=\"2\" >";
					print "<option value =\"0\">Select Location</option>";
				print "</select>";
			}
			else{
				$res = $this->getcurloclist($clid);
				if (empty($res)){
					print "<select name=\"lid\" id=\"sel2\" tabindex=\"2\" >";
						print "<option value =\"0\">Select Location</option>";
					print "</select>";
				}
				else{
					print "<select name=\"lid\" id=\"sel2\" tabindex=\"2\" >";
						print "<option value =\"0\">Select Location</option>";
						foreach ($res as $value){
							print "<option value=\"".$value['id']."\">".$value['locid']."</option>";
						}
					print "</select>";
				}
			}
		}
		
		public function vclid($clid){
			$ret = "";
			if ($clid == "0"){
				$ret = "Please Select Client";
			}
			return $ret;
		}
		
		public function vlocid($locid){
			$ret = "";
			if ($locid == "0"){
				$ret = "Please Select Client Location";
			}
			return $ret;
		}
    	
		public function vfname($fname){
			$ret = "";
			if ($fname == ""){
				$ret = "First name cannot be empty";
			}
			else{
				if (strlen($fname) > 30){
					"First name cannot be more than 30 characters";
				}
			}
			return $ret;
		}
		
		public function vmname($mname){
			$ret = "";
			if (strlen($mname) > 30){
				$ret = "Middle name cannot be more than 30 characters";
			}
			return $ret;
		}
		
		public function vlname($lname){
			$ret = "";
			if (strlen($lname) > 30){
				$ret = "Last name cannot be more than 30 characters";
			}
			return $ret;
		}
		
		public function vsex($sex){
			$ret = "";
			if ($sex == "0"){
				$ret = "Please Select sex";
			}
			return $ret;
		}
		
		public function vdate($year, $month, $day){
			$ret = "";
			if ($year == "0"){
				$ret = "Please select year";
			}
			else{
				if ($month == "0"){
					$ret = "Please select month";
				}
				else{
					if ($day == "0"){
						$ret = "Please Select Day";
					}
				}
			}
			return $ret;
		}
		
		public function vdept($dept){
			$ret = "";
			if (strlen($dept) > 50){
				$ret = "Department cannot be more than 50 characters";
			}
			return $ret;
		}
		
		public function vpos($pos){
			$ret = "";
			if (strlen($pos) > 60){
				$ret = "Position cannot be more than 60 characters";
			}
			return $ret;
		}
		
		public function vdesg($desg){
			$ret = "";
			if (strlen($desg) > 30){
				$ret = "Designation cannot be more than 30 characters";
			}
			return $ret;
		}
		
		public function vhyear($hyear){
			$ret = "";
			if ($hyear == "0"){
				$ret = "Please Select hire year";
			}
			return $ret;
		}
		
		public function vhtype($htype){
			$ret = "";
			if ($htype == "0"){
				$ret = "Please Select hire type";
			}
			return $ret;
		}
		
		public function vhplan($hplan){
			$ret = "";
			if (strlen($hplan) > 60){
				$ret = "Health plan cannot be more than 60 characters";
			}
			return $ret;
		}
		
		public function getmaxid(){
			$ret = 0;
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "employee";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT MAX(id) FROM `$this->db`.`$tablename`";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$resarr = mysql_fetch_assoc($result);
								$ret = $resarr['MAX(id)'];
								if (empty($ret)){
									$ret = 0;
								}
							}
						}
					}
				}
			}
			return $ret;
		}
		
		public function getlastinsertid(){
			$ret = "";
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$sql = "SELECT LAST_INSERT_ID()";
					$result = mysql_query($sql, $dbhandle);
					if ($result){
						if (mysql_num_rows($result) > 0){
							$resarr = mysql_fetch_assoc($result);
							$ret = $resarr['LAST_INSERT_ID()'];
						}
					}
				}
			}
			return $ret;
		}
		
		public function cremp1($clid, $locid, $fname, $mname, $lname, $dob, $sex, $dept, $pos, $desg, $htype, $hyear, $destination, $hplan, $status){
			
			$ret = FALSE;
			
			$clid = $this->injcheck($clid);
			$locid = $this->injcheck($locid);
			$fname = $this->injcheck($fname);
			$mname = $this->injcheck($mname);
			$lname = $this->injcheck($lname);
			$dob = $this->injcheck($dob);
			$sex = $this->injcheck($sex);
			$dept = $this->injcheck($dept);
			$pos = $this->injcheck($pos);
			$desg = $this->injcheck($desg);
			$htype = $this->injcheck($htype);
			$hyear = $this->injcheck($hyear);
			$destination = $this->injcheck($destination);
			$hplan = $this->injcheck($hplan);
			$status = $this->injcheck($status);
			
			$fname = $this->encode($fname);
			$mname = $this->encode($mname);
			$lname = $this->encode($lname);
			$dob = $this->encode($dob);
			$sex = $this->encode($sex);
			$dept = $this->encode($dept);
			$pos = $this->encode($pos);
			$desg = $this->encode($desg);
			$htype = $this->encode($htype);
			$hyear = $this->encode($hyear);
			$destination = $this->encode($destination);
			$hplan = $this->encode($hplan);
			$status = $this->encode($status);
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "employee";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "INSERT INTO `$this->db`.`$tablename` (
							`id`,
							`clid`, 
							`locid`,  
							`fname`, 
							`mname`, 
							`lname`, 
							`dob`, 
							`gender`, 
							`dept`, 
							`pos`, 
							`desg`, 
							`type`, 
							`hyear`, 
							`imgpath`, 
							`hplan`,
							`status`
						)
						VALUES(
							NULL, 
							'$clid', 
							'$locid', 
							'$fname', 
							'$mname', 
							'$lname', 
							'$dob', 
							'$sex', 
							'$dept', 
							'$pos', 
							'$desg', 
							'$htype', 
							'$hyear', 
							'$destination', 
							'$hplan',
							'$status'
						)";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							$ret = TRUE;
						}
					}
				}
			}
			return $ret;
		}
		
		public function upemplog($suname, $ipadd, $dts, $action, $empid){
			$ret = FALSE;
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "emplog";
					$tex = $this->tex($tablename);
					if ($tex){
						$suname = $this->injcheck($suname);
						$ipadd = $this->injcheck($ipadd);
						$dts = $this->injcheck($dts);
						$action = $this->injcheck($action);
						$empid = $this->injcheck($empid);
						$sql = "INSERT INTO `$this->db`.`$tablename` (
							`id`, 
							`uname`,
							`ipadd`,
							`dts`,
							`action`, 
							`empid`
						)
						VALUES(
							NULL,
							'$suname', 
							'$ipadd',
							'$dts', 
							'$action',
							'$empid'
						)";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							$ret = TRUE;
						}
					}
				}
			}
			return $ret;
		}
		
    }

	class SimpleImage {
 
   var $image;
   var $image_type;
 
   function load($filename) {
 
      $image_info = getimagesize($filename);
      $this->image_type = $image_info[2];
      if( $this->image_type == IMAGETYPE_JPEG ) {
 
         $this->image = imagecreatefromjpeg($filename);
      } elseif( $this->image_type == IMAGETYPE_GIF ) {
 
         $this->image = imagecreatefromgif($filename);
      } elseif( $this->image_type == IMAGETYPE_PNG ) {
 
         $this->image = imagecreatefrompng($filename);
      }
   }
   function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null) {
 
   // do this or they'll all go to jpeg
   $image_type=$this->image_type;

  if( $image_type == IMAGETYPE_JPEG ) {
     imagejpeg($this->image,$filename,$compression);
  } elseif( $image_type == IMAGETYPE_GIF ) {
     imagegif($this->image,$filename);  
  } elseif( $image_type == IMAGETYPE_PNG ) {
    // need this for transparent png to work          
    imagealphablending($this->image, false);
    imagesavealpha($this->image,true);
    imagepng($this->image,$filename);
  }   
  if( $permissions != null) {
     chmod($filename,$permissions);
  }
   }
   function output($image_type=IMAGETYPE_JPEG) {
 
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image);
      } elseif( $image_type == IMAGETYPE_GIF ) {
 
         imagegif($this->image);
      } elseif( $image_type == IMAGETYPE_PNG ) {
 
         imagepng($this->image);
      }
   }
   function getWidth() {
 
      return imagesx($this->image);
   }
   function getHeight() {
 
      return imagesy($this->image);
   }
   function resizeToHeight($height) {
 
      $ratio = $height / $this->getHeight();
      $width = $this->getWidth() * $ratio;
      $this->resize($width,$height);
   }
 
   function resizeToWidth($width) {
      $ratio = $width / $this->getWidth();
      $height = $this->getheight() * $ratio;
      $this->resize($width,$height);
   }
 
   function scale($scale) {
      $width = $this->getWidth() * $scale/100;
      $height = $this->getheight() * $scale/100;
      $this->resize($width,$height);
   }
 
   function resize($width,$height) {
      $new_image = imagecreatetruecolor($width, $height);
  /* Check if this image is PNG or GIF, then set if Transparent*/  
  if(($this->image_type == IMAGETYPE_GIF) || ($this->image_type==IMAGETYPE_PNG)){
      imagealphablending($new_image, false);
      imagesavealpha($new_image,true);
      $transparent = imagecolorallocatealpha($new_image, 255, 255, 255, 127);
      imagefilledrectangle($new_image, 0, 0, $width, $height, $transparent);
  }
  imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());

  $this->image = $new_image;
   }      
 
}
//Anything left between these php tags goes intot the reports!!!!!!
?>
<?php

// EXTRA GARBAGe - TRIAL FUNCTIONS, SAVED STUFF, ETC  -- REMOVE BEFORE UPLOADING

/*
/////
/////		Full Employee Report
/////                               
*/

class extrafunctionholder {


    	public function createClientCSV($clientID,$dateRange){ // Full Report
    		//phpinfo();
    		$start = time();
    		$dbhandle = $this->dbhandleSQLI();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					// GET Client Name
					$tablename = "client";
					$tableExists = $this->tableExists($tablename);
					
					if ($tableExists){
						$sql = "SELECT `$tablename`.`clname` FROM `$this->db`.`$tablename` WHERE `$tablename`.`id` = '$clientID'";
						$result = mysqli_query($dbhandle, $sql);
						if ($result){
							if (mysqli_num_rows($result) > 0){
								$row = mysqli_fetch_row($result);
								$clientName = $this->decode($row[0]);
								$csvText = $clientName."\n";
								$today = getdate();
								if($dateRange['useDateRange']){
									$csvFileName = $clientName."-Full_Employee_Report-".$dateRange['startMonth']."-".$dateRange['startDay']."-".$dateRange['startYear']."-TO-".$dateRange['endMonth']."-".$dateRange['endDay']."-".$dateRange['endYear']."__".$today['year']."_".$today['month']."_".$today['mday'];
								}else{
									$csvFileName = $clientName."-Full_Employee_Report-Complete_".$today['year']."_".$today['month']."_".$today['mday'];
								}
							}
							else{
								$ret[0] = "0";
							}
						}
					}

					$csvText .= "Report Type,Full Employee Report\n";

					if($dateRange['useDateRange']){
						$csvText .= "FOR,".$dateRange['startMonth']."/".$dateRange['startDay']."/".$dateRange['startYear'].",TO,".$dateRange['endMonth']."/".$dateRange['endDay']."/".$dateRange['endYear'];
						$csvText .= ("\n");
					}

					// Print KEY into CSV
					$csvText .= ("\n");
					$csvText .= ("KEY,\n");
					$csvText .= ("EMPLOYEE LINES,\n");
					$csvText .= ("First Name,Last Name,Date of Birth,Gender,Department,Year Hired,Status,\n");
					$csvText .= ("CONTACT LINES,\n");
					$csvText .= (",Date of Contact,Location Name,Username,Contact Type,Status,\n");
					$csvText .= ("CONSULT LINES,\n");
					$csvText .= (",,Consult Type,Name,Value,\n");
					$csvText .= ("\n");
					$csvText .= ("\n");
					// Get Client Employees
					$tablename = "employee";
					$tableExists = $this->tableExists($tablename);

					if ($tableExists){
						$sql = "SELECT `$tablename`.* FROM `$this->db`.`$tablename` WHERE `$tablename`.`clid` = '$clientID'";
						$result = mysqli_query($dbhandle, $sql);
						if ($result){
							if (mysqli_num_rows($result) > 0){
								echo ("Number of employee results: ".mysqli_num_rows($result)."<br/>");
								for ( $i = 0; $i < mysqli_num_rows($result); $i++ ){
									$row = mysqli_fetch_assoc($result);
									$employee = array(
										"ID"=>$row['id'],
										"firstName"=>$this->decode($row['fname']),
										"lastName"=>$this->decode($row['lname']),
										"dateofbirth"=> $this->decode($row['dob']),
										"gender"=> $this->decode($row['gender']),
										"department"=> $this->decode($row['dept']),
										"hireyear"=> $this->decode($row['hyear']),
										"profileimagepath"=> $this->decode($row['imgpath']),
										"status"=> $this->decode($row['status']),
									);
									echo ('<br/>'.$i .' ID: '.$employee['ID']." lastName: ".$employee['lastName'].'<br/>');
									//print_r($employee);
									$employee = $this->stripCommas($employee);
									// Print EMPLOYEE into CSV
									$csvText .= ($employee['firstName'].",".$employee['lastName'].",".$employee['dateofbirth'].",".$employee['gender'].",".$employee['department'].",".$employee['hireyear'].",".$employee['status']."\n");
									// CONTACTS LOOP
									$employeeID = $employee['ID'];
									$csvText .= "\n$employeeID,";
									//$contacts = $this->getEmployeeContacts($employee['ID'],$dateRange);	
									$tablename = "contact";
									$tableExists = $this->tableExists($tablename);

									if ($tableExists){
										$sql = "SELECT `$tablename`.* FROM `$this->db`.`$tablename` WHERE `$tablename`.`empid` = '$employeeID'";
										$csvText .= "Querying for contacts,\n";
										$contactResult = mysqli_query($dbhandle, $sql);
										if ($contactResult){
											if (mysqli_num_rows($contactResult) > 0){
												if($dateRange['useDateRange']){
													$contactCount = 0;
													for ( $y = 0; $y < mysqli_num_rows($contactResult); $y++ ){
														$row = mysqli_fetch_assoc($contactResult);
														$date = $this->decode($row['dat']);

														if( $this->checkDateRange($date,$dateRange) ){ // include contact if within range
															$contacts[$contactCount]=$row;
															$contacts[$contactCount]['uname'] = $this->decode($contacts[$contactCount]['uname']);
															$contacts[$contactCount]['contype'] = $this->decode($contacts[$contactCount]['contype']);
															$contacts[$contactCount]['status'] = $this->decode($contacts[$contactCount]['status']);
															$contacts[$contactCount]['dat'] = $this->decode($contacts[$contactCount]['dat']);
															$contactCount++;
														}												
													}
												}else{
													for ( $y = 0; $y < mysqli_num_rows($contactResult); $y++ ){ 
														$row = mysqli_fetch_assoc($contactResult);
														$contacts[$y]=$row;
														$contacts[$y]['uname'] = $this->decode($contacts[$y]['uname']);
														$contacts[$y]['contype'] = $this->decode($contacts[$y]['contype']);
														$contacts[$y]['status'] = $this->decode($contacts[$y]['status']);
														$contacts[$y]['dat'] = $this->decode($contacts[$y]['dat']);
														//$date = $contacts[$i]['dat'].split('/');
														$csvText .= $contacts[$y]['dat']."\n";											
													}
												}
											}
										}
									}
									
									//FOR Contacts
									for($y=0; $y < count($contacts); $y++ ){
										$contactID = $contacts[$y]['id'];
										echo($contactID.'<br/>');
										//Health
										$tablename = 'hcmain';
										$tableExists = $this->tableExists($tablename);
										$tablename2 = 'hcsoap';
										$tex2 = $this->tableExists($tablename2);
										if ($tableExists){
											$sql = "SELECT `$tablename`.* FROM `$this->db`.`$tablename` WHERE `$tablename`.`conid` = '$contactID'";
											$HCresult = mysqli_query($dbhandle, $sql);
											if ($HCresult){
												if (mysqli_num_rows($HCresult) > 0){
													for ( $u = 0; $u < mysqli_num_rows($HCresult); $u++ ){ 
														$row = mysqli_fetch_assoc($HCresult);
														$healthConsult[$u]=$row;
														$hcid = $healthConsult[$u]['id'];
														echo('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;HC: '.$hcid.'<br/>');
/*
														if ($tableExists){
															$sql = "SELECT `$tablename2`.* FROM `$this->db`.`$tablename2` WHERE `$tablename`.`hcid` = '$hcid'";
															$HCdetails = mysqli_query($dbhandle, $sql);
															if ($HCdetails){
																if (mysqli_num_rows($HCdetails) > 0){
																	for ( $x = 0; $x < mysqli_num_rows($HCdetails); $x++ ){ 
																		$row = mysqli_fetch_assoc($HCdetails);
																		$healthConsult[$u][$x]=$row;
																		$healthConsult[$u]['value'] = $this->decode($healthConsult[$u]['value']);
																		echo('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$nbsp;value: '.$healthConsult[$u]['value'].'<br/>');
																	}
																}
															}
														}
*/
													}
												}
											}
										}	
									}
													/*
													// Look up consult details from ID number
													$sql = "SELECT `$tablename2`.* FROM `$this->db`.`$tablename2` WHERE `$tablename2`.`hcid` = '$id'";
													$result = mysqli_query($dbhandle, $sql);
													if ($result){
														if (mysqli_num_rows($result) > 0){
															for ( $o = 0; $o < mysqli_num_rows($result); $o++ ){ 
																$healthConsult[$o] = mysqli_fetch_assoc($result);
																$healthConsult[$o]['value'] = $this->decode($healthConsult[$o]['value']);
																echo('<br/>$nbsp;$nbsp;'.$healthConsult[$o]['value'].'<br/>');
															}
														}
													}
													
												}
											}
										}


									} // End FOR $contacts

*/





									/*
									for($contactIndex = 0; $contactIndex < count($contacts); $contactIndex++ ){
										if($contacts != null){
											$contacts[$contactIndex] = $this->stripCommas($contacts[$contactIndex]);
											$contacts[$contactIndex]['location'] = $this->getLocation($contacts[$contactIndex]['locid']);f
											$contacts[$contactIndex]['location'] = $this->stripCommas($contacts[$contactIndex]['location']);
											// Print CONTACT into CSV
											$csvText .= (",".$contacts[$contactIndex]['dat'].",".$contacts[$contactIndex]['location']['locid'].",".$contacts[$contactIndex]['uname'].",".$contacts[$contactIndex]['contype'].",".$contacts[$contactIndex]['status']."\n");
											// QUERY for CONSULTS
											$consult = $this->getContactConsults($contacts[$contactIndex]['id']);
											if(isset($consult['health'])){
												for($hci = 0; $hci<count($consult['health']); $hci++ ){
													$csvText .= (",,Health Consult,".$consult['health'][$hci]['name'].",".$consult['health'][$hci]['value']."\n");
												}
											}
											if(isset($consult['injury'])){
												for($ici = 0; $ici<count($consult['injury']); $ici++ ){
													$csvText .= (",,Injury Consult,".$consult['injury'][$ici]['name'].",".$consult['injury'][$ici]['value']."\n");
												}
											}
											if(isset($consult['opportunity'])){
												for($oci = 0; $oci<count($consult['opportunity']); $oci++ ){
													$csvText .= (",,Opportunity Consult,".$consult['opportunity'][$oci]['name'].",".$consult['opportunity'][$oci]['value']."\n");
												}
											}
											if(isset($consult['proactive'])){
												for($oci = 0; $oci<count($consult['proactive']); $oci++ ){
													$csvText .= (",,Proactive Consult,".$consult['proactive'][$oci]['name'].",".$consult['proactive'][$oci]['value']."\n");
												}
											}
											if(isset($consult['wellness'])){
												for($oci = 0; $oci<count($consult['wellness']); $oci++ ){
													//echo("Wellness Consult :".$consult['wellness'][$oci]['name']."<br/>");
													$csvText .= (",,Wellness Consult,".$consult['wellness'][$oci]['name'].",".$consult['wellness'][$oci]['value']."\n");
												}
											}
										}else{
											$csvText .= ",No Contacts,\n";
										}
									}
									*/
									//echo('<br/>Processed Employee '.$i);
								
									$csvText .= "\n";
								}

							}
							else{
								$ret[0] = "0";
							}
						}
					}
				}
			}
			$end = time();
			$csvText .= "\nStart,".$start.',END,'.$end.',Total Time,'.($end - $start);
			$csvReturn =  array ( 'name' => $csvFileName , 'csv' => $csvText , );
			return $csvReturn;
    	}
/*
/////
/////		Full Employee Report
/////                               
*/

public function createClientCSVplainSQL($clientID,$dateRange){ // Full Report
    		phpinfo();
    		$start = time();
    		$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					// GET Client Name
					$tablename = "client";
					$tableExists = $this->tableExists($tablename);
					
					if ($tableExists){
						$sql = "SELECT `$tablename`.`clname` FROM `$this->db`.`$tablename` WHERE `$tablename`.`id` = '$clientID'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$row = mysql_fetch_row($result);
								$clientName = $this->decode($row[0]);
								$csvText = $clientName."\n";
								$today = getdate();
								if($dateRange['useDateRange']){
									$csvFileName = $clientName."-Full_Employee_Report-".$dateRange['startMonth']."-".$dateRange['startDay']."-".$dateRange['startYear']."-TO-".$dateRange['endMonth']."-".$dateRange['endDay']."-".$dateRange['endYear']."__".$today['year']."_".$today['month']."_".$today['mday'];
								}else{
									$csvFileName = $clientName."-Full_Employee_Report-Complete_".$today['year']."_".$today['month']."_".$today['mday'];
								}
							}
							else{
								$ret[0] = "0";
							}
						}
					}

					$csvText .= "Report Type,Full Employee Report\n";

					if($dateRange['useDateRange']){
						$csvText .= "FOR,".$dateRange['startMonth']."/".$dateRange['startDay']."/".$dateRange['startYear'].",TO,".$dateRange['endMonth']."/".$dateRange['endDay']."/".$dateRange['endYear'];
						$csvText .= ("\n");
					}

					// Print KEY into CSV
					$csvText .= ("\n");
					$csvText .= ("KEY,\n");
					$csvText .= ("EMPLOYEE LINES,\n");
					$csvText .= ("First Name,Last Name,Date of Birth,Gender,Department,Year Hired,Status,\n");
					$csvText .= ("CONTACT LINES,\n");
					$csvText .= (",Date of Contact,Location Name,Username,Contact Type,Status,\n");
					$csvText .= ("CONSULT LINES,\n");
					$csvText .= (",,Consult Type,Name,Value,\n");
					$csvText .= ("\n");
					$csvText .= ("\n");
					// Get Client Employees
					$tablename = "employee";
					$tableExists = $this->tableExists($tablename);

					if ($tableExists){
						$sql = "SELECT `$tablename`.* FROM `$this->db`.`$tablename` WHERE `$tablename`.`clid` = '$clientID'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								echo ("Number of employee results: ".mysql_num_rows($result)."<br/>");
								for ( $i = 0; $i < mysql_num_rows($result); $i++ ){
									$row = mysql_fetch_assoc($result);
									$employee = array(
										"ID"=>$row['id'],
										"firstName"=>$this->decode($row['fname']),
										"lastName"=>$this->decode($row['lname']),
										"dateofbirth"=> $this->decode($row['dob']),
										"gender"=> $this->decode($row['gender']),
										"department"=> $this->decode($row['dept']),
										"hireyear"=> $this->decode($row['hyear']),
										"profileimagepath"=> $this->decode($row['imgpath']),
										"status"=> $this->decode($row['status']),
									);
									echo ('<br/>'.$i .' ID: '.$employee['ID']." lastName: ".$employee['lastName'].'<br/>');
									//print_r($employee);
									$employee = $this->stripCommas($employee);
									// Print EMPLOYEE into CSV
									$csvText .= ($employee['firstName'].",".$employee['lastName'].",".$employee['dateofbirth'].",".$employee['gender'].",".$employee['department'].",".$employee['hireyear'].",".$employee['status']."\n");
									// CONTACTS LOOP
									$employeeID = $employee['ID'];
									$csvText .= "\n$employeeID,";
									//$contacts = $this->getEmployeeContacts($employee['ID'],$dateRange);	
									$tablename = "contact";
									$tableExists = $this->tableExists($tablename);

									if ($tableExists){
										$sql = "SELECT `$tablename`.* FROM `$this->db`.`$tablename` WHERE `$tablename`.`empid` = '$employeeID'";
										$csvText .= "Querying for contacts,\n";
										$contactResult = mysql_query($sql, $dbhandle);
										if ($contactResult){
											if (mysql_num_rows($contactResult) > 0){
												if($dateRange['useDateRange']){
													$contactCount = 0;
													for ( $y = 0; $y < mysql_num_rows($contactResult); $y++ ){
														$row = mysql_fetch_assoc($contactResult);
														$date = $this->decode($row['dat']);

														if( $this->checkDateRange($date,$dateRange) ){ // include contact if within range
															$contacts[$contactCount]=$row;
															$contacts[$contactCount]['uname'] = $this->decode($contacts[$contactCount]['uname']);
															$contacts[$contactCount]['contype'] = $this->decode($contacts[$contactCount]['contype']);
															$contacts[$contactCount]['status'] = $this->decode($contacts[$contactCount]['status']);
															$contacts[$contactCount]['dat'] = $this->decode($contacts[$contactCount]['dat']);
															$contactCount++;
														}												
													}
												}else{
													for ( $y = 0; $y < mysql_num_rows($contactResult); $y++ ){ 
														$row = mysql_fetch_assoc($contactResult);
														$contacts[$y]=$row;
														$contacts[$y]['uname'] = $this->decode($contacts[$y]['uname']);
														$contacts[$y]['contype'] = $this->decode($contacts[$y]['contype']);
														$contacts[$y]['status'] = $this->decode($contacts[$y]['status']);
														$contacts[$y]['dat'] = $this->decode($contacts[$y]['dat']);
														//$date = $contacts[$i]['dat'].split('/');
														$csvText .= $contacts[$y]['dat']."\n";											
													}
												}
											}
										}
									}
									
									//FOR Contacts
									for($y=0; $y < count($contacts); $y++ ){
										$contactID = $contacts[$y]['id'];
										echo($contactID.'<br/>');
										//Health
										$tablename = 'hcmain';
										$tableExists = $this->tableExists($tablename);
										$tablename2 = 'hcsoap';
										$tex2 = $this->tableExists($tablename2);
										if ($tableExists){
											$sql = "SELECT `$tablename`.* FROM `$this->db`.`$tablename` WHERE `$tablename`.`conid` = '$contactID'";
											$HCresult = mysql_query($sql, $dbhandle);
											if ($HCresult){
												if (mysql_num_rows($HCresult) > 0){
													for ( $u = 0; $u < mysql_num_rows($HCresult); $u++ ){ 
														$row = mysql_fetch_assoc($HCresult);
														$healthConsult[$u]=$row;
														$hcid = $healthConsult[$u]['id'];
														echo('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;HC: '.$hcid.'<br/>');
/*
														if ($tableExists){
															$sql = "SELECT `$tablename2`.* FROM `$this->db`.`$tablename2` WHERE `$tablename`.`hcid` = '$hcid'";
															$HCdetails = mysqli_query($dbhandle, $sql);
															if ($HCdetails){
																if (mysqli_num_rows($HCdetails) > 0){
																	for ( $x = 0; $x < mysqli_num_rows($HCdetails); $x++ ){ 
																		$row = mysqli_fetch_assoc($HCdetails);
																		$healthConsult[$u][$x]=$row;
																		$healthConsult[$u]['value'] = $this->decode($healthConsult[$u]['value']);
																		echo('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$nbsp;value: '.$healthConsult[$u]['value'].'<br/>');
																	}
																}
															}
														}
*/
													}
												}
											}
										}	
									}

								
									$csvText .= "\n";
								}

							}
							else{
								$ret[0] = "0";
							}
						}
					}
				}
			}
			$end = time();
			$csvText .= "\nStart,".$start.',END,'.$end.',Total Time,'.($end - $start);
			$csvReturn =  array ( 'name' => $csvFileName , 'csv' => $csvText , );
			return $csvReturn;
    	}

    	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    	/*
    	public function createClientCSV($clientID,$dateRange){ // Full Report
    		$start = time();
    		$dbhandle = $this->dbhandleSQLI();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					// GET Client Name
					$tablename = "client";
					$tableExists = $this->tableExists($tablename);
					if ($tableExists){
						$sql = "SELECT `$tablename`.`clname` FROM `$this->db`.`$tablename` WHERE `$tablename`.`id` = '$clientID'";
						$result = mysqli_query($dbhandle, $sql);
						if ($result){
							if (mysqli_num_rows($result) > 0){
								$row = mysqli_fetch_row($result);
								$clientName = $this->decode($row[0]);
								$csvText = $clientName."\n";
								$today = getdate();
								if($dateRange['useDateRange']){
									$csvFileName = $clientName."-Full_Employee_Report-".$dateRange['startMonth']."-".$dateRange['startDay']."-".$dateRange['startYear']."-TO-".$dateRange['endMonth']."-".$dateRange['endDay']."-".$dateRange['endYear']."__".$today['year']."_".$today['month']."_".$today['mday'];
								}else{
									$csvFileName = $clientName."-Full_Employee_Report-Complete_".$today['year']."_".$today['month']."_".$today['mday'];
								}
							}
							else{
								$ret[0] = "0";
							}
						}
					}
					$csvText .= "Report Type,Full Employee Report\n";
					if($dateRange['useDateRange']){
						$csvText .= "FOR,".$dateRange['startMonth']."/".$dateRange['startDay']."/".$dateRange['startYear'].",TO,".$dateRange['endMonth']."/".$dateRange['endDay']."/".$dateRange['endYear'];
						$csvText .= ("\n");
					}
					// Print KEY into CSV
					$csvText .= ("\n");
					$csvText .= ("KEY,\n");
					$csvText .= ("EMPLOYEE LINES,\n");
					$csvText .= ("First Name,Last Name,Date of Birth,Gender,Department,Year Hired,Status,\n");
					$csvText .= ("CONTACT LINES,\n");
					$csvText .= (",Date of Contact,Location Name,Username,Contact Type,Status,\n");
					$csvText .= ("CONSULT LINES,\n");
					$csvText .= (",,Consult Type,Name,Value,\n");
					$csvText .= ("\n");
					$csvText .= ("\n");
					// Get Client Employees
					$tablename = "employee";
					$tableExists = $this->tableExists($tablename);
					if ($tableExists){
						$sql = "SELECT `$tablename`.* FROM `$this->db`.`$tablename` WHERE `$tablename`.`clid` = '$clientID'";
						$result = mysqli_query($dbhandle, $sql);
						if ($result){
							if (mysqli_num_rows($result) > 0){
								for ( $i = 0; $i < mysqli_num_rows($result); $i++ ){
									$row = mysqli_fetch_assoc($result);
									$employee = array(
										"ID"=>$row['id'],
										"firstName"=>$this->decode($row['fname']),
										"lastName"=>$this->decode($row['lname']),
										"dateofbirth"=> $this->decode($row['dob']),
										"gender"=> $this->decode($row['gender']),
										"department"=> $this->decode($row['dept']),
										"hireyear"=> $this->decode($row['hyear']),
										"profileimagepath"=> $this->decode($row['imgpath']),
										"status"=> $this->decode($row['status']),
									);
									$employee = $this->stripCommas($employee);
									// Print EMPLOYEE into CSV
									$csvText .= ($employee['firstName'].",".$employee['lastName'].",".$employee['dateofbirth'].",".$employee['gender'].",".$employee['department'].",".$employee['hireyear'].",".$employee['status']."\n");
									// CONTACTS LOOP
									$contacts = $this->getEmployeeContacts($employee['ID'],$dateRange);




									for($contactIndex = 0; $contactIndex < count($contacts); $contactIndex++ ){
										if($contacts != null){
											$contacts[$contactIndex] = $this->stripCommas($contacts[$contactIndex]);
											$contacts[$contactIndex]['location'] = $this->getLocation($contacts[$contactIndex]['locid']);
											$contacts[$contactIndex]['location'] = $this->stripCommas($contacts[$contactIndex]['location']);
											// Print CONTACT into CSV
											$csvText .= (",".$contacts[$contactIndex]['dat'].",".$contacts[$contactIndex]['location']['locid'].",".$contacts[$contactIndex]['uname'].",".$contacts[$contactIndex]['contype'].",".$contacts[$contactIndex]['status']."\n");
											// QUERY for CONSULTS
											$consult = $this->getContactConsults($contacts[$contactIndex]['id']);

											if(isset($consult['health'])){
												for($hci = 0; $hci<count($consult['health']); $hci++ ){
													$csvText .= (",,Health Consult,".$consult['health'][$hci]['name'].",".$consult['health'][$hci]['value']."\n");
												}
											}else{ //echo("No Health Consults<br/>");
											}
											if(isset($consult['injury'])){
												for($ici = 0; $ici<count($consult['injury']); $ici++ ){
													$csvText .= (",,Injury Consult,".$consult['injury'][$ici]['name'].",".$consult['injury'][$ici]['value']."\n");
												}
											}else{//echo("No Injury Consults<br/>");
											}
											if(isset($consult['opportunity'])){
												for($oci = 0; $oci<count($consult['opportunity']); $oci++ ){
													$csvText .= (",,Opportunity Consult,".$consult['opportunity'][$oci]['name'].",".$consult['opportunity'][$oci]['value']."\n");
												}
											}else{//echo("No Opportunity Consults<br/>"*);
											}
											if(isset($consult['proactive'])){
												for($oci = 0; $oci<count($consult['proactive']); $oci++ ){
													$csvText .= (",,Proactive Consult,".$consult['proactive'][$oci]['name'].",".$consult['proactive'][$oci]['value']."\n");
												}
											}else{//echo("No Proactive Consults<br/>");
											}
											if(isset($consult['wellness'])){
												for($oci = 0; $oci<count($consult['wellness']); $oci++ ){
													//echo("Wellness Consult :".$consult['wellness'][$oci]['name']."<br/>");
													$csvText .= (",,Wellness Consult,".$consult['wellness'][$oci]['name'].",".$consult['wellness'][$oci]['value']."\n");
												}
											}else{//echo("No Wellness Consults<br/>");
											}
										}else{
											//echo("no contacts on record");
											$csvText .= ",No Contacts,\n";
										}
									}
									$csvText .= "\n";
								}
							}
							else{
								$ret[0] = "0";
							}
						}
					}
				}
			}
			$end = time();
			$csvText .= "\nStart,".$start.',END'.$end;
			$csvReturn =  array ( 'name' => $csvFileName , 'csv' => $csvText , );
			return $csvReturn;
    	}


    	*/
   }

?>