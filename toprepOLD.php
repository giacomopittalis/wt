<?php
	session_start();
	include 'sessionclass.php';
	include 'toprepclass.php';
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

  <title>Wellness - Topic Reports</title>
  
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

ajR4.open("GET", "toprepajax.php?clid=" + ghi, true);
ajR4.send(null);
};
  </script>
  
  <script>
  	function gettopic()
{
	var ghi = document.getElementById("sel9").value;
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
		document.getElementById("topaj").innerHTML = ajR3.responseText;
	}
};

ajR3.open("GET", "toprepajax1.php?constypeid=" + ghi, true);
ajR3.send(null);
};
  </script>
  
  <script>
  	function getsubtopic()
{
	var abc = document.getElementById("sel9").value;
	var def = document.getElementById("sel10").value;
	try 
    { /*Generally non IE browsers*/
     ajR2 = new XMLHttpRequest();
    }
catch (e)
    { /*IE 6 and down*/try 
        {ajR2 = new ActiveXObject("Msxml2.XMLHTTP");
        }
    catch (e)
        {try 
            {ajR2 = new ActiveXObject("Microsoft.XMLHTTP");
            }
        catch (e)
            { /*Failure to define ajax (old or broken browser)*/
             alert("Your browser is too old, or is misconfigured");
             return false;
            }
        }
    }
//receive data
ajR2.onreadystatechange = function()
{
	if(ajR2.readyState == 4){
		document.getElementById("sutaj").innerHTML = ajR2.responseText;
	}
};

ajR2.open("GET", "toprepajax2.php?constypeid=" + abc + "&topicid=" + def, true);
ajR2.send(null);
};
  </script>
  
  <?php
  	$obj1 = new toprep;
	$clidsta = "";
	$ctsta = "";
	$topicsta = "";
	$subtopicsta = "";
	$chart = "0";
	$res = "";
	$cap = array();
	$e = 0;
	$z = "";
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
		$ct = $_POST['ct'];
		$topic = $_POST['topic'];
		$subtopic = $_POST['subtopic'];
		$chart = $_POST['chart'];
		
		//print $clid."<br />";
		//print $locid."<br />";
		//print $sex."<br />";
		//print $arl."<br />";
		//print $arh."<br />";
		//print $year."<br />";
		//print $month."<br />";
		
		//Verification
		
		$clidsta = $obj1->vclid($clid);
		if ($clidsta != ""){
			$e++;
		}
		
		$ctsta = $obj1->vct($ct);
		if ($ctsta != ""){
			$e++;
		}
		
		$topicsta = $obj1->vtopic($topic);
		if ($topicsta != ""){
			$e++;
		}
		
		$subtopicsta = $obj1->vsubtopic($subtopic);
		if ($subtopicsta != ""){
			$e++;
		}
		
		//All is well
		
		if ($e == 0){
			
		}
		
		$res = $obj1->getqueryagg($clid, $locid, $sex, $arl, $arh, $year, $month, $ct, $topic, $subtopic);
		//var_dump($res);
		//print $res;
		//Get caption
		$cap = $obj1->getcaption($clid, $locid, $sex, $arl, $arh, $year, $month);
		$z = $obj1->getstdname($ct, $topic, $subtopic);
		$leg = array($z);
		$rca = array("ff3344");
		
		$y = $res;
		
		$max = $res + 1;
		//$pichart->addDataSet($res,9);
		//$pichart->setLegend($clidarr);
		//$pichart->setLabels($clidarr);
		//$pichart->setColors(array("ff3344", "11ff11"));
		
		$tot = 100;
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
					<h4>Topic Reports</h4>
					<br />
				</div>
				<div class="three columns">
					
				</div>
			</div>
			<form name="repfrm1" id="frmrep1" method="post" action="toprep.php">
				<div class="row">
					<div class="three columns">
						<label>Select Client</label>
					</div>
					<div class="four columns">
						<?php $obj1->printlinkedclientlist(); ?>
					</div>
					<div class="five columns">
						<?php print $clidsta; ?>
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
						<label>Consult Type</label>
					</div>
					<div class="four columns">
						<?php $obj1->printconstype(); ?>
					</div>
					<div class="five columns">
						<?php print $ctsta; ?>
					</div>
				</div>
				<div class="row">
					<div class="three columns">
						<label>Topic</label>
					</div>
					<div class="four columns" id="topaj">
						<select name="topic" id="sel10">
							<option value="0">Select Topic</option>
						</select>
					</div>
					<div class="five columns">
						<?php print $topicsta; ?>
					</div>
				</div>
				<div class="row">
					<div class="three columns">
						<label>Sub-Topic</label>
					</div>
					<div class="four columns" id="sutaj">
						<select name="subtopic" id="sel11">
							<option value="0">Select Sub-Topic</option>
						</select>
					</div>
					<div class="five columns">
						<?php print $subtopicsta; ?>
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
								print "<h5>".$z." :  ".$y." Employees"."</h5>"."<br />";
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
									$pichart->addDataSet(array($res));
									$pichart->setLegend($leg);
									$pichart->setLabels(array($res));
									$pichart->setColors($rca);
									$pichart->setDimensions(900, 310);
									print "<img src=\"".$pichart->getUrl()."\" />";
								}
								
								if ($chart == "2"){
									$pie3dChart = new gPie3DChart();
									$pie3dChart->addDataSet(array($res));
									$pie3dChart->setLegend($leg);
									$pie3dChart->setLabels(array($res));
									$pie3dChart->setColors($rca);
									print "<img src=\"".$pie3dChart->getUrl()."\" />";
								}
								
								if ($chart == "3"){
									$barChart = new gBarChart(500,150,'g');
									$barChart->addDataSet(array($res));
									$barChart->setColors($rca);
									$barChart->setLegend($leg);
									$barChart->setVisibleAxes(array("x", "y"));
									$barChart->setDataRange(0, $max);
									$barChart->addAxisRange(0, 0, 0);
									$barChart->addAxisRange(1, 0, $max);
									//$barChart->setGradientFill('c',0,array('FFE7C6',0,'76A4FB',1));
									$barChart->setAutoBarWidth();
									print "<img src=\"".$barChart->getUrl()."\" />";
								}
								
								if ($chart == "4"){
									$barChart = new gBarChart(150,500,'g','h');
									$barChart->addDataSet(array($res));
									$barChart->setColors($rca);
									$barChart->setLegend($leg);
									$barChart->setDataRange(0, $max);
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
