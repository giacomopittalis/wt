<?php
	include_once 'dbclass.php';
    class login extends db{
    	
    	public function cleaninput($input){
			$ret = "";
			$q = ENT_NOQUOTES;
			
			$ret = trim($input);
			$ret = htmlspecialchars($ret, $q);
			
			return $ret;
		}
		
		private function validateUsernameLength($uname){ // checkslength of username against rules
			$ret = TRUE;
			if ($uname == ""){
				$ret = FALSE;
			}
			else{
				if (strlen($uname) > 20){
					$ret = FALSE;
				}
				else{
					if (strlen($uname) < 6){
						$ret = FALSE;
					}
				}
			}
			return $ret;
		}
		
		private function validatePasswordLength($pass){ // checks length of password against rules
			$return = TRUE;
			if ($pass == ""){
				$return = FALSE;
			}
			else{
				if (strlen($pass) > 20){
					$return = FALSE;
				}
				else{
					if (strlen($pass) < 8){
						$return = FALSE;
					}
				}
			}
			return $return;
		}
		
		public function validate($user, $pass){

			$return = FALSE;
			$usernameLengthPasses = $this->validateUsernameLength($user);
			$passwordLengthPasses = $this->validatePasswordLength($pass);
             
			//echo("attempting login<br/>");
			if ($usernameLengthPasses && $passwordLengthPasses){
			 	
				$active = "active";
				
				$encodedUsername = $this->encode($user);
				$encodedPassword = $this->encode($pass);
				$eactive = $this->encode($active);
                              
				//echo '<script type="text/javascript">console.log("Login has been submitted '.$encodedUsername . ' ");</script>';
				//$firephp->log($encodedUsername);
				//$firephp->log($encodedPassword);
				$dbhandle = $this->dbhandle();
                                
                         
				if ($dbhandle){
					$dbfound = $this->dbfound();
                                        
                       
                                        
					if ($dbfound){
						$tablename = "user";
						$tableExists = $this->tableExists($tablename);
                                                
                        
                                                
                                                
						if ($tableExists){
							$sql = "SELECT `$tablename`.`uname`, `$tablename`.`pass`, `$tablename`.`status1` FROM `$this->db`.`$tablename` WHERE `$tablename`.`uname` = '$encodedUsername'";
							$result = mysql_query($sql, $dbhandle);
                                                        
                   
                                                        
							if ($result){
								if (mysql_num_rows($result) > 0){
									$resarr = mysql_fetch_assoc($result);
                                                                     
									if (($encodedUsername == $resarr['uname']) && ($encodedPassword == $resarr['pass']) && ($eactive == $resarr['status1'])){
										//echo("login succeeded<br/>".$resarr['uname']." = ".$encodedUsername."<br/>");
                                                                            
										$return = TRUE;
									}
								}
							}
						}
					}
				}
			}
			/*
			echo("validate login = ");
			if($return){
				echo("success<br/>");
			}else{
				echo("failure<br/>");
			}
			*/
			return $return;
		}
		
		public function deleteAttempt($uname){ //delattempt
			$ret = FALSE;
			
			$encodedUsername = $this->encode($uname);
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "loginattempt";
					$tableExists = $this->tableExists($tablename);
					if ($tableExists){
						$sql1 = "SELECT * FROM `$this->db`.`$tablename` WHERE `$tablename`.`uname` = '$encodedUsername'";
						$result1 = mysql_query($sql1, $dbhandle);
						if ($result1){
							if (mysql_num_rows($result1) > 0){
								$sql2 = "DELETE FROM `$this->db`.`$tablename` WHERE `$tablename`.`uname` = '$encodedUsername'";
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
		
		public function updateLoginAttempts($uname){ //upattempt()
			$ret = FALSE;
			
			$encodedUsername = $this->encode($uname);
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "loginattempt";
					$tableExists = $this->tableExists($tablename);
					if ($tableExists){
						$sql1 = "SELECT * FROM `$this->db`.`$tablename` WHERE `$tablename`.`uname` = '$encodedUsername'";
						$result1 = mysql_query($sql1, $dbhandle);
						if ($result1){
							if (mysql_num_rows($result1) > 0){
								//echo("Found username in loginattempt table<br/>");
								//Update
								$resarr = mysql_fetch_assoc($result1);
								//print_r($resarr);
								//echo("<br/>");
								$count = $resarr['lcount'];
								$count = $this->decode($count);
								$count = (int)$count;
								$count = $count + 1;
								//echo($count."<br/>");
								
								if ($count == 10){
									//Lock Account
									
									$locked = "locked";
									$elocked = $this->encode($locked);
									
									$tablename1 = "user";
									$tableExists1 = $this->tableExists($tablename1);
									if ($tableExists1){
										/*$active = "active";
										$eactive = $this->encode($active);*/
										$sql3 = "UPDATE `$this->db`.`$tablename1` SET `$tablename1`.`status1` = '$elocked' WHERE `$tablename1`.`uname` = '$encodedUsername'";
										$result3 = mysql_query($sql3, $dbhandle);
									}
								}
								
								$count = (string)$count;
								$ecount = $this->encode($count);
								
								$sql2 = "UPDATE `$this->db`.`$tablename` SET `$tablename`.`lcount` = '$ecount' WHERE `$tablename`.`uname` = '$encodedUsername'";
								$result2 = mysql_query($sql2, $dbhandle);
								if ($result2){
									$ret = TRUE;
								}
							}
							else{
								//Insert
								$count = "1";
								$ecount = $this->encode($count);
								
								$sql4 = "INSERT INTO `$this->db`.`$tablename` (
									`id`, 
									`uname`, 
									`lcount`
								)
								VALUES(
									NULL, 
									'$encodedUsername', 
									'$ecount'
								)";
								$result4 = mysql_query($sql4, $dbhandle);
								if ($result4){
									$ret = TRUE;
								}
							}
						}
					}
				}
			}
			return $ret;
		}


		public function updateLoginLog($uname, $uagent, $ipadd, $dts){ //uplogin
			$ret = FALSE;
			
			$encodedUsername = $this->encode($uname);
			//print $encodedUsername."<br />";
			$euagent = $this->encode($uagent);
			//print $euagent."<br />";
			$eipadd = $this->encode($ipadd);
			//print $eipadd."<br />";
			$edts = $this->encode($dts);
			//print $edts."<br />";
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "loginlog";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "INSERT INTO `$this->db`.`$tablename` (
							`id`, 
							`uname`, 
							`uagent`, 
							`ipadd`, 
							`dts`
						)
						VALUES(
							NULL, 
							'$encodedUsername', 
							'$euagent', 
							'$eipadd', 
							'$edts'
						)";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							//print "result Yes"."<br />";
							$ret = TRUE;
						}
					}
				}
			}
			return $ret;
		}
		
		public function uplogincount($uname){
			$ret = FALSE;
			
			$encodedUsername = $this->encode($uname);
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "logincount";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql1 = "SELECT * FROM `$this->db`.`$tablename` WHERE `$tablename`.`uname` = '$encodedUsername'";
						$result1 = mysql_query($sql1, $dbhandle);
						if ($result1){
							if (mysql_num_rows($result1) > 0){
								//update
								$resarr = mysql_fetch_assoc($result1);
								$count = $resarr['lcount'];
								$count = $this->decode($count);
								$count = (int)$count;
								$count = $count + 1;
								$count = (string)$count;
								$ecount = $this->encode($count);
								
								$sql2 = "UPDATE `$this->db`.`$tablename` SET `$tablename`.`lcount` = '$ecount' WHERE `$tablename`.`uname` = '$encodedUsername'";
								$result2 = mysql_query($sql2, $dbhandle);
								if ($result2){
									$ret = TRUE;
								}
							}
							else{
								//Insert
								$count = "1";
								$ecount = $this->encode($count);
								
								$sql3 = "INSERT INTO `$this->db`.`$tablename` (
									`id`, 
									`uname`, 
									`lcount`
								)
								VALUES(
									NULL, 
									'$encodedUsername', 
									'$ecount'
								)";
								$result3 = mysql_query($sql3, $dbhandle);
								if ($result3){
									$ret = TRUE;
								}
							}
						}
					}
				}
			}
			return $ret;
		}

		public function getpriv($uname){
			$return = "";
			
			$encodedUsername = $this->encode($uname);
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "user";
					$tableExists = $this->tableExists($tablename);
					if ($tableExists){
						$sql = "SELECT `$tablename`.`priv` FROM `$this->db`.`$tablename` WHERE `$tablename`.`uname` = '$encodedUsername'";
						//print $sql."<br />";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$resarr = mysql_fetch_assoc($result);
								$priv = $resarr['priv'];
								$return = $this->decode($priv);
							}
						}
					}
				}
			}
			return $return;
		}
		
		public function upsession($uname, $priv, $ipadd, $uagent, $token, $timeout){
			$ret = FALSE;
			
			$encodedUsername = $this->encode($uname);
			$epriv = $this->encode($priv);
			$eipadd = $this->encode($ipadd);
			$euagent = $this->encode($uagent);
			$etoken = $this->encode($token);
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "session";
					$tex = $this->tex($tablename);
					if ($tex){
						//Check if entry exists
						$sql1 = "SELECT * FROM `$this->db`.`$tablename` WHERE `$tablename`.`uname` = '$encodedUsername'";
						$result1 = mysql_query($sql1, $dbhandle);
						if ($result1){
							if (mysql_num_rows($result1) > 0){
								$sql2 = "DELETE FROM `$this->db`.`$tablename` WHERE `$tablename`.`uname` = '$encodedUsername'";
								$result2 = mysql_query($sql2, $dbhandle);
								if ($result2){
									$sql3 = "INSERT INTO `$this->db`.`$tablename` (
										`uname`, 
										`priv`, 
										`ipadd`, 
										`uagent`, 
										`token`, 
										`timeout`
									)
									VALUES(
										'$encodedUsername', 
										'$epriv',
										'$eipadd',
										'$euagent', 
										'$etoken', 
										'$timeout'
									)";
									$result3 = mysql_query($sql3, $dbhandle);
									if ($result3){
										$ret = TRUE;
									}
								}
							}
							else{
								$sql4 = "INSERT INTO `$this->db`.`$tablename` (
										`uname`, 
										`priv`, 
										`ipadd`, 
										`uagent`, 
										`token`, 
										`timeout`
									)
									VALUES(
										'$encodedUsername', 
										'$epriv',
										'$eipadd',
										'$euagent', 
										'$etoken', 
										'$timeout'
									)";
									$result4 = mysql_query($sql4, $dbhandle);
									if ($result4){
										$ret = TRUE;
									}
							}
						}
					}
				}
			}
			return $ret;
		}
		
    }
?>