<?php
	include "dbclass.php";
    class conperemp extends db{
    	
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
			
			print "<select name=\"year\" id=\"sel6\">";
				print "<option value=\"0\">All</option>";
				for ($i = $syear; $i <= $xyear; $i++){
					print "<option value=\"".$i."\">".$i."</option>";
				}
				print "<option value=\"".$cyear."\" selected=\"selected\">".$cyear."</option>";
			print "</select>";
			
			return $cyear;
		}
		
		public function printmonth(){
			$montharr = array();
			
			$montharr[0]['name'] = "All";
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
			
			print "<select name=\"month\" id=\"sel7\">";
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
					print "<option value =\"0\">All Clients</option>";
				print "</select>";
			}
			else{
				print "<select name=\"lc\" id=\"sel1\" tabindex=\"1\" onChange = \"getloc();\">";
					print "<option value =\"0\">All Clients</option>";
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
					print "<option value =\"0\">All Locations</option>";
				print "</select>";
			}
			else{
				$res = $this->getcurloclist($clid);
				if (empty($res)){
					print "<select name=\"lid\" id=\"sel2\" tabindex=\"2\" >";
						print "<option value =\"0\">All Locations</option>";
					print "</select>";
				}
				else{
					print "<select name=\"lid\" id=\"sel2\" tabindex=\"2\" >";
						print "<option value =\"0\">All Locations</option>";
						foreach ($res as $value){
							print "<option value=\"".$value['id']."\">".$value['locid']."</option>";
						}
					print "</select>";
				}
			}
		}
		
		public function printarl(){
			print "<select name=\"arl\" id=\"sel4\" tabindex=\"4\" >";
				print "<option value =\"0\">All</option>";
				for ($i = 16; $i <= 100; $i++){
					print "<option value =\"".$i."\">".$i."</option>";
				}
			print "</select>";
		}
		
		public function printarh(){
			print "<select name=\"arh\" id=\"sel5\" tabindex=\"4\" >";
				print "<option value =\"0\">All</option>";
				for ($i = 16; $i <= 100; $i++){
					print "<option value =\"".$i."\">".$i."</option>";
				}
			print "</select>";
		}
		
		public function vclid($clid){
			$ret = "";
			if ($clid == "0"){
				$ret = "Please Select Client";
			}
			return $ret;
		}
		
		public function getempconnumbers($clid, $locid, $sex, $arl, $arh, $year, $month){
			$ret = array();
			
			$zero = 0;
			$one = 0;
			$two = 0;
			$three = 0;
			$four = 0;
			$five = 0;
			$more = 0;
			
			$empconcountarr = $this->getempconcountarr($clid, $locid, $sex, $arl, $arh, $year, $month);
			
			foreach ($empconcountarr as $value){
				if ($value['concount'] == 0){
					$zero++;
				}
				elseif ($value['concount'] == 1){
					$one++;
				}
				elseif ($value['concount'] == 2){
					$two++;
				}
				elseif ($value['concount'] == 3){
					$three++;
				}
				elseif ($value['concount'] == 4){
					$four++;
				}
				elseif ($value['concount'] == 5){
					$five++;
				}
				elseif ($value['concount'] > 5){
					$more++;
				}
			}
			$ret = array($zero, $one, $two, $three, $four, $five, $more);
			
			return $ret;
		}
		
		public function getempconcountarr($clid, $locid, $sex, $arl, $arh, $year, $month){
			$ret = array();
			
			$empconarr = $this->getempconarr($clid, $locid, $sex, $arl, $arh, $year, $month);
			
			$i = 0;
			foreach ($empconarr as $value){
				$ret[$i]['empid'] = $value['empid'];
				$ret[$i]['concount'] = count($value['conidarr']);
				$i++;
			}
			return $ret;
		}
		
		public function getempconarr($clid, $locid, $sex, $arl, $arh, $year, $month){
			$ret = array();
			
			$emp = $this->filteremp($clid, $locid, $sex, $arl, $arh);
			
			$i = 0;
			foreach ($emp as $value){
				$ret[$i]['empid'] = $value;
				$ret[$i]['conidarr'] = $this->getempcon($value, $year, $month);
				$i++;
			}
			
			return $ret;
		}
		
		public function getempcon($empid, $year, $month){
			$ret = array();
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename  = "contact";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT * FROM `$this->db`.`$tablename`";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$i = 0;
								$tablename2 = "employee";
								while ($resarr = mysql_fetch_assoc($result)){
									$conid = $resarr['id'];
									$ymcheck = $this->checkconyearmon($conid, $year, $month);
									if ($ymcheck){
										if ($empid == $resarr['empid']){
											$ret[$i] = $conid;
											$i++;
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
		
		public function checkconyearmon($conid, $year, $month){
			$ret = FALSE;
			
			$yearr = $this->checkconyear($conid, $year);
			$monthh = $this->checkconmon($conid, $month);
			
			if ($yearr && $monthh){
				$ret = TRUE;
			}
			
			return $ret;
		}
		
		public function checkconyear($conid, $year){
			$ret = FALSE;
			
			if ($year == "0"){
				$ret = TRUE;
			}
			else{
				$yearr = $this->getyr($conid);
				if ($yearr == $year){
					$ret = TRUE;
				}
			}
			return $ret;
		}
		
		public function checkconmon($conid, $month){
			$ret = FALSE;
			
			if ($month == "0"){
				$ret = TRUE;
			}
			else{
				$monthh = $this->getmon($conid);
				if ($monthh == $month){
					$ret = TRUE;
				}
			}
			return $ret;
		}
		
		public function filteremp($clid, $locid, $sex, $arl, $arh){
			$emp = array();
			$emp = $this->getallemp();
			
			if ($clid != "0"){
				$emp = $this->filterclid($emp, $clid);
			}
			
			if ($locid != "0"){
				$emp = $this->filterlocid($emp, $locid);
			}
			
			if ($sex != "0"){
				$emp = $this->filtersex($emp, $sex);
			}
			
			if ($arl != "0"){
				$emp = $this->filterarl($emp, $arl);
			}
			
			if ($arh != "0"){
				$emp = $this->filterarh($emp, $arh);
			}
			
			return $emp;
		}
		
		public function getallemp(){
			$ret = array();
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename  = "employee";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT `$tablename`.`id` FROM `$this->db`.`$tablename`";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$i = 0;
								while ($resarr = mysql_fetch_assoc($result)){
									$ret[$i] = $resarr['id'];
									$i++;
								}
							}
						}
					}
				}
			}
			return $ret;
		}
		
		public function filterclid($emp, $clid){
			foreach ($emp as $key => $value){
				$clidd = $this->getclid($value);
				if ($clidd != $clid){
					unset($emp[$key]);
				}
			}
			return $emp;
		}
		
		public function filterlocid($emp, $locid){
			foreach ($emp as $key => $value){
				$locidd = $this->getlocid($value);
				if ($locidd != $locid){
					unset($emp[$key]);
				}
			}
			return $emp;
		}
		
		public function filtersex($emp, $sex){
			foreach ($emp as $key => $value){
				$sexx = $this->getsex($value);
				if ($sexx != $sex){
					unset($emp[$key]);
				}
			}
			return $emp;
		}
		
		public function filterarl($emp, $arl){
			foreach ($emp as $key => $value){
				$age = $this->getage($value);
				if ($age < $arl){
					unset($emp[$key]);
				}
			}
			return $emp;
		}
		
		public function filterarh($emp, $arh){
			foreach ($emp as $key => $value){
				$age = $this->getage($value);
				if ($age > $arh){
					unset($emp[$key]);
				}
			}
			return $emp;
		}
		
		public function getclid($empid){
			$ret = "";
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename  = "employee";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT `$tablename`.`clid` FROM `$this->db`.`$tablename` WHERE `$tablename`.`id` = '$empid'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$i = 0;
								$resarr = mysql_fetch_assoc($result);
									$ret = $resarr['clid'];
									$i++;
							}
						}
					}
				}
			}
			return $ret;
		}
		
		public function getlocid($empid){
			$ret = "";
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename  = "employee";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT `$tablename`.`locid` FROM `$this->db`.`$tablename` WHERE `$tablename`.`id` = '$empid'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$i = 0;
								$resarr = mysql_fetch_assoc($result);
									$ret = $resarr['locid'];
									$i++;
							}
						}
					}
				}
			}
			return $ret;
		}
		
		public function getsex($empid){
			$ret = "";
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename  = "employee";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT `$tablename`.`gender` FROM `$this->db`.`$tablename` WHERE `$tablename`.`id` = '$empid'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$i = 0;
								$resarr = mysql_fetch_assoc($result);
									$ret = $resarr['gender'];
									$i++;
							}
						}
					}
				}
			}
			return $ret;
		}
		
		public function getdob($empid){
			$ret = "";
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename  = "employee";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT `$tablename`.`dob` FROM `$this->db`.`$tablename` WHERE `$tablename`.`id` = '$empid'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$i = 0;
								$resarr = mysql_fetch_assoc($result);
									$ret = $resarr['dob'];
									$i++;
							}
						}
					}
				}
			}
			return $ret;
		}
		
		public function getage($empid){
			$dob = $this->getdob($empid);
			$dobarr = explode("/", $dob);
			$age = (date("md", date("U", mktime(0, 0, 0, $dobarr[0], $dobarr[1], $dobarr[2]))) > date("md") ? ((date("Y")-$dobarr[2])-1):(date("Y")-$dobarr[2]));
			return $age;
		}
		
		public function getyr($conid){
			$ret = "";
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename  = "contact";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT `$tablename`.`dat` FROM `$this->db`.`$tablename` WHERE `$tablename`.`id` = '$conid'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$resarr = mysql_fetch_assoc($result);
								$dat = $this->decode($resarr['dat']);
								$datarr = explode("/", $dat);
								$ret = $datarr[2];
							}
						}
					}
				}
			}
			return $ret;
		}
		
		public function getmon($conid){
			$ret = "";
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename  = "contact";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT `$tablename`.`dat` FROM `$this->db`.`$tablename` WHERE `$tablename`.`id` = '$conid'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$resarr = mysql_fetch_assoc($result);
								$dat = $this->decode($resarr['dat']);
								$datarr = explode("/", $dat);
								$ret = $datarr[0];
							}
						}
					}
				}
			}
			return $ret;
		}
		
		public function filteryear($con, $year){
			foreach ($con as $key => $value){
				$yearr = $this->getyr($value['conid']);
				$year = (int)$year;
				$yearr = (int)$yearr;
				if ($yearr != $year){
					unset($con[$key]);
				}
			}
			return $con;
		}
		
		public function filtermonth($con, $month){
			foreach ($con as $key => $value){
				$monthh = $this->getmon($value['conid']);
				$month = (int)$month;
				$monthh = (int)$monthh;
				if ($monthh != $month){
					unset($con[$key]);
				}
			}
			return $con;
		}
		
		public function getcaption($clid, $locid, $sex, $arl, $arh, $year, $month){
			$ret = array();
			
			if ($clid == "0"){
				$ret['Client'] = "All Clients";
			}
			else{
				$ret['Client'] = $this->getclname($clid);
			}
			
			if ($locid == "0"){
				$ret['Location'] = "All Locations";
			}
			else{
				$ret['Location'] = $this->getlocname($locid);
			}
			
			if ($sex == "0"){
				$ret['Gender'] = "All Genders";
			}
			else{
				$ret['Gender'] = $this->getsexname($sex);
			}
			
			if ($arl == "0"){
				$ret['Lower Age Limit'] = "No Lower Age Limit";
			}
			else{
				$ret['Lower Age Limit'] = $arl;
			}
			
			if ($arh == "0"){
				$ret['Upper Age Limit'] = "No Upper Age Limit";
			}
			else{
				$ret['Upper Age Limit'] = $arh;
			}
			
			if ($month == "0"){
				$ret['Month'] = "All Months";
			}
			else{
				$ret['Month'] = $month;
			}
			
			if ($year == "0"){
				$ret['Year'] = "All Years";
			}
			else{
				$ret['Year'] = $year;
			}
			
			return $ret;
		}
		
		public function getclname($clid){
			$ret = "";
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename  = "client";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT `$tablename`.`clname` FROM `$this->db`.`$tablename` WHERE `$tablename`.`id` = '$clid'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$resarr = mysql_fetch_assoc($result);
								$ret = $this->decode($resarr['clname']);
							}
						}
					}
				}
			}
			return $ret;
		}
		
		public function getlocname($locid){
			$ret = "";
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename  = "clientloc";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT `$tablename`.`locid` FROM `$this->db`.`$tablename` WHERE `$tablename`.`id` = '$locid'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$resarr = mysql_fetch_assoc($result);
								$ret = $this->decode($resarr['locid']);
							}
						}
					}
				}
			}
			return $ret;
		}
		
		public function getsexname($sex){
			$ret = "";
			
			if ($sex == "male"){
				$ret = "Male";
			}
			elseif ($sex == "female"){
				$ret = "Female";
			}
			elseif ($sex == "neuter"){
				$ret = "Neuter";
			}
			return $ret;
		}
		
		public function randcolor() {
    		return sprintf('%06X', mt_rand(0, 0xFFFFFF));
		}
		
		public function randcolorarr($clid){
			$ret = array();
			$count = count($clid);
			for ($i = 0; $i <= ($count - 1); $i++){
				$ret[$i] = $this->randcolor();
			}
			return $ret;
		}
 
	}
?>