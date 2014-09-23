<?php
	include "dbclass.php";
    class crsubtopic extends db{
    	
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
				print "<select name=\"topic\" id=\"sel2\" tabindex=\"2\">";
					print "<option value=\"0\">Select Topic</option>";
				print "</select>";
			}
			else{
				$res = $this->gettopiclist($constypeid);
				if (empty($res)){
					print "<select name=\"topic\" id=\"sel2\" tabindex=\"2\">";
						print "<option value=\"0\">Select Topic</option>";
					print "</select>";
				}
				else{
					print "<select name=\"topic\" id=\"sel2\" tabindex=\"2\">";
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
				print "<select name=\"topic\" id=\"sel2\" tabindex=\"2\">";
					print "<option value=\"0\">Select Topic</option>";
				print "</select>";
			}
			else{
				$res = $this->gettopiclist($constypeid);
				if (empty($res)){
					print "<select name=\"topic\" id=\"sel2\" tabindex=\"2\">";
						print "<option value=\"0\">Select Topic</option>";
					print "</select>";
				}
				else{
					print "<select name=\"topic\" id=\"sel2\" tabindex=\"2\">";
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

		private function subtopicex($constypeid, $topicid, $subtopic){
			$ret = FALSE;
			
			$active = "active";
			
			if ($constypeid == "0" || $topicid == "0"){
				$ret = TRUE;
			}
			else{
				$dbhandle = $this->dbhandle();
				if ($dbhandle){
					$dbfound = $this->dbfound();
					if ($dbfound){
						$tablename = "subtopic";
						$tex = $this->tex($tablename);
						if ($tex){
							$sql = "SELECT * FROM `$this->db`.`$tablename` WHERE `$tablename`.`subtopic` = '$subtopic' AND `$tablename`.`topicid` = '$topicid' AND `$tablename`.`constypeid` = '$constypeid' AND `$tablename`.`status` = '$active'";
							$result = mysql_query($sql, $dbhandle);
							if ($result){
								if (mysql_num_rows($result) > 0){
									$ret = TRUE;
								}
							}
						}
					}
				}
			}
			return $ret;
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
		
		public function vsubtopic($constypeid, $topicid, $subtopic){
			$ret = "";
			
			if ($subtopic == ""){
				$ret = "Sub Topic cannot be empty";
			}
			else{
				if (strlen($subtopic) > 90){
					$ret = "Sub Topic cannot be more than 90 characters";
				}
				else{
					if ($this->subtopicex($constypeid, $topicid, $subtopic)){
						$ret = "This sub topic already exists";
					}
				}
			}
			return $ret;
		}
		
		public function rando($length){
			$random= "";
  			srand((double)microtime()*1000000);
  			$char_list = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  			$char_list .= "abcdefghijklmnopqrstuvwxyz";
  			$char_list .= "1234567890";
  			// Add the special characters to $char_list if needed

  			for($i = 0; $i < $length; $i++)  
  			{    
     			$random .= substr($char_list,(rand()%(strlen($char_list))), 1);  
  			}  
  			return $random;
		}
		
		public function checksubtopicid($subtopicid){
			$ret = FALSE;
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "subtopic";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT * FROM `$this->db`.`$tablename` WHERE `$tablename`.`sid` = '$subtopicid'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$ret = TRUE;
							}
						}
					}
				}
			}
			return $ret;
		}
		
		public function checksubtopicname($sname){
			$ret = FALSE;
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "subtopic";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT * FROM `$this->db`.`$tablename` WHERE `$tablename`.`sname` = '$sname'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$ret = TRUE;
							}
						}
					}
				}
			}
			return $ret;
		}
		
		public function getsubtopicid(){
			$ret = "";
			$length = 4;
			$rando = $this->rando($length);
			$rando = (string)$rando;
			$subtopicid = "id".$rando;
			$check = $this->checksubtopicid($subtopicid);
			if ($check){
				$this->getsubtopicid();
			}
			else{
				$ret = $subtopicid;
			}
			return $ret;
		}
		
		public function getsubtopicname(){
			$ret = "";
			$length = 4;
			$rando = $this->rando($length);
			$rando = (string)$rando;
			$sname = "nm".$rando;
			$check = $this->checksubtopicname($sname);
			if ($check){
				$this->getsubtopicname();
			}
			else{
				$ret = $sname;
			}
			return $ret;
		}
		
		public function crsubtopic1($constypeid, $topicid, $subtopic){
			$ret = FALSE;
			
			$stype = "checkbox";
			$sname = $this->getsubtopicname();
			$sid = $this->getsubtopicid();
			$sclass = "cl".(string)$constypeid.(string)$topicid;
			$active = "active";
			
			if (!empty($sname) && !empty($sid)){
				$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "subtopic";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "INSERT INTO `$this->db`.`$tablename` (
							`id`, 
							`constypeid`, 
							`topicid`, 
							`subtopic`,
							`stype`, 
							`sname`, 
							`sid`, 
							`sclass`, 
							`status`
						)
						VALUES (
							NULL, 
							'$constypeid', 
							'$topicid',
							'$subtopic', 
							'$stype', 
							'$sname', 
							'$sid', 
							'$sclass', 
							'$active'
						)";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							$ret = TRUE;
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