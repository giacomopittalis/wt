<?php
	include 'dbclass.php';
    class usercp extends db{
    	
		public function cleaninput($input){
			$ret = "";
			$q = ENT_NOQUOTES;
			
			$ret = trim($input);
			$ret = htmlspecialchars($ret, $q);
			
			return $ret;
		}
    	
		public function validateopass($euname, $opass){
			$ret = FALSE;
				
			$eopass = $this->encode($opass);
				
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "user";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT `$tablename`.`pass` FROM `$this->db`.`$tablename` WHERE `$tablename`.`uname` = '$euname'";
							$result = mysql_query($sql, $dbhandle);
							if ($result){
								if (mysql_num_rows($result) > 0){
									$resarr = mysql_fetch_assoc($result);
									if ($eopass == $resarr['pass']){
										$ret = TRUE;
									}
								}
							}
						}
					}
				}
			return $ret;
		}
		
		public function vpass($pass){
			$ret = "";
			if ($pass == ""){
				$ret = "Password cannot be empty";
			}
			else{
				if (strlen($pass) > 20){
					"Password cannot be more than 20 characters";
				}
				else{
					if (strlen($pass) < 8){
						$ret = "Password must be atleast 8 characters long";
					}
				}
			}
			return $ret;
		}
		
		public function vpassx($pass, $passx){
			$ret = "";
			if ($pass != $passx){
				$ret = "Passwords do not match";
			}
			return $ret;
		}
    	
    	
		
		public function usercp1($euname, $npass){
			$ret = FALSE;
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "user";
					$tex = $this->tex($tablename);
					if ($tex){
						$npass = $this->injcheck($npass);
						$enpass = $this->encode($npass);
						$sql1 = "UPDATE `$this->db`.`$tablename` SET `$tablename`.`pass` = '$enpass' WHERE `$tablename`.`uname` = '$euname'";
						$result1 = mysql_query($sql1, $dbhandle);
						if ($result1){
							$ret = TRUE;
						}
					}
				}
			}
			return $ret;
		}
		
		public function upcplog($suname, $ipadd, $dts){
			$ret = FALSE;
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "cplog";
					$tex = $this->tex($tablename);
					if ($tex){
						$suname = $this->injcheck($suname);
						$ipadd = $this->injcheck($ipadd);
						$dts = $this->injcheck($dts);
						$sql = "INSERT INTO `$this->db`.`$tablename` (
							`id`, 
							`uname`,
							`ipadd`,
							`dts`
						)
						VALUES(
							NULL,
							'$suname', 
							'$ipadd',
							'$dts'
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