<?php
	session_start();
	include 'sessionclass.php';
	include 'crinjuryclass.php';
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

  <title>Wellness - Create New Injury</title>
  
  <!-- Included CSS Files (Uncompressed) -->
  <!--
  <link rel="stylesheet" href="stylesheets/foundation.css">
  -->
  
  <!-- Included CSS Files (Compressed) -->
  <link rel="stylesheet" href="stylesheets/foundation.min.css">
  <link rel="stylesheet" href="stylesheets/app.css">

  <script src="javascripts/modernizr.foundation.js"></script>
  
  <?php
  	$obj1 = new crinjury;
	
	$bpidsta = "";
	$injurysta = "";
	$bpid = "";
	$injury = "";
	$outsta = "";
	$e = 0;
	
	if (isset($_POST['sub1'])){
		
		//Get input
		$bpid = $_POST['bp'];
		$injury = $_POST['injury'];
		
		//Clean input
		$injury = $obj1->cleaninput($injury);
		
		//validate input
		$bpidsta = $obj1->vbpid($bpid);
		if ($bpidsta != ""){
			$e++;
		}
		
		$injurysta = $obj1->vinjury($injury, $bpid);
		if ($injurysta != ""){
			$e++;
		}
		
		//All is well
		if ($e == 0){
			$res1 = $obj1->crinjury1($bpid, $injury);
			if ($res1){
				$uname = $_SESSION['uname'];
				$ipadd = $_SESSION['ipadd'];
				$timeformat = "d-m-Y G-i-s";
				$dts = date($timeformat);
				$dts = (string)$dts;
				$dts = $obj1->encode($dts);
				$action = "crij";
				$action = $obj1->encode($action);
				$ijid = $obj1->getlastinsertid();
				$res2 = $obj1->upijlog($uname, $ipadd, $dts, $action, $ijid);
				if ($res2){
					$outsta = "Injury created successfully";
				}
				else{
					$outsta = "Error writing to log table";
				}
				$_SESSION['ij'] = $ijid;
			}
			else{
				$outsta = "Error creating Injury";
			}
		}
		
		//Set Session
		
		$_SESSION['bp'] = $bpid;
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
			<div class="row">
				<div class="twelve columns">
					<form name="frmtopic" id="topicfrom" action="crinjury.php" method="post">
						<fieldset>
							<legend>Create New Injury</legend>
							<div class="row">
								<div class="three columns">
									<label>Body Part</label>
								</div>
								<div class="four columns">
									<?php
										$obj1->printinitbplist();
									?>
								</div>
								<div class="five columns">
									<?php print $bpidsta; ?>
								</div>
							</div>
							<div class="row">
								<div class="three columns">
									<label>Injury</label>
								</div>
								<div class="four columns">
									<input type="text" name="injury" id="txt1" tabindex="2" maxlength="90"/>
								</div>
								<div class="five columns">
									<?php print $injurysta; ?>
								</div>
							</div>
							</div>
							<div class="row">
								<div class="three columns">
									<label></label>
								</div>
								<div class="four columns">
									<input type="submit" name="sub1" id="but1" tabindex="3" value="Create" class="success button"/>
								</div>
								<div class="five columns">
									<?php print $outsta; ?>
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
