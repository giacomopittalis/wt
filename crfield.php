<?php
	session_start();
	include 'sessionclass.php';
	include 'crfieldclass.php';
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

  <title>Wellness - Create New Field</title>
  
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

ajR4.open("GET", "crfieldajax.php?constypeid=" + ghi, true);
ajR4.send(null);
};
  </script>
  
  <script>
  	function getsubtopic()
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
		document.getElementById("topicajax2").innerHTML = ajR3.responseText;
	}
};

ajR3.open("GET", "crfieldajax1.php?constypeid=" + abc + "&topicid=" + def, true);
ajR3.send(null);
};
  </script>
  
  <?php
  	$obj1 = new crfield;
	
	$constypeidsta = "";
	$topicidsta = "";
	$subtopicidsta = "";
	$fldnamesta = "";
	$fltypesta = "";
	$flbasesta = "";
	
	$constypeid = "";
	$topicid = "";
	$subtopicid = "";
	$fldname = "";
	$fltype = "";
	$flbase = "";
	
	$outsta = "";
	$e = 0;
	
	if (isset($_POST['sub1'])){
		
		//Get input
		$constypeid = $_POST['constype'];
		$topicid = $_POST['topic'];
		$subtopicid = $_POST['subtopic'];
		$fldname = $_POST['fldname'];
		$fltype = $_POST['fltype'];
		$flbase = $_POST['flbase'];
		
		//Clean input
		
		$fldname = $obj1->cleaninput($fldname);
		$flbase = $obj1->cleaninput($flbase);
		
		//validate input
		$constypeidsta = $obj1->vconstypeid($constypeid);
		if ($constypeidsta != ""){
			$e++;
		}
		
		$topicidsta = $obj1->vtopic($topicid);
		if ($topicidsta != ""){
			$e++;
		}
		
		$subtopicidsta = $obj1->vsubtopicid($subtopicid);
		if ($subtopicidsta != ""){
			$e++;
		}
		
		$fldnamesta = $obj1->vfldname($fldname);
		if ($fldnamesta != ""){
			$e++;
		}
		
		$fltypesta = $obj1->vfltype($fltype);
		if ($fltypesta != ""){
			$e++;	
		}
		
		$flbasesta = $obj1->vflbase($fltype, $flbase);
		if ($flbasesta != ""){
			$e++;
		}
		
		//All is well
		if ($e == 0){
			
			if ($fltype == "checkbox"){
				$flbase = "none";
			}
			
			$flclass = "cl".$constypeid.$topicid.$subtopicid;
			$flid = $obj1->getfieldid();
			$flname = $obj1->getfieldname();
			
			$res1 = $obj1->crfield1($constypeid, $topicid, $subtopicid, $fldname, $flname, $fltype, $flid, $flclass, $flbase);
			if ($res1){
				$fieldid = $obj1->getlastinsertid();
				$uname = $_SESSION['uname'];
				$ipadd = $_SESSION['ipadd'];
				$timeformat = "d-m-Y G-i-s";
				$dts = date($timeformat);
				$dts = (string)$dts;
				$dts = $obj1->encode($dts);
				$action = "crfield";
				$action = $obj1->encode($action);
				$res2 = $obj1->upfieldslog($uname, $ipadd, $dts, $action, $fieldid);
				if ($res2){
					$outsta = "Field created successfully";
				}
				else{
					$outsta = "Error writing to log table";
				}
			}
			else{
				$outsta = "Error creating field";
			}
		}
		
		//Set Session
		
		$_SESSION['constype'] = $constypeid;
		$_SESSION['topic'] = $topicid;
		$_SESSION['subtopic'] = $subtopicid;
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
					<form name="frmtopic" id="topicfrom" action="crfield.php" method="post">
						<fieldset>
							<legend>Create New Field</legend>
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
								<div class="four columns" id="topicajax2">
									<?php
										$obj1->printinitsubtopiclist();
									?>
								</div>
								<div class="five columns">
									<?php print $subtopicidsta; ?>
								</div>
							</div>
							<div class="row">
								<div class="three columns">
									<label>Display Name</label>
								</div>
								<div class="four columns">
									<input type="text" name="fldname" id="txt1" tabindex="4" maxlength="90" />
								</div>
								<div class="five columns">
									<?php print $fldnamesta; ?>
								</div>
							</div>
							<div class="row">
								<div class="three columns">
									<label>Field Type</label>
								</div>
								<div class="four columns">
									<select name="fltype" id="sel5" tabindex="5">
										<option value="0">Select Field Type</option>
										<option value="checkbox">Check Box</option>
										<option value="text">Text Box</option>
									</select>
									
								</div>
								<div class="five columns">
									<?php print $fltypesta; ?>
								</div>
							</div>
							<div class="row">
								<div class="three columns">
									<label>Field Base Value</label>
								</div>
								<div class="four columns">
									<input type="text" name="flbase" id="txt2" tabindex="6" maxlength="90"/>
								</div>
								<div class="five columns">
									<?php print $flbasesta; ?>
								</div>
							</div>
							<div class="row">
								<div class="three columns">
									<label></label>
								</div>
								<div class="four columns">
									<input type="submit" name="sub1" id="but1" tabindex="7" value="Create" class="success button"/>
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
