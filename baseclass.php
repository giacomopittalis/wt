<?php
	include 'dbclass.php';
    class base extends db{
    	
    	//Create Database
		public function crdb(){
			$dbhandle = $this->dbhandle();
			$ret = "";
			if(!$dbhandle){
				$ret = "Error Connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if($dbfound){
					$ret = "Database Already Exists";
				}
				else{
					$sql = "CREATE DATABASE $this->db";
					$result = mysql_query($sql, $dbhandle);
					if($result){
						$ret = "Database Successfully Created";
					}
					else{
						$ret = "Error Creating Database";
					}
				}
			}
			return $ret;
		}
		
		//Check Database Connection
		public function checkdb(){
			$dbhandle = $this->dbhandle();
			$ret = "";
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if($dbfound){
					$ret = "Database already exists and connection is successful";
				}
				else{
					$ret = "Database does not exist but connection is successful";
				}
			}
			return $ret;
		}
		
		//Create User Table
		public function crusertable(){
			$ret = "";
			$tablename = "user";
			$default = "noxxx";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "User table already exists";
					}
					else{
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`fname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`mname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`lname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`street` varchar(200) NOT NULL DEFAULT 'noxxx',
								`city` varchar(100) NOT NULL DEFAULT 'noxxx',
								`zip` varchar(100) NOT NULL DEFAULT 'noxxx',
								`state` varchar(100) NOT NULL DEFAULT 'noxxx',
								`telephone` varchar(100) NOT NULL DEFAULT 'noxxx',
								`cell` varchar(100) NOT NULL DEFAULT 'noxxx',
								`email` varchar(100) NOT NULL DEFAULT 'noxxx',
								`empid` varchar(100) NOT NULL DEFAULT 'noxxx',
								`desg` varchar(100) NOT NULL DEFAULT 'noxxx',
								`uname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`pass` varchar(100) NOT NULL DEFAULT 'noxxx',
								`imgpath` varchar(100) NOT NULL DEFAULT 'noxxx',
								`priv` varchar(100) NOT NULL DEFAULT 'noxxx',
								`status1` varchar(100) NOT NULL DEFAULT 'active',
								`status2` varchar(100) NOT NULL DEFAULT 'active',
								PRIMARY KEY (`id`),
								KEY (`uname`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}
		
		//Create Login Log Table
		public function crloginlogtable(){
			$ret = "";
			$tablename = "loginlog";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`uname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`uagent` varchar(300) NOT NULL DEFAULT 'noxxx',
								`ipadd` varchar(100) NOT NULL DEFAULT 'noxxx',
								`dts` varchar(100) NOT NULL DEFAULT 'noxxx',
								PRIMARY KEY (`id`),
								KEY (`uname`),
								CONSTRAINT `$fk1` FOREIGN KEY (`uname`) REFERENCES `user` (`uname`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}
		
		//Create Login Attempt Table
		public function crloginattempttable(){
			$ret = "";
			$tablename = "loginattempt";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`uname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`lcount` varchar(100) NOT NULL DEFAULT 'noxxx',
								PRIMARY KEY (`id`),
								KEY (`uname`),
								CONSTRAINT `$fk1` FOREIGN KEY (`uname`) REFERENCES `user` (`uname`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}
		
		//Create Login Count Table
		public function crlogincounttable(){
			$ret = "";
			$tablename = "logincount";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`uname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`lcount` varchar(100) NOT NULL DEFAULT 'noxxx',
								PRIMARY KEY (`id`),
								KEY (`uname`),
								CONSTRAINT `$fk1` FOREIGN KEY (`uname`) REFERENCES `user` (`uname`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}
		
		//Create Session Data Table
		public function crsessiondatatable(){
			$ret = "";
			$tablename = "session";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`uname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`priv` varchar(100) NOT NULL DEFAULT 'noxxx',
								`ipadd` varchar(100) NOT NULL DEFAULT 'noxxx',
								`uagent` varchar(300) NOT NULL DEFAULT 'noxxx',
								`token` varchar(100) NOT NULL DEFAULT 'noxxx',
								`timeout` varchar(100) NOT NULL DEFAULT 'noxxx',
								PRIMARY KEY (`uname`),
								CONSTRAINT `$fk1` FOREIGN KEY (`uname`) REFERENCES `user` (`uname`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}
		
		//Create IPUA table
		public function cripuatable(){
			$ret = "";
			$tablename = "ipua";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`uname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`ipadd` varchar(100) NOT NULL DEFAULT 'noxxx',
								`uagent` varchar(100) NOT NULL DEFAULT 'noxxx',
								PRIMARY KEY (`id`),
								KEY (`uname`),
								CONSTRAINT `$fk1` FOREIGN KEY (`uname`) REFERENCES `user` (`uname`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}
		
		//Create User Creation Log Table
		public function crcrlogtable(){
			$ret = "";
			$tablename = "createlog";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$fk2 = $tablename."_ibfk_2";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`uname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`ipadd` varchar(100) NOT NULL DEFAULT 'noxxx',
								`dts` varchar(100) NOT NULL DEFAULT 'noxxx',
								`cruname` varchar(100) NOT NULL DEFAULT 'noxxx',
								PRIMARY KEY (`id`),
								KEY (`uname`),
								kEY (`cruname`),
								CONSTRAINT `$fk1` FOREIGN KEY (`uname`) REFERENCES `user` (`uname`),
								CONSTRAINT `$fk2` FOREIGN KEY (`cruname`) REFERENCES `user` (`uname`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}

		//Create User Unlock Log Table
		public function crunlocklogtable(){
			$ret = "";
			$tablename = "unlocklog";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$fk2 = $tablename."_ibfk_2";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`uname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`ipadd` varchar(100) NOT NULL DEFAULT 'noxxx',
								`dts` varchar(100) NOT NULL DEFAULT 'noxxx',
								`ununame` varchar(100) NOT NULL DEFAULT 'noxxx',
								PRIMARY KEY (`id`),
								KEY (`uname`),
								kEY (`ununame`),
								CONSTRAINT `$fk1` FOREIGN KEY (`uname`) REFERENCES `user` (`uname`),
								CONSTRAINT `$fk2` FOREIGN KEY (`ununame`) REFERENCES `user` (`uname`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}

		//Create User Lock Log Table
		public function crlocklogtable(){
			$ret = "";
			$tablename = "locklog";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$fk2 = $tablename."_ibfk_2";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`uname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`ipadd` varchar(100) NOT NULL DEFAULT 'noxxx',
								`dts` varchar(100) NOT NULL DEFAULT 'noxxx',
								`luname` varchar(100) NOT NULL DEFAULT 'noxxx',
								PRIMARY KEY (`id`),
								KEY (`uname`),
								kEY (`luname`),
								CONSTRAINT `$fk1` FOREIGN KEY (`uname`) REFERENCES `user` (`uname`),
								CONSTRAINT `$fk2` FOREIGN KEY (`luname`) REFERENCES `user` (`uname`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}

		//Create User Delete Log Table
		public function crdellogtable(){
			$ret = "";
			$tablename = "dellog";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$fk2 = $tablename."_ibfk_2";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`uname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`ipadd` varchar(100) NOT NULL DEFAULT 'noxxx',
								`dts` varchar(100) NOT NULL DEFAULT 'noxxx',
								`duname` varchar(100) NOT NULL DEFAULT 'noxxx',
								PRIMARY KEY (`id`),
								KEY (`uname`),
								kEY (`duname`),
								CONSTRAINT `$fk1` FOREIGN KEY (`uname`) REFERENCES `user` (`uname`),
								CONSTRAINT `$fk2` FOREIGN KEY (`duname`) REFERENCES `user` (`uname`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}

		//Create User Edit Log Table
		public function creditlogtable(){
			$ret = "";
			$tablename = "editlog";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$fk2 = $tablename."_ibfk_2";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`uname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`ipadd` varchar(100) NOT NULL DEFAULT 'noxxx',
								`dts` varchar(100) NOT NULL DEFAULT 'noxxx',
								`eduname` varchar(100) NOT NULL DEFAULT 'noxxx',
								PRIMARY KEY (`id`),
								KEY (`uname`),
								kEY (`eduname`),
								CONSTRAINT `$fk1` FOREIGN KEY (`uname`) REFERENCES `user` (`uname`),
								CONSTRAINT `$fk2` FOREIGN KEY (`eduname`) REFERENCES `user` (`uname`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}

		//Create User change password Log Table
		public function crcplogtable(){
			$ret = "";
			$tablename = "cplog";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`uname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`ipadd` varchar(100) NOT NULL DEFAULT 'noxxx',
								`dts` varchar(100) NOT NULL DEFAULT 'noxxx',
								PRIMARY KEY (`id`),
								KEY (`uname`),
								CONSTRAINT `$fk1` FOREIGN KEY (`uname`) REFERENCES `user` (`uname`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}

		//Create User Edit Pic Log Table
		public function creditpiclogtable(){
			$ret = "";
			$tablename = "editpiclog";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$fk2 = $tablename."_ibfk_2";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`uname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`ipadd` varchar(100) NOT NULL DEFAULT 'noxxx',
								`dts` varchar(100) NOT NULL DEFAULT 'noxxx',
								`epuname` varchar(100) NOT NULL DEFAULT 'noxxx',
								PRIMARY KEY (`id`),
								KEY (`uname`),
								kEY (`epuname`),
								CONSTRAINT `$fk1` FOREIGN KEY (`uname`) REFERENCES `user` (`uname`),
								CONSTRAINT `$fk2` FOREIGN KEY (`epuname`) REFERENCES `user` (`uname`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}

		//Create client Table
		public function crclienttable(){
			$ret = "";
			$tablename = "client";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`clname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`status` varchar(100) NOT NULL DEFAULT 'noxxx',
								PRIMARY KEY (`id`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}
		
		//Create client Log Table
		public function crclientlogtable(){
			$ret = "";
			$tablename = "clientlog";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$fk2 = $tablename."_ibfk_2";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`uname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`ipadd` varchar(100) NOT NULL DEFAULT 'noxxx',
								`dts` varchar(100) NOT NULL DEFAULT 'noxxx',
								`action` varchar(100) NOT NULL DEFAULT 'noxxx',
								`clid` int(10) unsigned NOT NULL,
								PRIMARY KEY (`id`),
								KEY (`uname`),
								KEY (`clid`),
								CONSTRAINT `$fk1` FOREIGN KEY (`uname`) REFERENCES `user` (`uname`),
								CONSTRAINT `$fk2` FOREIGN KEY (`clid`) REFERENCES `client` (`id`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}
		
		//Create client Location Table
		public function crclientloctable(){
			$ret = "";
			$tablename = "clientloc";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`clid` int(10) unsigned NOT NULL,
								`locid` varchar(100) NOT NULL DEFAULT 'noxxx',
								`street` varchar(200) NOT NULL DEFAULT 'noxxx',
								`city` varchar(100) NOT NULL DEFAULT 'noxxx',
								`zip` varchar(100) NOT NULL DEFAULT 'noxxx',
								`state` varchar(100) NOT NULL DEFAULT 'noxxx',
								`status` varchar(100) NOT NULL DEFAULT 'noxxx',
								PRIMARY KEY (`id`),
								KEY (`locid`),
								KEY (`clid`),
								CONSTRAINT `$fk1` FOREIGN KEY (`clid`) REFERENCES `client` (`id`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}

		//Create client Location log Table
		public function crclientloclogtable(){
			$ret = "";
			$tablename = "clientloclog";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$fk2 = $tablename."_ibfk_2";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`uname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`ipadd` varchar(100) NOT NULL DEFAULT 'noxxx',
								`dts` varchar(100) NOT NULL DEFAULT 'noxxx',
								`action` varchar(100) NOT NULL DEFAULT 'noxxx',
								`locid` varchar(100) NOT NULL DEFAULT 'noxxx',
								PRIMARY KEY (`id`),
								KEY (`uname`),
								KEY (`locid`),
								CONSTRAINT `$fk1` FOREIGN KEY (`uname`) REFERENCES `user` (`uname`),
								CONSTRAINT `$fk2` FOREIGN KEY (`locid`) REFERENCES `clientloc` (`locid`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}
		
		//Create Employee Table
		public function cremptable(){
			$ret = "";
			$tablename = "employee";
			$default = "noxxx";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "User table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$fk2 = $tablename."_ibfk_2";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`clid` int(10) unsigned NOT NULL,
								`locid` int(10) unsigned NOT NULL, 
								`fname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`mname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`lname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`dob` varchar(100) NOT NULL DEFAULT 'noxxx',
								`gender` varchar(100) NOT NULL DEFAULT 'noxxx',
								`dept` varchar(100) NOT NULL DEFAULT 'noxxx',
								`pos` varchar(100) NOT NULL DEFAULT 'noxxx',
								`desg` varchar(100) NOT NULL DEFAULT 'noxxx',
								`type` varchar(100) NOT NULL DEFAULT 'noxxx',
								`hyear` varchar(100) NOT NULL DEFAULT 'noxxx',
								`imgpath` varchar(100) NOT NULL DEFAULT 'noxxx',
								`hplan` varchar(100) NOT NULL DEFAULT 'active',
								`status` varchar(100) NOT NULL DEFAULT 'active',
								PRIMARY KEY (`id`),
								KEY (`clid`),
								KEY (`locid`),
								CONSTRAINT `$fk1` FOREIGN KEY (`clid`) REFERENCES `client` (`id`),
								CONSTRAINT `$fk2` FOREIGN KEY (`locid`) REFERENCES `clientloc` (`id`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}
		
		//Create employee log Table
		public function cremplogtable(){
			$ret = "";
			$tablename = "emplog";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$fk2 = $tablename."_ibfk_2";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`uname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`ipadd` varchar(100) NOT NULL DEFAULT 'noxxx',
								`dts` varchar(100) NOT NULL DEFAULT 'noxxx',
								`action` varchar(100) NOT NULL DEFAULT 'noxxx',
								`empid` int(10) unsigned NOT NULL,
								PRIMARY KEY (`id`),
								KEY (`uname`),
								KEY (`empid`),
								CONSTRAINT `$fk1` FOREIGN KEY (`uname`) REFERENCES `user` (`uname`),
								CONSTRAINT `$fk2` FOREIGN KEY (`empid`) REFERENCES `employee` (`id`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}

		//Create egr Table
		public function cregrtable(){
			$ret = "";
			$tablename = "egr";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$fk2 = $tablename."_ibfk_2";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`clid` int(10) unsigned NOT NULL,
								`uname` varchar(100) NOT NULL DEFAULT 'noxxx',
								PRIMARY KEY (`id`),
								KEY (`clid`),
								KEY (`uname`),
								CONSTRAINT `$fk1` FOREIGN KEY (`clid`) REFERENCES `client` (`id`),
								CONSTRAINT `$fk2` FOREIGN KEY (`uname`) REFERENCES `user` (`uname`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}

		//Create egr log Table
		public function cregrlogtable(){
			$ret = "";
			$tablename = "egrlog";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$fk2 = $tablename."_ibfk_2";
						$fk3 = $tablename."_ibfk_3";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`uname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`ipadd` varchar(100) NOT NULL DEFAULT 'noxxx',
								`dts` varchar(100) NOT NULL DEFAULT 'noxxx',
								`action` varchar(100) NOT NULL DEFAULT 'noxxx',
								`clid` int(10) unsigned NOT NULL,
								`gname` varchar(100) NOT NULL DEFAULT 'noxxx',
								PRIMARY KEY (`id`),
								KEY (`uname`),
								KEY (`clid`),
								CONSTRAINT `$fk1` FOREIGN KEY (`uname`) REFERENCES `user` (`uname`),
								CONSTRAINT `$fk2` FOREIGN KEY (`clid`) REFERENCES `client` (`id`),
								CONSTRAINT `$fk3` FOREIGN KEY (`gname`) REFERENCES `user` (`uname`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}

		//Create contact Table
		public function crcontable(){
			$ret = "";
			$tablename = "contact";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$fk2 = $tablename."_ibfk_2";
						$fk3 = $tablename."_ibfk_3";
						$fk4 = $tablename."_ibfk_4";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`clid` int(10) unsigned NOT NULL,
								`locid` int(10) unsigned NOT NULL,
								`uname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`empid` int(10) unsigned NOT NULL,
								`contype` varchar(100) NOT NULL DEFAULT 'noxxx',
								`dat` varchar(100) NOT NULL DEFAULT 'noxxx',
								`status` varchar(100) NOT NULL DEFAULT 'noxxx',
								PRIMARY KEY (`id`),
								KEY (`clid`),
								KEY (`locid`),
								KEY (`uname`),
								KEY (`empid`),
								CONSTRAINT `$fk1` FOREIGN KEY (`clid`) REFERENCES `client` (`id`),
								CONSTRAINT `$fk2` FOREIGN KEY (`locid`) REFERENCES `clientloc` (`id`),
								CONSTRAINT `$fk3` FOREIGN KEY (`uname`) REFERENCES `user` (`uname`),
								CONSTRAINT `$fk4` FOREIGN KEY (`empid`) REFERENCES `employee` (`id`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}

		//Create contact log Table
		public function crconlogtable(){
			$ret = "";
			$tablename = "conlog";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$fk2 = $tablename."_ibfk_2";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`uname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`ipadd` varchar(100) NOT NULL DEFAULT 'noxxx',
								`dts` varchar(100) NOT NULL DEFAULT 'noxxx',
								`action` varchar(100) NOT NULL DEFAULT 'noxxx',
								`conid` int(10) unsigned NOT NULL,
								PRIMARY KEY (`id`),
								KEY (`uname`),
								KEY (`conid`),
								CONSTRAINT `$fk1` FOREIGN KEY (`uname`) REFERENCES `user` (`uname`),
								CONSTRAINT `$fk2` FOREIGN KEY (`conid`) REFERENCES `contact` (`id`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}
		
		//Create consult type table
		public function crconstypetable(){
			$ret = FALSE;
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "constype";
					$tex = $this->tex($tablename);
					if (!$tex){
						$sql = "CREATE TABLE IF NOT EXISTS `$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`constype` varchar(100) NOT NULL DEFAULT 'noxxx',
								PRIMARY KEY (`id`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							$ret = TRUE;
						}
					}
				}
			}
			return $ret;
		}
		
		//Populate consult type table
		public function popconstypetable(){
			$ret = FALSE;
			
			$constypearr = array();
			$constypearr[0] = "Health Consult";
			$constypearr[1] = "Injury Consult";
			$constypearr[2] = "Opportunity Consult";
			$constypearr[3] = "Proactive Constult";
			$constypearr[4] = "Well Credit";
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "constype";
					$tex = $this->tex($tablename);
					if ($tex){
						foreach ($constypearr as $value){
							$sql = "INSERT INTO `$this->db`.`$tablename` (
							`id`, 
							`constype`
							)
							VALUES (
								NULL,
								'$value'
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
		
		//Combined function for constype table
		public function comconstype(){
			$ret = "";
			
			$res1 = $this->crconstypetable();
			if ($res1){
				$res2 = $this->popconstypetable();
				if ($res2){
					$ret = "Consult type table created and populated successfully";
				}
				else{
					$ret = "Consult type table created but NOT populated";
				}
			}
			else{
				$ret = "Could not create consult type table";
			}
			return $ret;
		}
		
		//Create topic table
		public function crtopictable(){
			$ret = "";
			$tablename = "topic";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`constypeid` int(10) unsigned NOT NULL,
								`topic` varchar(100) NOT NULL DEFAULT 'noxxx',
								`ttype` varchar(100) NOT NULL DEFAULT 'noxxx',
								`tname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`tid` varchar(100) NOT NULL DEFAULT 'noxxx',
								`tclass` varchar(100) NOT NULL DEFAULT 'noxxx',
								`status` varchar(100) NOT NULL DEFAULT 'noxxx',
								PRIMARY KEY (`id`),
								KEY (`constypeid`),
								CONSTRAINT `$fk1` FOREIGN KEY (`constypeid`) REFERENCES `constype` (`id`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}
		
		//Create topic log Table
		public function crtopiclogtable(){
			$ret = "";
			$tablename = "topiclog";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$fk2 = $tablename."_ibfk_2";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`uname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`ipadd` varchar(100) NOT NULL DEFAULT 'noxxx',
								`dts` varchar(100) NOT NULL DEFAULT 'noxxx',
								`action` varchar(100) NOT NULL DEFAULT 'noxxx',
								`topicid` int(10) unsigned NOT NULL,
								PRIMARY KEY (`id`),
								KEY (`uname`),
								KEY (`topicid`),
								CONSTRAINT `$fk1` FOREIGN KEY (`uname`) REFERENCES `user` (`uname`),
								CONSTRAINT `$fk2` FOREIGN KEY (`topicid`) REFERENCES `topic` (`id`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}

		//Create sub-topic table
		public function crsubtopictable(){
			$ret = "";
			$tablename = "subtopic";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$fk2 = $tablename."_ibfk_2";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`constypeid` int(10) unsigned NOT NULL,
								`topicid` int(10) unsigned NOT NULL,
								`subtopic` varchar(100) NOT NULL DEFAULT 'noxxx',
								`stype` varchar(100) NOT NULL DEFAULT 'noxxx',
								`sname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`sid` varchar(100) NOT NULL DEFAULT 'noxxx',
								`sclass` varchar(100) NOT NULL DEFAULT 'noxxx',
								`status` varchar(100) NOT NULL DEFAULT 'noxxx',
								PRIMARY KEY (`id`),
								KEY (`constypeid`),
								KEY (`topicid`),
								CONSTRAINT `$fk1` FOREIGN KEY (`constypeid`) REFERENCES `constype` (`id`),
								CONSTRAINT `$fk2` FOREIGN KEY (`topicid`) REFERENCES `topic` (`id`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}

		//Create sub-topic log Table
		public function crsubtopiclogtable(){
			$ret = "";
			$tablename = "subtopiclog";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$fk2 = $tablename."_ibfk_2";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`uname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`ipadd` varchar(100) NOT NULL DEFAULT 'noxxx',
								`dts` varchar(100) NOT NULL DEFAULT 'noxxx',
								`action` varchar(100) NOT NULL DEFAULT 'noxxx',
								`subtopicid` int(10) unsigned NOT NULL,
								PRIMARY KEY (`id`),
								KEY (`uname`),
								KEY (`subtopicid`),
								CONSTRAINT `$fk1` FOREIGN KEY (`uname`) REFERENCES `user` (`uname`),
								CONSTRAINT `$fk2` FOREIGN KEY (`subtopicid`) REFERENCES `subtopic` (`id`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}
		
		//Create fields table
		public function crfieldstable(){
			$ret = "";
			$tablename = "fields";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$fk2 = $tablename."_ibfk_2";
						$fk3 = $tablename."_ibfk_3";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`constypeid` int(10) unsigned NOT NULL,
								`topicid` int(10) unsigned NOT NULL,
								`subtopicid` int(10) unsigned NOT NULL,
								`fldname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`flname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`fltype` varchar(100) NOT NULL DEFAULT 'noxxx',
								`flid` varchar(100) NOT NULL DEFAULT 'noxxx',
								`flclass` varchar(100) NOT NULL DEFAULT 'noxxx',
								`flbase` varchar(100) NOT NULL DEFAULT 'noxxx',
								`status` varchar(100) NOT NULL DEFAULT 'noxxx',
								PRIMARY KEY (`id`),
								KEY (`constypeid`),
								KEY (`topicid`),
								KEY (`subtopicid`),
								CONSTRAINT `$fk1` FOREIGN KEY (`constypeid`) REFERENCES `constype` (`id`),
								CONSTRAINT `$fk2` FOREIGN KEY (`topicid`) REFERENCES `topic` (`id`),
								CONSTRAINT `$fk3` FOREIGN KEY (`subtopicid`) REFERENCES `subtopic` (`id`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}
		
		//Create fields log Table
		public function crfieldslogtable(){
			$ret = "";
			$tablename = "fieldslog";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$fk2 = $tablename."_ibfk_2";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`uname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`ipadd` varchar(100) NOT NULL DEFAULT 'noxxx',
								`dts` varchar(100) NOT NULL DEFAULT 'noxxx',
								`action` varchar(100) NOT NULL DEFAULT 'noxxx',
								`fieldid` int(10) unsigned NOT NULL,
								PRIMARY KEY (`id`),
								KEY (`uname`),
								KEY (`fieldid`),
								CONSTRAINT `$fk1` FOREIGN KEY (`uname`) REFERENCES `user` (`uname`),
								CONSTRAINT `$fk2` FOREIGN KEY (`fieldid`) REFERENCES `fields` (`id`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}
		
		//Create health consult main table
		public function crhcmaintable(){
			$ret = "";
			$tablename = "hcmain";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`conid` int(10) unsigned NOT NULL,
								PRIMARY KEY (`id`),
								KEY (`conid`),
								CONSTRAINT `$fk1` FOREIGN KEY (`conid`) REFERENCES `contact` (`id`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}
		
		//Create health consult dump table
		public function crhcdumptable(){
			$ret = "";
			$tablename = "hcdump";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`hcid` int(10) unsigned NOT NULL,
								`name` varchar(100) NOT NULL DEFAULT 'noxxx',
								`value` varchar(1000) NOT NULL DEFAULT 'noxxx',
								PRIMARY KEY (`id`),
								KEY (`hcid`),
								CONSTRAINT `$fk1` FOREIGN KEY (`hcid`) REFERENCES `hcmain` (`id`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}

		//Create health consult soap table
		public function crhcsoaptable(){
			$ret = "";
			$tablename = "hcsoap";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`hcid` int(10) unsigned NOT NULL,
								`name` varchar(100) NOT NULL DEFAULT 'noxxx',
								`value` varchar(1000) NOT NULL DEFAULT 'noxxx',
								PRIMARY KEY (`id`),
								KEY (`hcid`),
								CONSTRAINT `$fk1` FOREIGN KEY (`hcid`) REFERENCES `hcmain` (`id`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}

		//Create health consult log Table
		public function crhclogtable(){
			$ret = "";
			$tablename = "hclog";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$fk2 = $tablename."_ibfk_2";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`uname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`ipadd` varchar(100) NOT NULL DEFAULT 'noxxx',
								`dts` varchar(100) NOT NULL DEFAULT 'noxxx',
								`action` varchar(100) NOT NULL DEFAULT 'noxxx',
								`hcid` int(10) unsigned NOT NULL,
								PRIMARY KEY (`id`),
								KEY (`uname`),
								KEY (`hcid`),
								CONSTRAINT `$fk1` FOREIGN KEY (`uname`) REFERENCES `user` (`uname`),
								CONSTRAINT `$fk2` FOREIGN KEY (`hcid`) REFERENCES `hcmain` (`id`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}

		//Create body part table
		public function crbptable(){
			$ret = "";
			$tablename = "bodypart";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`bp` varchar(100) NOT NULL DEFAULT 'noxxx',
								`status` varchar(100) NOT NULL DEFAULT 'noxxx',
								PRIMARY KEY (`id`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}
		
		//Create body part log Table
		public function crbplogtable(){
			$ret = "";
			$tablename = "bplog";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$fk2 = $tablename."_ibfk_2";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`uname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`ipadd` varchar(100) NOT NULL DEFAULT 'noxxx',
								`dts` varchar(100) NOT NULL DEFAULT 'noxxx',
								`action` varchar(100) NOT NULL DEFAULT 'noxxx',
								`bpid` int(10) unsigned NOT NULL,
								PRIMARY KEY (`id`),
								KEY (`uname`),
								KEY (`bpid`),
								CONSTRAINT `$fk1` FOREIGN KEY (`uname`) REFERENCES `user` (`uname`),
								CONSTRAINT `$fk2` FOREIGN KEY (`bpid`) REFERENCES `bodypart` (`id`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}

		//Create injury table
		public function crinjurytable(){
			$ret = "";
			$tablename = "injury";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`bpid` int(10) unsigned NOT NULL,
								`ij` varchar(100) NOT NULL DEFAULT 'noxxx',
								`status` varchar(100) NOT NULL DEFAULT 'noxxx',
								PRIMARY KEY (`id`),
								KEY (`bpid`),
								CONSTRAINT `$fk1` FOREIGN KEY (`bpid`) REFERENCES `bodypart` (`id`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}

		//Create injury log Table
		public function crijlogtable(){
			$ret = "";
			$tablename = "ijlog";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$fk2 = $tablename."_ibfk_2";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`uname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`ipadd` varchar(100) NOT NULL DEFAULT 'noxxx',
								`dts` varchar(100) NOT NULL DEFAULT 'noxxx',
								`action` varchar(100) NOT NULL DEFAULT 'noxxx',
								`ijid` int(10) unsigned NOT NULL,
								PRIMARY KEY (`id`),
								KEY (`uname`),
								KEY (`ijid`),
								CONSTRAINT `$fk1` FOREIGN KEY (`uname`) REFERENCES `user` (`uname`),
								CONSTRAINT `$fk2` FOREIGN KEY (`ijid`) REFERENCES `injury` (`id`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}
		
		//Create injury consult main table
		public function cricmaintable(){
			$ret = "";
			$tablename = "icmain";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`conid` int(10) unsigned NOT NULL,
								PRIMARY KEY (`id`),
								KEY (`conid`),
								CONSTRAINT `$fk1` FOREIGN KEY (`conid`) REFERENCES `contact` (`id`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}
		
		//Create injury consult dump table
		public function cricdumptable(){
			$ret = "";
			$tablename = "icdump";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`icid` int(10) unsigned NOT NULL,
								`name` varchar(100) NOT NULL DEFAULT 'noxxx',
								`value` varchar(1000) NOT NULL DEFAULT 'noxxx',
								PRIMARY KEY (`id`),
								KEY (`icid`),
								CONSTRAINT `$fk1` FOREIGN KEY (`icid`) REFERENCES `icmain` (`id`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}

		//Create injury consult soap table
		public function cricsoaptable(){
			$ret = "";
			$tablename = "icsoap";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`icid` int(10) unsigned NOT NULL,
								`name` varchar(100) NOT NULL DEFAULT 'noxxx',
								`value` varchar(1000) NOT NULL DEFAULT 'noxxx',
								PRIMARY KEY (`id`),
								KEY (`icid`),
								CONSTRAINT `$fk1` FOREIGN KEY (`icid`) REFERENCES `icmain` (`id`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}

		//Create injury consult log Table
		public function criclogtable(){
			$ret = "";
			$tablename = "iclog";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$fk2 = $tablename."_ibfk_2";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`uname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`ipadd` varchar(100) NOT NULL DEFAULT 'noxxx',
								`dts` varchar(100) NOT NULL DEFAULT 'noxxx',
								`action` varchar(100) NOT NULL DEFAULT 'noxxx',
								`icid` int(10) unsigned NOT NULL,
								PRIMARY KEY (`id`),
								KEY (`uname`),
								KEY (`icid`),
								CONSTRAINT `$fk1` FOREIGN KEY (`uname`) REFERENCES `user` (`uname`),
								CONSTRAINT `$fk2` FOREIGN KEY (`icid`) REFERENCES `icmain` (`id`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}

		//Create opportunity consult main table
		public function crocmaintable(){
			$ret = "";
			$tablename = "ocmain";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`conid` int(10) unsigned NOT NULL,
								PRIMARY KEY (`id`),
								KEY (`conid`),
								CONSTRAINT `$fk1` FOREIGN KEY (`conid`) REFERENCES `contact` (`id`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}
		
		//Create opportunity consult dump table
		public function crocdumptable(){
			$ret = "";
			$tablename = "ocdump";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`ocid` int(10) unsigned NOT NULL,
								`name` varchar(100) NOT NULL DEFAULT 'noxxx',
								`value` varchar(1000) NOT NULL DEFAULT 'noxxx',
								PRIMARY KEY (`id`),
								KEY (`ocid`),
								CONSTRAINT `$fk1` FOREIGN KEY (`ocid`) REFERENCES `ocmain` (`id`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}

		//Create opportunity consult log Table
		public function croclogtable(){
			$ret = "";
			$tablename = "oclog";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$fk2 = $tablename."_ibfk_2";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`uname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`ipadd` varchar(100) NOT NULL DEFAULT 'noxxx',
								`dts` varchar(100) NOT NULL DEFAULT 'noxxx',
								`action` varchar(100) NOT NULL DEFAULT 'noxxx',
								`ocid` int(10) unsigned NOT NULL,
								PRIMARY KEY (`id`),
								KEY (`uname`),
								KEY (`ocid`),
								CONSTRAINT `$fk1` FOREIGN KEY (`uname`) REFERENCES `user` (`uname`),
								CONSTRAINT `$fk2` FOREIGN KEY (`ocid`) REFERENCES `ocmain` (`id`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}

		//Create proactive consult main table
		public function crpcmaintable(){
			$ret = "";
			$tablename = "pcmain";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`conid` int(10) unsigned NOT NULL,
								PRIMARY KEY (`id`),
								KEY (`conid`),
								CONSTRAINT `$fk1` FOREIGN KEY (`conid`) REFERENCES `contact` (`id`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}
		
		//Create proactive consult dump table
		public function crpcdumptable(){
			$ret = "";
			$tablename = "pcdump";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`pcid` int(10) unsigned NOT NULL,
								`name` varchar(100) NOT NULL DEFAULT 'noxxx',
								`value` varchar(1000) NOT NULL DEFAULT 'noxxx',
								PRIMARY KEY (`id`),
								KEY (`pcid`),
								CONSTRAINT `$fk1` FOREIGN KEY (`pcid`) REFERENCES `pcmain` (`id`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}

		//Create proactive consult log Table
		public function crpclogtable(){
			$ret = "";
			$tablename = "pclog";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$fk2 = $tablename."_ibfk_2";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`uname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`ipadd` varchar(100) NOT NULL DEFAULT 'noxxx',
								`dts` varchar(100) NOT NULL DEFAULT 'noxxx',
								`action` varchar(100) NOT NULL DEFAULT 'noxxx',
								`pcid` int(10) unsigned NOT NULL,
								PRIMARY KEY (`id`),
								KEY (`uname`),
								KEY (`pcid`),
								CONSTRAINT `$fk1` FOREIGN KEY (`uname`) REFERENCES `user` (`uname`),
								CONSTRAINT `$fk2` FOREIGN KEY (`pcid`) REFERENCES `pcmain` (`id`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}

		//Create well credit main table
		public function crwcmaintable(){
			$ret = "";
			$tablename = "wcmain";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`conid` int(10) unsigned NOT NULL,
								PRIMARY KEY (`id`),
								KEY (`conid`),
								CONSTRAINT `$fk1` FOREIGN KEY (`conid`) REFERENCES `contact` (`id`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}
		
		//Create well credit dump table
		public function crwcdumptable(){
			$ret = "";
			$tablename = "wcdump";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`wcid` int(10) unsigned NOT NULL,
								`name` varchar(100) NOT NULL DEFAULT 'noxxx',
								`value` varchar(1000) NOT NULL DEFAULT 'noxxx',
								PRIMARY KEY (`id`),
								KEY (`wcid`),
								CONSTRAINT `$fk1` FOREIGN KEY (`wcid`) REFERENCES `wcmain` (`id`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}

		//Create well credit log Table
		public function crwclogtable(){
			$ret = "";
			$tablename = "wclog";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$fk2 = $tablename."_ibfk_2";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`uname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`ipadd` varchar(100) NOT NULL DEFAULT 'noxxx',
								`dts` varchar(100) NOT NULL DEFAULT 'noxxx',
								`action` varchar(100) NOT NULL DEFAULT 'noxxx',
								`wcid` int(10) unsigned NOT NULL,
								PRIMARY KEY (`id`),
								KEY (`uname`),
								KEY (`wcid`),
								CONSTRAINT `$fk1` FOREIGN KEY (`uname`) REFERENCES `user` (`uname`),
								CONSTRAINT `$fk2` FOREIGN KEY (`wcid`) REFERENCES `wcmain` (`id`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}

		//Create well credit relationship table
		public function crwcrtable(){
			$ret = "";
			$tablename = "wcr";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`clid` int(10) unsigned NOT NULL,
								`sdate` varchar(100) NOT NULL DEFAULT 'noxxx',
								`edate` varchar(1000) NOT NULL DEFAULT 'noxxx',
								PRIMARY KEY (`id`),
								KEY (`clid`),
								CONSTRAINT `$fk1` FOREIGN KEY (`clid`) REFERENCES `client` (`id`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}

		//Create wcr log Table
		public function crwcrlogtable(){
			$ret = "";
			$tablename = "wcrlog";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$fk2 = $tablename."_ibfk_2";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`uname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`ipadd` varchar(100) NOT NULL DEFAULT 'noxxx',
								`dts` varchar(100) NOT NULL DEFAULT 'noxxx',
								`action` varchar(100) NOT NULL DEFAULT 'noxxx',
								`wcrid` int(10) unsigned NOT NULL,
								PRIMARY KEY (`id`),
								KEY (`uname`),
								KEY (`wcrid`),
								CONSTRAINT `$fk1` FOREIGN KEY (`uname`) REFERENCES `user` (`uname`),
								CONSTRAINT `$fk2` FOREIGN KEY (`wcrid`) REFERENCES `wcr` (`id`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}

		//Create hctonee table
		public function crhctoneetable(){
			$ret = "";
			$tablename = "hctonee";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`constypeid` int(10) unsigned NOT NULL,
								`hctonee` varchar(100) NOT NULL DEFAULT 'noxxx',
								`ttype` varchar(100) NOT NULL DEFAULT 'noxxx',
								`tname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`tid` varchar(100) NOT NULL DEFAULT 'noxxx',
								`tclass` varchar(100) NOT NULL DEFAULT 'noxxx',
								`bval` varchar(100) NOT NULL DEFAULT 'noxxx',
								`status` varchar(100) NOT NULL DEFAULT 'noxxx',
								PRIMARY KEY (`id`),
								KEY (`constypeid`),
								CONSTRAINT `$fk1` FOREIGN KEY (`constypeid`) REFERENCES `constype` (`id`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}
		
		//Create hctonee log Table
		public function crhctoneelogtable(){
			$ret = "";
			$tablename = "hctoneelog";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$fk2 = $tablename."_ibfk_2";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`uname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`ipadd` varchar(100) NOT NULL DEFAULT 'noxxx',
								`dts` varchar(100) NOT NULL DEFAULT 'noxxx',
								`action` varchar(100) NOT NULL DEFAULT 'noxxx',
								`hctoneeid` int(10) unsigned NOT NULL,
								PRIMARY KEY (`id`),
								KEY (`uname`),
								KEY (`hctoneeid`),
								CONSTRAINT `$fk1` FOREIGN KEY (`uname`) REFERENCES `user` (`uname`),
								CONSTRAINT `$fk2` FOREIGN KEY (`hctoneeid`) REFERENCES `hctonee` (`id`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}
		
		//Create wce table
		public function crwcetable(){
			$ret = "";
			$tablename = "wce";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`constypeid` int(10) unsigned NOT NULL,
								`wce` varchar(100) NOT NULL DEFAULT 'noxxx',
								`ttype` varchar(100) NOT NULL DEFAULT 'noxxx',
								`tname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`tid` varchar(100) NOT NULL DEFAULT 'noxxx',
								`tclass` varchar(100) NOT NULL DEFAULT 'noxxx',
								`bval` varchar(100) NOT NULL DEFAULT 'noxxx',
								`status` varchar(100) NOT NULL DEFAULT 'noxxx',
								PRIMARY KEY (`id`),
								KEY (`constypeid`),
								CONSTRAINT `$fk1` FOREIGN KEY (`constypeid`) REFERENCES `constype` (`id`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}
		
		//Create wce log Table
		public function crwcelogtable(){
			$ret = "";
			$tablename = "wcelog";
			$dbhandle = $this->dbhandle();
			if(!$dbhandle){
				$ret = "Error connecting to database";
			}
			else{
				$dbfound = $this->dbfound();
				if(!$dbfound){
					$ret = "Database does not exist";
				}
				else{
					$tex = $this->tex($tablename);
					if($tex){
						$ret = "Table already exists";
					}
					else{
						$fk1 = $tablename."_ibfk_1";
						$fk2 = $tablename."_ibfk_2";
						$sql = "CREATE TABLE IF NOT EXISTS`$tablename`(
								`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								`uname` varchar(100) NOT NULL DEFAULT 'noxxx',
								`ipadd` varchar(100) NOT NULL DEFAULT 'noxxx',
								`dts` varchar(100) NOT NULL DEFAULT 'noxxx',
								`action` varchar(100) NOT NULL DEFAULT 'noxxx',
								`wceid` int(10) unsigned NOT NULL,
								PRIMARY KEY (`id`),
								KEY (`uname`),
								KEY (`wceid`),
								CONSTRAINT `$fk1` FOREIGN KEY (`uname`) REFERENCES `user` (`uname`),
								CONSTRAINT `$fk2` FOREIGN KEY (`wceid`) REFERENCES `wce` (`id`)
								)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
								
						$result = mysql_query($sql, $dbhandle);
						if($result){
							$ret = "Table successfully created";
						}
						else{
							$ret = "Error creating table";
						}
					}
				}
			}
			return $ret;
		}

    }
?>