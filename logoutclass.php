<?php
	include 'dbclass.php';
    class logout extends db{
    	
    	public function logout($euname){
    		$ret = FALSE;
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "session";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql1 = "SELECT * FROM `$this->db`.`$tablename` WHERE `$tablename`.`uname` = '$euname'";
						$result1 = mysql_query($sql1, $dbhandle);
						if ($result1){
							if (mysql_num_rows($result1) > 0){
								$sql2 = "DELETE FROM `$this->db`.`$tablename` WHERE `$tablename`.`uname` = '$euname'";
								$result2 = mysql_query($sql2, $dbhandle);
								if ($result2){
									$ret = TRUE;
								}
							}
							else{
								$ret = TRUE;
							}
						}
					}
				}
			}
			return $ret;
    	}
		
    }
?>