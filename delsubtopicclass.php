<?php
	include "dbclass.php";
    class delsubtopic extends db{
    	
		public function cleaninput($input){
			$ret = "";
			$q = ENT_NOQUOTES;
			
			$ret = trim($input);
			$ret = htmlspecialchars($ret, $q);
			
			return $ret;
		}
		
		private function getconstypelist(){
			$ret = array();
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "constype";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT * FROM `$this->db`.`$tablename`";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$i = 0;
								while ($resarr = mysql_fetch_assoc($result)){
									$ret[$i]['id'] = $resarr['id'];
									$ret[$i]['constype'] = $resarr['constype'];
									$i++;
								}
							}
						}
					}
				}
			}
			return $ret;
		}
		
		public function printinitconstypelist(){
			
			if (isset($_SESSION['constype']) && $_SESSION['constype'] != "" && $_SESSION['constype'] != "0"){
				$sel = $_SESSION['constype'];
			}
			else{
				$sel = "0";
			}
			
			$res = $this->getconstypelist();
			
			if (empty($res)){
				print "<select name=\"constype\" id=\"sel1\" tabindex=\"1\" onchange=\"gettopic();\">";
					print "<option value=\"0\">Select Consult Type</option>";
				print "</select>";
			}
			else{
				print "<select name=\"constype\" id=\"sel1\" tabindex=\"1\" onchange=\"gettopic();\">";
					print "<option value=\"0\">Select Consult Type</option>";
					foreach ($res as $value){
						if ($value['id'] == $sel){
							print "<option value=\"".$value['id']."\" selected=\"selected\">".$value['constype']."</option>";
						}
						else{
							print "<option value=\"".$value['id']."\">".$value['constype']."</option>";
						}
					}
				print "</select>";
			}
		}
    	
		public function gettopiclist($constypeid){
			$ret = array();
			
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
									$i++;
								}
							}
						}
					}
				}
			}
			return $ret;
		}
		
		public function printtopiclist($constypeid){
			if ($constypeid == "0"){
				print "<select name=\"topic\" id=\"sel2\" tabindex=\"2\" onchange=\"getsubtopic();\">";
					print "<option value=\"0\">Select Topic</option>";
				print "</select>";
			}
			else{
				$res = $this->gettopiclist($constypeid);
				if (empty($res)){
					print "<select name=\"topic\" id=\"sel2\" tabindex=\"2\" onchange=\"getsubtopic();\">";
						print "<option value=\"0\">Select Topic</option>";
					print "</select>";
				}
				else{
					print "<select name=\"topic\" id=\"sel2\" tabindex=\"2\" onchange=\"getsubtopic();\">";
						print "<option value=\"0\">Select Topic</option>";
						foreach ($res as $value){
							print "<option value=\"".$value['id']."\">".$value['topic']."</option>";
						}
					print "</select>";
				}
			}
		}
		
		public function printinittopiclist(){
			if (isset($_SESSION['constype']) && $_SESSION['constype'] != "" && $_SESSION['constype'] != "0"){
				$constypeid = $_SESSION['constype'];
			}
			else{
				$constypeid = "0";
			}
			
			if (isset($_SESSION['topic']) && $_SESSION['topic'] != "" && $_SESSION['topic'] != "0"){
				$topicid = $_SESSION['topic'];
			}
			else{
				$topicid = "0";
			}
			
			if ($constypeid == "0"){
				print "<select name=\"topic\" id=\"sel2\" tabindex=\"2\" onchange=\"getsubtopic();\">";
					print "<option value=\"0\">Select Topic</option>";
				print "</select>";
			}
			else{
				$res = $this->gettopiclist($constypeid);
				if (empty($res)){
					print "<select name=\"topic\" id=\"sel2\" tabindex=\"2\" onchange=\"getsubtopic();\">";
						print "<option value=\"0\">Select Topic</option>";
					print "</select>";
				}
				else{
					print "<select name=\"topic\" id=\"sel2\" tabindex=\"2\" onchange=\"getsubtopic();\">";
						print "<option value=\"0\">Select Topic</option>";
						foreach ($res as $value){
							if ($value['id'] == $topicid){
								print "<option value=\"".$value['id']."\" selected=\"selected\">".$value['topic']."</option>";
							}
							else{
								print "<option value=\"".$value['id']."\">".$value['topic']."</option>";
							}
						}
					print "</select>";
				}
			}
		}

		public function getsubtopiclist($constypeid, $topicid){
			$ret = array();
			
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
									$i++;
								}
							}
						}
					}
				}
			}
			return $ret;
		}
		
		public function printsubtopiclist($constypeid, $topicid){
			if ($constypeid == "0" || $topicid == "0"){
				print "<select name=\"subtopic\" id=\"sel3\" tabindex=\"3\">";
					print "<option value=\"0\">Select Sub Topic</option>";
				print "</select>";
			}
			else{
				$res = $this->getsubtopiclist($constypeid, $topicid);
				if (empty($res)){
					print "<select name=\"subtopic\" id=\"sel3\" tabindex=\"3\">";
						print "<option value=\"0\">Select Sub Topic</option>";
					print "</select>";
				}
				else{
					print "<select name=\"subtopic\" id=\"sel3\" tabindex=\"3\">";
						print "<option value=\"0\">Select Sub Topic</option>";
						foreach ($res as $value){
							print "<option value=\"".$value['id']."\">".$value['subtopic']."</option>";
						}
					print "</select>";
				}
			}
		}
		
		public function printinitsubtopiclist(){
			if (isset($_SESSION['constype']) && $_SESSION['constype'] != "" && $_SESSION['constype'] != "0"){
				$constypeid = $_SESSION['constype'];
			}
			else{
				$constypeid = "0";
			}
			
			if (isset($_SESSION['topic']) && $_SESSION['topic'] != "" && $_SESSION['topic'] != "0"){
				$topicid = $_SESSION['topic'];
			}
			else{
				$topicid = "0";
			}
			
			if (isset($_SESSION['subtopic']) && $_SESSION['subtopic'] != "" && $_SESSION['subtopic'] != "0"){
				$subtopicid = $_SESSION['subtopic'];
			}
			else{
				$subtopicid = "0";
			}
			
			if ($constypeid == "0" || $topicid == "0"){
				print "<select name=\"subtopic\" id=\"sel3\" tabindex=\"3\">";
					print "<option value=\"0\">Select Sub Topic</option>";
				print "</select>";
			}
			else{
				$res = $this->getsubtopiclist($constypeid, $topicid);
				if (empty($res)){
					print "<select name=\"subtopic\" id=\"sel3\" tabindex=\"3\">";
						print "<option value=\"0\">Select Sub Topic</option>";
					print "</select>";
				}
				else{
					print "<select name=\"subtopic\" id=\"sel3\" tabindex=\"3\">";
						print "<option value=\"0\">Select Sub Topic</option>";
						foreach ($res as $value){
							if ($value['id'] == $subtopicid){
								print "<option value=\"".$value['id']."\" selected=\"selected\">".$value['subtopic']."</option>";
							}
							else{
								print "<option value=\"".$value['id']."\">".$value['subtopic']."</option>";
							}
						}
					print "</select>";
				}
			}
		}
		
		public function vconstypeid($constypeid){
			$ret = "";
			
			if ($constypeid == "0"){
				$ret = "Please select consult type";
			}
			
			return $ret;
		}
		
		public function vtopic($topicid){
			$ret = "";
			
			if ($topicid == "0"){
				$ret = "Please select a topic";
			}
			return $ret;
		}
		
		public function vsubtopicid($subtopicid){
			$ret = "";
			
			if ($subtopicid == "0"){
				$ret = "Please select a subtopic";
			}
			return $ret;
		}
		
		public function delsubtopic1($subtopicid){
			$ret = FALSE;
			
			$deleted = "deleted";
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "subtopic";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "UPDATE `$this->db`.`$tablename` SET `$tablename`.`status` = '$deleted' WHERE `$tablename`.`id` = '$subtopicid'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							$ret = TRUE;
						}
					}
				}
			}
			return $ret;
		}
		
		public function upsubtopiclog($uname, $ipadd, $dts, $action, $subtopicid){
			$ret = FALSE;
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "subtopiclog";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "INSERT INTO `$this->db`.`$tablename` (
							`id`, 
							`uname`, 
							`ipadd`, 
							`dts`, 
							`action`, 
							`subtopicid`
						)
						VALUES (
							NULL, 
							'$uname', 
							'$ipadd', 
							'$dts', 
							'$action', 
							'$subtopicid'
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