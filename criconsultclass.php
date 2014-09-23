<?php
	include 'dbclass.php';
	class criconsult extends db{
		
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
												$ret[$i]['caption'] = $this->decode($resarr2['lname']).", ".$this->decode($resarr2['fname'])." ".$this->decode($resarr2['mname'])." - ".$this->decode($resarr['dat'])." - ".$this->decode($resarr2['dept'])." - ".$this->decode($resarr2['desg']);
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

		public function getbplist(){
			$ret = array();
			
			$active = "active";
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "bodypart";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT * FROM `$this->db`.`$tablename` WHERE `$tablename`.`status` = '$active'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$i = 0;
								while ($resarr = mysql_fetch_assoc($result)){
									$ret[$i]['id'] = $resarr['id'];
									$ret[$i]['bp'] = $resarr['bp'];
									$i++;
								}
							}
						}
					}
				}
			}
			return $ret;
		}
		
		public function printbplist(){
			
			$res = $this->getbplist();
			if (empty($res)){
				print "<select name=\"bp\" id=\"sel4\" tabindex=\"1\" onchange=\"getij();\">";
					print "<option value=\"0\">Select Body Part</option>";
				print "</select>";
			}
			else{
				print "<select name=\"bp\" id=\"sel4\" tabindex=\"1\" onchange=\"getij();\">";
					print "<option value=\"0\">Select Body Part</option>";
					foreach ($res as $value){
						print "<option value=\"".$value['id']."\">".$value['bp']."</option>";
					}
				print "</select>";
			}
		}
		
		public function printinitbplist(){
			if (isset($_SESSION['bp']) && $_SESSION['bp'] != "" && $_SESSION['bp'] != "0"){
				$bpid = $_SESSION['bp'];
			}
			else{
				$bpid = "0";
			}
			
			if ($bpid == "0"){
				$this->printbplist();
			}
			else{
				$res = $this->getbplist();
				if (empty($res)){
					print "<select name=\"bp\" id=\"sel4\" tabindex=\"1\" onchange=\"getij();\">";
						print "<option value=\"0\">Select Body Part</option>";
					print "</select>";
				}
				else{
					print "<select name=\"bp\" id=\"sel4\" tabindex=\"1\" onchange=\"getij();\">";
						print "<option value=\"0\">Select Body Part</option>";
						foreach ($res as $value){
							if ($value['id'] == $bpid){
								print "<option value=\"".$value['id']."\" selected=\"selected\">".$value['bp']."</option>";
							}
							else{
								print "<option value=\"".$value['id']."\">".$value['bp']."</option>";
							}
						}
					print "</select>";
				}
			}
		}
    	
		public function getijlist($bpid){
			$ret = array();
			
			$active = "active";
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "injury";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT * FROM `$this->db`.`$tablename` WHERE `$tablename`.`bpid` = '$bpid' AND `$tablename`.`status` = '$active'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$i = 0;
								while ($resarr = mysql_fetch_assoc($result)){
									$ret[$i]['id'] = $resarr['id'];
									$ret[$i]['ij'] = $resarr['ij'];
									$i++;
								}
							}
						}
					}
				}
			}
			return $ret;
		}
		
		public function printijlist($bpid){
			if ($bpid == "0"){
				print "<select name=\"ij\" id=\"sel5\" tabindex=\"2\">";
					print "<option value=\"0\">Select Injury</option>";
				print "</select>";
			}
			else{
				$res = $this->getijlist($bpid);
				if (empty($res)){
					print "<select name=\"ij\" id=\"sel5\" tabindex=\"2\">";
						print "<option value=\"0\">Select Injury</option>";
					print "</select>";
				}
				else{
					print "<select name=\"ij\" id=\"sel5\" tabindex=\"2\">";
						print "<option value=\"0\">Select Injury</option>";
						foreach ($res as $value){
							print "<option value=\"".$value['id']."\">".$value['ij']."</option>";
						}
					print "</select>";
				}
			}
		}
		
		public function printinitijlist(){
			if (isset($_SESSION['bp']) && $_SESSION['bp'] != "" && $_SESSION['bp'] != "0"){
				$bpid = $_SESSION['bp'];
			}
			else{
				$bpid = "0";
			}
			
			if (isset($_SESSION['ij']) && $_SESSION['ij'] != "" && $_SESSION['ij'] != "0"){
				$ijid = $_SESSION['ij'];
			}
			else{
				$ijid = "0";
			}
			
			if ($bpid == "0"){
				print "<select name=\"ij\" id=\"sel5\" tabindex=\"2\">";
					print "<option value=\"0\">Select Injury</option>";
				print "</select>";
			}
			else{
				$res = $this->getijlist($bpid);
				if (empty($res)){
					print "<select name=\"ij\" id=\"sel5\" tabindex=\"2\">";
						print "<option value=\"0\">Select Injury</option>";
					print "</select>";
				}
				else{
					print "<select name=\"ij\" id=\"sel5\" tabindex=\"2\">";
						print "<option value=\"0\">Select Injury</option>";
						foreach ($res as $value){
							if ($value['id'] == $ijid){
								print "<option value=\"".$value['id']."\" selected=\"selected\">".$value['ij']."</option>";
							}
							else{
								print "<option value=\"".$value['id']."\">".$value['ij']."</option>";
							}
						}
					print "</select>";
				}
			}
		}

		public function gettopics(){
			$ret = array();
			
			$constypeid = 2;
			$active = "active";
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "topic";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT * FROM `$this->db`.`$tablename` WHERE `$tablename`.`constypeid` = '$constypeid' AND `$tablename`.`status` = '$active'";
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
		
		public function getsubtopics($topicid){
			$ret = array();
			
			$constypeid = 2;
			$active = "active";
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "subtopic";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT * FROM `$this->db`.`$tablename` WHERE `$tablename`.`constypeid` = '$constypeid' AND `$tablename`.`topicid` = '$topicid' AND `$tablename`.`status` = '$active'";
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
			return $ret;
		}

		public function splitintorows($topicid){
			$res = $this->getsubtopics($topicid);
			$ret = array();
			$ret = array_chunk($res, 5);
			return $ret;
		}
		
		public function getfields($topicid, $subtopicid){
			$ret = array();
			
			$constypeid = 2;
			$active = "active";
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "fields";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT * FROM `$this->db`.`$tablename` WHERE `$tablename`.`constypeid` = '$constypeid' AND `$tablename`.`topicid` = '$topicid' AND `$tablename`.`subtopicid` = '$subtopicid' AND `$tablename`.`status` = '$active'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$i = 0;
								while ($resarr = mysql_fetch_assoc($result)){
									$ret[$i]['id'] = $resarr['id'];
									$ret[$i]['fldname'] = $resarr['fldname'];
									$ret[$i]['fltype'] = $resarr['fltype'];
									$ret[$i]['flname'] = $resarr['flname'];
									$ret[$i]['flid'] = $resarr['flid'];
									$ret[$i]['flclass'] = $resarr['flclass'];
									$i++;
								}
							}
						}
					}
				}
			}
			return $ret;
		}

		public function getdividarr(){
			$ret = array();
			
			$topic = $this->gettopics();
			if (!empty($topic)){
				$i = 0;
				foreach ($topic as $value){
					$ret[$i] = "sdivid".$i;
					$i++;
				}
			}
			return $ret;
		}
		
		public function getfldividarr(){
			$ret = array();
			
			$topic = $this->gettopics();
			if (!empty($topic)){
				$i = 0;
				foreach ($topic as $value1){
					$subtopic = $this->getsubtopics($value1['id']);
					if (!empty($subtopic)){
						foreach ($subtopic as $value2){
							$field = $this->getfields($value1['id'], $value2['id']);
							if  (!empty($field)){
								$ret[$i] = "fdivid".$i;
								$i++;
							}
						}
					}
				}
			}
			return $ret;
		}
		
		public function printelements(){
			$topic = $this->gettopics();
			if (empty($topic)){
				print "";
			}
			else{
				$dividarr = $this->getdividarr();
				$fdividarr = $this->getfldividarr();
				$i = 0;
				$j = 0;
				foreach ($topic as $value1){
					print "<div class=\"row\">";
						print "<div class=\"twelve columns\">";
							print "<input type=\"".$value1['ttype']."\" name=\"".$value1['tname']."\" id=\"".$value1['tid']."\" class=\"".$value1['tclass']."\" value=\"yes\"/>".$value1['topic'];
						print "</div>";
					print "</div>";
					print "<div class=\"row\" id=\"".$dividarr[$i]."\">";
						print "<div class=\"twelve columns\">";
					$subtopics = $this->splitintorows($value1['id']);
					if (!empty($subtopics)){
						foreach ($subtopics as $value2){
							print "<div class=\"row\">";
    							print "<div class=\"one columns\">";
    							print "</div>";
								
								print "<div class=\"two columns\">";
									if (array_key_exists(0, $value2)){
										print "<input type=\"".$value2[0]['stype']."\" name=\"".$value2[0]['sname']."\" id=\"".$value2[0]['sid']."\" class=\"".$value2[0]['sclass']."\" value=\"yes\" />".$value2[0]['subtopic'];
										$fields = $this->getfields($value1['id'], $value2[0]['id']);
										if (!empty($fields)){
											print "<div class=\"row\" id=\"".$fdividarr[$j]."\">";
												print "<div class=\"twelve columns\">";
											foreach ($fields as $value3){
												print "<div class=\"row\">";
													print "<div class=\"twelve columns\">";
														if ($value3['fltype'] == "text"){
															print "<input type=\"".$value3['fltype']."\" name=\"".$value3['flname']."\" id=\"".$value3['flid']."\" class=\"".$value3['flclass']."\" placeholder=\"".$value3['fldname']."\" />";
														}
														else{
															print "<input type=\"".$value3['fltype']."\" name=\"".$value3['flname']."\" id=\"".$value3['flid']."\" class=\"".$value3['flclass']."\" value=\"yes\" />".$value3['fldname'];
														}
												print "</div>";
													print "</div>";
											}
											print "</div>";
												print "</div>";
												$j++;
										}
									}
    							print "</div>";
								
								print "<div class=\"two columns\">";
									if (array_key_exists(1, $value2)){
										print "<input type=\"".$value2[1]['stype']."\" name=\"".$value2[1]['sname']."\" id=\"".$value2[1]['sid']."\" class=\"".$value2[1]['sclass']."\" value=\"yes\" />".$value2[1]['subtopic'];
										$fields = $this->getfields($value1['id'], $value2[1]['id']);
										if (!empty($fields)){
											print "<div class=\"row\" id=\"".$fdividarr[$j]."\">";
												print "<div class=\"twelve columns\">";
											foreach ($fields as $value3){
												print "<div class=\"row\">";
													print "<div class=\"twelve columns\">";
														if ($value3['fltype'] == "text"){
															print "<input type=\"".$value3['fltype']."\" name=\"".$value3['flname']."\" id=\"".$value3['flid']."\" class=\"".$value3['flclass']."\" placeholder=\"".$value3['fldname']."\" />";
														}
														else{
															print "<input type=\"".$value3['fltype']."\" name=\"".$value3['flname']."\" id=\"".$value3['flid']."\" class=\"".$value3['flclass']."\" value=\"yes\" />".$value3['fldname'];
														}
												print "</div>";
													print "</div>";
											}
											print "</div>";
												print "</div>";
												$j++;
										}
									}
    							print "</div>";
								
								print "<div class=\"two columns\">";
									if (array_key_exists(2, $value2)){
										print "<input type=\"".$value2[2]['stype']."\" name=\"".$value2[2]['sname']."\" id=\"".$value2[2]['sid']."\" class=\"".$value2[2]['sclass']."\" value=\"yes\" />".$value2[2]['subtopic'];
										$fields = $this->getfields($value1['id'], $value2[2]['id']);
										if (!empty($fields)){
											print "<div class=\"row\" id=\"".$fdividarr[$j]."\">";
												print "<div class=\"twelve columns\">";
											foreach ($fields as $value3){
												print "<div class=\"row\">";
													print "<div class=\"twelve columns\">";
														if ($value3['fltype'] == "text"){
															print "<input type=\"".$value3['fltype']."\" name=\"".$value3['flname']."\" id=\"".$value3['flid']."\" class=\"".$value3['flclass']."\" placeholder=\"".$value3['fldname']."\" />";
														}
														else{
															print "<input type=\"".$value3['fltype']."\" name=\"".$value3['flname']."\" id=\"".$value3['flid']."\" class=\"".$value3['flclass']."\" value=\"yes\" />".$value3['fldname'];
														}
												print "</div>";
													print "</div>";
											}
											print "</div>";
												print "</div>";
												$j++;
										}
									}
    							print "</div>";
								
								print "<div class=\"two columns\">";
									if (array_key_exists(3, $value2)){
										print "<input type=\"".$value2[3]['stype']."\" name=\"".$value2[3]['sname']."\" id=\"".$value2[3]['sid']."\" class=\"".$value2[3]['sclass']."\" value=\"yes\" />".$value2[3]['subtopic'];
										$fields = $this->getfields($value1['id'], $value2[3]['id']);
										if (!empty($fields)){
											print "<div class=\"row\" id=\"".$fdividarr[$j]."\">";
												print "<div class=\"twelve columns\">";
											foreach ($fields as $value3){
												print "<div class=\"row\">";
													print "<div class=\"twelve columns\">";
														if ($value3['fltype'] == "text"){
															print "<input type=\"".$value3['fltype']."\" name=\"".$value3['flname']."\" id=\"".$value3['flid']."\" class=\"".$value3['flclass']."\" placeholder=\"".$value3['fldname']."\" />";
														}
														else{
															print "<input type=\"".$value3['fltype']."\" name=\"".$value3['flname']."\" id=\"".$value3['flid']."\" class=\"".$value3['flclass']."\" value=\"yes\" />".$value3['fldname'];
														}
												print "</div>";
													print "</div>";
											}
											print "</div>";
												print "</div>";
												$j++;
										}
									}
    							print "</div>";
								
								print "<div class=\"two columns\">";
									if (array_key_exists(4, $value2)){
										print "<input type=\"".$value2[4]['stype']."\" name=\"".$value2[4]['sname']."\" id=\"".$value2[4]['sid']."\" class=\"".$value2[4]['sclass']."\" value=\"yes\" />".$value2[4]['subtopic'];
										$fields = $this->getfields($value1['id'], $value2[4]['id']);
										if (!empty($fields)){
											print "<div class=\"row\" id=\"".$fdividarr[$j]."\">";
												print "<div class=\"twelve columns\">";
											foreach ($fields as $value3){
												print "<div class=\"row\">";
													print "<div class=\"twelve columns\">";
														if ($value3['fltype'] == "text"){
															print "<input type=\"".$value3['fltype']."\" name=\"".$value3['flname']."\" id=\"".$value3['flid']."\" class=\"".$value3['flclass']."\" placeholder=\"".$value3['fldname']."\" />";
														}
														else{
															print "<input type=\"".$value3['fltype']."\" name=\"".$value3['flname']."\" id=\"".$value3['flid']."\" class=\"".$value3['flclass']."\" value=\"yes\" />".$value3['fldname'];
														}
												print "</div>";
													print "</div>";
											}
											print "</div>";
												print "</div>";
												$j++;
										}
									}
    							print "</div>";
								
								print "<div class=\"one columns\">";
    							print "</div>";
								
							print "</div>";
						}
					}
				print "<br />";
				print "<br />";
				print "<div class=\"row\">";
					print "<div class=\"four columns\">";
							print "<label>Comments</label>";
					print "</div>";
					print "<div class=\"six columns\">";
							print "<textarea rows=\"10\" cols=\"30\" name=\"commta".$value1['id']."\"></textarea>";
					print "</div>";
					print "<div class=\"four columns\">";
							
					print "</div>";
				print "</div>";
				print "</div>";			
					print "</div>";
					$i++;
				}
			}
		}

		public function printflhidescript(){
			$fldividarr = $this->getfldividarr();
			if (!empty($fldividarr)){
				print "<script>";
					print "$(document).ready(function(){";
					foreach ($fldividarr as $value){
						print "$('#".$value."').hide();";
					}
					print "});";
				print "</script>";
			}
		}

		public function printhidescript(){
			$dividarr = $this->getdividarr();
			if (!empty($dividarr)){
				print "<script>";
					print "$(document).ready(function(){";
					foreach ($dividarr as $value){
						print "$('#".$value."').hide();";
					}
					print "});";
				print "</script>";
			}
		}
		
		public function printchangescript(){
			$dividarr = $this->getdividarr();
			$topics = $this->gettopics();
			$i = 0;
			if (!empty($topics)){
				foreach ($topics as $value){
					print "<script>";
						print "$(document).ready(function(){";
							print "$('#".$value['tid']."').change(function(){";
								print "if(this.checked){";
									print "$('#".$dividarr[$i]."').show();";
								print "}";
								print "else{";
									print "$('#".$dividarr[$i]."').hide();";
								print "}";
							print "});";
						print "});";
					print "</script>";
					$i++;
				}	
			}
		}
		
		public function printflchangescript(){
			$fldividarr = $this->getfldividarr();
			$topics = $this->gettopics();
			$i = 0;
			if (!empty($topics)){
				foreach ($topics as $value1){
					$subtopics = $this->getsubtopics($value1['id']);
					foreach ($subtopics as $value2){
						$fields = $this->getfields($value1['id'], $value2['id']);
						if (!empty($fields)){
							print "<script>";
								print "$(document).ready(function(){";
									print "$('#".$value2['sid']."').change(function(){";
										print "if(this.checked){";
											print "$('#".$fldividarr[$i]."').show();";
										print "}";
										print "else{";
											print "$('#".$fldividarr[$i]."').hide();";
										print "}";
									print "});";
								print "});";
							print "</script>";
							$i++;
						}
					}
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
		
		public function getgeninput(){
			$geninput = array();
			
			$geninput['clid'] = $this->cleaninput($_POST['lc']);
			$geninput['locid'] = $this->cleaninput($_POST['lid']);
			$geninput['conid'] = $this->cleaninput($_POST['con']);
			if (isset($_POST['umc'])){
				$geninput['umc'] = $_POST['umc'];
			}
			else{
				$geninput['umc'] = "no";
			}
			
			if (isset($_POST['fuc'])){
				$geninput['fuc'] = $_POST['fuc'];
			}
			else{
				$geninput['fuc'] = "no";
			}
			$geninput['fun'] = $this->cleaninput($_POST['fun']);
			return $geninput;
		}
		
		public function gettopictabinput(){
			$inparr = array();
			$topic = $this->gettopics();
			if (!empty($topic)){
				foreach ($topic as $value1){
					if (isset($_POST[$value1['tname']])){
						$inparr['topic'][$value1['tname']] = $this->cleaninput($_POST[$value1['tname']]);
					}
					else{
						$inparr['topic'][$value1['tname']] = "no";
					}
					$subtopic = $this->getsubtopics($value1['id']);
					if (!empty($subtopic)){
						foreach ($subtopic as $value2){
							if (isset($_POST[$value2['sname']])){
								$inparr['subtopic'][$value2['sname']] = $this->cleaninput($_POST[$value2['sname']]);
							}
							else{
								$inparr['subtopic'][$value2['sname']] = "no";
							}
							$field = $this->getfields($value1['id'], $value2['id']);
							if (!empty($field)){
								foreach ($field as $value3){
									if ($value3['fltype'] == "text"){
										$inparr['field'][$value3['flname']] = $this->cleaninput($_POST[$value3['flname']]);
										//if($inparr['field'][$value3['flname']] == ""){
											//$inparr['field'][$value3['flname']] = "ni";
										//}
									}
									else{
										if (isset($_POST[$value3['flname']])){
											$inparr['field'][$value3['flname']] = $this->cleaninput($_POST[$value3['flname']]);
										}
										else{
											$inparr['field'][$value3['flname']] = "no";
										}
									}
								}
							}
						}
					}
					$comname = "commta".$value1['id'];
					$inparr['topcom'][$comname] = $this->cleaninput($_POST[$comname]);
				}
			}
			return $inparr;
		}

		public function getsoapinput(){
			$soaparr = array();
			
			$soaparr[0]['name'] = "soap";
			$soaparr[0]['dname'] = "Soap";
			
			$i = 0;
			foreach ($soaparr as $value){
				if (isset($_POST[$value['name']])){
					$input[$i] = $this->cleaninput($_POST[$value['name']]);
				}
				else{
					$input[$i] = "no";
				}
				$i++;
			}
			
			$j = 0;
			foreach ($input as $value1){
				$soaparr[$j]['input'] = $value1;
				$j++;
			}
			return $soaparr;
		}

		public function getsubjectiveinput(){
			$subjectivearr = array();
			
			$subjectivearr[0]['name'] = "subjective";
			$subjectivearr[0]['dname'] = "Subjective";
			$subjectivearr[1]['name'] = "scommb";
			$subjectivearr[1]['dname'] = "Subjective Comments";
			
			$i = 0;
			foreach ($subjectivearr as $value){
				if (isset($_POST[$value['name']])){
					$input[$i] = $this->cleaninput($_POST[$value['name']]);
				}
				else{
					$input[$i] = "no";
				}
				$i++;
			}
			
			$j = 0;
			foreach ($input as $value1){
				$subjectivearr[$j]['input'] = $value1;
				$j++;
			}
			return $subjectivearr;
		}
		
		public function getobjectiveinput(){
			$objectivearr = array();
			
			$objectivearr[0]['name'] = "objective";
			$objectivearr[0]['dname'] = "Objective";
			$objectivearr[1]['name'] = "ocommb";
			$objectivearr[1]['dname'] = "Objective Comments";
			
			$i = 0;
			foreach ($objectivearr as $value){
				if (isset($_POST[$value['name']])){
					$input[$i] = $this->cleaninput($_POST[$value['name']]);
				}
				else{
					$input[$i] = "no";
				}
				$i++;
			}
			
			$j = 0;
			foreach ($input as $value1){
				$objectivearr[$j]['input'] = $value1;
				$j++;
			}
			return $objectivearr;
		}

		public function getassessmentinput(){
			$assessmentarr = array();
			
			$assessmentarr[0]['name'] = "assessment";
			$assessmentarr[0]['dname'] = "Assessment";
			$assessmentarr[1]['name'] = "acommb";
			$assessmentarr[1]['dname'] = "Assessment Comments";
			
			$i = 0;
			foreach ($assessmentarr as $value){
				if (isset($_POST[$value['name']])){
					$input[$i] = $this->cleaninput($_POST[$value['name']]);
				}
				else{
					$input[$i] = "no";
				}
				$i++;
			}
			
			$j = 0;
			foreach ($input as $value1){
				$assessmentarr[$j]['input'] = $value1;
				$j++;
			}
			return $assessmentarr;
		}
		
		public function getplaninput(){
			$planarr = array();
			
			$planarr[0]['name'] = "plan";
			$planarr[0]['dname'] = "Plan";
			$planarr[1]['name'] = "pcommb";
			$planarr[1]['dname'] = "Plan Comments";
			
			$i = 0;
			foreach ($planarr as $value){
				if (isset($_POST[$value['name']])){
					$input[$i] = $this->cleaninput($_POST[$value['name']]);
				}
				else{
					$input[$i] = "no";
				}
				$i++;
			}
			
			$j = 0;
			foreach ($input as $value1){
				$planarr[$j]['input'] = $value1;
				$j++;
			}
			return $planarr;
		}

		public function comsoapinputfunc(){
			$soapinparr = array();
			
			$soapinparr['soap'] = $this->getsoapinput();
			$soapinparr['subjective'] = $this->getsubjectiveinput();
			$soapinparr['objective'] = $this->getobjectiveinput();
			$soapinparr['assessment'] = $this->getassessmentinput();
			$soapinparr['plan'] = $this->getplaninput();
			
			return $soapinparr;
		}

		public function getinfoinput(){
			
			$infoarr = array();
			
			$infoarr[0]['name'] = "wnw";
			$infoarr[0]['dname'] = "Work vs. Non Work";
			$infoarr[1]['name'] = "xpx";
			$infoarr[1]['dname'] = "Existing vs. Pre Existing";
			$infoarr[2]['name'] = "moi1";
			$infoarr[2]['dname'] = "MOI";
			$infoarr[3]['name'] = "ltm";
			$infoarr[3]['dname'] = "Lost Time";
			$infoarr[4]['name'] = "mds";
			$infoarr[4]['dname'] = "MD Seen";
			$infoarr[5]['name'] = "bp";
			$infoarr[5]['dname'] = "Body Part";
			$infoarr[6]['name'] = "ij";
			$infoarr[6]['dname'] = "Injury Type";
			$infoarr[7]['name'] = "svr";
			$infoarr[7]['dname'] = "Severity Rate";
			$infoarr[8]['name'] = "pnr";
			$infoarr[8]['dname'] = "Pain Rate";
			$infoarr[9]['name'] = "iml";
			$infoarr[9]['dname'] = "Improvement Level";
			
			if (isset($_POST['wnw'])){
				$infoarr[0]['input'] = $this->cleaninput($_POST['wnw']);
			}
			else{
				$infoarr[0]['input'] = "nonwork";
			}
			
			if (isset($_POST['xpx'])){
				$infoarr[1]['input'] = $this->cleaninput($_POST['xpx']);
			}
			else{
				$infoarr[1]['input'] = "preexisting";
			}
			
			$infoarr[2]['input'] = $this->cleaninput($_POST['moi1']);
			
			$infoarr[3]['input'] = $this->cleaninput($_POST['ltm']);
			
			if (isset($_POST['mds'])){
				$infoarr[4]['input'] = $this->cleaninput($_POST['mds']);
			}
			else{
				$infoarr[4]['input'] = "no";
			}
			
			$infoarr[5]['input'] = $this->cleaninput($_POST['bp']);
			
			$infoarr[6]['input'] = $this->cleaninput($_POST['ij']);
			
			$infoarr[7]['input'] = $this->cleaninput($_POST['svr']);
			
			$infoarr[8]['input'] = $this->cleaninput($_POST['pnr']);
			
			$infoarr[9]['input'] = $this->cleaninput($_POST['iml']);
			
			return $infoarr;
		}

		public function getmoiinput(){
			$moiarr = array();
			
			$moiarr[0]['name'] = "sacute";
			$moiarr[0]['dname'] = "Acute";
			$moiarr[1]['name'] = "schronic";
			$moiarr[1]['dname'] = "Chronic";
			$moiarr[2]['name'] = "sbltr";
			$moiarr[2]['dname'] = "Blunt Trauma";
			$moiarr[3]['name'] = "scbet";
			$moiarr[3]['dname'] = "Caught Between";
			$moiarr[4]['name'] = "soveru";
			$moiarr[4]['dname'] = "Overuse";
			$moiarr[5]['name'] = "twisting";
			$moiarr[5]['dname'] = "Twisting";
			$moiarr[6]['name'] = "sheerf";
			$moiarr[6]['dname'] = "Sheer Force";
			$moiarr[7]['name'] = "overx";
			$moiarr[7]['dname'] = "Over Exertion";
			$moiarr[8]['name'] = "overstr";
			$moiarr[8]['dname'] = "Over Stretching";
			$moiarr[9]['name'] = "slipfall";
			$moiarr[9]['dname'] = "Slip / Fall";
			$moiarr[10]['name'] = "equip";
			$moiarr[10]['dname'] = "Equipment";
			$moiarr[11]['name'] = "sother";
			$moiarr[11]['dname'] = "Other";
			$moiarr[12]['name'] = "swelling";
			$moiarr[12]['dname'] = "Swelling";
			$moiarr[13]['name'] = "erythema";
			$moiarr[13]['dname'] = "Erythema";
			$moiarr[14]['name'] = "numbness";
			$moiarr[14]['dname'] = "Numbness";
			$moiarr[15]['name'] = "olof";
			$moiarr[15]['dname'] = "Loss of Function";
			$moiarr[16]['name'] = "odrom";
			$moiarr[16]['dname'] = "Decreased ROM";
			$moiarr[17]['name'] = "olos";
			$moiarr[17]['dname'] = "Loss of Strength";
			$moiarr[18]['name'] = "olosen";
			$moiarr[18]['dname'] = "Loss of Sensation";
			$moiarr[19]['name'] = "opl";
			$moiarr[19]['dname'] = "Pain Level";
			$moiarr[20]['name'] = "buring";
			$moiarr[20]['dname'] = "Burning";
			$moiarr[21]['name'] = "deformity";
			$moiarr[21]['dname'] = "Deformity";
			$moiarr[22]['name'] = "crepitus";
			$moiarr[22]['dname'] = "Crepitus";
			$moiarr[23]['name'] = "laxity";
			$moiarr[23]['dname'] = "Laxity";
			$moiarr[24]['name'] = "bleeding";
			$moiarr[24]['dname'] = "Bleeding";
			$moiarr[25]['name'] = "hematoma";
			$moiarr[25]['dname'] = "Hematoma";
			$moiarr[26]['name'] = "contusion";
			$moiarr[26]['dname'] = "Contusion";
			$moiarr[27]['name'] = "discoloration";
			$moiarr[27]['dname'] = "Discoloration";
			$moiarr[28]['name'] = "cromping";
			$moiarr[28]['dname'] = "Cromping";
			$moiarr[29]['name'] = "tightness";
			$moiarr[29]['dname'] = "Tightness";
			$moiarr[30]['name'] = "oother";
			$moiarr[30]['name'] = "Other";
			$moiarr[31]['name'] = "sprain";
			$moiarr[31]['dname'] = "Sprain";
			$moiarr[32]['name'] = "strain";
			$moiarr[32]['dname'] = "Strain";
			$moiarr[33]['name'] = "fracture";
			$moiarr[33]['dname'] = "Fracture";
			$moiarr[34]['name'] = "stressfrac";
			$moiarr[34]['dname'] = "Stress Fracture";
			$moiarr[35]['name'] = "acontusion";
			$moiarr[35]['dname'] = "Contusion";
			$moiarr[36]['name'] = "ahematoma";
			$moiarr[36]['dname'] = "Hematoma";
			$moiarr[37]['name'] = "laceration";
			$moiarr[37]['dname'] = "Laceration";
			$moiarr[38]['name'] = "avulsion";
			$moiarr[38]['dname'] = "Avulsion";
			$moiarr[39]['name'] = "tendinitis";
			$moiarr[39]['dname'] = "Tendinitis";
			$moiarr[40]['name'] = "bursitis";
			$moiarr[40]['dname'] = "Bursitis";
			$moiarr[41]['name'] = "asoreness";
			$moiarr[41]['dname'] = "Soreness";
			$moiarr[42]['name'] = "aburn";
			$moiarr[42]['dname'] = "Burn";
			$moiarr[43]['name'] = "ainfection";
			$moiarr[43]['dname'] = "Infection";
			$moiarr[44]['name'] = "aspasm";
			$moiarr[44]['dname'] = "Spasm";
			$moiarr[45]['name'] = "acramp";
			$moiarr[45]['dname'] = "Cramp";
			$moiarr[46]['name'] = "subluxation";
			$moiarr[46]['dname'] = "Subluxation";
			$moiarr[47]['name'] = "dislocation";
			$moiarr[47]['dname'] = "Dislocation";
			$moiarr[48]['name'] = "aother";
			$moiarr[48]['dname'] = "Other";
			$moiarr[49]['name'] = "pstretch";
			$moiarr[49]['dname'] = "Stretch";
			$moiarr[50]['name'] = "ice";
			$moiarr[50]['dname'] = "Ice";
			$moiarr[51]['name'] = "pcompression";
			$moiarr[51]['dname'] = "Compression";
			$moiarr[52]['name'] = "pheat";
			$moiarr[52]['dname'] = "Heat";
			$moiarr[53]['name'] = "prest";
			$moiarr[53]['dname'] = "Rest";
			$moiarr[54]['name'] = "pwcare";
			$moiarr[54]['dname'] = "Wound Care";
			$moiarr[55]['name'] = "psplinting";
			$moiarr[55]['dname'] = "Splinting";
			$moiarr[56]['name'] = "pbracing";
			$moiarr[56]['dname'] = "Bracing";
			$moiarr[57]['name'] = "mdref";
			$moiarr[57]['dname'] = "MD Referral";
			$moiarr[58]['name'] = "pstrex";
			$moiarr[58]['dname'] = "Strength Exercises";
			$moiarr[59]['name'] = "vhi";
			$moiarr[59]['dname'] = "VHI Routine";
			$moiarr[60]['name'] = "pother";
			$moiarr[60]['dname'] = "Other";
			
			$i = 0;
			foreach ($moiarr as $value){
				if (isset($_POST[$value['name']])){
					$input[$i] = $this->cleaninput($_POST[$value['name']]);
				}
				else{
					$input[$i] = "no";
				}
				$i++;
			}
			
			$j = 0;
			foreach ($input as $value1){
				$moiarr[$j]['input'] = $value1;
				$j++;
			}
			return $moiarr;
		}
		
		public function getinput(){
			$input = array();
			
			$input['general'] = $this->getgeninput();
			$input['info'] = $this->getinfoinput();
			$input['moi'] = $this->getmoiinput();
			$input['topics'] = $this->gettopictabinput();
			$input['soap'] = $this->comsoapinputfunc();
			
			return $input;
		}
		
		public function insicmain($conid){
			$ret = FALSE;
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "icmain";
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
		
		public function insicumc($icid, $umc, $fuc, $fun){
			$ret = FALSE;
			
			$umc = $this->encode($umc);
			$fuc = $this->encode($fuc);
			$fun = $this->encode($fun);
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "icdump";
					$tex = $this->tex($tablename);
					if ($tex){
						$name = "umc";
						$sql = "INSERT INTO `$this->db`.`$tablename` (
							`id`, 
							`icid`, 
							`name`, 
							`value`
						)
						VALUES (
							NULL, 
							'$icid', 
							'$name',
							'$umc'
						)";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							$name1 = "fuc";
							$sql1 = "INSERT INTO `$this->db`.`$tablename` (
								`id`, 
								`icid`, 
								`name`, 
								`value`
							)
							VALUES (
								NULL, 
								'$icid', 
								'$name1',
								'$fuc'
							)";
							$result1 = mysql_query($sql1, $dbhandle);
							if ($result1){
								$name2 = "fun";
								$sql2 = "INSERT INTO `$this->db`.`$tablename` (
									`id`, 
									`icid`, 
									`name`, 
									`value`
								)
								VALUES (
									NULL, 
									'$icid', 
									'$name2',
									'$fun'
								)";
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
		
		public function insicinfo($icid, $info){
			$ret = FALSE;
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "icdump";
					$tex = $this->tex($tablename);
					if ($tex){
						foreach ($info as $value){
							$name = $value['name'];
							$input = $value['input'];
							$name = $this->injcheck($name);
							$input = $this->injcheck($input);
							$input = $this->encode($input);
							$sql = "INSERT INTO `$this->db`.`$tablename` (
									`id`, 
									`icid`, 
									`name`, 
									`value`
								)
								VALUES (
									NULL, 
									'$icid', 
									'$name',
									'$input'
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
		
		public function insicmoi($icid, $moi){
			$ret = FALSE;
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "icdump";
					$tex = $this->tex($tablename);
					if ($tex){
						foreach ($moi as $value){
							$name = $value['name'];
							$input = $value['input'];
							$name = $this->injcheck($name);
							$input = $this->injcheck($input);
							$input = $this->encode($input);
							$sql = "INSERT INTO `$this->db`.`$tablename` (
									`id`, 
									`icid`, 
									`name`, 
									`value`
								)
								VALUES (
									NULL, 
									'$icid', 
									'$name',
									'$input'
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
		
		public function insictopics($icid, $topics){
			$ret = FALSE;
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "icdump";
					$tex = $this->tex($tablename);
					if ($tex){
						foreach ($topics as $value1){
							foreach ($value1 as $key => $value){
								$key = $this->injcheck($key);
								$value = $this->injcheck($value);
								$value = $this->encode($value);
								$sql = "INSERT INTO `$this->db`.`$tablename` (
									`id`, 
									`icid`, 
									`name`, 
									`value`
								)
								VALUES (
									NULL, 
									'$icid', 
									'$key',
									'$value'
								)";
								$result = mysql_query($sql, $dbhandle);
								if ($result){
									$ret = TRUE;
									continue;
								}
								else{
									$ret = FALSE;
									break 2;
								}
							}
						}
					}
				}
			}
			return $ret;
		}
		
		public function insicdump($icid, $umc, $fuc, $fun, $info, $topics, $moi){
			$ret = FALSE;
			
			$res1 = $this->insicumc($icid, $umc, $fuc, $fun);
			if ($res1){
				$res2 = $this->insicinfo($icid, $info);
				if ($res2){
					$res3 = $this->insictopics($icid, $topics);
					if ($res3){
						$res4 = $this->insicmoi($icid, $moi);
						if ($res4){
							$ret = TRUE;
						}
					}
				}
			}
			return $ret;
		}
		
		public function insicsoap($icid, $soap){
			$ret = FALSE;
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "icsoap";
					$tex = $this->tex($tablename);
					if ($tex){
						foreach ($soap as $value1){
							foreach ($value1 as $value2){
								$name = $value2['name'];
								$value = $value2['input'];
								$name = $this->injcheck($name);
								$value = $this->injcheck($value);
								$value = $this->encode($value);
								$sql = "INSERT INTO `$this->db`.`$tablename` (
									`id`, 
									`icid`, 
									`name`, 
									`value`
								)
								VALUES (
									NULL, 
									'$icid', 
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
									break 2;
								}
							}
						}
					}
				}
			}
			return $ret;
		}
		
		public function upiclog($icid){
			$ret = FALSE;
			
			$uname = $_SESSION['uname'];
			$ipadd = $_SESSION['ipadd'];
			$timeformat = "d-m-Y G-i-s";
			$dts = date($timeformat);
			$dts = (string)$dts;
			$dts = $this->encode($dts);
			$action = "cric";
			$action = $this->encode($action);
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "iclog";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "INSERT INTO `$this->db`.`$tablename` (
							`id`, 
							`uname`, 
							`ipadd`, 
							`dts`, 
							`action`, 
							`icid`
						)
						VALUES (
							NULL, 
							'$uname', 
							'$ipadd', 
							'$dts', 
							'$action', 
							'$icid'
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
		
		public function cric($input){
			$ret = FALSE;
			
			$res1 = $this->insicmain($input['general']['conid']);
			if ($res1){
				$icid = $this->getlastinsertid();
				$res2 = $this->insicdump($icid, $input['general']['umc'], $input['general']['fuc'], $input['general']['fun'], $input['info'] ,$input['topics'], $input['moi']);
				if ($res2){
					$res3 = $this->insicsoap($icid, $input['soap']);
					if ($res3){
						$res4 = $this->upiclog($icid);
						if ($res4){
							$ret = TRUE;
						}
					}
				}
			}
			return $ret;
		}
		
	}
?>