<?php
	include 'cryptclass.php';
	class db extends crypt{
		
		private $dbserver = "localhost";
		private $dbusername = "purnimap_well";
		private $dbpass = "matt1234";
		public $db = "purnimap_matt";
		
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
		
	}
?>