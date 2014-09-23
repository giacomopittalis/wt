<?php
	include 'dbclass.php';
    class test extends db{
    	
    	public function gettopics(){
    		$ret = array();
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "topic";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT * FROM `$this->db`.`$tablename`";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$i = 0;
								while ($resarr = mysql_fetch_assoc($result)){
									$ret[$i]['tid'] = $resarr['tid'];
									$ret[$i]['topic'] = $resarr['name'];
									$i++;
								}
							}
						}
					}
				}
			}
			return $ret;
    	}
		
		public function getstopics($tid){
			$ret = array();
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "stopic";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT * FROM `$this->db`.`$tablename` WHERE `$tablename`.`tid` = '$tid'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$i = 0;
								while ($resarr = mysql_fetch_assoc($result)){
									$ret[$i]['stid'] = $resarr['stid'];
									$ret[$i]['stopic'] = $resarr['name'];
									$i++;
								}
							}
						}
					}
				}
			}
			return $ret;
		}
		
		public function getfields($stid){
			$ret = array();
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "fields";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT * FROM `$this->db`.`$tablename` WHERE `$tablename`.`stid` = '$stid'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$i = 0;
								while ($resarr = mysql_fetch_assoc($result)){
									$ret[$i]['fid'] = $resarr['fid'];
									$ret[$i]['tid'] = $resarr['tid'];
									$ret[$i]['stid'] = $resarr['stid'];
									$ret[$i]['type'] = $resarr['type'];
									$ret[$i]['name'] = $resarr['name'];
									$ret[$i]['dname'] = $resarr['dname'];
									$ret[$i]['id'] = $resarr['id'];
									$ret[$i]['fclass'] = $resarr['fclass'];
									$i++;
								}
							}
						}
					}
				}
			}
			return $ret;
		}
		
		public function printform(){
			
			$res1 = $this->gettopics();
			
			foreach ($res1 as $value1){
				print "<fieldset>";
					print "<legend>".$value1['topic']."</legend>";
					$res2 = $this->getstopics($value1['tid']);
					foreach ($res2 as $value2){
						print "<div class=\"row\">";
							print "<div class=\"twelve columns\">";
								print "<h6>".$value2['stopic']."</h6>";
							print "</div>";
						print "</div>";
						$res3 = $this->getfields($value2['stid']);
						foreach ($res3 as $value3){
							print "<div class=\"row\">";
								print "<div class=\"three columns\">";
									print "<label>".$value3['dname']."</label>";
								print "</div>";
								print "<div class=\"four columns\">";
									print "<input type=\"".$value3['type']."\" name=\"".$value3['name']."\" id=\"".$value3['id']."\" />";
								print "</div>";
								print "<div class=\"five columns\">";
									
								print "</div>";
							print "</div>";
						}
					}
				print "</fieldset>";
			}
		}
		
    }
?>