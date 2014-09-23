<?php
    include 'dbclass.php';
	
	class work extends db{
		
		public function getlocarr(){
			$ret = array();
			
			$clid = 4;
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "clientloc";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT * FROM `$this->db`.`$tablename` WHERE  `$tablename`.`clid` = '$clid'";
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
						}
					}
				}
			}
			return $ret;
		}
		
		public function getlocid($locname){
			$ret = "";
			$locarr = $this->getlocarr();
			
			foreach ($locarr as $value){
				if ($locname == $value['locid']){
					$ret = $value['id'];
					break;
				}
			}
			return $ret;
		}
		
		public function gethyear($date){
			$ret = "";
			
			$exarr = explode("/", $date);
			
			$ret = $exarr[2];
			
			return $ret;
		}
		
		public function checkdbf(){
			$ret = array();
			
			$clid = 4;
			$imgpath = "images/noimage.jpg";
			$status = "active";
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "dbpc";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT * FROM `$this->db`.`$tablename`";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$i = 0;
								while ($resarr = mysql_fetch_assoc($result)){
									$locname = $resarr['location'];
									$date = $resarr ['hdate'];
									$locid = $this->getlocid($locname);
									$hyear = $this->gethyear($date);
									$ret[$i]['clid'] = $clid;
									$ret[$i]['locid'] = $locid;
									$ret[$i]['fname'] = $resarr['fname'];
									$ret[$i]['mname'] = $resarr['mname'];
									$ret[$i]['lname'] = $resarr['lname'];
									$ret[$i]['dob'] = $resarr['dob'];
									$ret[$i]['gender'] = "";
									$ret[$i]['dept'] = $resarr['dept'];
									$ret[$i]['pos'] = $resarr['pos'];
									$ret[$i]['desg'] = $resarr['desg'];
									$ret[$i]['type'] = "";
									$ret[$i]['hyear'] = $hyear;
									$ret[$i]['imgpath'] = $imgpath;
									$ret[$i]['hplan'] = "";
									$ret[$i]['status'] = $status;
									//print $hyear."<br />";
									$i++;
								}
							}
						}
					}
				}
			}
			return $ret;
		}

		public function crbemp(){
			
			$ret = FALSE;
			
			$dataarr = $this->checkdbf();
			
			foreach ($dataarr as $value){
				$clid = $value['clid'];
				$locid = $value['locid'];
				$fname = $value['fname'];
				$mname = $value['mname'];
				$lname = $value['lname'];
				$dob = $value['dob'];
				$gender = $value['gender'];
				$dept = $value['dept'];
				$pos = $value ['pos'];
				$desg = $value['desg'];
				$type = $value['type'];
				$hyear = $value['hyear'];
				$imgpath = $value['imgpath'];
				$hplan = $value['hplan'];
				$status = $value['status'];
				
				$clid = $this->injcheck($clid);
				$locid = $this->injcheck($locid);
				$fname = $this->injcheck($fname);
				$mname = $this->injcheck($mname);
				$lname = $this->injcheck($lname);
				$dob = $this->injcheck($dob);
				$gender = $this->injcheck($gender);
				$dept = $this->injcheck($dept);
				$pos = $this->injcheck($pos);
				$desg = $this->injcheck($desg);
				$type = $this->injcheck($type);
				$hyear = $this->injcheck($hyear);
				$imgpath = $this->injcheck($imgpath);
				$hplan = $this->injcheck($hplan);
				$status = $this->injcheck($status);
				
				$fname = $this->encode($fname);
				$mname = $this->encode($mname);
				$lname = $this->encode($lname);
				$dob = $this->encode($dob);
				$gender = $this->encode($gender);
				$dept = $this->encode($dept);
				$pos = $this->encode($pos);
				$desg = $this->encode($desg);
				$type = $this->encode($type);
				$hyear = $this->encode($hyear);
				$imgpath = $this->encode($imgpath);
				$hplan = $this->encode($hplan);
				$status = $this->encode($status);
				
				$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "employee";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "INSERT INTO `$this->db`.`$tablename` (
							`id`,
							`clid`, 
							`locid`,  
							`fname`, 
							`mname`, 
							`lname`, 
							`dob`, 
							`gender`, 
							`dept`, 
							`pos`, 
							`desg`, 
							`type`, 
							`hyear`, 
							`imgpath`, 
							`hplan`,
							`status`
						)
						VALUES(
							NULL, 
							'$clid', 
							'$locid', 
							'$fname', 
							'$mname', 
							'$lname', 
							'$dob', 
							'$gender', 
							'$dept', 
							'$pos', 
							'$desg', 
							'$type', 
							'$hyear', 
							'$imgpath', 
							'$hplan',
							'$status'
						)";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
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