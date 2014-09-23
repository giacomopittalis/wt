<?php
	include 'dbclass.php';
	class editoconsult extends db{
		
		public function cleaninput($input){
			$ret = "";
			$q = ENT_NOQUOTES;
			
			$ret = trim($input);
			$ret = htmlspecialchars($ret, $q);
			
			return $ret;
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
		
		public function getcuroclist($clid, $locid){
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
								while ($resarr = mysql_fetch_assoc($result)){
									$tablename1 = "ocmain";
									$tex1 = $this->tex($tablename1);
									if ($tex1){
										$conid = $resarr['id'];
										$sql1 = "SELECT * FROM `$this->db`.`$tablename1` WHERE `$tablename1`.`conid` = '$conid'";
										$result1 = mysql_query($sql1, $dbhandle);
										if ($result1){
											if (mysql_num_rows($result1) > 0){
												while ($resarr1 = mysql_fetch_assoc($result1)){
													$ret[$i]['ocid'] = $resarr1['id'];
													$tablename2 = "employee";
													$tex2 = $this->tex($tablename2);
													if ($tex2){
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
							}
						}
					}
				}
			}
			return $ret;
		}
		
		public function printcuroclist($clid, $locid){
			if ($clid == "0" || $locid == "0"){
				print "<select name=\"oc\" id=\"sel3\" tabindex=\"3\" >";
					print "<option value =\"0\">Select Opportunity Consult</option>";
				print "</select>";
			}
			else{
				$res = $this->getcuroclist($clid, $locid);
				if (empty($res)){
					print "<select name=\"oc\" id=\"sel3\" tabindex=\"3\" >";
						print "<option value =\"0\">Select Opportunity Consult</option>";
					print "</select>";
				}
				else{
					print "<select name=\"oc\" id=\"sel3\" tabindex=\"3\" >";
						print "<option value =\"0\">Select Opportunity Consult</option>";
						foreach ($res as $value){
							print "<option value=\"".$value['ocid']."\">".$value['caption']."</option>";
						}
					print "</select>";
				}
			}
		}
		
		public function printinitoclist(){
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
			
			if ($clid == "0" || $locid == "0"){
				print "<select name=\"oc\" id=\"sel3\" tabindex=\"3\" >";
					print "<option value =\"0\">Select Opportunity Consult</option>";
				print "</select>";
			}
			else{
				$res = $this->getcuroclist($clid, $locid);
				if (empty($res)){
					print "<select name=\"oc\" id=\"sel3\" tabindex=\"3\" >";
						print "<option value =\"0\">Select Opportunity Consult</option>";
					print "</select>";
				}
				else{
					print "<select name=\"oc\" id=\"sel3\" tabindex=\"3\" >";
						print "<option value =\"0\">Select Opportunity Consult</option>";
						foreach ($res as $value){
							print "<option value=\"".$value['ocid']."\">".$value['caption']."</option>";
						}
					print "</select>";
				}
			}
		}

		public function getocdump($ocid){
			$ret = array();
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "ocdump";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT * from `$this->db`.`$tablename` WHERE `$tablename`.`ocid` = '$ocid'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$i = 0;
								while ($resarr = mysql_fetch_assoc($result)){
									$ret[$i]['field'] = $resarr['name'];
									if (!$resarr['value']){
										$ret[$i]['value'] = "";
									}
									else{
										$ret[$i]['value'] = $this->decode($resarr['value']);
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
		
		public function printjsonscript(){
			
			print "<script>";
				print "$(document).ready(function(){";
					print "$('#consultajax2').delegate('#sel3', 'change', function(e){";
						print "$.getJSON('editoconsultajax2.php?ocid=' + $('#sel3').val(),";
						print "function(data){";
							print "$.each(data, function(i, item){";
									//fuc
									print "if(item.field == '"."fuc"."'){";
										print "if(item.value == '"."yes"."'){";
											print "$('#fuc').prop('checked', true);";
										print "}";
										print "else{";
											print "$('#fuc').prop('checked', false);";
										print "}";
									print "}";
									//fun
									print "if(item.field == '"."fun"."'){";
										print "$('#fun').val(item.value);";
									print "}";
									//comm
									print "if(item.field == '"."comm"."'){";
										print "$('#comm').val(item.value);";
									print "}";
							print "});";
						print "});";
					print "});";
				print "});";
			print "</script>";
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
		
		public function vocid($ocid){
			$ret = "";
			if ($ocid == "0"){
				$ret = "Please Select an opportunity consult";
			}
			return $ret;
		}
		
		public function getinput(){
			$input = array();
			
			$input['clid'] = $this->cleaninput($_POST['lc']);
			$input['locid'] = $this->cleaninput($_POST['lid']);
			$input['ocid'] = $this->cleaninput($_POST['oc']);
			
			$input['comm'] = $this->cleaninput($_POST['comm']);
			
			if (isset($_POST['fuc'])){
				$input['fuc'] = $_POST['fuc'];
			}
			else{
				$input['fuc'] = "no";
			}
			$input['fun'] = $this->cleaninput($_POST['fun']);
			
			return $input;
		}
		
		public function editoccomm($ocid, $comm, $fuc, $fun){
			$ret = FALSE;
			
			$fuc = $this->encode($fuc);
			$fun = $this->encode($fun);
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "ocdump";
					$tex = $this->tex($tablename);
					if ($tex){
						$name = "comm";
						$comm = $this->injcheck($comm);
						$comm = $this->encode($comm);
						$sql = "UPDATE `$this->db`.`$tablename` SET `$tablename`.`value` = '$comm' WHERE `$tablename`.`name` ='$name' AND `$tablename`.`ocid` = '$ocid'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							$name1 = "fuc";
							$sql1 = $sql = "UPDATE `$this->db`.`$tablename` SET `$tablename`.`value` = '$fuc' WHERE `$tablename`.`name` ='$name1' AND `$tablename`.`ocid` = '$ocid'";
							$result1 = mysql_query($sql1, $dbhandle);
							if ($result1){
								$name2 = "fun";
								$sql2 = $sql = "UPDATE `$this->db`.`$tablename` SET `$tablename`.`value` = '$fun' WHERE `$tablename`.`name` ='$name2' AND `$tablename`.`ocid` = '$ocid'";
								$result2 = mysql_query($sql2, $dbhandle);
								if ($result2){
									$ret = TRUE;
								}
							}
						}
					}
				}
			}
			return $ret;	
		}
		
		public function editocdump($ocid, $comm, $fuc, $fun){
			$ret = FALSE;
			
			$res1 = $this->editoccomm($ocid, $comm, $fuc, $fun);
			if ($res1){
				$ret = TRUE;
			}
			return $ret;
		}
		
		public function upoclog($ocid){
			$ret = FALSE;
			
			$uname = $_SESSION['uname'];
			$ipadd = $_SESSION['ipadd'];
			$timeformat = "d-m-Y G-i-s";
			$dts = date($timeformat);
			$dts = (string)$dts;
			$dts = $this->encode($dts);
			$action = "editoc";
			$action = $this->encode($action);
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "oclog";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "INSERT INTO `$this->db`.`$tablename` (
							`id`, 
							`uname`, 
							`ipadd`, 
							`dts`, 
							`action`, 
							`ocid`
						)
						VALUES (
							NULL, 
							'$uname', 
							'$ipadd', 
							'$dts', 
							'$action', 
							'$ocid'
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
		
		public function editoc($input){
			$ret = FALSE;
			
			$res2 = $this->editocdump($input['ocid'], $input['comm'], $input['fuc'], $input['fun']);
			if ($res2){
				$res3 = $this->upoclog($input['ocid']);
				if ($res3){
					$ret = TRUE;
				}
			}
			return $ret;
		}
		
	}
?>