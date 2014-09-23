<?php
	include "dbclass.php";
    class crloc extends db{
    	
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
		
		private function locidex($locid){
			$ret = FALSE;
			
			$elocid = $this->encode($locid);
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "clientloc";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT * FROM `$this->db`.`$tablename` WHERE `$tablename`.`locid` = '$elocid'";
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
		
		public function vclid($clid){
			$ret = "";
			
			if ($clid == "0"){
				$ret = "Please select client";
			}
			return $ret;
		}
		
		public function vlocid($locid){
			$ret = "";
			
			if ($locid == ""){
				$ret = "Location ID cannot be empty";
			}
			else{
				if (strlen($locid) > 20){
					$ret = "Location ID cannot be more than 20 characters";
				}
				else{
					if ($this->locidex($locid)){
						$ret = "This Location ID already exists";
					}
				}
			}
			return $ret;
		}
		
		public function vstreet($street){
			$ret = "";
			
			if ($street == ""){
				$ret = "Street cannot be empty";
			}
			else{
				if (strlen($street) > 100){
					$ret = "Street cannot be more than 100 characters";
				}
			}
			return $ret;
		}
		
		public function vcity($city){
			$ret = "";
			
			if ($city == ""){
				$ret = "City cannot be empty";
			}
			else{
				if (strlen($city) > 50){
					$ret = "City cannot be more than 50 characters";
				}
			}
			return $ret;
		}
		
		public function vzip($zip){
			$ret = "";
			
			if ($zip == ""){
				$ret = "Zip cannot be empty";
			}
			else{
				if (strlen($zip) > 10){
					$ret = "Zip cannot be more than 10 characters";
				}
			}
			return $ret;
		}
		
		public function vstate($state){
			$ret = "";
			
			if ($state == "0"){
				$ret = "Please select state";
			}
			return $ret;
		}
		
		public function crloc1($clid, $locid, $street, $city, $zip, $state){
			$ret = FALSE;
			
			$active = "active";
			$eactive = $this->encode($active);
			
			$elocid = $this->encode($locid);
			$estreet = $this->encode($street);
			$ecity = $this->encode($city);
			$ezip = $this->encode($zip);
			$estate = $this->encode($state);
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "clientloc";
					$tex = $this->tex($tablename);
					if ($tex){
						
						$clid = $this->injcheck($clid);
						$elocid = $this->injcheck($elocid);
						$estreet = $this->injcheck($estreet);
						$ecity = $this->injcheck($ecity);
						$ezip = $this->injcheck($ezip);
						$estate = $this->injcheck($estate);
						
						$sql = "INSERT INTO `$this->db`.`$tablename` (
							`id`,
							`clid`, 
							`locid`, 
							`street`, 
							`city`, 
							`zip`,
							`state`, 
							`status`
						)
						VALUES(
							NULL, 
							'$clid', 
							'$elocid', 
							'$estreet', 
							'$ecity', 
							'$ezip', 
							'$estate',
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
		
		public function upclientloclog($uname, $ipadd, $dts, $action, $locid){
			$ret = FALSE;
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "clientloclog";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "INSERT INTO `$this->db`.`$tablename` (
							`id`, 
							`uname`, 
							`ipadd`, 
							`dts`, 
							`action`, 
							`locid`
						)
						VALUES(
							NULL, 
							'$uname', 
							'$ipadd', 
							'$dts', 
							'$action', 
							'$locid'
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