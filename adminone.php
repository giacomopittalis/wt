<?php
	session_start();
	include 'suclass.php';
	include 'cruserclass.php';
	$obj = new su;
	$sss = $obj->susss();
	if(!$sss){
		header("location: sulogout.php");
	}
	$sto = $obj->sutimeout();
	if (!$sto){
		header("location: sulogout.php");
	}
	$_SESSION['timeout'] = time();
?>
<!DOCTYPE html>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8" />

  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width" />

  <title>Wellness - Create First Admin</title>
  
  <!-- Included CSS Files (Uncompressed) -->
  <!--
  <link rel="stylesheet" href="stylesheets/foundation.css">
  -->
  
  <!-- Included CSS Files (Compressed) -->
  <link rel="stylesheet" href="stylesheets/foundation.min.css">
  <link rel="stylesheet" href="stylesheets/app.css">

  <script src="javascripts/modernizr.foundation.js"></script>
  
  <?php
  	$outsta = "";
	$e = 0;
	$f = 0;
	
	$fnamesta = "";
	$mnamesta = "";
	$lnamesta = "";
	$streetsta = "";
	$citysta = "";
	$zipsta = "";
	$statesta = "";
	$telsta = "";
	$cellsta = "";
	$emailsta = "";
	$empidsta = "";
	$desgsta = "";
	$unamesta = "";
	$passsta = "";
	$passxsta = "";
	$picsta = "";
	
	$fname = "";
	$mname = "";
	$lname = "";
	$street = "";
	$city = "";
	$zip = "";
	$state = "";
	$tel = "";
	$cell = "";
	$email = "";
	$empid = "";
	$desg = "";
	$uname = "";
	$pass = "";
	$passx = "";
	
	if (isset($_POST['sub1'])){
		
		//Get input
		$fname = $_POST['fname'];
		$mname = $_POST['mname'];
		$lname = $_POST['lname'];
		$street = $_POST['street'];
		$city = $_POST['city'];
		$zip = $_POST['zip'];
		$state = $_POST['state'];
		$tel = $_POST['tel'];
		$cell = $_POST['cell'];
		$email = $_POST['email'];
		$empid = $_POST['empid'];
		$desg = $_POST['desg'];
		$uname = $_POST['uname'];
		$pass = $_POST['pass'];
		$passx = $_POST['passx'];
		
		//Clean input
		
		$obj1 = new user;
		
		$fname = $obj1->cleaninput($fname);
		$mname = $obj1->cleaninput($mname);
		$lname = $obj1->cleaninput($lname);
		$street = $obj1->cleaninput($street);
		$city = $obj1->cleaninput($city);
		$zip = $obj1->cleaninput($zip);
		$state = $obj1->cleaninput($state);
		$tel = $obj1->cleaninput($tel);
		$cell = $obj1->cleaninput($cell);
		$email = $obj1->cleaninput($email);
		$empid = $obj1->cleaninput($empid);
		$desg = $obj1->cleaninput($desg);
		$uname = $obj1->cleaninput($uname);
		$pass = $obj1->cleaninput($pass);
		$passx = $obj1->cleaninput($passx);
		
		//Validate Input
		
		$fnamesta = $obj1->vfname($fname);
		if ($fnamesta != ""){
			$e++;
		}
		
		$mnamesta = $obj1->vmname($mname);
		if ($mnamesta != ""){
			$e++;
		}
		
		$lnamesta = $obj1->vlname($lname);
		if ($lnamesta != ""){
			$e++;
		}
		
		$streetsta = $obj1->vstreet($street);
		if ($streetsta != ""){
			$e++;
		}
		
		$citysta = $obj1->vcity($city);
		if ($citysta != ""){
			$e++;
		}
		
		$zipsta = $obj1->vzip($zip);
		if ($zipsta != ""){
			$e++;
		}
		
		$telsta = $obj1->vtel($tel);
		if ($telsta != ""){
			$e++;
		}
		
		$cellsta = $obj1->vcell($cell);
		if ($cellsta != ""){
			$e++;
		}
		
		$emailsta = $obj1->vemail($email);
		if ($emailsta != ""){
			$e++;
		}
		
		$empidsta = $obj1->vempid($empid);
		if ($empidsta != ""){
			$e++;
		}
		
		$desgsta = $obj1->vdesg($desg);
		if ($desgsta != ""){
			$e++;
		}
		
		$unamesta = $obj1->vuname($uname);
		if ($unamesta != ""){
			$e++;
		}
		
		$passsta = $obj1->vpass($pass);
		if ($passsta != ""){
			$e++;
		}
		
		$passxsta = $obj1->vpassx($pass, $passx);
		if ($passxsta != ""){
			$e++;
		}
		
		//Validate image
		//Check if user has selected a file and file size is greater than zero
		if(isset($_FILES['pic']) && $_FILES['pic']['size'] > 0){
			$photoname = $_FILES['pic']['name'];
			$photosize = $_FILES['pic']['size'];
			$phototmp = $_FILES['pic']['tmp_name'];
			$photomime = $_FILES['pic']['type'];
			$ext = pathinfo($photoname, PATHINFO_EXTENSION);
			$maxsize = "10240000";//In bytes
			$atypes = array("jpeg", "png", "gif", "jpg", "bmp", "JPG", "PNG");
			//Check allowed file types
			if(in_array($ext, $atypes)){
				//Check file size	
				if($photosize > $maxsize){
					$picsta = "Image size is too big";
					$e++;
				}
				//All is well
				else{
					$fh = fopen($phototmp, 'r');
					$photodata = fread($fh, $photosize);
					$photodata = addslashes($photodata);
				}
			}
			else{
				$picsta = "Only Images can be selected";
				$e++;
			}
		}
		else{
			$f = 1;
		}
		
		//All is well
		if ($e == 0){
			$destination = "";
			if ($f == 0){
				$phopath = "images/agimg"."/";
				$newphotoname = $uname.".".$ext;
				$destination = $phopath.$newphotoname;
				move_uploaded_file($phototmp, $destination);
				$obj2 = new SimpleImage;
				$obj2->load($destination);
				$width = 600;
				$height = 600;
				$obj2->resize($width, $height);
				$obj2->save($destination);
			}
			else{
				$destination = "images/noimage.jpg";
			}
			
			$priv = "admin";
			$status1 = "active";
			$status2 = "active";
			
			$outsta = $obj1->crnewuser($fname, $mname, $lname, $street, $city, $zip, $state, $tel, $cell, $email, $empid, $desg, $uname, $pass, $destination, $priv, $status1, $status2);
			
			$suname = "demo123";
			$suname = $obj1->encode($suname);
			$ipadd = $_SERVER['REMOTE_ADDR'];
			$ipadd = $obj1->encode($ipadd);
			$timeformat = "d-m-Y G-i-s";
			$dts = date($timeformat);
			$dts = (string)$dts;
			$dts = $obj1->encode($dts);
			$euname = $obj1->encode($uname);
			$res = $obj1->upcreatelog($suname, $ipadd, $dts, $uname);
			
			$e = 0;
			$f = 0;
	
			$fnamesta = "";
			$mnamesta = "";
			$lnamesta = "";
			$streetsta = "";
			$citysta = "";
			$zipsta = "";
			$statesta = "";
			$telsta = "";
			$cellsta = "";
			$emailsta = "";
			$empidsta = "";
			$desgsta = "";
			$unamesta = "";
			$passsta = "";
			$passxsta = "";
			$picsta = "";
	
			$fname = "";
			$mname = "";
			$lname = "";
			$street = "";
			$city = "";
			$zip = "";
			$state = "";
			$tel = "";
			$cell = "";
			$email = "";
			$empid = "";
			$desg = "";
			$uname = "";
			$pass = "";
			$passx = "";
			
		}
		
		
	}
  	
  ?>
</head>
<body>
	
	<div class="row" id="container1">
		<div class="twelve columns" id="container1a">
			<div class="row" id="head1">
				<div class="twelve columns" id="head1a">
					<br />
					<br />
					<a href="sulogout.php">Logout</a>
				</div>
			</div>
			<div class="row" id="content3">
				<div class="twelve columns" id="content3a">
					<form name="adminonefrm" id="frmadminone" action="adminone.php" method="post" enctype="multipart/form-data">
						<fieldset>
							<legend>Nomenclature</legend>
							<div class="row" id="adminobj1">
								<div class="three columns" id="adminobj1a">
									<label class="adminlkey">First Name</label>
								</div>
								<div class="four columns" id="adminobj1b">
									<input type="text" name="fname" id="txt1" tabindex="1" maxlength="30" placeholder="First Name" value="<?php print $fname; ?>"/>
								</div>
								<div class="five columns" id="loginobj1c">
									<label class="adminlval"><?php print $fnamesta; ?></label>
								</div>
							</div>
							<div class="row" id="adminobj2">
								<div class="three columns" id="adminobj2a">
									<label class="adminlkey">Middle Name</label>
								</div>
								<div class="four columns" id="adminobj2b">
									<input type="text" name="mname" id="txt2" tabindex="2" maxlength="30" placeholder="Middle Name" value="<?php print $mname; ?>"/>
								</div>
								<div class="five columns" id="loginobj2c">
									<label class="adminlval"><?php print $mnamesta; ?></label>
								</div>
							</div>
							<div class="row" id="adminobj3">
								<div class="three columns" id="adminobj3a">
									<label class="adminlkey">Last Name</label>
								</div>
								<div class="four columns" id="adminobj3b">
									<input type="text" name="lname" id="txt3" tabindex="3" maxlength="30" placeholder="Last Name" value="<?php print $lname; ?>"/>
								</div>
								<div class="five columns" id="loginobj3c">
									<label class="adminlval"><?php print $lnamesta; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Address</legend>
							<div class="row" id="adminobj4">
								<div class="three columns" id="adminobj4a">
									<label class="adminlkey">Street</label>
								</div>
								<div class="four columns" id="adminobj4b">
									<input type="text" name="street" id="txt4" tabindex="4" maxlength="90" placeholder="Street" value="<?php print $street; ?>"/>
								</div>
								<div class="five columns" id="loginobj4c">
									<label class="adminlval"><?php print $streetsta; ?></label>
								</div>
							</div>
							<div class="row" id="adminobj5">
								<div class="three columns" id="adminobj5a">
									<label class="adminlkey">City</label>
								</div>
								<div class="four columns" id="adminobj5b">
									<input type="text" name="city" id="txt5" tabindex="5" maxlength="50" placeholder="City" value="<?php print $city; ?>"/>
								</div>
								<div class="five columns" id="loginobj5c">
									<label class="adminlval"><?php print $citysta; ?></label>
								</div>
							</div>
							<div class="row" id="adminobj6">
								<div class="three columns" id="adminobj6a">
									<label class="adminlkey">Zip</label>
								</div>
								<div class="four columns" id="adminobj6b">
									<input type="text" name="zip" id="txt6" tabindex="6" maxlength="10" placeholder="Zip" value="<?php print $zip; ?>"/>
								</div>
								<div class="five columns" id="loginobj6c">
									<label class="adminlval"><?php print $zipsta; ?></label>
								</div>
							</div>
							<div class="row" id="adminobj7">
								<div class="three columns" id="adminobj7a">
									<label class="adminlkey">State</label>
								</div>
								<div class="four columns" id="adminobj7b">
									<select name="state" id="sel1" tabindex="7">
										<option value="0" selected="selected">Select State</option>
										<option value="Alabama">Alabama</option>
										<option value="Alaska">Alaska</option>
										<option value="Arizona">Arizona</option>
										<option value="Arkansas">Arkansas</option>
										<option value="California">California</option>
										<option value="Colorado">Colorado</option>
										<option value="Connecticut">Connecticut</option>
										<option value="Delaware">Delaware</option>
										<option value="Florida">Florida</option>
										<option value="Georgia">Georgia</option>
										<option value="Hawaii">Hawaii</option>
										<option value="Idaho">Idaho</option>
										<option value="Illinois">Illinois</option>
										<option value="Indiana">Indiana</option>
										<option value="Iowa">Iowa</option>
										<option value="Kansas">Kansas</option>
										<option value="Kentucky">Kentucky</option>
										<option value="Louisiana">Louisiana</option>
										<option value="Maine">Maine</option>
										<option value="Maryland">Maryland</option>
										<option value="Massachussetts">Massachusetts</option>
										<option value="Michigan">Michigan</option>
										<option value="Minnesota">Minnesota</option>
										<option value="Mississippi">Mississippi</option>
										<option value="Missouri">Missouri</option>
										<option value="Montana">Montana</option>
										<option value="Nebraska">Nebraska</option>
										<option value="Nevada">Nevada</option>
										<option value="New Hampshire">New Hampshire</option>
										<option value="New Jersey">New Jersey</option>
										<option value="New Mexico">New Mexico</option>
										<option value="New York">New York</option>
										<option value="North Carolina">North Carolina</option>
										<option value="North Dakota">North Dakota</option>
										<option value="Ohio">Ohio</option>
										<option value="Oklahoma">Oklahoma</option>
										<option value="Oregon">Oregon</option>
										<option value="Pennsylvania">Pennsylvania</option>
										<option value="Rhode Island">Rhode Island</option>
										<option value="South Carolina">South Carolina</option>
										<option value="South Dakota">South Dakota</option>
										<option value="Tennessee">Tennessee</option>
										<option value="Texas">Texas</option>
										<option value="Utah">Utah</option>
										<option value="Vermont">Vermont</option>
										<option value="Virginia">Virginia</option>
										<option value="Washington">Washington</option>
										<option value="West Virginia">West Virginia</option>
										<option value="Wisconsin">Wisconsin</option>
										<option value="Wyoming">Wyoming</option>
									</select>
								</div>
								<div class="five columns" id="loginobj7c">
									<label class="adminlval"></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Electronic Contact</legend>
							<div class="row" id="adminobj8">
								<div class="three columns" id="adminobj8a">
									<label class="adminlkey">Telephone</label>
								</div>
								<div class="four columns" id="adminobj8b">
									<input type="text" name="tel" id="txt8" tabindex="8" maxlength="16" placeholder="Telephone" value="<?php print $tel; ?>"/>
								</div>
								<div class="five columns" id="loginobj8c">
									<label class="adminlval"><?php print $telsta; ?></label>
								</div>
							</div>
							<div class="row" id="adminobj9">
								<div class="three columns" id="adminobj9a">
									<label class="adminlkey">Cell</label>
								</div>
								<div class="four columns" id="adminobj9b">
									<input type="text" name="cell" id="txt9" tabindex="9" maxlength="16" placeholder="Cell" value="<?php print $cell; ?>"/>
								</div>
								<div class="five columns" id="loginobj9c">
									<label class="adminlval"><?php print $cellsta; ?></label>
								</div>
							</div>
							<div class="row" id="adminobj10">
								<div class="three columns" id="adminobj10a">
									<label class="adminlkey">Email</label>
								</div>
								<div class="four columns" id="adminobj10b">
									<input type="text" name="email" id="txt10" tabindex="10" maxlength="50" placeholder="Email" value="<?php print $email; ?>"/>
								</div>
								<div class="five columns" id="loginobj10c">
									<label class="adminlval"><?php print $emailsta; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Official Demographics</legend>
							<div class="row" id="adminobj11">
								<div class="three columns" id="adminobj11a">
									<label class="adminlkey">Employee ID</label>
								</div>
								<div class="four columns" id="adminobj11b">
									<input type="text" name="empid" id="txt11" tabindex="11" maxlength="20" placeholder="Employee ID" value="<?php print $empid; ?>"/>
								</div>
								<div class="five columns" id="loginobj11c">
									<label class="adminlval"><?php print $empidsta; ?></label>
								</div>
							</div>
							<div class="row" id="adminobj12">
								<div class="three columns" id="adminobj12a">
									<label class="adminlkey">Designation</label>
								</div>
								<div class="four columns" id="adminobj12b">
									<input type="text" name="desg" id="txt12" tabindex="12" maxlength="30" placeholder="Designation" value="<?php print $desg; ?>"/>
								</div>
								<div class="five columns" id="loginobj12c">
									<label class="adminlval"><?php print $desgsta; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Credentials</legend>
							<div class="row" id="adminobj13">
								<div class="three columns" id="adminobj13a">
									<label class="adminlkey">Username</label>
								</div>
								<div class="four columns" id="adminobj13b">
									<input type="text" name="uname" id="txt13" tabindex="13" maxlength="20" placeholder="Username" value="<?php print $uname; ?>"/>
								</div>
								<div class="five columns" id="loginobj13c">
									<label class="adminlval"><?php print $unamesta; ?></label>
								</div>
							</div>
							<div class="row" id="adminobj14">
								<div class="three columns" id="adminobj14a">
									<label class="adminlkey">Password</label>
								</div>
								<div class="four columns" id="adminobj14b">
									<input type="password" name="pass" id="txt14" tabindex="14" maxlength="20" placeholder="Password" />
								</div>
								<div class="five columns" id="loginobj14c">
									<label class="adminlval"><?php print $passsta; ?></label>
								</div>
							</div>
							<div class="row" id="adminobj15">
								<div class="three columns" id="adminobj15a">
									<label class="adminlkey">Retype Password</label>
								</div>
								<div class="four columns" id="adminobj15b">
									<input type="password" name="passx" id="txt15" tabindex="15" maxlength="20" placeholder="Retype Password" />
								</div>
								<div class="five columns" id="loginobj15c">
									<label class="adminlval"><?php print $passxsta; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Identification</legend>
							<div class="row" id="adminobj16">
								<div class="three columns" id="adminobj16a">
									<label class="adminlkey">Photograph</label>
								</div>
								<div class="four columns" id="adminobj16b">
									<input type="hidden" name="MAX_FILE_SIZE" value="1024000" />
									<input type="file" name="pic" id="pic1" tabindex="16"/>
								</div>
								<div class="five columns" id="loginobj16c">
									<label class="adminlval"><?php print $picsta; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<div class="row" id="adminobj17">
								<div class="three columns" id="adminobj17a">
									
								</div>
								<div class="four columns" id="adminobj17b">
									<input type="submit" name="sub1" id="but1" tabindex="17" value="Create" class="success button" />
								</div>
								<div class="five columns" id="loginobj17c">
									<label class="adminlval"><?php print $outsta; ?></label>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</div>

  <!-- Included JS Files (Uncompressed) -->
  <!--
  <script src="javascripts/jquery.js"></script>
  <script src="javascripts/jquery.foundation.mediaQueryToggle.js"></script>
  <script src="javascripts/jquery.foundation.forms.js"></script>
  <script src="javascripts/jquery.event.move.js"></script>
  <script src="javascripts/jquery.event.swipe.js"></script>
  <script src="javascripts/jquery.foundation.reveal.js"></script>
  <script src="javascripts/jquery.foundation.orbit.js"></script>
  <script src="javascripts/jquery.foundation.navigation.js"></script>
  <script src="javascripts/jquery.foundation.buttons.js"></script>
  <script src="javascripts/jquery.foundation.tabs.js"></script>
  <script src="javascripts/jquery.foundation.tooltips.js"></script>
  <script src="javascripts/jquery.foundation.accordion.js"></script>
  <script src="javascripts/jquery.placeholder.js"></script>
  <script src="javascripts/jquery.foundation.alerts.js"></script>
  <script src="javascripts/jquery.foundation.topbar.js"></script>
  <script src="javascripts/jquery.foundation.joyride.js"></script>
  <script src="javascripts/jquery.foundation.clearing.js"></script>
  <script src="javascripts/jquery.foundation.magellan.js"></script>
  
  -->
  
  <!-- Included JS Files (Compressed) -->
  <script src="javascripts/foundation.min.js"></script>
  
  <!-- Initialize JS Plugins -->
  <script src="javascripts/app.js"></script> 
  
</body>
</html>