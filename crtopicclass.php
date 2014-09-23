<?php
	include "dbclass.php";
    class crtopic extends db{
    	
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
				print "<select name=\"constype\" id=\"sel1\" tabindex=\"1\">";
					print "<option value=\"0\">Select Consult Type</option>";
				print "</select>";
			}
			else{
				print "<select name=\"constype\" id=\"sel1\" tabindex=\"1\">";
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
    	
		private function topicex($topic, $constypeid){
			$ret = FALSE;
			
			$active = "active";
			
			if ($constypeid == "0"){
				$ret = TRUE;
			}
			else{
				$dbhandle = $this->dbhandle();
				if ($dbhandle){
					$dbfound = $this->dbfound();
					if ($dbfound){
						$tablename = "topic";
						$tex = $this->tex($tablename);
						if ($tex){
							$sql = "SELECT * FROM `$this->db`.`$tablename` WHERE `$tablename`.`topic` = '$topic' AND `$tablename`.`constypeid` = '$constypeid' AND `$tablename`.`status` = '$active'";
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
		
		public function vtopic($topic, $constypeid){
			$ret = "";
			
			if ($topic == ""){
				$ret = "Topic cannot be empty";
			}
			else{
				if (strlen($topic) > 90){
					$ret = "Topic cannot be more than 90 characters";
				}
				else{
					if ($this->topicex($topic, $constypeid)){
						$ret = "This topic already exists";
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
		
		public function checktopicid($topicid){
			$ret = FALSE;
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "topic";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT * FROM `$this->db`.`$tablename` WHERE `$tablename`.`tid` = '$topicid'";
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
		
		public function checktopicname($tname){
			$ret = FALSE;
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "topic";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT * FROM `$this->db`.`$tablename` WHERE `$tablename`.`tname` = '$tname'";
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
		
		public function gettopicid(){
			$ret = "";
			$length = 3;
			$rando = $this->rando($length);
			$rando = (string)$rando;
			$topicid = "id".$rando;
			$check = $this->checktopicid($topicid);
			if ($check){
				$this->gettopicid();
			}
			else{
				$ret = $topicid;
			}
			return $ret;
		}
		
		public function gettopicname(){
			$ret = "";
			$length = 4;
			$rando = $this->rando($length);//Generates a random string
			$rando = (string)$rando;
			$tname = "nm".$rando;
			$check = $this->checktopicname($tname);//Checks if tname already exists in the database
			if ($check){
				$this->gettopicname();
			}
			else{
				$ret = $tname;
			}
			return $ret;
		}
		
		public function crtopic1($constypeid, $topic){
			$ret = FALSE;
			
			$ttype = "checkbox";
			$tname = $this->gettopicname();
			$tid = $this->gettopicid();
			$tclass = "cl".(string)$constypeid;
			$active = "active";
			if (!empty($tname) && !empty($tid)){
				$dbhandle = $this->dbhandle();
				if ($dbhandle){
					$dbfound = $this->dbfound();
					if ($dbfound){
						$tablename = "topic";
						$tex = $this->tex($tablename);
						if ($tex){
							$sql = "INSERT INTO `$this->db`.`$tablename` (
								`id`, 
								`constypeid`, 
								`topic`, 
								`ttype`, 
								`tname`, 
								`tid`, 
								`tclass`, 
								`status`
							)
							VALUES (
								NULL, 
								'$constypeid', 
								'$topic', 
								'$ttype', 
								'$tname', 
								'$tid', 
								'$tclass', 
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
		
		public function uptopiclog($uname, $ipadd, $dts, $action, $topicid){
			$ret = FALSE;
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "topiclog";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "INSERT INTO `$this->db`.`$tablename` (
							`id`, 
							`uname`, 
							`ipadd`, 
							`dts`, 
							`action`, 
							`topicid`
						)
						VALUES (
							NULL, 
							'$uname', 
							'$ipadd', 
							'$dts', 
							'$action', 
							'$topicid'
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