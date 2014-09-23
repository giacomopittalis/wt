<?php
	include 'dbclass.php';
    class lock extends db{
    	
    	private function getactivelist(){
    		$ret = array();
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "user";
					$tex = $this->tex($tablename);
					if ($tex){
						$active = "active";
						$eactive = $this->encode($active);
						$sql = "SELECT `$tablename`.`uname`,  `$tablename`.`fname`, `$tablename`.`lname` FROM `$this->db`.`$tablename` WHERE `$tablename`.`status1` = '$eactive'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$i = 0;
								while ($resarr = mysql_fetch_assoc($result)){
									$ret[$i]['uname'] = $this->decode($resarr['uname']);
									$ret[$i]['caption'] = $this->decode($resarr['fname'])." - ".$this->decode($resarr['lname'])." - ".$this->decode($resarr['uname']);
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
		
		public function printactivelist(){
			$res = $this->getactivelist();
			
			if ($res[0] == "0"){
				print "<select name=\"lu\" id=\"sel1\" tabindex=\"1\" >";
					print "<option value =\"0\">Select User</option>";
				print "</select>";
			}
			else{
				print "<select name=\"lu\" id=\"sel1\" tabindex=\"1\" >";
					print "<option value =\"0\">Select User</option>";
					foreach ($res as $value){
						print "<option value=\"".$value['uname']."\">".$value['caption']."</option>";
					}
				print "</select>";
			}
		}
		
		//Validate input
		public function vuname($uname){
			$ret = "";
			if ($uname == "0"){
				$ret = "Please Select a user";
			}
			return $ret;
		}
		
		public function lockuser($uname){
			$ret = FALSE;
			$euname = $this->encode($uname);
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "user";
					$tex = $this->tex($tablename);
					if ($tex){
						$locked = "locked";
						$elocked = $this->encode($locked);
						$sql1 = "UPDATE `$this->db`.`$tablename` SET `$tablename`.`status1` = '$elocked' WHERE `$tablename`.`uname` = '$euname'";
						$result1 = mysql_query($sql1, $dbhandle);
						if ($result1){
							$ret = TRUE;
						}
					}
				}
			}
			return $ret;
		}
		
		public function uplocklog($suname, $ipadd, $dts, $uname){
			$ret = FALSE;
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "locklog";
					$tex = $this->tex($tablename);
					if ($tex){
						$suname = $this->injcheck($suname);
						$ipadd = $this->injcheck($ipadd);
						$dts = $this->injcheck($dts);
						$uname = $this->injcheck($uname);
						$sql = "INSERT INTO `$this->db`.`$tablename` (
							`id`, 
							`uname`,
							`ipadd`,
							`dts`,
							`luname`
						)
						VALUES(
							NULL,
							'$suname', 
							'$ipadd',
							'$dts', 
							'$uname'
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