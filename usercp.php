<?php
	session_start();
	include 'sessionclass.php';
	include 'usercpclass.php';
	$obj = new session;
	$seadminguide = $obj->seadminguide();
?>
<!DOCTYPE html>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8" />

  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width" />

  <title>Wellness - Change Password</title>
  
  <!-- Included CSS Files (Uncompressed) -->
  <!--
  <link rel="stylesheet" href="stylesheets/foundation.css">
  -->
  
  <!-- Included CSS Files (Compressed) -->
  <link rel="stylesheet" href="stylesheets/foundation.min.css">
  <link rel="stylesheet" href="stylesheets/app.css">

  <script src="javascripts/modernizr.foundation.js"></script>
  
  <?php
  	$obj1 = new usercp;
	$outsta = "";
	$opasssta = "";
	$npasssta = "";
	$cpasssta = "";
	$e = 0;
	
	if (isset($_POST['sub1'])){
		
		//Get input
		$euname = $_SESSION['uname'];
		
		$opass = $_POST['opass'];
		$npass = $_POST['npass'];
		$cpass = $_POST['cpass'];
		
		//Clean Input
		
		$opass = $obj1->cleaninput($opass);
		$npass = $obj1->cleaninput($npass);
		$cpass = $obj1->cleaninput($cpass);
		
		//validate input
		
		$opassval = $obj1->validateopass($euname, $opass);
		if (!$opassval){
			$opasssta = "Could not validate old password";
			$e++;
		}
		
		$npasssta = $obj1->vpass($npass);
		if ($npasssta != ""){
			$e++;
		}
		
		$cpasssta = $obj1->vpassx($npass, $cpass);
		if ($cpasssta != ""){
			$e++;
		}
		
		//All is well
		if ($e == 0){
			$res1 = $obj1->usercp1($euname, $npass);
			if ($res1){
				$ipadd = $_SESSION['ipadd'];
				$timeformat = "d-m-Y G-i-s";
				$dts = date($timeformat);
				$dts = (string)$dts;
				$dts = $obj1->encode($dts);
				$res2 = $obj1->upcplog($euname, $ipadd, $dts);
				if ($res2){
					$outsta = "Password successfully Changed";
				}
				else{
					$outsta = "Password could not be changed";
				}
			}
		}
		
		
	}
  ?>
</head>
<body><?php include('header.php'); ?> 
	
	<div class="row" id="container1">
		<div class="ten columns centered" id="container1a">
			<div class="row">
		<div class="twelve columns">
			<div class="row">
				<div class="three columns">
					<a href="logout.php">Logout</a>
				</div>
				<div class="three columns">
					<a href="usercp.php">Change Password</a>
				</div>
				<div class="three columns">
					<a href="cremp.php">Create Employee</a>
				</div>
				<div class="three columns">
					<a href="editemp.php">Edit Employee</a>
				</div>
			</div>
			<div class="row">
				<div class="three columns">
					<a href="editemppic.php">Edit Employee Photo</a>
				</div>
				<div class="three columns">
					<a href="delemp.php">Delete Employee</a>
				</div>
				<div class="three columns">
					<a href="crcon.php">Create Contact</a>
				</div>
				<div class="three columns">
					<a href="clcon.php">Close Contact</a>
				</div>
			</div>
			<div class="row">
				<div class="three columns">
					<a href="crhconsult.php">New Health Consult</a>
				</div>
				<div class="three columns">
					<a href="criconsult.php">New Injury Consult</a>
				</div>
				<div class="three columns">
					<a href="croconsult.php">New Opportunity Consult</a>
				</div>
				<div class="three columns">
					<a href="crpconsult.php">New Proactive Consult</a>
				</div>
			</div>
		</div>
	</div>
			<div class="row" id="head1">
				<div class="twelve columns" id="head1a">
					<br />
					<br />
				</div>
			</div>
			<div class="row" id="contentunlk5">
				<div class="twelve columns" id="contentunlk5a">
					<form name="frmunlock" id="unlockfrom" action="usercp.php" method="post">
						<fieldset>
							<legend>Change Password</legend>
							<div class="row" id="unlk1">
								<div class="three columns" id="unlk1c">
									<label>Old Password</label>
									<br />
									<br />
								</div>
								<div class="four columns" id="unlk1a">
									<input type="password" name="opass" id="pass1" tabindex="1" maxlength="20" />
									<br />
									<br />
								</div>
								<div class="five columns" id="unlk1b">
									<?php
										print $opasssta;
									?>
									<br />
									<br />
								</div>
							</div>
							<div class="row" id="unlk4">
								<div class="three columns" id="unlk4c">
									<label>New Password</label>
									<br />
									<br />
								</div>
								<div class="four columns" id="unlk4a">
									<input type="password" name="npass" id="pass2" tabindex="2" maxlength="20" />
									<br />
									<br />
								</div>
								<div class="five columns" id="unlk4b">
									<?php
										print $npasssta;
									?>
									<br />
									<br />
								</div>
							</div>
							<div class="row" id="unlk5">
								<div class="three columns" id="unlk5c">
									<label>Confirm Password</label>
									<br />
									<br />
								</div>
								<div class="four columns" id="unlk5a">
									<input type="password" name="cpass" id="pass3" tabindex="3" maxlength="20" />
									<br />
									<br />
								</div>
								<div class="five columns" id="unlk5b">
									<?php
										print $cpasssta;
									?>
									<br />
									<br />
								</div>
							</div>
							<div class="row" id="unlk2">
								<div class=" twelve columns" id="unlk2a">
									<input type="submit" name="sub1" id="but1" tabindex="4" class="success button" value="Change Password" />
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
