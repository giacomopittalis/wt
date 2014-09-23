<?php
	session_start();
	include 'sessionclass.php';
	include 'crwceclass.php';
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

  <title>Wellness - Create New Wce</title>
  
  <!-- Included CSS Files (Uncompressed) -->
  <!--
  <link rel="stylesheet" href="stylesheets/foundation.css">
  -->
  
  <!-- Included CSS Files (Compressed) -->
  <link rel="stylesheet" href="stylesheets/foundation.min.css">
  <link rel="stylesheet" href="stylesheets/app.css">

  <script src="javascripts/modernizr.foundation.js"></script>
  
  <?php
  	$obj1 = new crwce;
	
	$constypeidsta = "";
	$wcesta = "";
	$namesta = "";
	$typesta = "";
	$bvalsta= "";
	$constypeid = "";
	$wce = "";
	$name = "";
	$type = "";
	$bval = "";
	$outsta = "";
	$e = 0;
	
	if (isset($_POST['sub1'])){
		
		//Get input
		$constypeid = $_POST['constype'];
		$wce = $_POST['wce'];
		$name = $_POST['name'];
		$type = $_POST['type'];
		$bval = $_POST['bval'];
		//Clean input
		$wce = $obj1->cleaninput($wce);
		$name = $obj1->cleaninput($name);
		$bval = $obj1->cleaninput($bval);
		
		//validate input
		$constypeidsta = $obj1->vconstypeid($constypeid);
		if ($constypeidsta != ""){
			$e++;
		}
		
		$wcesta = $obj1->vwce($wce, $constypeid);
		if ($wcesta != ""){
			$e++;
		}
		
		$namesta = $obj1->vname($name);
		if ($namesta != ""){
			$e++;
		}
		
		$typesta = $obj1->vtype($type);
		if ($typesta != ""){
			$e++;
		}
		
		$bvalsta = $obj1->vbval($bval);
		if ($bvalsta != ""){
			$e++;
		}
		
		//All is well
		if ($e == 0){
			$name = strtolower($name);
			$res1 = $obj1->crwce1($constypeid, $wce, $name, $type, $bval);
			if ($res1){
				$uname = $_SESSION['uname'];
				$ipadd = $_SESSION['ipadd'];
				$timeformat = "d-m-Y G-i-s";
				$dts = date($timeformat);
				$dts = (string)$dts;
				$dts = $obj1->encode($dts);
				$action = "crwce";
				$action = $obj1->encode($action);
				$wceid = $obj1->getlastinsertid();
				$res2 = $obj1->upwcelog($uname, $ipadd, $dts, $action, $wceid);
				if ($res2){
					$outsta = "Wce created successfully";
				}
				else{
					$outsta = "Error writing to log table";
				}
			}
			else{
				$outsta = "Error creating wce";
			}
		}
		
		//Set Session
		
		$_SESSION['constype'] = $constypeid;
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
					<form name="frmtopic" id="topicfrom" action="crwce.php" method="post">
						<fieldset>
							<legend>Create New Hctonee</legend>
							<div class="row">
								<div class="three columns">
									<label>Consult Type</label>
								</div>
								<div class="four columns">
									<?php
										$obj1->printinitconstypelist();
									?>
								</div>
								<div class="five columns">
									<?php print $constypeidsta; ?>
								</div>
							</div>
							<div class="row">
								<div class="three columns">
									<label>Wce</label>
								</div>
								<div class="four columns">
									<input type="text" name="wce" id="txt1" tabindex="2" maxlength="90"/>
								</div>
								<div class="five columns">
									<?php print $wcesta; ?>
								</div>
							</div>
							<div class="row">
								<div class="three columns">
									<label>Name</label>
								</div>
								<div class="four columns">
									<input type="text" name="name" id="txt2" tabindex="3" maxlength="90"/>
								</div>
								<div class="five columns">
									<?php print $namesta; ?>
								</div>
							</div>
							<div class="row">
								<div class="three columns">
									<label>Type</label>
								</div>
								<div class="four columns">
									<select name="type" id="type" tabindex="4">
										<option value="0">Select Type</option>
										<option value="text">Textbox</option>
										<option value="checkbox">Checkbox</option>
									</select>
								</div>
								<div class="five columns">
									<?php print $typesta; ?>
								</div>
							</div>
							<div class="row">
								<div class="three columns">
									<label>Base Value</label>
								</div>
								<div class="four columns">
									<input type="text" name="bval" id="bval" tabindex="5"/>
								</div>
								<div class="five columns">
									<?php print $bvalsta; ?>
								</div>
							</div>
							<div class="row">
								<div class="three columns">
									<label></label>
								</div>
								<div class="four columns">
									<input type="submit" name="sub1" id="but1" tabindex="6" value="Create" class="success button"/>
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
