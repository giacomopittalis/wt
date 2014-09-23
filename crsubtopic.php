<?php
	session_start();
	include 'sessionclass.php';
	include 'crsubtopicclass.php';
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

  <title>Wellness - Create New Sub Topic</title>
  
  <!-- Included CSS Files (Uncompressed) -->
  <!--
  <link rel="stylesheet" href="stylesheets/foundation.css">
  -->
  
  <!-- Included CSS Files (Compressed) -->
  <link rel="stylesheet" href="stylesheets/foundation.min.css">
  <link rel="stylesheet" href="stylesheets/app.css">

  <script src="javascripts/modernizr.foundation.js"></script>
  
  <script>
  	function gettopic()
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
		document.getElementById("topicajax1").innerHTML = ajR4.responseText;
	}
};

ajR4.open("GET", "crsubtopicajax.php?constypeid=" + ghi, true);
ajR4.send(null);
};
  </script>
  
  <?php
  	$obj1 = new crsubtopic;
	
	$constypeidsta = "";
	$topicidsta = "";
	$subtopicsta = "";
	$constypeid = "";
	$topicid = "";
	$subtopic = "";
	$outsta = "";
	$e = 0;
	
	if (isset($_POST['sub1'])){
		
		//Get input
		$constypeid = $_POST['constype'];
		$topicid = $_POST['topic'];
		$subtopic = $_POST['subtopic'];
		
		//Clean input
		$subtopic = $obj1->cleaninput($subtopic);
		
		//validate input
		$constypeidsta = $obj1->vconstypeid($constypeid);
		if ($constypeidsta != ""){
			$e++;
		}
		
		$topicidsta = $obj1->vtopic($topicid);
		if ($topicidsta != ""){
			$e++;
		}
		
		$subtopicsta = $obj1->vsubtopic($constypeid, $topicid, $subtopic);
		if ($subtopicsta != ""){
			$e++;
		}
		
		//All is well
		if ($e == 0){
			$res1 = $obj1->crsubtopic1($constypeid, $topicid, $subtopic);
			if ($res1){
				$subtopicid = $obj1->getlastinsertid();
				$uname = $_SESSION['uname'];
				$ipadd = $_SESSION['ipadd'];
				$timeformat = "d-m-Y G-i-s";
				$dts = date($timeformat);
				$dts = (string)$dts;
				$dts = $obj1->encode($dts);
				$action = "crsubtopic";
				$action = $obj1->encode($action);
				$res2 = $obj1->upsubtopiclog($uname, $ipadd, $dts, $action, $subtopicid);
				if ($res2){
					$outsta = "Sub Topic created successfully";
				}
				else{
					$outsta = "Error writing to log table";
				}
				$_SESSION['subtopic'] = $subtopicid;
			}
			else{
				$outsta = "Error creating Sub Topic";
			}
		}
		
		//Set Session
		
		$_SESSION['constype'] = $constypeid;
		$_SESSION['topic'] = $topicid;
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
			<div class="row">
				<div class="twelve columns">
					<form name="frmtopic" id="topicfrom" action="crsubtopic.php" method="post">
						<fieldset>
							<legend>Create Sub Topic</legend>
							<div class="row">
								<div class="three columns">
									<label>Consult Type</label>
								</div>
								<div class="four columns">
									<?php $obj1->printinitconstypelist(); ?>
								</div>
								<div class="five columns">
									<?php print $constypeidsta; ?>
								</div>
							</div>
							<div class="row">
								<div class="three columns">
									<label>Topic</label>
								</div>
								<div class="four columns" id="topicajax1">
									<?php
										$obj1->printinittopiclist();
									?>
								</div>
								<div class="five columns">
									<?php print $topicidsta; ?>
								</div>
							</div>
							<div class="row">
								<div class="three columns">
									<label>Sub Topic</label>
								</div>
								<div class="four columns" id="topicajax1">
									<input type="text" name="subtopic" id="txt1" tabindex="3" maxlength="90" />
								</div>
								<div class="five columns">
									<?php print $subtopicsta; ?>
								</div>
							</div>
							<div class="row">
								<div class="three columns">
									<label></label>
								</div>
								<div class="four columns">
									<input type="submit" name="sub1" id="but1" tabindex="4" value="Create" class="success button"/>
								</div>
								<div class="five columns">
									<?php print $outsta; ?>
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
