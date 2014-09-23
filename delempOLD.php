<?php
	session_start();
	include 'sessionclass.php';
	include 'delempclass.php';
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

  <title>Wellness - Delete Employee</title>
  
  <!-- Included CSS Files (Uncompressed) -->
  <!--
  <link rel="stylesheet" href="stylesheets/foundation.css">
  -->
  
  <!-- Included CSS Files (Compressed) -->
  <link rel="stylesheet" href="stylesheets/foundation.min.css">
  <link rel="stylesheet" href="stylesheets/app.css">

  <script src="javascripts/modernizr.foundation.js"></script>
  
  <script>
  	function getemp()
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
		document.getElementById("adminobj0zb").innerHTML = ajR3.responseText;
	}
};

ajR3.open("GET", "delempajax.php?clid=" + abc + "&locid=" + def, true);
ajR3.send(null);
};
  </script>
  
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
		document.getElementById("adminobj0yb").innerHTML = ajR4.responseText;
	}
};

ajR4.open("GET", "delempajax1.php?clid=" + ghi, true);
ajR4.send(null);
};
  </script>
  
  <?php
  
  	$obj1 = new delemp;
  
  	$outsta = "";
	$e = 0;
	
	$clidsta = "";
	$locidsta = "";
	$empsta = "";
	
	$clid = "";
	$locid = "";
	$emp = "";
	
	if (isset($_POST['sub1'])){
		
		//Get input
		$clid = $_POST['lc'];
		$locid = $_POST['lid'];
		$emp = $_POST['emp'];
		
		
		//Clean input
		
		//Validate Input
		
		$clidsta = $obj1->vclid($clid);
		if ($clidsta != ""){
			$e++;
		}
		
		$locidsta = $obj1->vlocid($locid);
		if ($locidsta != ""){
			$e++;
		}
		
		$empsta = $obj1->vemp($emp);
		if ($empsta != ""){
			$e++;
		}
		
		//All is well
		if ($e == 0){
			
			$res1 = $obj1->delemp1($emp);
			if ($res1){
				$suname = $_SESSION['uname'];
				$ipadd = $_SESSION['ipadd'];
				$timeformat = "d-m-Y G-i-s";
				$dts = date($timeformat);
				$dts = (string)$dts;
				$dts = $obj1->encode($dts);
				$action = "delemp";
				$action = $obj1->encode($action);
				$res2 = $obj1->upemplog($suname, $ipadd, $dts, $action, $emp);
				if ($res2){
					$outsta = "Employee successfully deleted";
					
					$e = 0;
			
					$clidsta = "";
					$locidsta = "";
					$empsta = "";
	
					$clid = "";
					$locid = "";
					$emp = "";
				}
				else{
					$outsta = "Could not delete employee";
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
					<a href="logout.php">Logout</a>
				</div>
			</div>
			<div class="row" id="content3">
				<div class="twelve columns" id="content3a">
					<form name="adminonefrm" id="frmadminone" action="delemp.php" method="post">
						<fieldset>
							<legend>Hierarchy</legend>
							<div class="row" id="adminobj0x">
								<div class="three columns" id="adminobj0xa">
									<label class="adminlkey">Client</label>
								</div>
								<div class="four columns" id="adminobj0xb">
									<?php
										$obj1->printlinkedclientlist();
									?>
								</div>
								<div class="five columns" id="loginobj0xc">
									<label class="adminlval"><?php print $clidsta; ?></label>
								</div>
							</div>
							<div class="row" id="adminobj0y">
								<div class="three columns" id="adminobj0ya">
									<label class="adminlkey">Location</label>
								</div>
								<div class="four columns" id="adminobj0yb">
									<select name="lid" id="sel2" tabindex="2">
										<option value="0">Select Location</option>
									</select>
								</div>
								<div class="five columns" id="loginobj0yc">
									<label class="adminlval"><?php print $locidsta; ?></label>
								</div>
							</div>
							<div class="row" id="adminobj0z">
								<div class="three columns" id="adminobj0za">
									<label class="adminlkey">Employee</label>
								</div>
								<div class="four columns" id="adminobj0zb">
									<select name="emp" id="sel10" tabindex="3">
										<option value="0">Select Employee</option>
									</select>
								</div>
								<div class="five columns" id="loginobj0zc">
									<label class="adminlval"><?php print $empsta; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<div class="row" id="adminobj17">
								<div class="three columns" id="adminobj17a">
									
								</div>
								<div class="four columns" id="adminobj17b">
									<input type="submit" name="sub1" id="but1" tabindex="18" value="Delete" class="success button" />
								</div>
								<div class="five columns" id="loginobj17c">
									<label class="adminlval"><?php print $outsta; ?></label>
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