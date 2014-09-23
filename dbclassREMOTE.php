<?php
	include_once 'cryptclass.php';
	class db extends crypt{
		
		private $dbserver = "";
		private $dbusername = "";
		private $dbpass = "";
		public $db = "";

		
		function db(){
			$site="kompleet";//change this to change the SITE it will function on
			if($site=="kompleet"){
				 $dbserver = "localhost";
				 $dbusername = "root";
				 $dbpass = "K0mpl33t";
				 $db = "welltrail";
			}
			if($site=="home"){
				$dbserver = "localhost";
				$dbusername = "root";
				//private $dbpass = "K0mpl33t";
				$dbpass = "";
				$db = "welltrail";
			}
			if($site=="justhost"){
				$dbserver = "localhost";
				$dbusername = "vivanpc1_DB";
				//private $dbpass = "K0mpl33t";
				$dbpass = "letmein5";
				$db = "vivanpc1_welltrail";
			}
			$this->dbserver = $dbserver;
			$this->dbusername = $dbusername;
			$this->dbpass = $dbpass;
			$this->db = $db;
		}

		//Database Handle
		public function dbhandle(){
			$dbhandle = mysql_connect($this->dbserver, $this->dbusername, $this->dbpass);
			return $dbhandle;
		}
		//Database Handle
		public function dbhandleSQLI(){
			$dbhandleSQLI = mysqli_connect($this->dbserver, $this->dbusername, $this->dbpass);
			return $dbhandleSQLI;
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
			$return = FALSE;
			if($dbhandle){
				$dbfound = $this->dbfound();
				if($dbfound){
					$sql = "SELECT 1 FROM $tablename";
					$result = mysql_query($sql, $dbhandle);
					if($result){
						$return = TRUE;
					}
				}
			}
			return $return;
		}
				//Check if Table Exists
		public function tableExists($tablename){
			$dbhandle = $this->dbhandle();
			$return = FALSE;
			if($dbhandle){
				$dbfound = $this->dbfound();
				if($dbfound){
					$sql = "SELECT 1 FROM $tablename";
					$result = mysql_query($sql, $dbhandle);
					if($result){
						$return = TRUE;
					}
				}
			}
			return $return;
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
		
function objectRSort(&$object, $key) 
    { 
        for ($i = count($object) - 1; $i >= 0; $i--) 
        { 
          $swapped = false; 
          for ($j = 0; $j < $i; $j++) 
          { 
               if ($object[$j]->$key < $object[$j + 1]->$key) 
               { 
                    $tmp = $object[$j]; 
                    $object[$j] = $object[$j + 1];       
                    $object[$j + 1] = $tmp; 
                    $swapped = true; 
               } 
          } 
          if (!$swapped) return; 
        } 
    } 

}
?>