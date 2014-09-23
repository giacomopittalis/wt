<?php
	session_start();
	include 'sessionclass.php';
	include 'mconrepclass.php';
	include 'gchart/gChart.php';
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

  <title>Wellness - Contact Report</title>
  
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
		document.getElementById("repobj1").innerHTML = ajR4.responseText;
	}
};

ajR4.open("GET", "mconrepajax.php?clid=" + ghi, true);
ajR4.send(null);
};
  </script>
  
  <?php
  	$obj1 = new mconrep;
	$clidarr = array();
	$chart = "0";
	$res = "";
	$cap = array();
  ?>
  
  <?php
  	if (isset($_POST['sub1'])){
		
  		$clid = $_POST['lc'];
  		$locid = $_POST['lid'];
		$sex = $_POST['sex'];
		$arl = $_POST['arl'];
		$arh = $_POST['arh'];
		$year = $_POST['year'];
		$month = $_POST['month'];
		$chart = $_POST['chart'];
		
		//print $clid."<br />";
		//print $locid."<br />";
		//print $sex."<br />";
		//print $arl."<br />";
		//print $arh."<br />";
		//print $year."<br />";
		//print $month."<br />";
		
		$res = $obj1->getmconrep($clid, $locid, $sex, $arl, $arh, $year, $month);
		
		//print $res;
		//Get caption
		$cap = $obj1->getcaption($clid, $locid, $sex, $arl, $arh, $year, $month);
		$clidarr = array("Contacts");
		$resarr = array($res);
		//$pichart->addDataSet($res,9);
		//$pichart->setLegend($clidarr);
		//$pichart->setLabels($clidarr);
		//$pichart->setColors(array("ff3344", "11ff11"));
  	}
  ?>
  
</head>
<body><?php include('header.php'); ?> 
	
	<div class="row">
		<div class="twelve columns">
			<div class="row" id="head1">
				<div class="twelve columns" id="head1a">
					<br />
					<br />
				</div>
			</div>
			<div class="row">
				<div class="three columns">
					
				</div>
				<div class="four columns">
					<h4>Contact Report</h4>
					<br />
				</div>
				<div class="three columns">
					
				</div>
			</div>
			<form name="repfrm1" id="frmrep1" method="post" action="mconrep.php">
				<div class="row">
					<div class="three columns">
						<label>Select Client</label>
					</div>
					<div class="four columns">
						<?php $obj1->printlinkedclientlist(); ?>
					</div>
					<div class="five columns">
					
					</div>
				</div>
				<div class="row">
					<div class="three columns">
						<label>Select Location</label>
					</div>
					<div class="four columns" id="repobj1">
						<select name="lid" id="sel2" tabindex="2">
							<option value="0">All Locations</option>
						</select>
					</div>
					<div class="five columns">
					
					</div>
				</div>
				<div class="row">
					<div class="three columns">
						<label>Select Gender</label>
					</div>
					<div class="four columns">
						<select name="sex" id="sel3" tabindex="3">
							<option value="0">All</option>
							<option value="female">Female</option>
							<option value="male">Male</option>
							<option value="neuter">Neuter</option>
						</select>
					</div>
					<div class="five columns">
						
					</div>
				</div>
				<div class="row">
					<div class="three columns">
						<label>Select Lower Age Range</label>
					</div>
					<div class="four columns">
						<?php $obj1->printarl(); ?>
					</div>
					<div class="five columns">
						
					</div>
				</div>
				<div class="row">
					<div class="three columns">
						<label>Select Higher Age Range</label>
					</div>
					<div class="four columns">
						<?php $obj1->printarh(); ?>
					</div>
					<div class="five columns">
						
					</div>
				</div>
				<div class="row">
					<div class="three columns">
						<label>Year</label>
					</div>
					<div class="four columns">
						<?php $obj1->printyear(); ?>
					</div>
					<div class="five columns">
						
					</div>
				</div>
				<div class="row">
					<div class="three columns">
						<label>Month</label>
					</div>
					<div class="four columns">
						<?php $obj1->printmonth(); ?>
					</div>
					<div class="five columns">
						
					</div>
				</div>
				<div class="row">
					<div class="three columns">
						<label>Select Chart</label>
					</div>
					<div class="four columns">
						<select name="chart" id="sel8" tabindex="3">
							<option value="0">Select Chart</option>
							<option value="1">Pie Chart</option>
							<option value="2">3D Pie Chart</option>
							<option value="3">Vertical Bar Chart</option>
							<option value="4">Horizontal Bar Chart</option>
						</select>
					</div>
					<div class="five columns">
						
					</div>
				</div>
				<div class="row">
					<div class="three columns">
						<label></label>
					</div>
					<div class="four columns">
						<input type="submit" name="sub1" id="but1" value="Generate" class="success button" />
					</div>
					<div class="five columns">
						
					</div>
				</div>
				<div class="row">
					<div class="one columns">
						
					</div>
					<div class="ten columns">
						<br />
						<br />
						<?php
							foreach ($cap as $key => $value){
								print "<h6>".$key." :  ".$value."</h6>"."<br />";
							}
							if ($res != ""){
								print "<h5>"."Contacts :  ".$res."</h5>"."<br />";
							}
						?>
						<br />
						<br />
					</div>
					<div class="one columns">
						
					</div>
				</div>
				<div class="row">
					<div class="one columns">
						<label></label>
					</div>
					<div class="ten columns">
						<?php
							if ($chart != "0"){
								
								if ($chart == "1"){
									$pichart = new gPieChart();
									$pichart->addDataSet($resarr);
									$pichart->setLegend($clidarr);
									$pichart->setLabels($resarr);
									$pichart->setColors(array("ff3344"));
									$pichart->setDimensions(900, 310);
									print "<img src=\"".$pichart->getUrl()."\" />";
								}
								
								if ($chart == "2"){
									$pie3dChart = new gPie3DChart();
									$pie3dChart->addDataSet($resarr);
									$pie3dChart->setLegend($clidarr);
									$pie3dChart->setLabels($resarr);
									$pie3dChart->setColors(array("ff3344"));
									print "<img src=\"".$pie3dChart->getUrl()."\" />";
								}
								
								if ($chart == "3"){
									$barChart = new gBarChart(500,150,'g');
									$barChart->addDataSet($resarr);
									$barChart->setColors(array("ff3344"));
									$barChart->setLegend($clidarr);
									$barChart->setVisibleAxes(array("x", "y"));
									$barChart->setDataRange(0, 10);
									$barChart->addAxisRange(0, 0, 10);
									$barChart->addAxisRange(1, 0, 10);
									//$barChart->setGradientFill('c',0,array('FFE7C6',0,'76A4FB',1));
									$barChart->setAutoBarWidth();
									print "<img src=\"".$barChart->getUrl()."\" />";
								}
								
								if ($chart == "4"){
									$barChart = new gBarChart(150,500,'g','h');
									$barChart->addDataSet($resarr);
									$barChart->setColors(array("ff3344"));
									$barChart->setLegend($clidarr);
									$barChart->setVisibleAxes(array("x", "y"));
									$barChart->setDataRange(0, 10);
									$barChart->addAxisRange(0, 0, 10);
									$barChart->addAxisRange(1, 0, 10);
									//$barChart->setGradientFill('c',0,array('FFE7C6',0,'76A4FB',1));
									$barChart->setAutoBarWidth();
									print "<img src=\"".$barChart->getUrl()."\" />";
								}
								
							}
						?>
					</div>
					<div class="one columns">
						
					</div>
				</div>
			</form>
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
