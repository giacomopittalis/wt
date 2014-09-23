<?php
	session_start();
	include 'sessionclass.php';
	include 'edituserpicclass.php';
	$obj = new session;
	$seadmin = $obj->seadmin();
?>
<!DOCTYPE html>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8" />

  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width" />

  <title>Wellness - Edit User Photograph</title>
  
  <!-- Included CSS Files (Uncompressed) -->
  <!--
  <link rel="stylesheet" href="stylesheets/foundation.css">
  -->
  
  <!-- Included CSS Files (Compressed) -->
  <link rel="stylesheet" href="stylesheets/foundation.min.css">
  <link rel="stylesheet" href="stylesheets/app.css">

  <script src="javascripts/modernizr.foundation.js"></script>
  
  <?php
  	$obj1 = new edituserpic;
	$outsta = "";
	$unamesta = "";
	$picsta = "";
	$e = 0;
	$f = 0;
	
	if (isset($_POST['sub1'])){
		
		//Get input
		$uname = $_POST['lu'];
		
		//validate input
		
		$unamesta = $obj1->vuname($uname);
		
		if ($unamesta != ""){
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
				if (file_exists($destination)){
					unlink($destination);
				}
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
			
			$out = $obj1->edituserpic1($uname, $destination);
			
			if ($out){
				$outsta = "Photograph successfully Edited";
			}
			else{
				$outsta = "Photograph could not be edited";
			}
			
			$suname = $_SESSION['uname'];
			$ipadd = $_SESSION['ipadd'];
			$timeformat = "d-m-Y G-i-s";
			$dts = date($timeformat);
			$dts = (string)$dts;
			$dts = $obj1->encode($dts);
			$euname = $obj1->encode($uname);
			$res = $obj1->upeditpiclog($suname, $ipadd, $dts, $euname);
			
			$e = 0;
			$f = 0;
			
			$unamesta = "";
			$picsta = "";
		}
	}
  ?>
</head>
<body><?php include('header.php'); ?> 
	
	<div class="row" id="container1">
		<div class="twelve columns" id="container1a">
			<div class="row" id="head1">
				<div class="twelve columns" id="head1a">
					<br />
					<br />
				</div>
			</div>
			<div class="row" id="contentunlk5">
				<div class="eight columns centered" id="contentunlk5a">
					<form name="frmunlock" id="unlockfrom" action="edituserpic.php" method="post">
						<fieldset>
							<legend>Edit User Photograph</legend>
							<div class="row" id="unlk1">
								<div class=" six columns" id="unlk1a">
									<?php
										$obj1->printcuruserlist();
									?>
									<br />
									<br />
								</div>
								<div class=" six columns" id="unlk1b">
									<?php
										print $unamesta;
									?>
									<br />
									<br />
								</div>
							</div>
							<div class="row" id="unlk4">
								<div class=" six columns" id="unlk4a">
									<input type="hidden" name="MAX_FILE_SIZE" value="1024000" />
									<input type="file" name="pic" id="pic1"/>
									<br />
									<br />
								</div>
								<div class=" six columns" id="unlk4b">
									<?php
										print $picsta;
									?>
									<br />
									<br />
								</div>
							</div>
							<div class="row" id="unlk2">
								<div class=" twelve columns" id="unlk2a">
									<input type="submit" name="sub1" id="but1" tabindex="2" class="success button" value="Edit Photograph" />
								</div>
							</div>
							<div class="row" id="unlk3">
								<div class=" twelve columns" id="unlk3a">
									<label class="unlksta"><?php print $outsta; ?></label>
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
