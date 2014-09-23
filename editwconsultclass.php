<?php
	include 'dbclass.php';
	class editwconsult extends db{
		
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
		
		public function getcurwclist($clid, $locid){
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
									$tablename1 = "wcmain";
									$tex1 = $this->tex($tablename1);
									if ($tex1){
										$conid = $resarr['id'];
										$sql1 = "SELECT * FROM `$this->db`.`$tablename1` WHERE `$tablename1`.`conid` = '$conid'";
										$result1 = mysql_query($sql1, $dbhandle);
										if ($result1){
											if (mysql_num_rows($result1) > 0){
												while ($resarr1 = mysql_fetch_assoc($result1)){
													$ret[$i]['wcid'] = $resarr1['id'];
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
		
		public function printcurwclist($clid, $locid){
			if ($clid == "0" || $locid == "0"){
				print "<select name=\"wc\" id=\"sel3\" tabindex=\"3\" >";
					print "<option value =\"0\">Select Well Credit Consult</option>";
				print "</select>";
			}
			else{
				$res = $this->getcurwclist($clid, $locid);
				if (empty($res)){
					print "<select name=\"wc\" id=\"sel3\" tabindex=\"3\" >";
						print "<option value =\"0\">Select Well Credit Consult</option>";
					print "</select>";
				}
				else{
					print "<select name=\"wc\" id=\"sel3\" tabindex=\"3\" >";
						print "<option value =\"0\">Select Well Credit Consult</option>";
						foreach ($res as $value){
							print "<option value=\"".$value['wcid']."\">".$value['caption']."</option>";
						}
					print "</select>";
				}
			}
		}
		
		public function printinitwclist(){
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
				print "<select name=\"wc\" id=\"sel3\" tabindex=\"3\" >";
					print "<option value =\"0\">Select Well Credit Consult</option>";
				print "</select>";
			}
			else{
				$res = $this->getcurwclist($clid, $locid);
				if (empty($res)){
					print "<select name=\"wc\" id=\"sel3\" tabindex=\"3\" >";
						print "<option value =\"0\">Select Well Credit Consult</option>";
					print "</select>";
				}
				else{
					print "<select name=\"wc\" id=\"sel3\" tabindex=\"3\" >";
						print "<option value =\"0\">Select Well Credit Consult</option>";
						foreach ($res as $value){
							print "<option value=\"".$value['wcid']."\">".$value['caption']."</option>";
						}
					print "</select>";
				}
			}
		}

		public function getwcdump($wcid){
			$ret = array();
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "wcdump";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT * from `$this->db`.`$tablename` WHERE `$tablename`.`wcid` = '$wcid'";
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
						print "$.getJSON('editwconsultajax2.php?wcid=' + $('#sel3').val(),";
						print "function(data){";
							print "$.each(data, function(i, item){";
									//wce
									$wcearr = $this->getwce();
									foreach ($wcearr as $value){
										print "if(item.field == '".$value['tname']."'){";
											print "if(item.value == '"."yes"."'){";
												print "$('#".$value['tid']."').prop('checked', true);";
											print "}";
											print "else{";
												print "$('#".$value['tid']."').prop('checked', false);";
											print "}";
									print "}";
									}
							print "});";
						print "});";
					print "});";
				print "});";
			print "</script>";
		}

		public function getwce(){
			$ret = array();
			
			$constypeid = 5;
			$active = "active";
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "wce";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT * FROM `$this->db`.`$tablename` WHERE `$tablename`.`constypeid` = '$constypeid' AND `$tablename`.`status` = '$active'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$i = 0;
								while ($resarr = mysql_fetch_assoc($result)){
									$ret[$i]['id'] = $resarr['id'];
									$ret[$i]['wce'] = $resarr['wce'];
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
		
		public function printwce(){
			$wcearr = $this->getwce();
			
			if (!empty($wcearr)){
				print "<div class=\"row\">";
					print "<div class=\"twelve columns\">";
						foreach ($wcearr as $value){
							print "<div class=\"row\">";
								print "<div class=\"one columns\">";
								
								print "</div>";
								print "<div class=\"six columns\">";
									print "<input type=\"".$value['ttype']."\" name=\"".$value['tname']."\" id=\"".$value['tid']."\" value=\"yes\" />".$value['wce'];
								print "</div>";
								print "<div class=\"five columns\">";
									
								print "</div>";
							print "</div>";
						}
					print "</div>";
				print "</div>";
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
		
		public function getinput(){
			$input = array();
			
			$input['clid'] = $this->cleaninput($_POST['lc']);
			$input['locid'] = $this->cleaninput($_POST['lid']);
			$input['conid'] = $this->cleaninput($_POST['con']);
			
			$input['wce'] = $this->getwceinput();
			
			return $input;
		}
		
		public function getwceinput(){
			$ret = array();
			
			$wcearr = $this->getwce();
			$i = 0;
			foreach ($wcearr as $value){
				$ret[$i]['name'] = $value['tname'];
				if (isset($value['tname'])){
					$ret[$i]['value'] = $this->cleaninput($_POST[$value['tname']]);
				}
				else{
					$ret[$i]['value'] = "no";
				}
				$i++;
			}
			return $ret;
		}
		
		public function inswcmain($conid){
			$ret = FALSE;
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "wcmain";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "INSERT INTO `$this->db`.`$tablename` (
							`id`, 
							`conid`
						)
						VALUES (
							NULL, 
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
		
		public function inswce($wcid, $wce){
			$ret = FALSE;
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "wcdump";
					$tex = $this->tex($tablename);
					if ($tex){
						foreach ($wce as $value1){
							$name = $this->injcheck($value1['name']);
							$value = $this->injcheck($value1['value']);
							$value = $this->encode($value);
							$sql = "INSERT INTO `$this->db`.`$tablename` (
								`id`, 
								`wcid`, 
								`name`, 
								`value`
							)
							VALUES (
								NULL, 
								'$wcid', 
								'$name',
								'$value'
							)";
							$result = mysql_query($sql, $dbhandle);
							if ($result){
								$ret = TRUE;
								continue;
							}
							else{
								$ret = FALSE;
								break;
							}
						}
					}
				}
			}
			return $ret;
		}
		
		public function inswcdump($wcid, $wce){
			$ret = FALSE;
			
			$res1 = $this->inswce($wcid, $wce);
			if ($res1){
				$ret = TRUE;
			}
			return $ret;
		}
		
		public function upwclog($wcid){
			$ret = FALSE;
			
			$uname = $_SESSION['uname'];
			$ipadd = $_SESSION['ipadd'];
			$timeformat = "d-m-Y G-i-s";
			$dts = date($timeformat);
			$dts = (string)$dts;
			$dts = $this->encode($dts);
			$action = "crwc";
			$action = $this->encode($action);
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "wclog";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "INSERT INTO `$this->db`.`$tablename` (
							`id`, 
							`uname`, 
							`ipadd`, 
							`dts`, 
							`action`, 
							`wcid`
						)
						VALUES (
							NULL, 
							'$uname', 
							'$ipadd', 
							'$dts', 
							'$action', 
							'$wcid'
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
		
		public function crwc($input){
			$ret = FALSE;
			
			$res1 = $this->inswcmain($input['conid']);
			if ($res1){
				$wcid = $this->getlastinsertid();
				$res2 = $this->inswcdump($wcid, $input['wce']);
				if ($res2){
					$res3 = $this->upwclog($wcid);
					if ($res3){
						$ret = TRUE;
					}
				}
			}
			return $ret;
		}
		
	}
?>