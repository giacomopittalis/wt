<?php
	session_start();
	include 'sessionclass.php';
	include 'delegrclass.php';
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

  <title>Wellness - Delete Company Guide Relationship</title>
  
  <!-- Included CSS Files (Uncompressed) -->
  <!--
  <link rel="stylesheet" href="stylesheets/foundation.css">
  -->
  
  <!-- Included CSS Files (Compressed) -->
  <link rel="stylesheet" href="stylesheets/foundation.min.css">
  <link rel="stylesheet" href="stylesheets/app.css">

  <script src="javascripts/modernizr.foundation.js"></script>
  
  <script>
  	function getguide()
{
	var def = document.getElementById("sel1").value;
	try 
    { /*Generally non IE browsers*/
     ajR3 = new XMLHttpRequest();
    }
catch (e)
    { /*IE 6 and down*/try 
        {ajR3 = new ActiveXObject("Msxml2.XMLHTTP");
        }
    catch (e)
        {try 
            {ajR3 = new ActiveXObject("Microsoft.XMLHTTP");
            }
        catch (e)
            { /*Failure to define ajax (old or broken browser)*/
             alert("Your browser is too old, or is misconfigured");
             return false;
            }
        }
    }
//receive data
ajR3.onreadystatechange = function()
{
	if(ajR3.readyState == 4){
		document.getElementById("unlk4a").innerHTML = ajR3.responseText;
	}
};

ajR3.open("GET", "delegrajax.php?clid=" + def, true);
ajR3.send(null);
};
  </script>
  
  <?php
  	$obj1 = new delegr;
	
	$outsta = "";
	$clidsta = "";
	$egrsta = "";
	
	$clid = "";
	$egr = "";
	
	$e = 0;
	
	if (isset($_POST['sub1'])){
		
		//Get input
		$clid = $_POST['lc'];
		$egr = $_POST['gname'];
		
		//Clean input
		
		//validate input
		
		$clidsta = $obj1->vclid($clid);
		if ($clidsta != ""){
			$e++;
		}
		
		$egrsta = $obj1->vegr($egr);
		if ($egrsta != ""){
			$e++;
		}
		
		//All is well
		if ($e == 0){
			$egname = $obj1->getgname($egr);
			$res1 = $obj1->delegr1($egr);
			if ($res1){
				$uname = $_SESSION['uname'];
				$ipadd = $_SESSION['ipadd'];
				$timeformat = "d-m-Y G-i-s";
				$dts = date($timeformat);
				$dts = (string)$dts;
				$dts = $obj1->encode($dts);
				$action = "delegr";
				$action = $obj1->encode($action);
				$res2 = $obj1->upegrlog($uname, $ipadd, $dts, $action, $clid, $egname);
				if ($res2){
					$outsta = "Guide successfully removed from client";
				}
				else{
					$outsta = "Could not remove guide from client";
				}
			}
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
				<div class="ten columns centered" id="contentunlk5a">
					<form name="frmunlock" id="unlockfrom" action="delegr.php" method="post">
						<fieldset>
							<legend>Delete Client Location</legend>
							<div class="row" id="unlk1">
								<div class="six columns" id="unlk1a">
									<?php
										$obj1->printcurclientlist();
									?>
									<br />
									<br />
								</div>
								<div class="six columns" id="unlk1b">
									<?php
										print $clidsta;
									?>
									<br />
									<br />
								</div>
							</div>
							<div class="row" id="unlk4">
								<div class="six columns" id="unlk4a">
									<select name="gname" id="sel2" tabindex="2">
										<option value="0">Select Guide</option>
									</select>
									<br />
									<br />
								</div>
								<div class="six columns" id="unlk4b">
									<?php
										print $egrsta;
									?>
									<br />
									<br />
								</div>
							</div>
							<div class="row" id="unlk2">
								<div class=" twelve columns" id="unlk2a">
									<input type="submit" name="sub1" id="but1" tabindex="7" class="success button" value="Delete" />
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
