<?php
	include 'dbclass.php';
	class clcon extends db{
		
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
				print "<select name=\"lid\" id=\"sel2\" tabindex=\"2\" onChange = \"getcon();\">";
					print "<option value =\"0\">Select Location</option>";
				print "</select>";
			}
			else{
				$res = $this->getcurloclist($clid);
				if (empty($res)){
					print "<select name=\"lid\" id=\"sel2\" tabindex=\"2\" onChange = \"getcon();\">";
						print "<option value =\"0\">Select Location</option>";
					print "</select>";
				}
				else{
					if ($sel == "0"){
						print "<select name=\"lid\" id=\"sel2\" tabindex=\"2\" onChange = \"getcon();\">";
							print "<option value =\"0\">Select Location</option>";
							foreach ($res as $value){
								print "<option value=\"".$value['id']."\">".$value['locid']."</option>";
							}
						print "</select>";
					}
					else{
						print "<select name=\"lid\" id=\"sel2\" tabindex=\"2\" onChange = \"getcon();\">";
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
				print "<select name=\"lid\" id=\"sel2\" tabindex=\"2\" onChange = \"getcon();\">";
					print "<option value =\"0\">Select Location</option>";
				print "</select>";
			}
			else{
				$res = $this->getcurloclist($clid);
				if (empty($res)){
					print "<select name=\"lid\" id=\"sel2\" tabindex=\"2\" onChange = \"getcon();\">";
						print "<option value =\"0\">Select Location</option>";
					print "</select>";
				}
				else{
					print "<select name=\"lid\" id=\"sel2\" tabindex=\"2\" onChange = \"getcon();\">";
						print "<option value =\"0\">Select Location</option>";
						foreach ($res as $value){
							print "<option value=\"".$value['id']."\">".$value['locid']."</option>";
						}
					print "</select>";
				}
			}
		}
		
		private function getcurconlist($clid, $locid){
			$ret = array();
			
			$status = "open";
			$status = $this->encode($status);
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename  = "contact";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT * FROM `$this->db`.`$tablename` WHERE `$tablename`.`clid` = '$clid' AND `$tablename`.`locid` = '$locid' AND `$tablename`.`status` = '$status'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$i = 0;
								$tablename2 = "employee";
								while ($resarr = mysql_fetch_assoc($result)){
									$ret[$i]['conid'] = $resarr['id'];
									$empid = $resarr['empid'];
									$sql2 = "SELECT * FROM `$this->db`.`$tablename2` WHERE `$tablename2`.`id` = '$empid'";
									$result2 = mysql_query($sql2, $dbhandle);
									if ($result2){
										if (mysql_num_rows($result2) > 0){
											while ($resarr2 = mysql_fetch_assoc($result2)){
												$ret[$i]['caption'] = $this->decode($resarr2['fname'])." ".$this->decode($resarr2['mname'])." ".$this->decode($resarr2['lname'])." - ".$this->decode($resarr['dat'])." - ".$this->decode($resarr2['dept'])." - ".$this->decode($resarr2['desg']);
											}
										}
									}
									$i++;
								}
							}
						}
					}
				}
			}
			return $ret;
		}
		
		public function printcurconlist($clid, $locid){
			if ($clid == "0" || $locid == "0"){
				print "<select name=\"con\" id=\"sel3\" tabindex=\"3\" >";
					print "<option value =\"0\">Select Contact</option>";
				print "</select>";
			}
			else{
				$res = $this->getcurconlist($clid, $locid);
				if (empty($res)){
					print "<select name=\"con\" id=\"sel3\" tabindex=\"3\" >";
						print "<option value =\"0\">Select Contact</option>";
					print "</select>";
				}
				else{
					print "<select name=\"con\" id=\"sel3\" tabindex=\"3\" >";
						print "<option value =\"0\">Select Contact</option>";
						foreach ($res as $value){
							print "<option value=\"".$value['conid']."\">".$value['caption']."</option>";
						}
					print "</select>";
				}
			}
		}
		
		public function printinitconlist(){
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
			
			if (isset($_SESSION['contact']) && $_SESSION['contact'] != "" && $_SESSION['contact'] != "0"){
				$sel = $_SESSION['contact'];
			}
			else{
				$sel = "0";
			}
			
			if ($clid == "0" || $locid == "0"){
				print "<select name=\"con\" id=\"sel3\" tabindex=\"3\" >";
					print "<option value =\"0\">Select Contact</option>";
				print "</select>";
			}
			else{
				$res = $this->getcurconlist($clid, $locid);
				if (empty($res)){
					print "<select name=\"con\" id=\"sel3\" tabindex=\"3\" >";
						print "<option value =\"0\">Select Contact</option>";
					print "</select>";
				}
				else{
					print "<select name=\"con\" id=\"sel3\" tabindex=\"3\" >";
						print "<option value =\"0\">Select Contact</option>";
						foreach ($res as $value){
							if ($value['conid'] == $sel){
								print "<option value=\"".$value['conid']."\" selected=\"selected\">".$value['caption']."</option>";
							}
							else{
								print "<option value=\"".$value['conid']."\">".$value['caption']."</option>";
							}
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
		
		public function vconid($conid){
			$ret = "";
			if ($conid == "0"){
				$ret = "Please Select a contact";
			}
			return $ret;
		}
		
		public function clcon1($conid){
			$ret = FALSE;
			
			$status = "closed";
			$status = $this->encode($status);
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "contact";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "UPDATE `$this->db`.`$tablename` SET `$tablename`.`status` = '$status' WHERE `$tablename`.`id` = '$conid'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							$ret = TRUE;
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