<?php
	include "dbclass.php";
    class editclient extends db{
    	
		private function getcurclientlist(){
    		$ret = array();
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "client";
					$tex = $this->tex($tablename);
					if ($tex){
						$deleted = "deleted";
						$edeleted = $this->encode($deleted);
						$sql = "SELECT `$tablename`.`id`,  `$tablename`.`clname` FROM `$this->db`.`$tablename` WHERE `$tablename`.`status` != '$edeleted'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$i = 0;
								while ($resarr = mysql_fetch_assoc($result)){
									$ret[$i]['clid'] = $resarr['id'];
									$ret[$i]['clname'] = $this->decode($resarr['clname']);
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
		
		public function printcurclientlist(){
			$res = $this->getcurclientlist();
			
			if ($res[0] == "0"){
				print "<select name=\"lc\" id=\"sel1\" tabindex=\"1\" >";
					print "<option value =\"0\">Select Client</option>";
				print "</select>";
			}
			else{
				print "<select name=\"lc\" id=\"sel1\" tabindex=\"1\" >";
					print "<option value =\"0\">Select Client</option>";
					foreach ($res as $value){
						print "<option value=\"".$value['clid']."\">".$value['clname']."</option>";
					}
				print "</select>";
			}
		}
    	
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
		
		public function vclid($clid){
			$ret = "";
			
			if ($clid == "n"){
				$ret = "Please select a client";
			}
			
			return $ret;
		}
		
		public function editclient1($clid, $clname){
			$ret = FALSE;
			
			$eclname = $this->encode($clname);
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "client";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "UPDATE `$this->db`.`$tablename` SET `$tablename`.`clname` = '$eclname' WHERE `$tablename`.`id` = '$clid'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							$ret = TRUE;
						}
					}
				}
			}
			return $ret;
		}
		
		public function upclientlog($uname, $ipadd, $dts, $action, $clid){
			$ret = FALSE;
			
			$euname = $uname;
			$eipadd = $ipadd;
			$edts = $this->encode($dts);
			$eaction = $this->encode($action);
			
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
		
		public function getjsonarr ($clid){
			$ret = array();
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "client";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT `$tablename`.`clname` FROM `$this->db`.`$tablename` WHERE `$tablename`.`id` = '$clid'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$resarr = mysql_fetch_assoc($result);
								$ret[0]['field'] = "clname";
								$ret[0]['value'] = $this->decode($resarr['clname']);
							}
						}
					}
				}
			}
			return $ret;
		}
		
    }

?>