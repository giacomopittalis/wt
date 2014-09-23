<?php
	include "dbclass.php";
    class delwce extends db{
    	
		public function cleaninput($input){
			$ret = "";
			$q = ENT_NOQUOTES;
			
			$ret = trim($input);
			$ret = htmlspecialchars($ret, $q);
			
			return $ret;
		}
		
		public function getwcelist(){
			$ret = array();
			
			$active = "active";
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "wce";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT * FROM `$this->db`.`$tablename` WHERE `$tablename`.`status` = '$active'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$i = 0;
								while ($resarr = mysql_fetch_assoc($result)){
									$ret[$i]['id'] = $resarr['id'];
									$ret[$i]['caption'] = $resarr['wce'];
									$i++;
								}
							}
						}
					}
				}
			}
			return $ret;
		}
		
		public function printwcelist(){
			$res = $this->getwcelist();
			if (empty($res)){
				print "<select name=\"wceid\" id=\"sel1\" tabindex=\"1\">";
					print "<option value=\"0\">Select Wce</option>";
				print "</select>";
			}
			else{
				print "<select name=\"wceid\" id=\"sel1\" tabindex=\"1\">";
					print "<option value=\"0\">Select Wce</option>";
					foreach ($res as $value){
						print "<option value=\"".$value['id']."\">".$value['caption']."</option>";
					}
				print "</select>";
			}
		}
		
		public function vwceid($wceid){
			$ret = "";
			
			if ($wceid == "0"){
				$ret = "Please select wce";
			}
			
			return $ret;
		}
		
		public function delwce1($wceid){
			$ret = FALSE;
			
			$deleted = "deleted";
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "wce";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "UPDATE `$this->db`.`$tablename` SET `$tablename`.`status` = '$deleted' WHERE `$tablename`.`id` = '$wceid'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							$ret = TRUE;
						}
					}
				}
			}
			return $ret;
		}
		
		public function upwcelog($uname, $ipadd, $dts, $action, $wceid){
			$ret = FALSE;
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "wcelog";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "INSERT INTO `$this->db`.`$tablename` (
							`id`, 
							`uname`, 
							`ipadd`, 
							`dts`, 
							`action`, 
							`wceid`
						)
						VALUES (
							NULL, 
							'$uname', 
							'$ipadd', 
							'$dts', 
							'$action', 
							'$wceid'
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