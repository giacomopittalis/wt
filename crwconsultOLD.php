<?php
	session_start();
	include 'sessionclass.php';
	include 'crwconsultclass.php';
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

  <title>Wellness - Create New Well Credit Consult</title>
  
  <!-- Included CSS Files (Uncompressed) -->
  <!--
  <link rel="stylesheet" href="stylesheets/foundation.css">
  -->
  
  <!-- Included CSS Files (Compressed) -->
  <link rel="stylesheet" href="stylesheets/foundation.min.css">
  <link rel="stylesheet" href="stylesheets/app.css">

  <script src="javascripts/modernizr.foundation.js"></script>
  
  <script>
  	function getloc()
{
	var ghi = document.getElementById("sel1").value;
	try 
    { /*Generally non IE browsers*/
     ajR4 = new XMLHttpRequest();
    }
catch (e)
    { /*IE 6 and down*/try 
        {ajR4 = new ActiveXObject("Msxml2.XMLHTTP");
        }
    catch (e)
        {try 
            {ajR4 = new ActiveXObject("Microsoft.XMLHTTP");
            }
        catch (e)
            { /*Failure to define ajax (old or broken browser)*/
             alert("Your browser is too old, or is misconfigured");
             return false;
            }
        }
    }
//receive data
ajR4.onreadystatechange = function()
{
	if(ajR4.readyState == 4){
		document.getElementById("consultajax1").innerHTML = ajR4.responseText;
	}
};

ajR4.open("GET", "crwconsultajax.php?clid=" + ghi, true);
ajR4.send(null);
};
  </script>
  
  <script>
  	function getcon()
{
	var abc = document.getElementById("sel1").value;
	var def = document.getElementById("sel2").value;
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
		document.getElementById("consultajax2").innerHTML = ajR3.responseText;
	}
};

ajR3.open("GET", "crwconsultajax1.php?clid=" + abc + "&locid=" + def, true);
ajR3.send(null);
};
  </script>
  
  <?php
  	
  	$obj1 = new crwconsult;
  	$e = 0;
	
	$outsta = "";
	$clidsta = "";
	$locidsta = "";
	$conidsta = "";
	
	$clid = "";
	$locid = "";
	$conid = "";
	
	
	if (isset($_POST['sub1'])){
		
		//Get And Clean Input
		
		$input = $obj1->getinput();
		
		//Validate input
		$clidsta = $obj1->vclid($input['clid']);
		if ($clidsta != ""){
			$e++;
		}
		
		$locidsta = $obj1->vlocid($input['locid']);
		if ($locidsta != ""){
			$e++;
		}
		
		$conidsta = $obj1->vconid($input['conid']);
		if ($conidsta != ""){
			$e++;
		}
		
		//All is well
		
		if ($e == 0){
			$res = $obj1->crwc($input);
			if ($res){
				$outsta = "Well Credit consult successfully created";
			}
			else{
				$outsta = "Well Credit consult could not be created";
			}
		}
		$_SESSION['client'] = $input['clid'];
		$_SESSION['location'] = $input['locid'];
		$_SESSION['contact'] = $input['conid'];
		
	}
  	
  ?>
  
</head>
<body><?php include('header.php'); ?> 
	<div class="row">
		<div class="ten columns centered">
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
	<div class="row">
		<div class="twelve columns">
			<form name="iconsultfrm" id="frmiconsult" action="crwconsult.php" method="post">
				<fieldset>
					<div class="row">
						<div class="three columns">
							<label>Client</label>
						</div>
						<div class="four columns">
							<?php $obj1->printlinkedclientlist(); ?>
						</div>
						<div class="five columns">
							<label><?php print $clidsta ?></label>
						</div>
					</div>
				</fieldset>
				<fieldset>
					<div class="row">
						<div class="three columns">
							<label>Location</label>
						</div>
						<div class="four columns" id="consultajax1">
							<?php $obj1->printinitloclist(); ?>
						</div>
						<div class="five columns">
							<label><?php print $locidsta ?></label>
						</div>
					</div>
				</fieldset>
				<fieldset>
					<div class="row">
						<div class="three columns">
							<label>Contact ID</label>
						</div>
						<div class="four columns" id="consultajax2">
							<?php $obj1->printinitconlist(); ?>
						</div>
						<div class="five columns">
							<label><?php print $conidsta ?></label>
						</div>
					</div>
				</fieldset>
				<fieldset>
					<?php $obj1->printwce() ?>
				</fieldset>
				<fieldset>
					<div class="row">
						<div class="three columns">
							<label></label>
						</div>
						<div class="four columns">
							<input type="submit" name="sub1" id="but1" tabindex="6" value="Create" class="success button"/>
						</div>
						<div class="five columns">
							<label><?php print $outsta ?></label>
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