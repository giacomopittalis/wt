<?php
    class su {
    	
		private $inactive = 600;
		
    	//This function checks if super user username and password combination is correct
		private function suauth($uname, $pass){
			include 'cryptclass.php';
			$obj = new crypt;
			$ret = FALSE;
			
			$euname = $obj->encode($uname);
			$epass = $obj->encode($pass);
			
			$muname = "demo123";
			$mpass = "demo12345";
			
			$emuname = $obj->encode($muname);
			$empass = $obj->encode($mpass);
			
			if ($euname == $emuname && $epass == $empass){
				$ret = TRUE;
			}
			return $ret;
		}
		
		public function cleaninput($input){
			$ret = "";
			$q = ENT_NOQUOTES;
			
			$ret = trim($input);
			$ret = htmlspecialchars($ret, $q);
			
			return $ret;
		}
		
		private function validateuname($uname){
			$ret = TRUE;
			
			if ($uname == ""){
				$ret = FALSE;
			}
			else{
				if (strlen($uname) < 6){
					$ret = FALSE;
				}
				else{
					if (strlen($uname) > 20){
						$ret = FALSE;
					}
				}
			}
			
			return $ret;
		}
		
		private function validatepass($pass){
			$ret = TRUE;
			
			if ($pass == ""){
				$ret = FALSE;
			}
			else{
				if (strlen($pass) < 8){
					$ret = FALSE;
				}
				else{
					if (strlen($pass) > 20){
						$ret = FALSE;
					}
				}
			}
			
			return $ret;
		}
		
		public function validation($uname, $pass){
			$ret = TRUE;
			
			$uname = $this->cleaninput($uname);
			$pass = $this->cleaninput($pass);
			
			$unameval = $this->validateuname($uname);
			$passval = $this->validatepass($pass);
			
			if (!($unameval && $passval)){
				$ret = FALSE;
			}
			else{
				$auth = $this->suauth($uname, $pass);
				if (!$auth){
					$ret = FALSE;
				}
			}
			return $ret;
		}
		
		public function susss(){
			$ret = FALSE;
			if (isset($_SESSION['priv']) && $_SESSION['priv'] != "" && $_SESSION['priv'] == "suser" && isset($_SESSION['timeout']) && $_SESSION['timeout'] != ""){
				$ret = TRUE;
			}
			return $ret;
		}
		
    	public function sutimeout(){
    		$ret = TRUE;
    		$sessionlife = time() - $_SESSION['timeout'];
			if ($sessionlife > $this->inactive){
				$ret = FALSE;
			}
			return $ret;
    	}
    }
?>