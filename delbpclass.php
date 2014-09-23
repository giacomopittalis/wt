<?php
	include "dbclass.php";
    class delbp extends db{
    	
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
		
		public function vbpid($bpid){
			$ret = "";
			
			if ($bpid == "0"){
				$ret = "Please select a bodypart";
			}
			return $ret;
		}
		
		public function delbp1($bpid){
			$ret = FALSE;
			
			$deleted = "deleted";
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "bodypart";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "UPDATE `$this->db`.`$tablename` SET `$tablename`.`status` = '$deleted' WHERE `$tablename`.`id` = '$bpid'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							$ret = TRUE;
						}
					}
				}
			}
			return $ret;
		}
		
		public function upbplog($uname, $ipadd, $dts, $action, $bpid){
			$ret = FALSE;
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "bplog";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "INSERT INTO `$this->db`.`$tablename` (
							`id`, 
							`uname`, 
							`ipadd`, 
							`dts`, 
							`action`, 
							`bpid`
						)
						VALUES (
							NULL, 
							'$uname', 
							'$ipadd', 
							'$dts', 
							'$action', 
							'$bpid'
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