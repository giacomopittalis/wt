<?php
	include "dbclass.php";
       include "matt.php";
    class editemp extends db{
    	
		public function cleaninput($input){
			$ret = "";
			$q = ENT_NOQUOTES;
			
			$ret = trim($input);
			$ret = htmlspecialchars($ret, $q);
			
			return $ret;
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
					print "<select name=\"lid\" id=\"sel2\" tabindex=\"2\" onchange=\"getemp();\">";
						print "<option value =\"0\">Select Location</option>";
						foreach ($res as $value){
							print "<option value=\"".$value['id']."\">".$value['locid']."</option>";
						}
					print "</select>";
				}
			}
		}
		
		

		public function getcuremplist($clid, $locid){
			$ret = array();
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "employee";
					$tex = $this->tex($tablename);
					if ($tex){
						$active = "active";
						$eactive = $this->encode($active);
						$sql = "SELECT `$tablename`.`id`, `$tablename`.`dept`, `$tablename`.`desg`, `$tablename`.`fname`, `$tablename`.`mname`, `$tablename`.`lname` FROM `$this->db`.`$tablename` WHERE `$tablename`.`clid` = '$clid' AND `$tablename`.`locid` = '$locid' AND `$tablename`.`status` = '$eactive'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$i = 0;
								while ($resarr = mysql_fetch_assoc($result)){
									$ret[$i]['id'] = $resarr['id'];
									$ret[$i]['caption'] = $this->decode($resarr['lname']).", ".$this->decode($resarr['fname'])." ".$this->decode($resarr['mname'])." - ".$this->decode($resarr['dept'])." - ".$this->decode($resarr['desg']);
									$i++;
								}
							}
						}
					}
				}
			}
		 $ret = array_sort($ret, 'caption', SORT_ASC);
               return $ret; 	
                 
		}
		
		public function printcuremplist($clid, $locid){
			$res = $this->getcuremplist($clid, $locid);
			
			if (empty($res)){
				print "<select name=\"emp\" id=\"sel10\" tabindex=\"3\" >";
					print "<option value =\"0\">Select Employee</option>";
				print "</select>";
			}
			else{
				print "<select name=\"emp\" id=\"sel10\" tabindex=\"3\" >";
					print "<option value =\"0\">Select Employee</option>";
					foreach ($res as $value){
						print "<option value=\"".$value['value']."\">".$value['caption']."</option>";
					}
				print "</select>";
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
		
		public function vemp($emp){
			$ret = "";
			if ($emp == "0"){
				$ret = "Please Select Employee";
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
		
		public function vdob($dob){
			$ret = "";
			if ($dob == ""){
				$ret = "DOB cannot be empty";
			}
			else{
				$format = "m/d/Y";
				$date = date_parse_from_format($format, $dob);
				if (!empty($date['warnings'])){
					$ret = "Please enter a valid DOB";
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
		
		public function editemp1($empid, $fname, $mname, $lname, $dob, $sex, $dept, $pos, $desg, $htype, $hyear, $hplan){
			
			$ret = FALSE;
			
			$clid = $this->injcheck($empid);
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
			$hplan = $this->injcheck($hplan);
			
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
			$hplan = $this->encode($hplan);
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "employee";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "UPDATE `$this->db`.`$tablename` SET 
							`$tablename`.`fname` = '$fname', 
							`$tablename`.`mname` = '$mname', 
							`$tablename`.`lname` = '$lname', 
							`$tablename`.`dob` = '$dob', 
							`$tablename`.`gender` = '$sex', 
							`$tablename`.`dept` = '$dept',
							`$tablename`.`pos` = '$pos', 
							`$tablename`.`desg` = '$desg', 
							`$tablename`.`type` = '$htype', 
							`$tablename`.`hyear` = '$hyear', 
							`$tablename`.`hplan` = '$hplan' WHERE `$tablename`.`id` = '$empid'
						";
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
		
		public function getjsonarr($empid){
			$retarr = array();
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "employee";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT * FROM `$this->db`.`$tablename` WHERE `$tablename`.`id` = '$empid'";
						$result = mysql_query($sql,$dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$resarr = mysql_fetch_assoc($result);
								$retarr[0]['field'] = "fname";
								if (!$resarr['fname']){
									$retarr[0]['value'] = "";
								}
								else{
									$retarr[0]['value'] = $this->decode($resarr['fname']);
								}
								$retarr[1]['field'] = "mname";
								if (!$resarr['mname']){
									$retarr[1]['value'] = "";
								}
								else{
									$retarr[1]['value'] = $this->decode($resarr['mname']);
								}
								$retarr[2]['field'] = "lname";
								if (!$resarr['lname']){
									$retarr[2]['value'] = "";
								}
								else{
									$retarr[2]['value'] = $this->decode($resarr['lname']);
								}
								$retarr[3]['field'] = "dob";
								if (!$resarr['dob']){
									$retarr[3]['value'] = "";
								}
								else{
									$retarr[3]['value'] = $this->decode($resarr['dob']);
								}
								$retarr[4]['field'] = "sex";
								if (!$resarr['gender']){
									$retarr[4]['value'] = "0";
								}
								else{
									$retarr[4]['value'] = $this->decode($resarr['gender']);
								}
								$retarr[5]['field'] = "dept";
								if (!$resarr['dept']){
									$retarr[5]['value'] = "";
								}
								else{
									$retarr[5]['value'] = $this->decode($resarr['dept']);
								}
								$retarr[6]['field'] = "pos";
								if (!$resarr['pos']){
									$retarr[6]['value'] = "";
								}
								else{
									$retarr[6]['value'] = $this->decode($resarr['pos']);
								}
								$retarr[7]['field'] = "desg";
								if (!$resarr['desg']){
									$retarr[7]['value'] = "";
								}
								else{
									$retarr[7]['value'] = $this->decode($resarr['desg']);
								}
								$retarr[8]['field'] = "htype";
								if (!$resarr['type']){
									$retarr[8]['value'] = "";
								}
								else{
									$retarr[8]['value'] = $this->decode($resarr['type']);
								}
								$retarr[9]['field'] = "hyear";
								if (!$resarr['hyear']){
									$retarr[9]['value'] = "0";
								}
								else{
									$retarr[9]['value'] = $this->decode($resarr['hyear']);
								}
								$retarr[10]['field'] = "hplan";
								if (!$resarr['hplan']){
									$retarr[10]['value'] = "";
								}
								else{
									$retarr[10]['value'] = $this->decode($resarr['hplan']);
								}
							}
						}
					}
				}
			}
			return $retarr;
		}
		
    }
?>