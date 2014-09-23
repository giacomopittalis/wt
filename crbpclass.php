<?php
	include "dbclass.php";
    class crbp extends db{
    	
		public function cleaninput($input){
			$ret = "";
			$q = ENT_NOQUOTES;
			
			$ret = trim($input);
			$ret = htmlspecialchars($ret, $q);
			
			return $ret;
		}
    	
		private function bpex($bp){
			$ret = FALSE;
			
			$active = "active";
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "bodypart";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT * FROM `$this->db`.`$tablename` WHERE `$tablename`.`bp` = '$bp' AND `$tablename`.`status` = '$active'";
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
		
		public function vbp($bp){
			$ret = "";
			
			if ($bp == ""){
				$ret = "Body part cannot be empty";
			}
			else{
				if (strlen($bp) > 90){
					$ret = "Body part cannot be more than 90 characters";
				}
				else{
					if ($this->bpex($bp)){
						$ret = "This body part already exists";
					}
				}
			}
			return $ret;
		}
		
		public function crbp1($bp){
			$ret = FALSE;
			
			$active = "active";
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "bodypart";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "INSERT INTO `$this->db`.`$tablename` (
							`id`, 
							`bp`, 
							`status`
						)
						VALUES (
							NULL, 
							'$bp', 
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