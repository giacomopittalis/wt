<?php
	include "dbclass.php";
    class crclient extends db{
    	
		public function cleaninput($input){
			$ret = "";
			$q = ENT_NOQUOTES;
			
			$ret = trim($input);
			$ret = htmlspecialchars($ret, $q);
			
			return $ret;
		}
    	
		private function clientex($clname){
			$ret = FALSE;
			
			$eclname = $this->encode($clname);
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "client";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT * FROM `$this->db`.`$tablename` WHERE `$tablename`.`clname` = '$eclname'";
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
		
		public function vclname($clname){
			$ret = "";
			
			if ($clname == ""){
				$ret = "Client name cannot be empty";
			}
			else{
				if (strlen($clname) > 60){
					$ret = "Client name cannot be more than 60 characters";
				}
				else{
					if ($this->clientex($clname)){
						$ret = "This client already exists";
					}
				}
			}
			return $ret;
		}
		
		public function crclient1($clname){
			$ret = FALSE;
			
			$eclname = $this->encode($clname);
			$active = "active";
			$eactive = $this->encode($active);
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "client";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "INSERT INTO `$this->db`.`$tablename` (
							`id`, 
							`clname`, 
							`status`
						)
						VALUES (
							NULL, 
							'$eclname', 
							'$eactive'
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
		
		private function getclid ($clname){
			$ret = "";
			
			$eclname = $this->encode($clname);
			
			$dbhandle =  $this->dbhandle();
			if ($dbhandle){
				$dbfound =  $this->dbfound();
				if ($dbfound){
					$tablename = "client";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT `$tablename`.`id` FROM  `$this->db`.`$tablename` WHERE `$tablename`.`clname` = '$eclname'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$resarr = mysql_fetch_assoc($result);
								$ret = $resarr['id'];
							}
						}
					}
				}
			}
			return $ret;
		}
		
		public function upclientlog($uname, $ipadd, $dts, $action, $clname){
			$ret = FALSE;
			
			$euname = $uname;
			$eipadd = $ipadd;
			$edts = $this->encode($dts);
			$eaction = $this->encode($action);
			$clid = $this->getclid($clname);
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "clientlog";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "INSERT INTO `$this->db`.`$tablename` (
							`id`, 
							`uname`, 
							`ipadd`, 
							`dts`, 
							`action`, 
							`clid`
						)
						VALUES (
							NULL, 
							'$euname', 
							'$eipadd', 
							'$edts', 
							'$eaction', 
							'$clid'
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