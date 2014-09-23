<?php
	include "dbclass.php";
    class delegr extends db{
    	
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
				print "<select name=\"lc\" id=\"sel1\" tabindex=\"1\" onChange = \"getguide();\">";
					print "<option value =\"0\">Select Client</option>";
					foreach ($res as $value){
						print "<option value=\"".$value['clid']."\">".$value['clname']."</option>";
					}
				print "</select>";
			}
		}

		public function getlinkedguidelist($clid){
			$ret = array();
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "egr";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT `$tablename`.`id`, `$tablename`.`uname` FROM `$this->db`.`$tablename` WHERE `$tablename`.`clid` = '$clid'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$i = 0;
								while ($resarr = mysql_fetch_assoc($result)){
									$ret[$i]['value'] = $resarr['id'];
									$ret[$i]['caption'] = $this->decode($resarr['uname']);
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
		
		public function printlinkedguidelist($clid){
			$res = $this->getlinkedguidelist($clid);
			
			if ($res[0] == "0"){
				print "<select name=\"gname\" id=\"sel2\" tabindex=\"2\" >";
					print "<option value =\"0\">Select Guide</option>";
				print "</select>";
			}
			else{
				print "<select name=\"gname\" id=\"sel2\" tabindex=\"2\" >";
					print "<option value =\"0\">Select Guide</option>";
					foreach ($res as $value){
						print "<option value=\"".$value['value']."\">".$value['caption']."</option>";
					}
				print "</select>";
			}
		}
		
		public function vclid($clid){
			$ret = "";
			
			if ($clid == "0"){
				$ret = "Please select client";
			}
			return $ret;
		}
		
		public function vegr($egr){
			$ret = "";
			
			if ($egr == "0"){
				$ret = "Please select guide";
			}
			return $ret;
		}
		
		public function delegr1($egr){
			$ret = FALSE;
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "egr";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "DELETE FROM `$this->db`.`$tablename` WHERE `$tablename`.`id` = '$egr'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							$ret = TRUE;
						}
					}
				}
			}
			return $ret;
		}
		
		public function getgname($egr){
			$ret = "";
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "egr";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT `$tablename`.`uname` FROM `$this->db`.`$tablename` WHERE `$tablename`.`id` = '$egr'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$resarr = mysql_fetch_assoc($result);
								$ret = $resarr['uname'];
							}
						}
					}
				}
			}
			return $ret;
		}
		
		public function upegrlog($uname, $ipadd, $dts, $action, $clid, $gname){
			$ret = FALSE;
			
			$egname = $this->encode($gname);
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "egrlog";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "INSERT INTO `$this->db`.`$tablename` (
							`id`, 
							`uname`, 
							`ipadd`, 
							`dts`, 
							`action`, 
							`clid`, 
							`gname`
						)
						VALUES(
							NULL, 
							'$uname', 
							'$ipadd',
							'$dts', 
							'$action', 
							'$clid', 
							'$gname'
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