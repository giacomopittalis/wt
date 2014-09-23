<?php
	session_start();
	include 'sessionclass.php';
	include 'crconclass.php';
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

  <title>Wellness - Create New Contact</title>
  
  <!-- Included CSS Files (Uncompressed) -->
  <!--
  <link rel="stylesheet" href="stylesheets/foundation.css">
  -->
  
  <!-- Included CSS Files (Compressed) -->
  <link rel="stylesheet" href="stylesheets/foundation.min.css">
  <link rel="stylesheet" href="stylesheets/app.css">

  <script src="javascripts/modernizr.foundation.js"></script>
  
  <script>
  	function daysl()
{
	var abc = document.getElementById("sel8").value;
	var def = document.getElementById("sel5").value;
	try 
    { /*Generally non IE browsers*/
     ajR1 = new XMLHttpRequest();
    }
catch (e)
    { /*IE 6 and down*/try 
        {ajR1 = new ActiveXObject("Msxml2.XMLHTTP");
        }
    catch (e)
        {try 
            {ajR1 = new ActiveXObject("Microsoft.XMLHTTP");
            }
        catch (e)
            { /*Failure to define ajax (old or broken browser)*/
             alert("Your browser is too old, or is misconfigured");
             return false;
            }
        }
    }
//receive data
ajR1.onreadystatechange = function()
{
	if(ajR1.readyState == 4){
		document.getElementById("adminobj18d").innerHTML = ajR1.responseText;
	}
};

ajR1.open("GET", "crconajax2.php?month=" + def + "&year=" + abc, true);
ajR1.send(null);
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
		document.getElementById("crconajax1").innerHTML = ajR4.responseText;
	}
};

ajR4.open("GET", "crconajax.php?clid=" + ghi, true);
ajR4.send(null);
};
  </script>
  <script>
  	function getemp()
{
	var abc = document.getElementById("sel1").value;
	var def = document.getElementById("sel2").value;
	var jkl = document.getElementById("bulk").value;
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
		document.getElementById("crconajax2").innerHTML = ajR3.responseText;
	}
};

ajR3.open("GET", "crconajax1.php?clid=" + abc + "&locid=" + def + "&bulk=" + jkl, true);
ajR3.send(null);
};
  </script>
  
  <?php
  	
  	$obj1 = new crcon;
  	$e = 0;
	
	$outsta = "";
	$clidsta = "";
	$locidsta = "";
	$bulksta = "";
	$empidsta = "";
	$ctypesta = "";
	$datsta = "";
	
	$clid = "";
	$locid = "";
	$bulk = "";
	$empid = "";
	$ctype = "0";
	$year = "";
	$month = "";
	$day = "";
	$dat = "";
	
	if (isset($_POST['sub1'])){
		
		//Get Input
		$clid = $_POST['lc'];
		$locid = $_POST['lid'];
		$empid = $_POST['empid'];
		$ctype = $_POST['ctype'];
		$bulk = $_POST['bulk'];
		$year = $_POST['year'];
		$month = $_POST['month'];
		$day = $_POST['day'];
		
		//Clean Input
		
		if(is_array($empid)){
			$del_val = "0";
			if(($key = array_search($del_val, $empid)) !== false) {
    			unset($empid[$key]);
			}
		}
		
		$dat = $obj1->cleaninput($dat);
		
		//Validate input
		$clidsta = $obj1->vclid($clid);
		if ($clidsta != ""){
			$e++;
		}
		
		$locidsta = $obj1->vlocid($locid);
		if ($locidsta != ""){
			$e++;
		}
		
		$ctypesta = $obj1->vctype($ctype);
		if ($ctypesta != ""){
			$e++;
		}
		
		if (is_array($empid)){
			$empidsta = $obj1->vempid1($empid);
			if ($empidsta != ""){
				$e++;
			}
		}
		else{
			$empidsta = $obj1->vempid($empid);
			if ($empidsta != ""){
				$e++;
			}
		}
		
		$datsta = $obj1->vdate($year, $month, $day);
		if ($datsta != ""){
			$e++;
		}
		
		//All is well
		
		if ($e == 0){
			$dat = $month."/".$day."/".$year;
			
			$suname = $_SESSION['uname'];
			
			$status = "open";
			
			if ($bulk != "bulk"){
				$res1 = $obj1->crcon1($clid, $locid, $ctype, $empid, $suname, $dat, $status);
				if ($res1){
					$conid = $obj1->getlastinsertid();
					$ipadd = $_SESSION['ipadd'];
					$timeformat = "d-m-Y G-i-s";
					$dts = date($timeformat);
					$dts = (string)$dts;
					$dts = $obj1->encode($dts);
					$action = "crcon";
					$action = $obj1->encode($action);
					
					$res2 = $obj1->upconlog($suname, $ipadd, $dts, $action, $conid);
					if ($res2){
						$outsta = "Contact successfully Created";
					}
					else{
						$outsta = "Error writing to contact log";
					}
					$_SESSION['contact'] = $conid;
				}
			}
			else{
				foreach ($empid as $value){
					$res1 = $obj1->crcon1($clid, $locid, $ctype, $value, $suname, $dat, $status);
					if ($res1){
						$conid = $obj1->getlastinsertid();
						$ipadd = $_SESSION['ipadd'];
						$timeformat = "d-m-Y G-i-s";
						$dts = date($timeformat);
						$dts = (string)$dts;
						$dts = $obj1->encode($dts);
						$action = "crcon";
						$action = $obj1->encode($action);
					
						$res2 = $obj1->upconlog($suname, $ipadd, $dts, $action, $conid);
						$_SESSION['contact'] = $conid;
					}
				}
				$outsta = "Bulk Contact Successfully Created";
			}
		}
		$_SESSION['client'] = $clid;
		$_SESSION['location'] = $locid;
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
	<div class="row" id="conty">
		<div class="twelve columns" id="contz">
			<form name="crconfrm" id="frmcrcon" action="crcon.php" method="post">
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
						<div class="four columns" id="crconajax1">
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
							<label>Select Mode</label>
						</div>
						<div class="four columns">
							<select name="bulk" id="bulk" tabindex="4" onchange="getemp();">
								<option value="normal">Normal</option>
								<option value="bulk">Bulk</option>
							</select>
						</div>
						<div class="five columns">
							<label><?php print $bulksta ?></label>
						</div>
					</div>
				</fieldset>
				<fieldset>
					<div class="row">
						<div class="three columns">
							<label>Contact Method</label>
						</div>
						<div class="four columns">
							<select name="ctype" id="sel4" tabindex="4">
								<option value="0">Select Contact Method</option>
								<option value="oneonone" selected="selected">One on One</option>
								<option value="telephonic">Telephonic</option>
								<option value="email">Email</option>
								<option value="group">Group</option>
							</select>
						</div>
						<div class="five columns">
							<label><?php print $ctypesta ?></label>
						</div>
					</div>
				</fieldset>
				<fieldset>
					<div class="row">
						<div class="three columns">
							<label>Employee</label>
						</div>
						<div class="four columns" id="crconajax2">
							<?php $obj1->printinitemplist(); ?>
						</div>
						<div class="five columns">
							<label><?php print $empidsta ?></label>
						</div>
					</div>
				</fieldset>
				<fieldset>
					<div class="row" id="adminobj18">
						<div class="three columns" id="adminobj18a">
							<label class="adminlkey">Date</label>
						</div>
						<div class="two columns" id="adminobj18b">
							<?php $obj1->printyear(); ?>
						</div>
						<div class="one columns" id="adminobj18c">
							<?php $obj1->printmonth(); ?>
						</div>
						<div class="one columns" id="adminobj18d">
							<?php $obj1->printcurdays(); ?>
						</div>
						<div class="five columns" id="loginobj18e">
							<label class="adminlval"><?php print $datsta; ?></label>
						</div>
					</div>
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