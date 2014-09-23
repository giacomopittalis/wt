<?php
	include "dbclass.php";
   include "matt.php";
    class delemp extends db{
    	
		public function cleaninput($input){
			$ret = "";
			$q = ENT_NOQUOTES;
			
			$ret = trim($input);
			$ret = htmlspecialchars($ret, $q);
			
			return $ret;
		}

		private function getcurclientlist(){
    		$ret = array();
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "client";
					$tex = $this->tex($tablename);
					if ($tex){
						$deleted = "deleted";
						$edeleted = $this->encode($deleted);
						$sql = "SELECT `$tablename`.`id`,  `$tablename`.`clname` FROM `$this->db`.`$tablename` WHERE `$tablename`.`status` != '$edeleted'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$i = 0;
								while ($resarr = mysql_fetch_assoc($result)){
									$ret[$i]['clid'] = $resarr['id'];
									$ret[$i]['clname'] = $this->decode($resarr['clname']);
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
		
		private function getlinkedclientlist(){
			$ret = array();
			
			$admin = "admin";
			$eadmin = $this->encode($admin);
			$guide = "guide";
			$eguide = $this->encode($guide);
			
			$curclientlist = $this->getcurclientlist();
			
			$suname = $_SESSION['uname'];
			$priv = $_SESSION['priv'];
			
			if ($priv == $eadmin){
				$ret = $curclientlist;
			}
			else{
				if ($priv == $eguide){
					$dbhandle = $this->dbhandle();
					if ($dbhandle){
						$dbfound = $this->dbfound();
						if ($dbfound){
							$tablename = "egr";
							$tex = $this->tex($tablename);
							if ($tex){
								$i = 0;
								foreach ($curclientlist as $value){
									$clid = $value['clid'];
									$sql = "SELECT `$tablename`.`uname` FROM `$this->db`.`$tablename` WHERE `$tablename`.`clid` = '$clid'";
									$result = mysql_query($sql, $dbhandle);
									if ($result){
										if (mysql_num_rows($result) > 0){
											while ($resarr = mysql_fetch_assoc($result)){
												if (in_array($suname, $resarr)){
													$ret[$i] = $value;
													$i++;
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
			return $ret;
		}

		public function printlinkedclientlist(){
			$res = $this->getlinkedclientlist();
			
			if (empty($res)){
				print "<select name=\"lc\" id=\"sel1\" tabindex=\"1\" >";
					print "<option value =\"0\">Select Client</option>";
				print "</select>";
			}
			else{
				print "<select name=\"lc\" id=\"sel1\" tabindex=\"1\" onChange = \"getloc();\">";
					print "<option value =\"0\">Select Client</option>";
					foreach ($res as $value){
						print "<option value=\"".$value['clid']."\">".$value['clname']."</option>";
					}
				print "</select>";
			}
		}
		
		private function getcurloclist($clid){
			$ret = array();
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "clientloc";
					$tex = $this->tex($tablename);
					if ($tex){
						$active = "active";
						$eactive = $this->encode($active);
						$sql = "SELECT `$tablename`.`id`, `$tablename`.`locid` FROM `$this->db`.`$tablename` WHERE `$tablename`.`clid` = '$clid' AND `$tablename`.`status` = '$eactive'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$i = 0;
								while ($resarr = mysql_fetch_assoc($result)){
									$ret[$i]['id'] = $resarr['id'];
									$ret[$i]['locid'] = $this->decode($resarr['locid']);
									$i++;
								}
							}
						}
					}
				}
			}
			return $ret;
		}
		
		public function printcurloclist($clid){
			
			if ($clid == "0"){
				print "<select name=\"lid\" id=\"sel2\" tabindex=\"2\" >";
					print "<option value =\"0\">Select Location</option>";
				print "</select>";
			}
			else{
				$res = $this->getcurloclist($clid);
				if (empty($res)){
					print "<select name=\"lid\" id=\"sel2\" tabindex=\"2\" >";
						print "<option value =\"0\">Select Location</option>";
					print "</select>";
				}
				else{
					print "<select name=\"lid\" id=\"sel2\" tabindex=\"2\" onchange=\"getemp();\">";
						print "<option value =\"0\">Select Location</option>";
						foreach ($res as $value){
							print "<option value=\"".$value['id']."\">".$value['locid']."</option>";
						}
					print "</select>";
				}
			}
		}
		
		public function getcuremplist($clid, $locid){
			$ret = array();
			
			$status = "deleted";
			$estatus = $this->encode($status);
			
			if ($clid != "0" && $locid != "0"){
				$dbhandle = $this->dbhandle();
				if ($dbhandle){
					$dbfound = $this->dbfound();
					if ($dbfound){
						$tablename = "employee";
						$tex = $this->tex($tablename);
						if ($tex){
							$sql = "SELECT * FROM `$this->db`.`$tablename` WHERE `$tablename`.`clid` = '$clid' AND `$tablename`.`locid` = '$locid' AND `$tablename`.`status` != '$estatus'";
							$result = mysql_query($sql, $dbhandle);
							if ($result){
								if (mysql_num_rows($result) > 0){
									$i = 0;
									while ($resarr = mysql_fetch_assoc($result)){
										$ret[$i]['value'] = $resarr['id'];
										$ret[$i]['caption'] = $this->decode($resarr['fname'])." ".$this->decode($resarr['mname'])." ".$this->decode($resarr['lname'])." - ".$this->decode($resarr['dept'])." - ".$this->decode($resarr['desg']);
										$i++;
									}
								}
							}
						}
					}
				}
			}
                    $ret = array_sort($ret, 'caption', SORT_ASC);
			return $ret;
		}
		
		public function printcuremplist($clid, $locid){
			$res = $this->getcuremplist($clid, $locid);
			
			if (empty($res)){
				print "<select name=\"emp\" id=\"sel10\" tabindex=\"3\" >";
					print "<option value =\"0\">Select Employee</option>";
				print "</select>";
			}
			else{
				print "<select name=\"emp\" id=\"sel10\" tabindex=\"3\" >";
					print "<option value =\"0\">Select Employee</option>";
					foreach ($res as $value){
						print "<option value=\"".$value['value']."\">".$value['caption']."</option>";
					}
				print "</select>";
			}
		}
		
		public function vclid($clid){
			$ret = "";
			if ($clid == "0"){
				$ret = "Please Select Client";
			}
			return $ret;
		}
		
		public function vlocid($locid){
			$ret = "";
			if ($locid == "0"){
				$ret = "Please Select Client Location";
			}
			return $ret;
		}
		
		public function vemp($emp){
			$ret = "";
			if ($emp == "0"){
				$ret = "Please Select Employee";
			}
			return $ret;
		}
    	
		
		
		public function delemp1($empid){
			
			$ret = FALSE;
			
			$status = "deleted";
			
			$estatus = $this->encode($status);
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "employee";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "UPDATE `$this->db`.`$tablename` SET `$tablename`.`status` = '$estatus' WHERE `$tablename`.`id` = '$empid'";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							$ret = TRUE;
						}
					}
				}
			}
			return $ret;
		}
		
		public function upemplog($suname, $ipadd, $dts, $action, $empid){
			$ret = FALSE;
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "emplog";
					$tex = $this->tex($tablename);
					if ($tex){
						$suname = $this->injcheck($suname);
						$ipadd = $this->injcheck($ipadd);
						$dts = $this->injcheck($dts);
						$action = $this->injcheck($action);
						$empid = $this->injcheck($empid);
						$sql = "INSERT INTO `$this->db`.`$tablename` (
							`id`, 
							`uname`,
							`ipadd`,
							`dts`,
							`action`, 
							`empid`
						)
						VALUES(
							NULL,
							'$suname', 
							'$ipadd',
							'$dts', 
							'$action',
							'$empid'
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