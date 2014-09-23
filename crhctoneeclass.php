<?php
	include "dbclass.php";
    class crhctonee extends db{
    	
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
    	
		private function hctoneeex($hctonee, $constypeid){
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
						$tablename = "hctonee";
						$tex = $this->tex($tablename);
						if ($tex){
							$sql = "SELECT * FROM `$this->db`.`$tablename` WHERE `$tablename`.`hctonee` = '$hctonee' AND `$tablename`.`constypeid` = '$constypeid' AND `$tablename`.`status` = '$active'";
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
		
		public function checkhctoneename($name){
			$ret = FALSE;
			
			$active = "active";
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "hctonee";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT * FROM `$this->db`.`$tablename` WHERE `$tablename`.`tname` = '$name' AND `$tablename`.`status` = '$active'";
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
		
		public function checkspace($name){
			$ret = FALSE;
			
			if ( preg_match('/\s/',$name)){
				$ret = TRUE;
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
		
		public function vhctonee($hctonee, $constypeid){
			$ret = "";
			
			if ($hctonee == ""){
				$ret = "Hctonee cannot be empty";
			}
			else{
				if (strlen($hctonee) > 90){
					$ret = "Hctonee cannot be more than 90 characters";
				}
				else{
					if ($this->hctoneeex($hctonee, $constypeid)){
						$ret = "This Hctonee already exists";
					}
				}
			}
			return $ret;
		}
		
		public function vname($name){
			$ret = "";
			
			if ($name == ""){
				$ret = "Name cannot be empty";
			}
			else{
				if (strlen($name) > 90){
					$ret = "Name cannot be more than 90 characters";
				}
				else{
						if ($this->checkspace($name)){
							$ret = "Name cannot contain spaces";
						}
					else{
						if ($this->checkhctoneename($name)){
							$ret = "This Name already exists";
						}
					}
				}
			}
			return $ret;
		}
		
		public function vtype($type){
			$ret = "";
			
			if ($type == "0"){
				$ret = "Please select type";
			}
			
			return $ret;
		}
		
		public function vbval($bval){
			$ret = "";
			
			if ($bval == ""){
				$ret = "Base Value cannot be empty";
			}
			else{
				if (strlen($bval) > 90){
					$ret = "Base Value cannot be more than 90 characters";
				}
				else{
						if ($this->checkspace($bval)){
							$ret = "Base value cannot contain spaces";
						}
					else{
						if (!is_numeric($bval)){
							$ret = "Base value has to be numeric";
						}
					}
				}
			}
			return $ret;
		}
		
		public function crhctonee1($constypeid, $hctonee, $name, $type, $bval){
			$ret = FALSE;
			
			$tid = $name;
			$tclass = "cl".(string)$constypeid;
			$active = "active";
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "hctonee";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "INSERT INTO `$this->db`.`$tablename` (
							`id`, 
							`constypeid`, 
							`hctonee`, 
							`ttype`, 
							`tname`, 
							`tid`, 
							`tclass`, 
							`bval`, 
							`status`
						)
						VALUES (
							NULL, 
							'$constypeid', 
							'$hctonee', 
							'$type', 
							'$name', 
							'$tid', 
							'$tclass', 
							'$bval', 
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
		
		public function uphctoneelog($uname, $ipadd, $dts, $action, $hctoneeid){
			$ret = FALSE;
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "hctoneelog";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "INSERT INTO `$this->db`.`$tablename` (
							`id`, 
							`uname`, 
							`ipadd`, 
							`dts`, 
							`action`, 
							`hctoneeid`
						)
						VALUES (
							NULL, 
							'$uname', 
							'$ipadd', 
							'$dts', 
							'$action', 
							'$hctoneeid'
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