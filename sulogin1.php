<!DOCTYPE html>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8" />

  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width" />

  <title>Wellness - Super User Login</title>
  
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
	include 'suclass.php';
	$obj1 = new db;
	$obj2 = new su;
	
	$outsta = "";
	$unamesta = "";
	$passsta = "";
	$e = 0;
	$f = 0;
	
	if (isset($_POST['sub1'])){
		
		$uname = $_POST['uname'];
		$pass = $_POST['pass'];
		
		$uname = $obj2->cleaninput($uname);
		$pass = $obj2->cleaninput($pass);
		
		$uname = strtolower($uname);
		
		//Validate username and password
		
		$validate = $obj2->validation($uname, $pass);
		
		$timeformat = "d-m-Y G-i-s";
		$dts = date($timeformat);
		$dts = (string)$dts;
		$ipadd = $_SERVER['REMOTE_ADDR'];
		$ua = $_SERVER['HTTP_USER_AGENT'];
		$priv = "suser";
		$timeout = time();
		$timeout = (string)$timeout;
		if (!$validate){
			$outsta = "Username password combination does not match";
			
			//Append data to login attempt table
			
			$x['uname'] = $uname;
			$x['ua'] = $ua;
			$x['ipadd'] = $ipadd;
			$x['dts'] = $dts;
			
			$nvalid = $obj1->suloginappla($x);
		}
		else{
			//Remove data from login attempt table if exists
			$ladelrow = $obj1->ladelrow($uname);
			
			//Update login Log
			$y['uname'] = $uname;
			$y['ua'] = $ua;
			$y['ipadd'] = $ipadd;
			$y['dts'] = $dts;
			
			$loginlogins = $obj1->loginlogins($y);
			
			//Update Login Count table
			
			//Update ipua table
			//Delete data if exists and update session table
			//Start session, assign session variables
			//Redirect to dashboard
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
				</div>
			</div>
			<div class="row" id="content1">
				<div class="eight columns centered" id="content1a">
					<form name="loginfrm" id="frmlogin" action="login.php" method="post">
						<fieldset>
							<legend>Wellness - Login</legend>
							<div class="row" id="loginobj1">
								<div class="three columns" id="loginobj1a">
									<label class="loginlkey">Username</label>
								</div>
								<div class="four columns" id="loginobj1b">
									<input type="text" name="uname" id="txt1" tabindex="1" maxlength="20" placeholder="Username" />
								</div>
								<div class="five columns" id="loginobj1c">
									<label class="loginlval"><?php print $unamesta; ?></label>
								</div>
							</div>
							<div class="row" id="loginobj2">
								<div class="three columns" id="loginobj2a">
									<label class="loginlkey">Password</label>
								</div>
								<div class="four columns" id="loginobj2b">
									<input type="password" name="pass" id="txt2" tabindex="2" maxlength="20" placeholder="Password" />
								</div>
								<div class="five columns" id="loginobj2c">
									<label class="loginlval"><?php print $passsta; ?></label>
								</div>
							</div>
							<div class="row" id="loginobj3">
								<div class="three columns" id="loginobj3a">
										
								</div>
								<div class="four columns" id="loginobj3b">
									<input type="submit" name="sub1" id="but1" tabindex="3" value="Login" class="success button" />
								</div>
								<div class="five columns" id="loginobj2c">
									<label class="loginlval"><?php print $outsta; ?></label>
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
