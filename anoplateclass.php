<?php
	include 'dbclass.php';
	class anoplate extends db{
		
		public function checkexists(){
			$ret = FALSE;
			
			$clid = 6;
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "employee";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT `$tablename`.`id` FROM `$this->db`.`$tablename` WHERE `$tablename`.`clid` = '$clid'";
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
		
		public function insano(){
			$ret = FALSE;
			
			$data = $this->getdata();
			
			$clid = 6;
			$locid = 33;
			$mname = "";
			$pos = "";
			$desg = "";
			$htype = "";
			$imgpath = $this->encode("images/noimage.jpg");
			$hplan = "";
			$status = $this->encode("active");
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "employee";
					$tex = $this->tex($tablename);
					if ($tex){
						foreach ($data as $value){
							$fname = $this->encode($value['fname']);
							$lname = $this->encode($value['lname']);
							$dob = $this->encode($value['dob']);
							$gender = $this->encode($value['gender']);
							$dept = $this->encode($value['dept']);
							$hyear = $this->encode($value['hyear']);
							
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
								'$htype', 
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
		
		public function getdata(){
			
			$data = array();
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "anoplate";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT * FROM `$this->db`.`$tablename`";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$i = 0;
								while ($resarr = mysql_fetch_assoc($result)){
									$data[$i]['fname'] = $resarr['First Name'];
									$data[$i]['lname'] = $resarr['Last Name'];
									$data[$i]['dob'] = $resarr['DOB'];
									$data[$i]['hyear'] = $this->getyear($resarr['DOH']);
									$data[$i]['gender'] = $this->getsex($resarr['Gender']);
									$data[$i]['dept'] = $resarr['Dept.'];
									
									$i++;
								}
							}
						}
					}
				}
			}
			return $data;
		}
		
		public function getyear($date){
			$ret = "";
			
			$datarr = explode("/", $date);
			
			$ret = $datarr[2];
			
			return $ret;
		}
		
		public function getsex($sex){
			$ret = "";
			
			if ($sex == "M" || $sex == "m"){
				$ret = "male";
			}
			elseif ($sex == "F" || $sex == "f"){
				$ret = "female";
			}
			elseif ($sex == "N" || $sex == "n"){
				$ret = "neuter";
			}
			
			return $ret;
		}
		
	}
?>