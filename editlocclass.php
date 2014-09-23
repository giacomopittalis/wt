<?php
	include "dbclass.php";
    class editloc extends db{
    	
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
				print "<select name=\"lc\" id=\"sel1\" tabindex=\"1\" onChange = \"getloc();\">";
					print "<option value =\"0\">Select Client</option>";
					foreach ($res as $value){
						print "<option value=\"".$value['clid']."\">".$value['clname']."</option>";
					}
				print "</select>";
			}
		}
		
		private function getcurloclist($clid){
			$ret = array();
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "clientloc";
					$tex = $this->tex($tablename);
					if ($tex){
						$active = "active";
						$eactive = $this->encode($active);
						$sql = "SELECT `$tablename`.`id`, `$tablename`.`locid` FROM `$this->db`.`$tablename` WHERE `$tablename`.`clid` = '$clid' AND `$tablename`.`status` = '$eactive'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$i = 0;
								while ($resarr = mysql_fetch_assoc($result)){
									$ret[$i]['id'] = $resarr['id'];
									$ret[$i]['locid'] = $this->decode($resarr['locid']);
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
		
		public function printcurloclist($clid){
			
			if ($clid == "0"){
				print "<select name=\"lid\" id=\"sel2\" tabindex=\"2\" >";
					print "<option value =\"0\">Select Client First</option>";
				print "</select>";
			}
			else{
				$res = $this->getcurloclist($clid);
				if ($res[0] == "0"){
					print "<select name=\"lid\" id=\"sel2\" tabindex=\"2\" >";
						print "<option value =\"0\">This client has no locations</option>";
					print "</select>";
				}
				else{
					print "<select name=\"lid\" id=\"sel2\" tabindex=\"2\" >";
						print "<option value =\"0\">Select Location</option>";
						foreach ($res as $value){
							print "<option value=\"".$value['id']."\">".$value['locid']."</option>";
						}
					print "</select>";
				}
			}
		}
		
		public function getjsonarr($locid){
			$retarr = array();
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "clientloc";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT * FROM `$this->db`.`$tablename` WHERE `$tablename`.`id` = '$locid'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							$resarr = mysql_fetch_assoc($result);
							$retarr[0]['field'] = "street";
							$retarr[0]['value'] = $this->decode($resarr['street']);
							$retarr[1]['field'] = "city";
							$retarr[1]['value'] = $this->decode($resarr['city']);
							$retarr[2]['field'] = "zip";
							$retarr[2]['value'] = $this->decode($resarr['zip']);
							$retarr[3]['field'] = "state";
							$retarr[3]['value'] = $this->decode($resarr['state']);
						}
					}
				}
			}
			return $retarr;
		}
    	
		public function cleaninput($input){
			$ret = "";
			$q = ENT_NOQUOTES;
			
			$ret = trim($input);
			$ret = htmlspecialchars($ret, $q);
			
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
			
			if ($locid == "0"){
				$ret = "Please select location";
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
		
		public function getlocid($id){
			$ret = "";
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "clientloc";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT `$tablename`.`locid` FROM `$this->db`.`$tablename` WHERE `$tablename`.`id` = '$id'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$resarr = mysql_fetch_assoc($result);
								$ret = $resarr['locid'];
							}
						}
					}
				}
			}
			return $ret;
		}
		
		public function editloc1($locid, $street, $city, $zip, $state){
			$ret = FALSE;
			
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
						
						$estreet = $this->injcheck($estreet);
						$ecity = $this->injcheck($ecity);
						$ezip = $this->injcheck($ezip);
						$estate = $this->injcheck($estate);
						
						$sql = "UPDATE `$this->db`.`$tablename` SET `$tablename`.`street` = '$estreet', `$tablename`.`city` = '$ecity', `$tablename`.`zip` = '$ezip', `$tablename`.`state` = '$estate' WHERE `$tablename`.`id` = '$locid'";
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