<?php
	session_start();
	include 'sessionclass.php';
	$obj = new session;
	$seadmin = $obj->seadminguide();
?>
<!DOCTYPE html>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8" />

  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width" />

  <title>Wellness - WellGuide Dashboard</title>
  
  <!-- Included CSS Files (Uncompressed) -->
  <!--
  <link rel="stylesheet" href="stylesheets/foundation.css">
  -->
  
  <!-- Included CSS Files (Compressed) -->
  <link rel="stylesheet" href="stylesheets/foundation.min.css">
  <link rel="stylesheet" href="stylesheets/app.css">

  <script src="javascripts/modernizr.foundation.js"></script>
</head>
<body>
	
	<div class="row" id="container1">
		<div class="twelve columns" id="container1a">
			<div class="row" id="head1">
				<div class="twelve columns" id="head1a">
					<br />
					<br />
				</div>
			</div>
			<div class="row" id="content5">
				<div class="twelve columns" id="content5a">
					<a href="logout.php">Logout</a>
					<br />
					<br />
					<a href="usercp.php">Change Password</a>
					<br />
					<br />
					<a href="cremp.php">Create Employee</a>
					<br />
					<br />
					<a href="editemp.php">Edit Employee</a>
					<br />
					<br />
					<a href="editemppic.php">Edit Employee Photo</a>
					<br />
					<br /><?php
	session_start();
	include 'sessionclass.php';
	$obj = new session;
	$seadmin = $obj->seadminguide();
?>
<!DOCTYPE html>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8" />

  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width" />

  <title>Wellness - WellGuide Dashboard</title>
  
  <!-- Included CSS Files (Uncompressed) -->
  <!--
  <link rel="stylesheet" href="stylesheets/foundation.css">
  -->
  
  <!-- Included CSS Files (Compressed) -->
  <link rel="stylesheet" href="stylesheets/foundation.min.css">
  <link rel="stylesheet" href="stylesheets/app.css">

  <script src="javascripts/modernizr.foundation.js"></script>
</head>
<body>
	
	<div class="row" id="container1">
		<div class="twelve columns" id="container1a">
			<div class="row" id="head1">
				<div class="twelve columns" id="head1a">
					<br />
					<br />
				</div>
			</div>
			<div class="row" id="content5">
			  <div class="twelve columns" id="content5a"><br>
				  <table width="100%" border="0" cellspacing="0" cellpadding="0">
				    <tr>
				      <td colspan="4" bgcolor="#FFCC33"><strong>WellGuide Main Menu</strong></td>
				      <td width="22%"><a href="usercp.php">Change Password</a></td>
				      <td width="10%"><a href="logout.php">Logout</a></td>
			        </tr>
				    <tr>
				      <td width="15%"><a href="cremp.php">Create Employee</a></td>
				      <td width="5%"><a href="editemp.php">Edit</a></td>
				      <td width="7%"><a href="editemppic.php"> Photo</a></td>
				      <td width="41%"><a href="delemp.php">Delete </a></td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
			        </tr>
				    <tr>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
			        </tr>
				    <tr>
				      <td><a href="crcon.php">Create Contact</a></td>
				      <td><a href="clcon.php">Close </a></td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
			        </tr>
				    <tr>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
			        </tr>
				    <tr>
				      <td><a href="crhconsult.php">New Health Consult</a></td>
				      <td><a href="edithconsult.php">Edit </a></td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
			        </tr>
				    <tr>
				      <td><a href="crpconsult.php">New Proactive Consult</a></td>
				      <td><a href="editpconsult.php">Edit </a></td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
			        </tr>
				    <tr>
				      <td><a href="criconsult.php">New Injury Consult</a></td>
				      <td><a href="editiconsult.php">Edit</a></td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
			        </tr>
				    <tr>
				      <td><a href="croconsult.php">New Opportunity Consult</a></td>
				      <td><a href="editoconsult.php">Edit</a></td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
			        </tr>
				    <tr>
				      <td><a href="crwconsult.php">New Well Credit Consult</a></td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
			        </tr>
		        </table>
				  <br />
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

					<a href="delemp.php">Delete Employee</a>
					<br />
					<br />
					<a href="crcon.php">Create Contact</a>
					<br />
					<br />
					<a href="clcon.php">Close Contact</a>
					<br />
					<br />
					<a href="crhconsult.php">New Health Consult</a>
					<br />
					<br />
					<a href="criconsult.php">New Injury Consult</a>
					<br />
					<br />
					<a href="croconsult.php">New Opportunity Consult</a>
					<br />
					<br />
					<a href="crpconsult.php">New Proactive Consult</a>
					<br />
					<br />
					<a href="crwconsult.php">New Well Credit Consult</a>
					<br />
					<br />
					<a href="edithconsult.php">Edit Health Consult</a>
					<br />
					<br />
					<a href="editiconsult.php">Edit Injury Consult</a>
					<br />
					<br />
					<a href="editoconsult.php">Edit Opportunity Consult</a>
					<br />
					<br />
					<a href="editpconsult.php">Edit Proactive Consult</a>
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
