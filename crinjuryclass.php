<?php
	include "dbclass.php";
    class crinjury extends db{
    	
		public function cleaninput($input){
			$ret = "";
			$q = ENT_NOQUOTES;
			
			$ret = trim($input);
			$ret = htmlspecialchars($ret, $q);
			
			return $ret;
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
				print "<select name=\"bp\" id=\"sel1\" tabindex=\"1\">";
					print "<option value=\"0\">Select Body Part</option>";
				print "</select>";
			}
			else{
				print "<select name=\"bp\" id=\"sel1\" tabindex=\"1\">";
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
					print "<select name=\"bp\" id=\"sel1\" tabindex=\"1\">";
						print "<option value=\"0\">Select Body Part</option>";
					print "</select>";
				}
				else{
					print "<select name=\"bp\" id=\"sel1\" tabindex=\"1\">";
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
    	
		private function injuryex($injury, $bpid){
			$ret = FALSE;
			
			$active = "active";
			
			if ($bpid == "0"){
				$ret = TRUE;
			}
			else{
				$dbhandle = $this->dbhandle();
				if ($dbhandle){
					$dbfound = $this->dbfound();
					if ($dbfound){
						$tablename = "injury";
						$tex = $this->tex($tablename);
						if ($tex){
							$sql = "SELECT * FROM `$this->db`.`$tablename` WHERE `$tablename`.`ij` = '$injury' AND `$tablename`.`bpid` = '$bpid' AND `$tablename`.`status` = '$active'";
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
		
		public function vbpid($bpid){
			$ret = "";
			
			if ($bpid == "0"){
				$ret = "Please select body part";
			}
			
			return $ret;
		}
		
		public function vinjury($injury, $bpid){
			$ret = "";
			
			if ($injury == ""){
				$ret = "Injury cannot be empty";
			}
			else{
				if (strlen($injury) > 90){
					$ret = "Injury cannot be more than 90 characters";
				}
				else{
					if ($this->injuryex($injury, $bpid)){
						$ret = "This injury already exists";
					}
				}
			}
			return $ret;
		}
		
		
		
		public function crinjury1($bpid, $injury){
			$ret = FALSE;
			
			$active = "active";
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "injury";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "INSERT INTO `$this->db`.`$tablename` (
							`id`, 
							`bpid`, 
							`ij`,  
							`status`
						)
						VALUES (
							NULL, 
							'$bpid', 
							'$injury', 
							'$active'
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
		
		public function upijlog($uname, $ipadd, $dts, $action, $ijid){
			$ret = FALSE;
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "ijlog";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "INSERT INTO `$this->db`.`$tablename` (
							`id`, 
							`uname`, 
							`ipadd`, 
							`dts`, 
							`action`, 
							`ijid`
						)
						VALUES (
							NULL, 
							'$uname', 
							'$ipadd', 
							'$dts', 
							'$action', 
							'$ijid'
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