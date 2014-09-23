<?php
	include 'dbclass.php';
	
function array_sort($array, $on, $order=SORT_ASC)
{
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
            break;
            case SORT_DESC:
                arsort($sortable_array);
            break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}

class crcon extends db{
		
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
			
			print "<select name=\"year\" id=\"sel8\" onchange=\"daysl();\">";
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
			
			if (isset($_SESSION['client']) && $_SESSION['client'] != "" && $_SESSION['client'] != "0"){
				$sel = $_SESSION['client'];
			}
			else{
				$sel = "0";
			}
			
			if (empty($res)){
				print "<select name=\"lc\" id=\"sel1\" tabindex=\"1\" >";
					print "<option value =\"0\">Select Client</option>";
				print "</select>";
			}
			elseif ($sel == "0"){
				print "<select name=\"lc\" id=\"sel1\" tabindex=\"1\" onChange = \"getloc();\">";
					print "<option value =\"0\">Select Client</option>";
					foreach ($res as $value){
						print "<option value=\"".$value['clid']."\">".$value['clname']."</option>";
					}
				print "</select>";
			}
			else{
				print "<select name=\"lc\" id=\"sel1\" tabindex=\"1\" onChange = \"getloc();\">";
					print "<option value =\"0\">Select Client</option>";
					foreach ($res as $value){
						if ($value['clid'] != $sel){
							print "<option value=\"".$value['clid']."\">".$value['clname']."</option>";
						}
						else{
							print "<option value=\"".$value['clid']."\" selected=\"selected\">".$value['clname']."</option>";
						}
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
		
		public function printinitloclist(){
			if (isset($_SESSION['location']) && $_SESSION['location'] != "" && $_SESSION['location'] != "0"){
				$sel = $_SESSION['location'];
			}
			else{
				$sel = "0";
			}
			
			if (isset($_SESSION['client']) && $_SESSION['client'] != "" && $_SESSION['client'] != "0"){
				$clid = $_SESSION['client'];
			}
			else{
				$clid = "0";
			}
			
			if ($clid == "0"){
				print "<select name=\"lid\" id=\"sel2\" tabindex=\"2\" onChange = \"getemp();\">";
					print "<option value =\"0\">Select Location</option>";
				print "</select>";
			}
			else{
				$res = $this->getcurloclist($clid);
				if (empty($res)){
					print "<select name=\"lid\" id=\"sel2\" tabindex=\"2\" onChange = \"getemp();\">";
						print "<option value =\"0\">Select Location</option>";
					print "</select>";
				}
				else{
					if ($sel == "0"){
						print "<select name=\"lid\" id=\"sel2\" tabindex=\"2\" onChange = \"getemp();\">";
							print "<option value =\"0\">Select Location</option>";
							foreach ($res as $value){
								print "<option value=\"".$value['id']."\">".$value['locid']."</option>";
							}
						print "</select>";
					}
					else{
						print "<select name=\"lid\" id=\"sel2\" tabindex=\"2\" onChange = \"getemp();\">";
							print "<option value =\"0\">Select Location</option>";
							foreach ($res as $value){
								if ($value['id'] != $sel){
									print "<option value=\"".$value['id']."\">".$value['locid']."</option>";
								}
								else{
									print "<option value=\"".$value['id']."\" selected=\"selected\">".$value['locid']."</option>";
								}
							}
						print "</select>";
					}
				}
			}
		}
		
		public function printcurloclist($clid){
			
			if ($clid == "0"){
				print "<select name=\"lid\" id=\"sel2\" tabindex=\"2\" onChange = \"getemp();\">";
					print "<option value =\"0\">Select Location</option>";
				print "</select>";
			}
			else{
				$res = $this->getcurloclist($clid);
				if (empty($res)){
					print "<select name=\"lid\" id=\"sel2\" tabindex=\"2\" onChange = \"getemp();\">";
						print "<option value =\"0\">Select Location</option>";
					print "</select>";
				}
				else{
					print "<select name=\"lid\" id=\"sel2\" tabindex=\"2\" onChange = \"getemp();\">";
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

		public function printcuremplist($clid, $locid, $bulk){
			
			if ($clid == "0" || $locid == "0"){
				print "<select name=\"empid\" id=\"sel3\" tabindex=\"4\" >";
					print "<option value =\"0\">Select Employee</option>";
				print "</select>";
			}
			else{
				$res = $this->getcuremplist($clid, $locid);
				if (empty($res)){
					print "<select name=\"empid\" id=\"sel3\" tabindex=\"4\" >";
						print "<option value =\"0\">Select Employee</option>";
					print "</select>";
				}
				else{
					if ($bulk != "bulk"){
						print "<select name=\"empid\" id=\"sel3\" tabindex=\"4\" >";
							print "<option value =\"0\">Select Employee</option>";
							foreach ($res as $value){
								print "<option value=\"".$value['id']."\">".$value['caption']."</option>";
							}
						print "</select>";
					}
					else{
						print "<select name=\"empid[]\" id=\"sel3\" tabindex=\"4\" multiple=\"multiple\">";
							print "<option value =\"0\" selected=\"selected\">Select Employee</option>";
							foreach ($res as $value){
								print "<option value=\"".$value['id']."\">".$value['caption']."</option>";
							}
						print "</select>";
					}
				}
			}
		}
		
		public function printinitemplist(){
			if (isset($_SESSION['location']) && $_SESSION['location'] != "" && $_SESSION['location'] != "0"){
				$locid = $_SESSION['location'];
			}
			else{
				$locid = "0";
			}
			
			if (isset($_SESSION['client']) && $_SESSION['client'] != "" && $_SESSION['client'] != "0"){
				$clid = $_SESSION['client'];
			}
			else{
				$clid = "0";
			}
			
			$ctype = "0";
			
			$this->printcuremplist($clid, $locid, $ctype);
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
		
		public function vempid($empid){
			$ret = "";
			if ($empid == "0"){
				$ret = "Please Select Employee";
			}
			return $ret;
		}
		
		public function vempid1($empid){
			$ret = "";
			if (empty($empid)){
				$ret = "Please Select Employee";
			}
			return $ret;
		}
		
		public function vctype($ctype){
			$ret = "";
			if ($ctype == "0"){
				$ret = "Please Select Contact Method";
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
		
		public function crcon1($clid, $locid, $ctype, $empid, $uname, $dat, $status){
			$ret = FALSE;
			
			$clid = $this->injcheck($clid);
			$locid = $this->injcheck($locid);
			$ctype = $this->injcheck($ctype);
			$empid = $this->injcheck($empid);
			$uname = $this->injcheck($uname);
			$dat = $this->injcheck($dat);
			$status = $this->injcheck($status);
			
			$ctype = $this->encode($ctype);
			$dat = $this->encode($dat);
			$status = $this->encode($status);
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "contact";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "INSERT INTO `$this->db`.`$tablename` (
							`id`, 
							`clid`, 
							`locid`, 
							`uname`, 
							`empid`, 
							`contype`, 
							`dat`, 
							`status`
						)
						VALUES (
							NULL, 
							'$clid', 
							'$locid', 
							'$uname',
							'$empid', 
							'$ctype',  
							'$dat', 
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
		
		public function upconlog($suname, $ipadd, $dts, $action, $conid){
			$ret = FALSE;
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "conlog";
					$tex = $this->tex($tablename);
					if ($tex){
						$suname = $this->injcheck($suname);
						$ipadd = $this->injcheck($ipadd);
						$dts = $this->injcheck($dts);
						$action = $this->injcheck($action);
						$conid = $this->injcheck($conid);
						
						$sql = "INSERT INTO `$this->db`.`$tablename` (
							`id`, 
							`uname`,
							`ipadd`,
							`dts`,
							`action`, 
							`conid`
						)
						VALUES(
							NULL,
							'$suname', 
							'$ipadd',
							'$dts', 
							'$action',
							'$conid'
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
?>