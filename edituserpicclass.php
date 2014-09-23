<?php
	include 'dbclass.php';
    class edituserpic extends db{
    	
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
				print "<select name=\"lu\" id=\"sel1\" tabindex=\"1\" >";
					print "<option value =\"0\">Select User</option>";
				print "</select>";
			}
			else{
				print "<select name=\"lu\" id=\"sel1\" tabindex=\"1\" >";
					print "<option value =\"0\">Select User</option>";
					foreach ($res as $value){
						print "<option value=\"".$value['uname']."\">".$value['caption']."</option>";
					}
				print "</select>";
			}
		}
		
		//Validate input
		public function vuname($uname){
			$ret = "";
			if ($uname == "0"){
				$ret = "Please Select a user";
			}
			return $ret;
		}
		
		public function edituserpic1($uname, $destination){
			$ret = FALSE;
			$euname = $this->encode($uname);
			$edestination = $this->encode($destination);
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "user";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql1 = "UPDATE `$this->db`.`$tablename` SET `$tablename`.`imgpath` = '$edestination' WHERE `$tablename`.`uname` = '$euname'";
						$result1 = mysql_query($sql1, $dbhandle);
						if ($result1){
							$ret = TRUE;
						}
					}
				}
			}
			return $ret;
		}
		
		public function upeditpiclog($suname, $ipadd, $dts, $uname){
			$ret = FALSE;
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "editpiclog";
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
							`epuname`
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