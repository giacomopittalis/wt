<?php	session_start();	//include 'firebugPHPlogging.php';	//include '../../firePHPsetup.php';	include 'sessionclass.php';	include 'loginclass.php';	$obj = new session;	$secheckag = $obj->secheckadminguide();	if ($secheckag){		$obj->redl();	}?><?php  	$outsta = "";	$e = 0;	// 'Submit Login' button	//var_dump($_REQUEST);	//echo $_POST['loginSubmitted'];	if(isset($_POST['loginSubmitted'])){		echo '<script type="text/javascript">console.log("Login has been submitted");</script>';		$username = $_POST['username'];		$password = $_POST['password'];		$login = new login;				$username = strtolower($username);		$username = $login->cleaninput($username);		$pass = $login->cleaninput($password);		//testfirephp();		$validate = $login->validate($username, $password);                  		$timeFormat = "d-m-Y G-i-s";		$dts = date($timeFormat);		$dts = (string)$dts;		$ipAddress = $_SERVER['REMOTE_ADDR'];		$userAgent = $_SERVER['HTTP_USER_AGENT'];		//echo($ipAddress."blass<br/>");		//echo($userAgent);		if ($validate){	echo("inside \$validate");			//echo($login->tableExists("loginlog"));			//Delete data if exists in login attempt table			$updateLoginAttempts = $login->updateLoginAttempts($username);			$deleteAttempt = $login->deleteAttempt($username);			//var_dump($delattempt);						//Insert data into login log table			$updateLoginLog = $login->updateLoginLog($username, $userAgent, $ipAddress, $dts);			//var_dump($uploginlog);						//Update or Insert into login count table			$uplogincount = $login->uplogincount($username);			//var_dump($uplogincount);					//Delete if exists and Insert data into session table			$timeout = time();			$length = 12;			$token = $obj->token($length);			$priv = $login->getpriv($username);			  			$upsession = $login->upsession($username, $priv, $ipAddress, $userAgent, $token, $timeout);			//var_dump($upsession);						//Set session variables						$euname = $login->encode($username);			$epriv = $login->encode($priv);			$eipadd = $login->encode($ipAddress);			$euagent = $login->encode($userAgent);			$etoken = $login->encode($token);				$_SESSION['uname'] = $euname;		$_SESSION['priv'] = $epriv;			$_SESSION['ipadd'] = $eipadd;					$_SESSION['uagent'] = $euagent;			$_SESSION['token'] = $etoken;			$_SESSION['timeout'] = $timeout;						//var_dump($_SESSION);					//Redirect			//echo("log in validated<br/>");				$admin = "admin";			$eadmin = $login->encode($admin);			$guide = "guide";			$eguide = $login->encode($guide);  			//echo($epriv);			//echo("<br/>");			//echo($eadmin);			//echo("<br/>");			//echo($eguide);			//echo("<br/>");       			if ($epriv == $eadmin){				echo("welcome.. Admin");				header("Location: adash.php");							}			else{				if ($epriv == $eguide){					header("Location: gdash.php");				}			}					}		else{echo "caz";			$updateLoginAttempts = $login->updateLoginAttempts($username); // not clear if this is working - does not seem to be logging..		}	}	if (isset($_POST['sub1'])){				$obj1 = new login;				$uname = $_POST['uname'];		$pass = $_POST['pass'];				//Convert		$uname = strtolower($uname);				//Clean Input		$uname = $obj1->cleaninput($uname);		$pass = $obj1->cleaninput($pass);				//Validate Input		$validate = $obj1->validate($uname, $pass);		//var_dump($validate);		//Get other values				$timeformat = "d-m-Y G-i-s";		$dts = date($timeformat);		$dts = (string)$dts;		$ipadd = $_SERVER['REMOTE_ADDR'];		$uagent = $_SERVER['HTTP_USER_AGENT'];				//Post validation		if ($validate){			//Delete data if exists in login attempt table			$delattempt = $obj1->delattempt($uname);			//var_dump($delattempt);			//Insert data into login log table			$uploginlog = $obj1->uploginlog($uname, $uagent, $ipadd, $dts);			//var_dump($uploginlog);			//Update or Insert into login count table			$uplogincount = $obj1->uplogincount($uname);			//var_dump($uplogincount);			//Delete if exists and Insert data into session table			$timeout = time();			$length = 12;			$token = $obj->token($length);			$priv = $obj1->getpriv($uname);			echo("did I make it here?");						$upsession = $obj1->upsession($uname, $priv, $ipadd, $uagent, $token, $timeout);			//var_dump($upsession);						//Set session variables						$euname = $obj1->encode($uname);			$epriv = $obj1->encode($priv);			$eipadd = $obj1->encode($ipadd);			$euagent = $obj1->encode($uagent);			$etoken = $obj1->encode($token);						$_SESSION['uname'] = $euname;			$_SESSION['priv'] = $epriv;			$_SESSION['ipadd'] = $eipadd;			$_SESSION['uagent'] = $euagent;			$_SESSION['token'] = $etoken;			$_SESSION['timeout'] = $timeout;						//var_dump($_SESSION);						//Redirect						$admin = "admin";			$eadmin = $obj1->encode($admin);			$guide = "guide";			$eguide = $obj1->encode($guide);						if ($epriv == $eadmin){				header("Location: adash.php");			}			else{				if ($epriv == $eguide){					header("Location: gdash.php");				}			}					}		else{			//Update and lock account if necessary or create entry in login attempt table			$upattempt = $obj1->upattempt($uname);		}			}	  ?><!DOCTYPE html><!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ --><!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]--><!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]--><head>  <meta charset="utf-8" />  <!-- Set the viewport width to device width for mobile -->  <meta name="viewport" content="width=device-width" />  <title>Wellness - Login</title><?php/*  foreach ($_POST as $key => $value){  echo "{$key} = {$value}<br/>";}echo("End Post Values<br/>");*/?>  <!-- Included CSS Files (Uncompressed) -->  <!--  <link rel="stylesheet" href="stylesheets/foundation.css">  -->    <!-- Included CSS Files (Compressed) --><link rel="stylesheet" href="style-G.css">  <script src="javascripts/modernizr.foundation.js"></script>    </head><body style="background-color: #EEEFEF;">		<div class="row" id="container1">		<div class="twelve columns" id="container1a">			<div class="row" id="head1">				<div class="twelve columns" id="head1a">					<br />					<br />				</div>			</div>			<div class="row" id="content1">				<div class="eight columns centered" id="content1a">				                                    <form name="loginForm" action="login.php" method="post" id="login-box" >							<legend><img src="img/logo.jpg" style="margin: auto;"><br>                                                            Admin login</legend>                                                        <h2>Please login to manage clients</h2>							<div class="row" id="loginobj1">									<input id="username" type="text" name="username" id="txt1" tabindex="1" maxlength="20" placeholder="Username" style="margin-top: 30px; margin-left: 100px; color:#BBBBBB!important;        font-family: arial;        font-size: 16px;" />							<input type="password" name="password" id="txt2" tabindex="2" maxlength="20" placeholder="Password" style="margin-top: 40px; margin-left: 100px; color:#BBBBBB!important;        font-family: arial;        font-size: 16px;" />															</div>							<div class="row" id="loginobj3">															<input type="submit" name="loginSubmitted" id="but1" tabindex="3" value="" class="success button" />															</div>					</form>				</div>			</div>		</div>	</div>  <!-- Included JS Files (Uncompressed) -->  <!--  <script src="javascripts/jquery.js"></script>  <script src="javascripts/jquery.foundation.mediaQueryToggle.js"></script>  <script src="javascripts/jquery.foundation.forms.js"></script>  <script src="javascripts/jquery.event.move.js"></script>  <script src="javascripts/jquery.event.swipe.js"></script>  <script src="javascripts/jquery.foundation.reveal.js"></script>  <script src="javascripts/jquery.foundation.orbit.js"></script>  <script src="javascripts/jquery.foundation.navigation.js"></script>  <script src="javascripts/jquery.foundation.buttons.js"></script>  <script src="javascripts/jquery.foundation.tabs.js"></script>  <script src="javascripts/jquery.foundation.tooltips.js"></script>  <script src="javascripts/jquery.foundation.accordion.js"></script>  <script src="javascripts/jquery.placeholder.js"></script>  <script src="javascripts/jquery.foundation.alerts.js"></script>  <script src="javascripts/jquery.foundation.topbar.js"></script>  <script src="javascripts/jquery.foundation.joyride.js"></script>  <script src="javascripts/jquery.foundation.clearing.js"></script>  <script src="javascripts/jquery.foundation.magellan.js"></script>    -->    <!-- Included JS Files (Compressed) -->  <script src="javascripts/foundation.min.js"></script>    <!-- Initialize JS Plugins -->  <script src="javascripts/app.js"></script>   </body></html>