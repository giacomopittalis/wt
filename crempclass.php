<?php
	include "dbclass.php";
    class cremp extends db{
    	
		public function cleaninput($input){
			$ret = "";
			$q = ENT_NOQUOTES;
			
			$ret = trim($input);
			$ret = htmlspecialchars($ret, $q);
			
			return $ret;
		}
		
		public function printyear(){
			$cyear = date("Y");
			$syear = $cyear - 80;
			$xyear = $cyear - 1;
			
			print "<select name=\"year\" id=\"sel4\" onchange=\"daysl();\">";
				print "<option value=\"0\">Year</option>";
				for ($i = $syear; $i <= $xyear; $i++){
					print "<option value=\"".$i."\">".$i."</option>";
				}
				print "<option value=\"".$cyear."\" selected=\"selected\">".$cyear."</option>";
			print "</select>";
			
			return $cyear;
		}
		
		public function printmonth(){
			$montharr = array();
			
			$montharr[0]['name'] = "Month";
			$montharr[0]['value'] = "0";
			$montharr[1]['name'] = "January";
			$montharr[1]['value'] = "01";
			$montharr[2]['name'] = "February";
			$montharr[2]['value'] = "02";
			$montharr[3]['name'] = "March";
			$montharr[3]['value'] = "03";
			$montharr[4]['name'] = "April";
			$montharr[4]['value'] = "04";
			$montharr[5]['name'] = "May";
			$montharr[5]['value'] = "05";
			$montharr[6]['name'] = "June";
			$montharr[6]['value'] = "06";
			$montharr[7]['name'] = "July";
			$montharr[7]['value'] = "07";
			$montharr[8]['name'] = "August";
			$montharr[8]['value'] = "08";
			$montharr[9]['name'] = "September";
			$montharr[9]['value'] = "09";
			$montharr[10]['name'] = "October";
			$montharr[10]['value'] = "10";
			$montharr[11]['name'] = "November";
			$montharr[11]['value'] = "11";
			$montharr[12]['name'] = "December";
			$montharr[12]['value'] = "12";
			
			$curmonth = date("m");
			
			print "<select name=\"month\" id=\"sel5\" onchange=\"daysl();\">";
				foreach ($montharr as $value){
					if ($value['value'] == $curmonth){
						print "<option value=\"".$value['value']."\" selected=\"selected\">".$value['name']."</option>";
					}
					else{
						print "<option value=\"".$value['value']."\">".$value['name']."</option>";
					}
				}
			print "</select>";
		}

		public function printcurdays(){
			$cyear = date("Y");
			$cmonth = date("m");
			$cday = date("d");
			$ndays = $this->getdays($cyear, $cmonth);
			
			print "<select name=\"day\" id=\"sel6\">";
				print "<option value=\"0\">Day</option>";
				for ($i = 1; $i <= $ndays; $i++){
					if ($i == $cday){
						print "<option value=\"".$i."\" selected=\"selected\">".$i."</option>";
					}
					else{
						print "<option value=\"".$i."\">".$i."</option>";
					}
				}
			print "</select>";
		}
		
		public function printyear1(){
			$cyear = date("Y");
			$syear = $cyear - 80;
			
			print "<select name=\"hyear\" id=\"sel9\" >";
				print "<option value=\"0\">Year</option>";
				for ($i = $syear; $i <= $cyear; $i++){
					print "<option value=\"".$i."\">".$i."</option>";
				}
			print "</select>";
		}
		
		private function isleap($year){
			$ret = date('L', mktime(0, 0, 0, 1, 1, $year));
			return $ret;
		}
		
		private function getdays($year, $month){
			$ret = 0;
			
			if ($month == "0" || $year == "0"){
				$ret = 0;
			}
			else{
				if ($month == "01" || $month == "03" || $month == "05" || $month == "07" || $month == "08" || $month == "10" || $month == "12"){
					$ret = 31;
				}
				else{
					if ($month == "04" || $month == "06" || $month == "09" || $month == "11"){
						$ret = 30;
					}
					else{
						if ($month == "02"){
							$isleap = $this->isleap($year);
							if ($isleap){
								$ret = 29;
							}
							else{
								$ret = 28;
							}
						}
					}
				}
			}
			return $ret;
		}
		
		public function printdays($year, $month){
			$days = $this->getdays($year, $month);
			
			if ($days == 0){
				print "<select name=\"day\" id=\"sel6\">";
					print "<option value=\"0\">Day</option>";
				print "</select>";
			}
			else{
				print "<select name=\"day\" id=\"sel6\">";
					print "<option value=\"0\">Day</option>";
					for ($i = 1; $i <= $days; $i++){
						print "<option value=\"".$i."\">".$i."</option>";
					}
				print "</select>";
			}
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
					print "<select name=\"lid\" id=\"sel2\" tabindex=\"2\" >";
						print "<option value =\"0\">Select Location</option>";
						foreach ($res as $value){
							print "<option value=\"".$value['id']."\">".$value['locid']."</option>";
						}
					print "</select>";
				}
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
		
		public function vsex($sex){
			$ret = "";
			if ($sex == "0"){
				$ret = "Please Select sex";
			}
			return $ret;
		}
		
		public function vdate($year, $month, $day){
			$ret = "";
			if ($year == "0"){
				$ret = "Please select year";
			}
			else{
				if ($month == "0"){
					$ret = "Please select month";
				}
				else{
					if ($day == "0"){
						$ret = "Please Select Day";
					}
				}
			}
			return $ret;
		}
		
		public function vdept($dept){
			$ret = "";
			if (strlen($dept) > 50){
				$ret = "Department cannot be more than 50 characters";
			}
			return $ret;
		}
		
		public function vpos($pos){
			$ret = "";
			if (strlen($pos) > 60){
				$ret = "Position cannot be more than 60 characters";
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
		
		public function vhyear($hyear){
			$ret = "";
			if ($hyear == "0"){
				$ret = "Please Select hire year";
			}
			return $ret;
		}
		
		public function vhtype($htype){
			$ret = "";
			if ($htype == "0"){
				$ret = "Please Select hire type";
			}
			return $ret;
		}
		
		public function vhplan($hplan){
			$ret = "";
			if (strlen($hplan) > 60){
				$ret = "Health plan cannot be more than 60 characters";
			}
			return $ret;
		}
		
		public function getmaxid(){
			$ret = 0;
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "employee";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "SELECT MAX(id) FROM `$this->db`.`$tablename`";
						$result = mysql_query($sql, $dbhandle);
						if ($result){
							if (mysql_num_rows($result) > 0){
								$resarr = mysql_fetch_assoc($result);
								$ret = $resarr['MAX(id)'];
								if (empty($ret)){
									$ret = 0;
								}
							}
						}
					}
				}
			}
			return $ret;
		}
		
		public function getlastinsertid(){
			$ret = "";
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$sql = "SELECT LAST_INSERT_ID()";
					$result = mysql_query($sql, $dbhandle);
					if ($result){
						if (mysql_num_rows($result) > 0){
							$resarr = mysql_fetch_assoc($result);
							$ret = $resarr['LAST_INSERT_ID()'];
						}
					}
				}
			}
			return $ret;
		}
		
		public function cremp1($clid, $locid, $fname, $mname, $lname, $dob, $sex, $dept, $pos, $desg, $htype, $hyear, $destination, $hplan, $status){
			
			$ret = FALSE;
			
			$clid = $this->injcheck($clid);
			$locid = $this->injcheck($locid);
			$fname = $this->injcheck($fname);
			$mname = $this->injcheck($mname);
			$lname = $this->injcheck($lname);
			$dob = $this->injcheck($dob);
			$sex = $this->injcheck($sex);
			$dept = $this->injcheck($dept);
			$pos = $this->injcheck($pos);
			$desg = $this->injcheck($desg);
			$htype = $this->injcheck($htype);
			$hyear = $this->injcheck($hyear);
			$destination = $this->injcheck($destination);
			$hplan = $this->injcheck($hplan);
			$status = $this->injcheck($status);
			
			$fname = $this->encode($fname);
			$mname = $this->encode($mname);
			$lname = $this->encode($lname);
			$dob = $this->encode($dob);
			$sex = $this->encode($sex);
			$dept = $this->encode($dept);
			$pos = $this->encode($pos);
			$desg = $this->encode($desg);
			$htype = $this->encode($htype);
			$hyear = $this->encode($hyear);
			$destination = $this->encode($destination);
			$hplan = $this->encode($hplan);
			$status = $this->encode($status);
			
			$dbhandle = $this->dbhandle();
			if ($dbhandle){
				$dbfound = $this->dbfound();
				if ($dbfound){
					$tablename = "employee";
					$tex = $this->tex($tablename);
					if ($tex){
						$sql = "INSERT INTO `$this->db`.`$tablename` (
							`id`,
							`clid`, 
							`locid`,  
							`fname`, 
							`mname`, 
							`lname`, 
							`dob`, 
							`gender`, 
							`dept`, 
							`pos`, 
							`desg`, 
							`type`, 
							`hyear`, 
							`imgpath`, 
							`hplan`,
							`status`
						)
						VALUES(
							NULL, 
							'$clid', 
							'$locid', 
							'$fname', 
							'$mname', 
							'$lname', 
							'$dob', 
							'$sex', 
							'$dept', 
							'$pos', 
							'$desg', 
							'$htype', 
							'$hyear', 
							'$destination', 
							'$hplan',
							'$status'
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