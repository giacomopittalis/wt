<?php
	include "dbclass.php";
    class user extends db{
    	
		public function cleaninput($input){
			$ret = "";
			$q = ENT_NOQUOTES;
			
			$ret = trim($input);
			$ret = htmlspecialchars($ret, $q);
			
			return $ret;
		}
    	
		private function checuname($name){
			if(preg_match("/^[a-zA-Z0-9-_ ]+$/", $name) === 0){
				$cname = TRUE;
			}
			else{
				$cname = FALSE;
			}
			return $cname;
		}
		
		private function unameexcheck($uname){
			$ret = FALSE;
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
							if (mysql_num_rows($result) > 0){
								$ret = TRUE;
							}
						}
					}
				}
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
					"First name cannot be more than 30 characters";
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
		
		public function vuname($uname){
			$ret = "";
			if ($uname == ""){
				$ret = "Username cannot be empty";
			}
			else{
				if (strlen($uname) > 20){
					"Username cannot be more than 20 characters";
				}
				else{
					if (strlen($uname) < 6){
						$ret = "Username must be atleast 6 characters long";
					}
					else{
						if ($this->checuname($uname)){
							$ret = "Username can only contain letters, numbers, hyphen and underscore";
						}
						else{
							if ($this->unameexcheck($uname)){
								$ret = "Username already exists";
							}
						}
					}
				}
			}
			return $ret;
		}
		
		public function vpass($pass){
			$ret = "";
			if ($pass == ""){
				$ret = "Password cannot be empty";
			}
			else{
				if (strlen($pass) > 20){
					"Password cannot be more than 20 characters";
				}
				else{
					if (strlen($pass) < 8){
						$ret = "Password must be atleast 8 characters long";
					}
				}
			}
			return $ret;
		}
		
		public function vpassx($pass, $passx){
			$ret = "";
			if ($pass != $passx){
				$ret = "Passwords do not match";
			}
			return $ret;
		}
		
		public function crnewuser($fname, $mname, $lname, $street, $city, $zip, $state, $tel, $cell, $email, $empid, $desg, $uname, $pass, $destination, $priv, $status1, $status2){
			
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
			$uname = $this->injcheck($uname);
			$pass = $this->injcheck($pass);
			$destination = $this->injcheck($destination);
			$priv = $this->injcheck($priv);
			$status1 = $this->injcheck($status1);
			$status2 = $this->injcheck($status2);
			
			$uname = strtolower($uname);
			
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
			$uname = $this->encode($uname);
			$pass = $this->encode($pass);
			$destination = $this->encode($destination);
			$priv = $this->encode($priv);
			$status1 = $this->encode($status1);
			$status2 = $this->encode($status2);
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "user";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "INSERT INTO `$this->db`.`$tablename` (
							`id`, 
							`fname`, 
							`mname`, 
							`lname`, 
							`street`, 
							`city`, 
							`zip`, 
							`state`, 
							`telephone`, 
							`cell`, 
							`email`, 
							`empid`,
							`desg`, 
							`uname`, 
							`pass`, 
							`imgpath`, 
							`priv`, 
							`status1`, 
							`status2`
						)
						VALUES(
							NULL, 
							'$fname', 
							'$mname', 
							'$lname', 
							'$street', 
							'$city', 
							'$zip', 
							'$state', 
							'$tel', 
							'$cell', 
							'$email', 
							'$empid',
							'$desg', 
							'$uname', 
							'$pass', 
							'$destination', 
							'$priv', 
							'$status1', 
							'$status2'
						)";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							$ret = "User created successfully";
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
		
		public function upcreatelog($suname, $ipadd, $dts, $uname){
			$ret = FALSE;
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "createlog";
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
							`cruname`
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
		
    }

	class SimpleImage {
 
   var $image;
   var $image_type;
 
   function load($filename) {
 
      $image_info = getimagesize($filename);
      $this->image_type = $image_info[2];
      if( $this->image_type == IMAGETYPE_JPEG ) {
 
         $this->image = imagecreatefromjpeg($filename);
      } elseif( $this->image_type == IMAGETYPE_GIF ) {
 
         $this->image = imagecreatefromgif($filename);
      } elseif( $this->image_type == IMAGETYPE_PNG ) {
 
         $this->image = imagecreatefrompng($filename);
      }
   }
   function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null) {
 
   // do this or they'll all go to jpeg
   $image_type=$this->image_type;

  if( $image_type == IMAGETYPE_JPEG ) {
     imagejpeg($this->image,$filename,$compression);
  } elseif( $image_type == IMAGETYPE_GIF ) {
     imagegif($this->image,$filename);  
  } elseif( $image_type == IMAGETYPE_PNG ) {
    // need this for transparent png to work          
    imagealphablending($this->image, false);
    imagesavealpha($this->image,true);
    imagepng($this->image,$filename);
  }   
  if( $permissions != null) {
     chmod($filename,$permissions);
  }
   }
   function output($image_type=IMAGETYPE_JPEG) {
 
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image);
      } elseif( $image_type == IMAGETYPE_GIF ) {
 
         imagegif($this->image);
      } elseif( $image_type == IMAGETYPE_PNG ) {
 
         imagepng($this->image);
      }
   }
   function getWidth() {
 
      return imagesx($this->image);
   }
   function getHeight() {
 
      return imagesy($this->image);
   }
   function resizeToHeight($height) {
 
      $ratio = $height / $this->getHeight();
      $width = $this->getWidth() * $ratio;
      $this->resize($width,$height);
   }
 
   function resizeToWidth($width) {
      $ratio = $width / $this->getWidth();
      $height = $this->getheight() * $ratio;
      $this->resize($width,$height);
   }
 
   function scale($scale) {
      $width = $this->getWidth() * $scale/100;
      $height = $this->getheight() * $scale/100;
      $this->resize($width,$height);
   }
 
   function resize($width,$height) {
      $new_image = imagecreatetruecolor($width, $height);
  /* Check if this image is PNG or GIF, then set if Transparent*/  
  if(($this->image_type == IMAGETYPE_GIF) || ($this->image_type==IMAGETYPE_PNG)){
      imagealphablending($new_image, false);
      imagesavealpha($new_image,true);
      $transparent = imagecolorallocatealpha($new_image, 255, 255, 255, 127);
      imagefilledrectangle($new_image, 0, 0, $width, $height, $transparent);
  }
  imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());

  $this->image = $new_image;
   }      
 
}
?>