<?php
	include_once "dbclass.php";
	include_once "crhconsultclass.php";
    class dataQuery extends db{
/*
o.OOOo.      Oo    oOoOOoOOo    Oo     .oOOOo.   O       o o.OOoOoo `OooOOo.  o       O        .oOOOo.   o         Oo    .oOOOo.  .oOOOo.  
 O    `o    o  O       o       o  O   .O     o.  o       O  O        o     `o O       o       .O     o  O         o  O   o     o  o     o  
 o      O  O    o      o      O    o  o       O  O       o  o        O      O `o     O'       o         o        O    o  O.       O.       
 O      o oOooOoOo     O     oOooOoOo O       o  o       o  ooOO     o     .O   O   o         o         o       oOooOoOo  `OOoo.   `OOoo.  
 o      O o      O     o     o      O o       O  o       O  O        OOooOO'     `O'          o         O       o      O       `O       `O 
 O      o O      o     O     O      o O    Oo o  O       O  o        o    o       o           O         O       O      o        o        o 
 o    .O' o      O     O     o      O `o     O'  `o     Oo  O        O     O      O           `o     .o o     . o      O O.    .O O.    .O 
 OooOO'   O.     O     o'    O.     O  `OoooO Oo  `OoooO'O ooOooOoO  O      o     O            `OoooO'  OOoOooO O.     O  `oooO'   `oooO'  
  
*/
/*
 _______       ___   .___________.    ___         .______    __    __   __   __       _______   __  .__   __.   _______ 
|       \     /   \  |           |   /   \        |   _  \  |  |  |  | |  | |  |     |       \ |  | |  \ |  |  /  _____|
|  .--.  |   /  ^  \ `---|  |----`  /  ^  \       |  |_)  | |  |  |  | |  | |  |     |  .--.  ||  | |   \|  | |  |  __  
|  |  |  |  /  /_\  \    |  |      /  /_\  \      |   _  <  |  |  |  | |  | |  |     |  |  |  ||  | |  . `  | |  | |_ | 
|  '--'  | /  _____  \   |  |     /  _____  \     |  |_)  | |  `--'  | |  | |  `----.|  '--'  ||  | |  |\   | |  |__| | 
|_______/ /__/     \__\  |__|    /__/     \__\    |______/   \______/  |__| |_______||_______/ |__| |__| \__|  \______|
*/

		public function BuildEmployeeSuperArray($emps,$cons,$HCIDtoCONID=false,$hcdump=false,$hcsoap=false,$ICIDtoCONID=false,$icdump=false,$icsoap=false,$PCIDtoCONID=false,$pcdump=false,$pcsoap=false){
			//health consults
			if($HCIDtoCONID && $hcdump){
				foreach($hcdump as $hc){
					array_push($cons[$HCIDtoCONID[$hc['hcid']]]['hcdump'],$hc);
				}
			}
			if($HCIDtoCONID && $hcsoap){
				foreach($hcsoap as $hc){
					array_push($cons[$HCIDtoCONID[$hc['hcid']]]['hcsoap'],$hc);
				}
			}
			//injury consults
			if($ICIDtoCONID && $icdump){
				foreach($icdump as $ic){
					array_push($cons[$ICIDtoCONID[$ic['icid']]]['icdump'],$ic);
				}
			}
			if($ICIDtoCONID && $icsoap){
				foreach($icsoap as $ic){
					array_push($cons[$ICIDtoCONID[$ic['icid']]]['icsoap'],$ic);
				}
			}
			//proactive consults
			if($PCIDtoCONID && $pcdump){
				foreach($pcdump as $pc){
					array_push($cons[$PCIDtoCONID[$pc['pcid']]]['pcdump'],$pc);
				}
			}
			if($PCIDtoCONID && $pcsoap){
				foreach($pcsoap as $pc){
					array_push($cons[$PCIDtoCONID[$pc['pcid']]]['pcsoap'],$pc);
				}
			}

			foreach ($cons as $con){
				array_push($emps[$con['empid']]['contacts'],$con);
			}
			//should also verify that all contacts are ordered sequentially by date
			return $emps;
			//
		}

		public function BuildEmployeeArray($employeesraw){
			foreach($employeesraw as $ekey => $e){
				$emps[$e['ID']] = array(  //array indexed by EMPID
					'empid' => $e['ID'],
					'fname' => $e['firstName'],
					'lname' => $e['lastName'],
					'dob' => $e['dateofbirth'], 
					'gender' => $e['gender'], 
					'dept' => $e['department'], 
					'hireyear' => $e['hireyear'], 
					'imgpath' => $e['profileimagepath'], 
					'status"' => $e['status'],
					'contacts' => array(), 
				);
			}
			return $emps;
		}

		public function BuildContactArray($contactsraw){
			foreach($contactsraw as $ckey => $c){
				$cons[$c['id']] = array(
					'conid' => $c['id'],
					'clid' => $c['clid'],
					'locid' => $c['locid'],
					'uname' => $c['uname'],
					'empid' => $c['empid'],
					'dat' => $c['dat'],
					'status' => $c['status'],
					'hcdump' => array(),
					'hcsoap' => array(),
					'icdump' => array(),
					'icsoap' => array(),
					'pcdump' => array(),
					'pcsoap' => array(),
				);
			}
			return $cons;
		}

		public function BuildHealthConsultArray($healthmainsraw,$getDumpTable=true,$getSoapTable=true,$dbhandle=false){
			$HCIDtoCONID=false; // indexed by hcid
			foreach($healthmainsraw as $hmrkey => $hmr){
				$HCIDtoCONID[$hmr['id']] = $hmr['conid'];
			}
			if($HCIDtoCONID){
				if($getDumpTable){
					$healthdumpsraw = $this->getHCID_dumps(array_keys($HCIDtoCONID),$dbhandle);
					$hcindex = 0;
					foreach($healthdumpsraw as $hckey => $hc){
						if($hc['value'] != ""){
							if($hc['value'] == "5I0kf0i2kTIZaMRbWtaHwoIZGL_TVuct1_mlJUfIh0k"){ // hardcoded 'no' dramatically improves speed
								$hc['value'] = "no";
							}else{
								$hc['value'] = $this->decode($hc['value']);
							}
						}
						$hcdump[$hcindex] = $hc;
						$hcindex++;
						//echo($hcindex." ".$hc['value']."<br>");
					}
				}//End Dumps
				if($getSoapTable){
					$healthsoapsraw = $this->getHCID_soaps(array_keys($HCIDtoCONID),$dbhandle);
					$hcindex = 0;
					foreach($healthsoapsraw as $hckey => $hc){
						if($hc['value'] != ""){
							$hc['value'] = $this->decode($hc['value']);
						}
						$hcsoap[$hcindex] = $hc;
						$hcindex++;
					}
				}//End Soaps
			}
			$return['HCIDtoCONID'] = $HCIDtoCONID;
			if($getSoapTable){
				$return['soap'] = $hcsoap;
			}
			if($getDumpTable){
				$return['dump'] = $hcdump;
			}
			return $return;
		}

		public function BuildInjuryConsultArray($injurymainsraw,$getDumpTable=true,$getSoapTable=true,$dbhandle=false){
			$ICIDtoCONID=false; // indexed by icid
			foreach($injurymainsraw as $imrkey => $imr){
				$ICIDtoCONID[$imr['id']] = $imr['conid'];
			}
			if($ICIDtoCONID){
				if($getDumpTable){
					$injurydumpsraw = $this->getICID_dumps(array_keys($ICIDtoCONID),$dbhandle);
					$icindex = 0;
					foreach($injurydumpsraw as $ckey => $c){
						$c['value'] = $this->decode($c['value']);
						$icdump[$icindex] = $c;
						$icindex++;	
					}
				}//End Dumps
				if($getSoapTable){
					$injurysoapsraw = $this->getICID_soaps(array_keys($ICIDtoCONID),$dbhandle);
					$icindex = 0;
					foreach($injurysoapsraw as $key => $c){
						$c['value'] = $this->decode($c['value']);
						$icsoap[$icindex] = $c;
						$icindex++;
					}
				}//End Soaps
			}
			$return['ICIDtoCONID'] = $ICIDtoCONID;
			if($getDumpTable){
				$return['dump'] = $icdump;
			}
			if($getSoapTable){
				$return['soap'] = $icsoap;
			}
			return $return;
		}

		public function BuildProactiveConsultArray($proactivemainsraw,$getDumpTable=true,$getSoapTable=true,$dbhandle=false){
			$PCIDtoCONID=false; // indexed by icid
			foreach($proactivemainsraw as $pmrkey => $pmr){
				$PCIDtoCONID[$pmr['id']] = $pmr['conid'];
			}
			if($PCIDtoCONID){
				if($getDumpTable){
					$proactivedumpsraw = $this->getPCID_dumps(array_keys($PCIDtoCONID),$dbhandle);
					$pcindex = 0;
					foreach($proactivedumpsraw as $ckey => $c){
						$c['value'] = $this->decode($c['value']);
						$pcdump[$pcindex] = $c;
						$pcindex++;	
					}
				}//End Dumps
				if($getSoapTable){
					$proactivesoapsraw = $this->getPCID_soaps(array_keys($PCIDtoCONID),$dbhandle);
					$pcindex = 0;
					foreach($proactivesoapsraw as $key => $c){
						$c['value'] = $this->decode($c['value']);
						$pcsoap[$pcindex] = $c;
						$pcindex++;
					}
				}//End Soaps
			}
			if($getDumpTable){
				$return['dump'] = $pcdump;
				$return['PCIDtoCONID'] = $PCIDtoCONID;
			}
			if($getSoapTable){
				$return['soap'] = $pcsoap;
			}
			return $return;
		}



/*

 .oOOOo.   o                                                o        o                                                     OOooOoO                                                 
.O     o  O  o                                             O        O                                o                     o                                 o                     
o         o                    O                           o        o                            O                         O                             O                         
o         O                   oOo                          o        o                           oOo                        oOooO                        oOo                        
o         o  O  .oOo. 'OoOo.   o         .oOoO' 'OoOo. .oOoO        O       .oOo. .oOo  .oOoO'   o   O  .oOo. 'OoOo.       O       O   o  'OoOo. .oOo    o   O  .oOo. 'OoOo. .oOo  
O         O  o  OooO'  o   O   O         O   o   o   O o   O        O       O   o O     O   o    O   o  O   o  o   O       o       o   O   o   O O       O   o  O   o  o   O `Ooo. 
`o     .o o  O  O      O   o   o         o   O   O   o O   o        o     . o   O o     o   O    o   O  o   O  O   o       o       O   o   O   o o       o   O  o   O  O   o     O 
 `OoooO'  Oo o' `OoO'  o   O   `oO       `OoO'o  o   O `OoO'o       OOoOooO `OoO' `OoO' `OoO'o   `oO o' `OoO'  o   O       O'      `OoO'o  o   O `OoO'   `oO o' `OoO'  o   O `OoO' 
 */


////////////////////////////////////////////////////////////////////////
		public function getClientLocations($clid){
			$location = false;
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "clientloc";
					$tableExists = $this->tableExists($tablename);
					if ($tableExists){
						$active = "active";
						$eactive = $this->encode($active);
						$sql = "SELECT `$tablename`.`id`, `$tablename`.`locid` FROM `$this->db`.`$tablename` WHERE `$tablename`.`clid` = '$clid' AND `$tablename`.`status` = '$eactive'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$i = 0;
								while ($resarr = mysql_fetch_assoc($result)){
									$location[$i]['id'] = $resarr['id'];
									$location[$i]['locid'] = $this->decode($resarr['locid']);
									$i++;
								}
							}
						}
					}
				}
			}
			return $location;
		}
		////////////////////////////////////////////////////////////////////////////////////////////////




 /*Employee Functions
o.OOoOoo                 o                               OOooOoO                                                 
 O                      O                                o                                 o                     
 o                      o                                O                             O                         
 ooOO                   O                                oOooO                        oOo                        
 O       `oOOoOO. .oOo. o  .oOo. O   o .oOo. .oOo.       O       O   o  'OoOo. .oOo    o   O  .oOo. 'OoOo. .oOo  
 o        O  o  o O   o O  O   o o   O OooO' OooO'       o       o   O   o   O O       O   o  O   o  o   O `Ooo. 
 O        o  O  O o   O o  o   O O   o O     O           o       O   o   O   o o       o   O  o   O  O   o     O 
ooOooOoO  O  o  o oOoO' Oo `OoO' `OoOO `OoO' `OoO'       O'      `OoO'o  o   O `OoO'   `oO o' `OoO'  o   O `OoO' 
                  O                  o                                                                           
                  o'              OoO'                                                                           
*/
		public function getClientEmployees($clientID,$dateRange,$locations,$dbhandle = false,$tableExists = false){
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
										"locid" => $row['locid'],
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
									"locid" => $row['locid'],
								);
							}
							//$employee[$i] = $this->stripCommas($employee[$i]);
						}
						//Echo("TOTAL EMPLOYEES = ".count($employee)."<br/>" );
						// filter out values by location 
						if($locations['useLocations']){
							$includedEmps = array();
							foreach($employee as $emp){
								if(in_array( $emp['locid'],$locations['ids']) ){
									array_push($includedEmps,$emp);
								}
							}
							$employee = $includedEmps;
							//Echo("TOTAL EMPLOYEES AT SELECTED LOCATIONS= ".count($employee)."<br/>" );
						}

						//
					}
				}
			}
			return $employee;
		}
/*Contact Functions
 .oOOOo.                                              OOooOoO                                                 
.O     o                                              o                                 o                     
o                        O                  O         O                             O                         
o                       oOo                oOo        oOooO                        oOo                        
o         .oOo. 'OoOo.   o   .oOoO' .oOo    o         O       O   o  'OoOo. .oOo    o   O  .oOo. 'OoOo. .oOo  
O         O   o  o   O   O   O   o  O       O         o       o   O   o   O O       O   o  O   o  o   O `Ooo. 
`o     .o o   O  O   o   o   o   O  o       o         o       O   o   O   o o       o   O  o   O  O   o     O 
 `OoooO'  `OoO'  o   O   `oO `OoO'o `OoO'   `oO       O'      `OoO'o  o   O `OoO'   `oO o' `OoO'  o   O `OoO' 
*/
		public function getEmployeesContacts($employeeIDs,$dateRange,$dbhandle=false,$tableExists=false){
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
						if(is_array($employeeIDs)){
							$str = implode(',',$employeeIDs);
						} else{
							$str = $employeeIDs;
						}
						$sql = "SELECT `$tablename`.* FROM `$this->db`.`$tablename` WHERE `$tablename`.`empid` IN (".$str.")";
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
/* Health Consult Functions
o      O               o        o           .oOOOo.                             o             OOooOoO                                                 
O      o              O        O           .O     o                            O              o                                 o                     
o      O              o    O   o           o                                   o    O         O                             O                         
OoOooOOo              O   oOo  O           o                                   O   oOo        oOooO                        oOo                        
o      O .oOo. .oOoO' o    o   OoOo.       o         .oOo. 'OoOo. .oOo  O   o  o    o         O       O   o  'OoOo. .oOo    o   O  .oOo. 'OoOo. .oOo  
O      o OooO' O   o  O    O   o   o       O         O   o  o   O `Ooo. o   O  O    O         o       o   O   o   O O       O   o  O   o  o   O `Ooo. 
o      o O     o   O  o    o   o   O       `o     .o o   O  O   o     O O   o  o    o         o       O   o   O   o o       o   O  o   O  O   o     O 
o      O `OoO' `OoO'o Oo   `oO O   o        `OoooO'  `OoO'  o   O `OoO' `OoO'o Oo   `oO       O'      `OoO'o  o   O `OoO'   `oO o' `OoO'  o   O `OoO' 
*/
	// deprecated
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
		//Return all HCIDs for all the CONIDs in the provided array
		public function getContacts_HCIDs($contactIDs,$dbhandle = false){ // takes an array of contact IDs
			if($dbhandle == false){
				$dbhandle = $this->dbhandleSQLI();
			}
			$hcid = false;
			if ($this->dbfound()){
				$tablename = "hcmain";
				if ($this->tableExists($tablename)){
					// Get ID numbers for Consults
					if(is_array($contactIDs)){
						$str = implode(',',$contactIDs);
					} else{
						$str = $contactIDs; 
					}

					$sql = "SELECT `$tablename`.* FROM `$this->db`.`$tablename` WHERE `$tablename`.`conid` IN (".$str.")";
					//echo"<br>".$sql;
					$result = mysqli_query($dbhandle, $sql);
					if ($result){
						if (mysqli_num_rows($result) > 0){
							for ( $i = 0; $i < mysqli_num_rows($result); $i++ ){ 
								$row = mysqli_fetch_assoc($result);
								$hcid[$i]=$row;
								//$id = $healthConsult[$i]['id'];
							}
						}
					}
				}
			}
			return $hcid;
		}
		// Return all records for the provided HCIDs in the HCDUMP table
		public function getHCID_dumps($hcIDs,$dbhandle = false){
			if($dbhandle == false){
				$dbhandle = $this->dbhandleSQLI();
			}
			$hcid = false;
			if ($this->dbfound()){
				$tablename = "hcdump";
				if ($this->tableExists($tablename)){
					// Get ID numbers for Consults
					if(is_array($hcIDs)){
						$str = implode(',',$hcIDs);
					} else{
						$str = $hcIDs; 
					}
					$sql = "SELECT `$tablename`.* FROM `$this->db`.`$tablename` WHERE `$tablename`.`hcid` IN (".$str.")";
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
		// Return all records for the provided HCIDs in the HCSOAP table
		public function getHCID_soaps($hcIDs,$dbhandle = false){
			if($dbhandle == false){
				$dbhandle = $this->dbhandleSQLI();
			}
			$hcid = false;
			if ($this->dbfound()){
				$tablename = "hcsoap";
				if ($this->tableExists($tablename)){
					// Get ID numbers for Consultsj
					if(is_array($hcIDs)){
						$str = implode(',',$hcIDs);
					} else{
						$str = $hcIDs; 
					}
					$sql = "SELECT `$tablename`.* FROM `$this->db`.`$tablename` WHERE `$tablename`.`hcid` IN (".$str.")";
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
/* Proactive Consult Functions
OooOOo.                                                         .oOOOo.                             o             OOooOoO                                                 
O     `O                                 o                     .O     o                            O              o                                 o                     
o      O                             O                         o                                   o    O         O                             O                         
O     .o                            oOo                        o                                   O   oOo        oOooO                        oOo                        
oOooOO'  `OoOo. .oOo. .oOoO' .oOo    o   O  `o   O .oOo.       o         .oOo. 'OoOo. .oOo  O   o  o    o         O       O   o  'OoOo. .oOo    o   O  .oOo. 'OoOo. .oOo  
o         o     O   o O   o  O       O   o   O   o OooO'       O         O   o  o   O `Ooo. o   O  O    O         o       o   O   o   O O       O   o  O   o  o   O `Ooo. 
O         O     o   O o   O  o       o   O   o  O  O           `o     .o o   O  O   o     O O   o  o    o         o       O   o   O   o o       o   O  o   O  O   o     O 
o'        o     `OoO' `OoO'o `OoO'   `oO o'  `o'   `OoO'        `OoooO'  `OoO'  o   O `OoO' `OoO'o Oo   `oO       O'      `OoO'o  o   O `OoO'   `oO o' `OoO'  o   O `OoO' 
*/



		//Return all PCIDs for all the CONIDs in the provided array
		public function getContacts_PCIDs($contactIDs,$dbhandle = false){ // takes an array of contact IDs
			if($dbhandle == false){
				$dbhandle = $this->dbhandleSQLI();
			}
			$pcid = false;
			if ($this->dbfound()){
				$tablename = "pcmain";
				if ($this->tableExists($tablename)){
					// Get ID numbers for Consults
					if(is_array($contactIDs)){
						$str = implode(',',$contactIDs);
					} else{
						$str = $contactIDs; 
					}

					$sql = "SELECT `$tablename`.* FROM `$this->db`.`$tablename` WHERE `$tablename`.`conid` IN (".$str.")";
					//echo"<br>".$sql;
					$result = mysqli_query($dbhandle, $sql);
					if ($result){
						if (mysqli_num_rows($result) > 0){
							for ( $i = 0; $i < mysqli_num_rows($result); $i++ ){ 
								$row = mysqli_fetch_assoc($result);
								$pcid[$i]=$row;
							}
						}
					}
				}
			}
			return $pcid;
		}

		// Return all records for the provided HCIDs in the HCDUMP table
		public function getPCID_dumps($xcIDs,$dbhandle = false){
			if($dbhandle == false){
				$dbhandle = $this->dbhandleSQLI();
			}
			$xcid = false;
			if ($this->dbfound()){
				$tablename = "pcdump";
				if ($this->tableExists($tablename)){
					// Get ID numbers for Consults
					if(is_array($xcIDs)){
						$str = implode(',',$xcIDs);
					} else{
						$str = $xcIDs; 
					}
					$sql = "SELECT `$tablename`.* FROM `$this->db`.`$tablename` WHERE `$tablename`.`pcid` IN (".$str.")";
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
		// Return all records for the provided HCIDs in the HCSOAP table
		public function getPCID_soaps($xcIDs,$dbhandle = false){
			if($dbhandle == false){
				$dbhandle = $this->dbhandleSQLI();
			}
			$xcid = false;
			if ($this->dbfound()){
				$tablename = "pcsoap";
				if ($this->tableExists($tablename)){
					// Get ID numbers for Consultsj
					if(is_array($xcIDs)){
						$str = implode(',',$xcIDs);
					} else{
						$str = $xcIDs; 
					}
					$sql = "SELECT `$tablename`.* FROM `$this->db`.`$tablename` WHERE `$tablename`.`pcid` IN (".$str.")";
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

/* Opportunity Consult Functions
 .oOOOo.                                                                     .oOOOo.                             o             OOooOoO                                                 
.O     o.                                              o                    .O     o                            O              o                                 o                     
O       o                            O                      O               o                                   o    O         O                             O                         
o       O                           oOo                    oOo              o                                   O   oOo        oOooO                        oOo                        
O       o .oOo. .oOo. .oOo. `OoOo.   o   O   o  'OoOo. O    o   O   o       o         .oOo. 'OoOo. .oOo  O   o  o    o         O       O   o  'OoOo. .oOo    o   O  .oOo. 'OoOo. .oOo  
o       O O   o O   o O   o  o       O   o   O   o   O o    O   o   O       O         O   o  o   O `Ooo. o   O  O    O         o       o   O   o   O O       O   o  O   o  o   O `Ooo. 
`o     O' o   O o   O o   O  O       o   O   o   O   o O    o   O   o       `o     .o o   O  O   o     O O   o  o    o         o       O   o   O   o o       o   O  o   O  O   o     O 
 `OoooO'  oOoO' oOoO' `OoO'  o       `oO `OoO'o  o   O o'   `oO `OoOO        `OoooO'  `OoO'  o   O `OoO' `OoO'o Oo   `oO       O'      `OoO'o  o   O `OoO'   `oO o' `OoO'  o   O `OoO' 
          O     O                                                   o                                                                                                                  
          o'    o'                                               OoO'                                                                                                                  
*/
/* Injury Consult Functions
ooOoOOo                                       .oOOOo.                             o             OOooOoO                                                 
   O             O                           .O     o                            O              o                                 o                     
   o                                         o                                   o    O         O                             O                         
   O                                         o                                   O   oOo        oOooO                        oOo                        
   o    'OoOo.  'o O   o  `OoOo. O   o       o         .oOo. 'OoOo. .oOo  O   o  o    o         O       O   o  'OoOo. .oOo    o   O  .oOo. 'OoOo. .oOo  
   O     o   O   O o   O   o     o   O       O         O   o  o   O `Ooo. o   O  O    O         o       o   O   o   O O       O   o  O   o  o   O `Ooo. 
   O     O   o   o O   o   O     O   o       `o     .o o   O  O   o     O O   o  o    o         o       O   o   O   o o       o   O  o   O  O   o     O 
ooOOoOo  o   O   O `OoO'o  o     `OoOO        `OoooO'  `OoO'  o   O `OoO' `OoO'o Oo   `oO       O'      `OoO'o  o   O `OoO'   `oO o' `OoO'  o   O `OoO' 
                 o                   o                                                                                                                  
               oO'                OoO'                                                                                                                  
*/
               //Return all ICIDs for all the CONIDs in the provided array
		public function getContacts_ICIDs($contactIDs,$dbhandle = false){ // takes an array of contact IDs
			if($dbhandle == false){
				$dbhandle = $this->dbhandleSQLI();
			}
			$icid = false;
			if ($this->dbfound()){
				$tablename = "icmain";
				if ($this->tableExists($tablename)){
					// Get ID numbers for Consults
					if(is_array($contactIDs)){
						$str = implode(',',$contactIDs);
					} else{
						$str = $contactIDs; 
					}

					$sql = "SELECT `$tablename`.* FROM `$this->db`.`$tablename` WHERE `$tablename`.`conid` IN (".$str.")";
					//echo"<br>".$sql;
					$result = mysqli_query($dbhandle, $sql);
					if ($result){
						if (mysqli_num_rows($result) > 0){
							for ( $i = 0; $i < mysqli_num_rows($result); $i++ ){ 
								$row = mysqli_fetch_assoc($result);
								$icid[$i]=$row;
								//$id = $healthConsult[$i]['id'];
							}
						}
					}
				}
			}
			return $icid;
		}
		// Return all records for the provided ICIDs in the ICDUMP table
		public function getICID_dumps($icIDs,$dbhandle = false){
			if($dbhandle == false){
				$dbhandle = $this->dbhandleSQLI();
			}
			$icid = false;
			if ($this->dbfound()){
				$tablename = "icdump";
				if ($this->tableExists($tablename)){
					// Get ID numbers for Consults
					if(is_array($icIDs)){
						$str = implode(',',$icIDs);
					} else{
						$str = $icIDs; 
					}
					$sql = "SELECT `$tablename`.* FROM `$this->db`.`$tablename` WHERE `$tablename`.`icid` IN (".$str.")";
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
		// Return all records for the provided ICIDs in the HCSOAP table
		public function getICID_soaps($icIDs,$dbhandle = false){
			if($dbhandle == false){
				$dbhandle = $this->dbhandleSQLI();
			}
			$icid = false;
			if ($this->dbfound()){
				$tablename = "icsoap";
				if ($this->tableExists($tablename)){
					// Get ID numbers for Consults
					if(is_array($icIDs)){
						$str = implode(',',$icIDs);
					} else{
						$str = $icIDs; 
					}
					$sql = "SELECT `$tablename`.* FROM `$this->db`.`$tablename` WHERE `$tablename`.`icid` IN (".$str.")";
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
/* Wellness Consult Functions
o          `O        o  o                                 .oOOOo.                             o             OOooOoO                                                 
O           o       O  O                                 .O     o                            O              o                                 o                     
o           O       o  o                                 o                                   o    O         O                             O                         
O           O       O  O                                 o                                   O   oOo        oOooO                        oOo                        
o     o     o .oOo. o  o  'OoOo. .oOo. .oOo  .oOo        o         .oOo. 'OoOo. .oOo  O   o  o    o         O       O   o  'OoOo. .oOo    o   O  .oOo. 'OoOo. .oOo  
O     O     O OooO' O  O   o   O OooO' `Ooo. `Ooo.       O         O   o  o   O `Ooo. o   O  O    O         o       o   O   o   O O       O   o  O   o  o   O `Ooo. 
`o   O o   O' O     o  o   O   o O         O     O       `o     .o o   O  O   o     O O   o  o    o         o       O   o   O   o o       o   O  o   O  O   o     O 
 `OoO' `OoO'  `OoO' Oo Oo  o   O `OoO' `OoO' `OoO'        `OoooO'  `OoO'  o   O `OoO' `OoO'o Oo   `oO       O'      `OoO'o  o   O `OoO'   `oO o' `OoO'  o   O `OoO' 

*/






 
//////////////////////
 //////////////////////
 ///
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
	}
?>
