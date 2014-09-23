<!DOCTYPE html>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8" />

  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width" />

  <title>Wellness - Base1</title>
  
  <!-- Included CSS Files (Uncompressed) -->
  <!--
  <link rel="stylesheet" href="stylesheets/foundation.css">
  -->
  
  <!-- Included CSS Files (Compressed) -->
  <link rel="stylesheet" href="stylesheets/foundation.min.css">
  <link rel="stylesheet" href="stylesheets/app.css">

  <script src="javascripts/modernizr.foundation.js"></script>
  <?php
  	include 'dbclass.php';
	$obj = new db;
	$res1 = "";
	$res2 = "";
	$res3 = "";
	$res4 = "";
	$res5 = "";
	$res6 = "";
	$res7 = "";
	$res8 = "";
	$res9 = "";
	
	if(isset($_POST['sub1'])){
		$res1 = $obj->crdb();
	}
	
	if(isset($_POST['sub2'])){
		$res2 = $obj->checkdb();
	}
	
	if(isset($_POST['sub3'])){
		$res3 = $obj->crusertable();
	}
	
	if(isset($_POST['sub4'])){
		$res4 = $obj->crloginlogtable();
	}
	
	if(isset($_POST['sub5'])){
		$res5 = $obj->crloginattempttable();
	}
	
	if(isset($_POST['sub6'])){
		$res6 = $obj->crlogincounttable();
	}
	
	if(isset($_POST['sub7'])){
		$res7 = $obj->crsessiondatatable();
	}
	
	if(isset($_POST['sub8'])){
		$res8 = $obj->cripuatable();
	}
	
	if(isset($_POST['sub9'])){
		$res9 = $obj->crcrlogtable();
	}
  ?>
</head>
<body>
	
	<div class="row" id="container2">
		<div class="twelve columns" id="container2a">
			<div class="row" id="head1">
				<div class="twelve columns" id="head1a">
					<br />
					<br />
				</div>
			</div>
			<div class="row" id="content2">
				<div class="twelve columns" id="content2a">
					<form name="basefrm1" id="frmbase1" action="base.php" method="post">
						<fieldset>
							<legend>Create Database</legend>
							<div class="row" id="baseobj1">
								<div class="six columns" id="baseobj1a">
									<input type="submit" name="sub1" id="but1" tabindex="1" value="Create Database" class="success button"/>
								</div>
								<div class="six columns" id="baseobj1b">
									<label class="baselval"><?php print $res1; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Check Database Link</legend>
							<div class="row" id="baseobj2">
								<div class="six columns" id="baseobj2a">
									<input type="submit" name="sub2" id="but2" tabindex="2" value="Check Database Link" class="success button"/>
								</div>
								<div class="six columns" id="baseobj2b">
									<label class="baselval"><?php print $res2; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create User Table</legend>
							<div class="row" id="baseobj3">
								<div class="six columns" id="baseobj3a">
									<input type="submit" name="sub3" id="but3" tabindex="3" value="Create User Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj3b">
									<label class="baselval"><?php print $res3; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Login Log Table</legend>
							<div class="row" id="baseobj4">
								<div class="six columns" id="baseobj4a">
									<input type="submit" name="sub4" id="but4" tabindex="4" value="Create Login Log Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj4b">
									<label class="baselval"><?php print $res4; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Login Attempt Table</legend>
							<div class="row" id="baseobj5">
								<div class="six columns" id="baseobj5">
									<input type="submit" name="sub5" id="but5" tabindex="5" value="Create Login Attempt Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj5b">
									<label class="baselval"><?php print $res5; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Login Count Table</legend>
							<div class="row" id="baseobj6">
								<div class="six columns" id="baseobj6a">
									<input type="submit" name="sub6" id="but6" tabindex="6" value="Create Login Count Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj6b">
									<label class="baselval"><?php print $res6; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Session Data Table</legend>
							<div class="row" id="baseobj7">
								<div class="six columns" id="baseobj7a">
									<input type="submit" name="sub7" id="but7" tabindex="7" value="Create Session Data Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj7b">
									<label class="baselval"><?php print $res7; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create IP / UA Log Table</legend>
							<div class="row" id="baseobj8">
								<div class="six columns" id="baseobj8a">
									<input type="submit" name="sub8" id="but8" tabindex="8" value="Create IP / UA Log Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj8b">
									<label class="baselval"><?php print $res8; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create User Creation Log Table</legend>
							<div class="row" id="baseobj9">
								<div class="six columns" id="baseobj9a">
									<input type="submit" name="sub9" id="but9" tabindex="9" value="Create User Creation Log Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj9b">
									<label class="baselval"><?php print $res9; ?></label>
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
