<?php
	include "dbclass.php";
    class edituser extends db{
    	
		private function getcuruserlist(){
    		$ret = array();
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "user";
					$tex = $this->tex($tablename);
					if ($tex){
						$deleted = "deleted";
						$edeleted = $this->encode($deleted);
						$sql = "SELECT `$tablename`.`uname`,  `$tablename`.`fname`, `$tablename`.`lname` FROM `$this->db`.`$tablename` WHERE `$tablename`.`status1` != '$edeleted'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$i = 0;
								while ($resarr = mysql_fetch_assoc($result)){
									$ret[$i]['uname'] = $this->decode($resarr['uname']);
									$ret[$i]['caption'] = $this->decode($resarr['fname'])." - ".$this->decode($resarr['lname'])." - ".$this->decode($resarr['uname']);
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
		
		public function printcuruserlist(){
			$res = $this->getcuruserlist();
			
			if ($res[0] == "0"){
				print "<select name=\"uname\" id=\"sel3\" tabindex=\"1\" >";
					print "<option value =\"0\">Select User</option>";
				print "</select>";
			}
			else{
				print "<select name=\"uname\" id=\"sel3\" tabindex=\"1\" >";
					print "<option value =\"0\">Select User</option>";
					foreach ($res as $value){
						print "<option value=\"".$value['uname']."\">".$value['caption']."</option>";
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
		
		public function vuname($uname){
			$ret = "";
			if ($uname == "0"){
				$ret = "Please select a user";
			}
			return $ret;
		}
    	
		public function vfname($fname){
			$ret = "";
			if ($fname == ""){
				$ret = "First name cannot be empty";
			}
			else{
				if (strlen($fname) > 30){
					$ret = "First name cannot be more than 30 characters";
				}
			}
			return $ret;
		}
		
		public function vmname($mname){
			$ret = "";
			if (strlen($mname) > 30){
				$ret = "Middle name cannot be more than 30 characters";
			}
			return $ret;
		}
		
		public function vlname($lname){
			$ret = "";
			if (strlen($lname) > 30){
				$ret = "Last name cannot be more than 30 characters";
			}
			return $ret;
		}
		
		public function vstreet($street){
			$ret = "";
			if (strlen($street) > 90){
				$ret = "Street cannot be more than 90 characters";
			}
			return $ret;
		}
		
		public function vcity($city){
			$ret = "";
			if (strlen($city) > 50){
				$ret = "City cannot be more than 50 characters";
			}
			return $ret;
		}
		
		public function vzip($zip){
			$ret = "";
			if (strlen($zip) > 10){
				$ret = "Zip cannot be more than 10 characters";
			}
			return $ret;
		}
		
		public function vtel($tel){
			$ret = "";
			if (strlen($tel) > 16){
				$ret = "Telephone cannot be more than 10 characters";
			}
			return $ret;
		}
		
		public function vcell($cell){
			$ret = "";
			if (strlen($cell) > 16){
				$ret = "Cell cannot be more than 10 characters";
			}
			return $ret;
		}
		
		public function vemail($email){
			$ret = "";
			if (strlen($email) > 50){
				$ret = "Email cannot be more than 50 characters";
			}
			else{
				if ($email != ""){
					if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
						$ret = "Please enter a valid email";
					}
				}
			}
			return $ret;
		}
		
		public function vempid($empid){
			$ret = "";
			if (strlen($empid) > 20){
				$ret = "Employee ID cannot be more than 20 characters";
			}
			return $ret;
		}
		
		public function vdesg($desg){
			$ret = "";
			if (strlen($desg) > 30){
				$ret = "Designation cannot be more than 30 characters";
			}
			return $ret;
		}
		
		public function vpriv($priv){
			$ret = "";
			if ($priv == "0"){
				$ret = "Please Select Privilege";
			}
			return $ret;
		}
		
		public function edituser1($fname, $mname, $lname, $street, $city, $zip, $state, $tel, $cell, $email, $empid, $desg, $uname, $priv){
			
			$ret = "";
			
			$fname = $this->injcheck($fname);
			$mname = $this->injcheck($mname);
			$lname = $this->injcheck($lname);
			$street = $this->injcheck($street);
			$city = $this->injcheck($city);
			$zip = $this->injcheck($zip);
			$state = $this->injcheck($state);
			$tel = $this->injcheck($tel);
			$cell = $this->injcheck($cell);
			$email = $this->injcheck($email);
			$empid = $this->injcheck($empid);
			$desg = $this->injcheck($desg);
			$priv = $this->injcheck($priv);
			
			$fname = $this->encode($fname);
			$mname = $this->encode($mname);
			$lname = $this->encode($lname);
			$street = $this->encode($street);
			$city = $this->encode($city);
			$zip = $this->encode($zip);
			$state = $this->encode($state);
			$tel = $this->encode($tel);
			$cell = $this->encode($cell);
			$email = $this->encode($email);
			$empid = $this->encode($empid);
			$desg = $this->encode($desg);
			$priv = $this->encode($priv);
			$uname = $this->encode($uname);
                        
                       
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "user";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "UPDATE `$this->db`.`$tablename` SET `$tablename`.`fname` = '$fname', `$tablename`.`mname` = '$mname', `$tablename`.`lname` = '$lname', `$tablename`.`street` = '$street', `$tablename`.`city` = '$city', `$tablename`.`zip` = '$zip', `$tablename`.`state` = '$state', `$tablename`.`telephone` = '$tel', `$tablename`.`cell` = '$cell', `$tablename`.`email` = '$email', `$tablename`.`empid` = '$empid', `$tablename`.`desg` = '$desg', `$tablename`.`priv` = '$priv' WHERE `$tablename`.`uname` = '$uname'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							$ret = "User Edited successfully";
						}
						else{
							$ret = "Error executing query";
						}
					}
					else{
						$ret = "Database table Error";
					}
				}
				else{
					$ret = "Database does not exist";
				}
			}
			else{
				$ret = "Could not connect to database";
			}
			
			return $ret;
			
		}
		
		public function upeditlog($suname, $ipadd, $dts, $uname){
			$ret = FALSE;
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "editlog";
					$tex = $this->tex($tablename);
					if ($tex){
						$suname = $this->injcheck($suname);
						$ipadd = $this->injcheck($ipadd);
						$dts = $this->injcheck($dts);
						$uname = $this->injcheck($uname);
						$sql = "INSERT INTO `$this->db`.`$tablename` (
							`id`, 
							`uname`,
							`ipadd`,
							`dts`,
							`eduname`
						)
						VALUES(
							NULL,
							'$suname', 
							'$ipadd',
							'$dts', 
							'$uname'
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
		
		public function getjsonarr($uname){
			$retarr = array();
			$euname = $this->encode($uname);
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "user";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT * FROM `$this->db`.`$tablename` WHERE `$tablename`.`uname` = '$euname'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							$resarr = mysql_fetch_assoc($result);
                                                        
							$retarr[0]['field'] = "fname";
                                                        $fname=$this->decode($resarr['fname']);
                                                        if ($fname=="") {
                                                            $fname="";
                                                        }
							$retarr[0]['value'] = $fname;
                                                        
                                                        
                                                        
							$retarr[1]['field'] = "mname";
                                                        $mname=$this->decode($resarr['mname']);
                                                        if ($mname=="") {
                                                            $mname="";
                                                        } 
							$retarr[1]['value'] = $mname;
							
                                                        
                                                        
                                                        
                                                        
							$retarr[2]['field'] = "lname";
							 $lname=$this->decode($resarr['lname']);
                                                        if ($lname=="") {
                                                            $lname="";
                                                        } 
							$retarr[2]['value'] = $lname;
                                                        
                                                        
							$retarr[3]['field'] = "street";
							 $street=$this->decode($resarr['street']);
                                                        if ($street=="") {
                                                            $street="";
                                                        } 
							$retarr[3]['value'] = $street;
                                                        
                                                        
                                                        
							$retarr[4]['field'] = "city";
							$city=$this->decode($resarr['city']);
                                                        if ($city=="") {
                                                            $city="";
                                                        }
                                                        $retarr[4]['value'] = $city;
                                                        
                                                      
							$retarr[5]['field'] = "zip";
							$zip=$this->decode($resarr['zip']);
                                                        if ($zip=="") {
                                                            $zip="";
                                                        }
                                                        $retarr[5]['value'] = $zip;
                                                        
                                                        
                                                        
							$retarr[6]['field'] = "state";
							$state=$this->decode($resarr['state']);
                                                        if ($state=="") {
                                                            $state="";
                                                        }
                                                        $retarr[6]['value'] = $state;
                                                        
                                                        
                                                        
                                                        
							$retarr[7]['field'] = "tel";
							$telephone=$this->decode($resarr['telephone']);
                                                        if ($telephone=="") {
                                                            $telephone="";
                                                        }
                                                        $retarr[7]['value'] = $telephone;
                                                        
							$retarr[8]['field'] = "cell";
							$cell=$this->decode($resarr['cell']);
                                                        if ($cell=="") {
                                                            $cell="";
                                                        }
                                                        $retarr[8]['value'] = $cell;
                                                        
                                                        
							$retarr[9]['field'] = "email";
							$email=$this->decode($resarr['email']);
                                                        if ($email=="") {
                                                            $email="";
                                                        }
                                                        $retarr[9]['value'] = $email;
                                                        
                                                        
							$retarr[10]['field'] = "empid";
							$empid=$this->decode($resarr['empid']);
                                                        if ($empid=="") {
                                                            $empid="";
                                                        }
                                                        $retarr[10]['value'] = $empid;
                                                        
							$retarr[11]['field'] = "desg";
							$desg=$this->decode($resarr['desg']);
                                                        if ($desg=="") {
                                                            $desg="";
                                                        }
                                                        $retarr[11]['value'] = $desg;
                                                        
                                                        
							$retarr[12]['field'] = "priv";
							$priv=$this->decode($resarr['priv']);
                                                        if ($priv=="") {
                                                            $priv="";
                                                        }
                                                        $retarr[12]['value'] = $priv;
						}
					}
				}
			}
			return $retarr;
		}
		
    }

?>