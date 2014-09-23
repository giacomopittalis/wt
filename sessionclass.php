<?php
	 $dbserver = "welltrail.cg1maemtimf4.us-west-2.rds.amazonaws.com";
	 $dbusername = "welltrail";
	 $dbpass = "w3lltra1l";
	 $db = "welltrail";
    class session {
    	
		private $inactive = 600;
		
		private $dbserver = "welltrail.cg1maemtimf4.us-west-2.rds.amazonaws.com";
		private $dbusername = "welltrail";
		private $dbpass = "w3lltra1l";
		public $db = "welltrail";
		
		//Database Handle
		public function dbhandle(){
			$dbhandle = mysql_connect($this->dbserver, $this->dbusername, $this->dbpass);
			return $dbhandle;
		}
		
		//Check if database exists
		public function dbfound(){
			$dbhandle = $this->dbhandle();
			$dbfound = mysql_select_db($this->db, $dbhandle);
			return $dbfound;
		}
		
		//Check if Table Exists
		public function tex($tablename){
			$dbhandle = $this->dbhandle();
			$ret = FALSE;
			if($dbhandle){
				$dbfound = $this->dbfound();
				if($dbfound){
					$sql = "SELECT 1 FROM $tablename";
					$result = mysql_query($sql, $dbhandle);
					if($result){
						$ret = TRUE;
					}
				}
			}
			return $ret;
		}
		
		public function injcheck($data){
			$dbhandle = $this->dbhandle();
			if (get_magic_quotes_gpc()){
				$data = stripcslashes($data);
			}
			if (!is_numeric($data)){
				$data = mysql_real_escape_string($data, $dbhandle);
			}
			return $data;
		}
		
		private $skey 	= "PuRnIma1953"; // you can change it
 
    	private function safe_b64encode($string) {
 
        	$data = base64_encode($string);
        	$data = str_replace(array('+','/','='),array('-','_',''),$data);
        	return $data;
    	}
 
		private function safe_b64decode($string) {
        	$data = str_replace(array('-','_'),array('+','/'),$string);
        	$mod4 = strlen($data) % 4;
        	if ($mod4) {
            	$data .= substr('====', $mod4);
        	}
        	return base64_decode($data);
    	}
 
    	public  function encode($value){ 
 
	    	if(!$value){
	    		return false;
			}
        	$text = $value;
        	$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        	$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        	$crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->skey, $text, MCRYPT_MODE_ECB, $iv);
        	return trim($this->safe_b64encode($crypttext)); 
    	}
 
    	public function decode($value){
 
        	if(!$value){
        		return false;
        	}
        	$crypttext = $this->safe_b64decode($value); 
        	$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        	$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        	$decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->skey, $crypttext, MCRYPT_MODE_ECB, $iv);
        	return trim($decrypttext);
    	}
    	
		public function token($length){
			$random= "";
  			srand((double)microtime()*1000000);
  			$char_list = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  			$char_list .= "abcdefghijklmnopqrstuvwxyz";
  			$char_list .= "1234567890";
  			// Add the special characters to $char_list if needed

  			for($i = 0; $i < $length; $i++)  
  			{    
     			$random .= substr($char_list,(rand()%(strlen($char_list))), 1);  
  			}  
  			return $random;
		}
		
		public function setimeout(){
    		$ret = TRUE;
    		$sessionlife = time() - $_SESSION['timeout'];
			if ($sessionlife > $this->inactive){
				$ret = FALSE;
			}
			return $ret;
    	}
		
		//Check if all session variables are set and not null
		public function sex(){
			$ret = FALSE;
			if (
			(isset($_SESSION['priv']) && $_SESSION['priv'] != "") && 
			(isset($_SESSION['uname']) && $_SESSION['uname'] != "") && 
			(isset($_SESSION['ipadd']) && $_SESSION['ipadd'] != "") &&
			(isset($_SESSION['uagent']) && $_SESSION['uagent'] != "") &&
			(isset($_SESSION['token']) && $_SESSION['token'] != "") &&
			(isset($_SESSION['timeout']) && $_SESSION['timeout'] != "")
			){
				$ret = TRUE;
			}
			return $ret;
		}
		
		//Check if all session variables match with database values
		public function sematch(){
			$ret = FALSE;
			$sexadmin = $this->sex();
			if ($sexadmin){
				$dbhandle = $this->dbhandle();
				if ($dbhandle){
					$dbfound = $this->dbfound();
					if ($dbfound){
						$tablename = "session";
						$tex = $this->tex($tablename);
						if ($tex){
							$euname = $_SESSION['uname'];
							$sql = "SELECT * FROM `$this->db`.`$tablename` WHERE `$tablename`.`uname` = '$euname'";
							$result = mysql_query($sql, $dbhandle);
							if ($result){
								if (mysql_num_rows($result) > 0){
									$sexarr = mysql_fetch_assoc($result);
									if (
									($_SESSION['priv'] == $sexarr['priv']) && 
									($_SESSION['uname']) == $sexarr['uname'] && 
									($_SESSION['ipadd']) == $sexarr['ipadd'] &&
									($_SESSION['uagent']) == $sexarr['uagent'] && 
									($_SESSION['token']) == $sexarr['token'] &&
									($_SESSION['timeout'] == $sexarr['timeout'])
									){
										$ret = TRUE;
									}
								}
							}
						}
					}
				}
			}
			return $ret;
		}
		
		//Check if user is an admin
		public function secheckadmin(){
			$ret = FALSE;
			$sematch = $this->sematch();
			if ($sematch){
				$admin = "admin";
				$eadmin = $this->encode($admin);
				if ($_SESSION['priv'] == $eadmin){
					$ret = TRUE;
				}
			}
			return $ret;
		}
		
		//Check if user is admin or guide
		public function secheckadminguide(){
			$ret = FALSE;
			$sematch = $this->sematch();
			if ($sematch){
				$admin = "admin";
				$eadmin = $this->encode($admin);
				$guide = "guide";
				$eguide = $this->encode($guide);
				if ($_SESSION['priv'] == $eadmin || $_SESSION['priv'] == $eguide){
					$ret = TRUE;
				}
			}
			return $ret;
		}
		
		//Update session variables		
		public function seupdate(){
			$ret = FALSE;
			$length = 12;
			$timeout = time();
			$token = $this->token($length);
			$token = $this->encode($token);
			$euname = $_SESSION['uname'];
			$_SESSION['token'] = $token;
			$_SESSION['timeout'] = $timeout;
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "session";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "UPDATE `$this->db`.`$tablename` SET `$tablename`.`token` = '$token', `$tablename`.`timeout` = '$timeout' WHERE `$tablename`.`uname` = '$euname'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							$ret = TRUE;
						}
					}
				}
			}
			return $ret;
		}
		
		//Combined admin session function
		public function seadmin(){
			$ret = FALSE;
			$secheck = $this->secheckadmin();
			if ($secheck){
				$sto = $this->setimeout();
				if ($sto){
					$ret = $this->seupdate();
					if (!$ret){
						header("location: logout.php");
					}
					else{
						$ret = TRUE;
					}
				}
				else{
					header("location: logout.php");
				}
			}
			else{
				header("location: logout.php");
			}
			return $ret;
		}
		
		//Combined admin guide session function
		public function seadminguide(){
			$ret = FALSE;
			$secheck = $this->secheckadminguide();
			if ($secheck){
				$sto = $this->setimeout();
				if ($sto){
					$ret = $this->seupdate();
					if (!$ret){
						header("location: logout.php");
					}
					else{
						$ret = TRUE;
					}
				}
				else{
					header("location: logout.php");
				}
			}
			else{
				header("location: logout.php");
			}
			return $ret;
		}
		
		//Login page redirection function
		public function redl(){
			$admin = "admin";
			$guide = "guide";
			$eadmin = $this->encode($admin);
			$eguide = $this->encode($guide);
			if ($_SESSION['priv'] == $eadmin){
				header("location: adash.php");
			}
			if ($_SESSION['priv'] == $eguide){
				header("location: gdash.php");
			}
		}
		
    }
?>