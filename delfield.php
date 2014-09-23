<?php
	session_start();
	include 'sessionclass.php';
	include 'delfieldclass.php';
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

  <title>Wellness - Delete Field</title>
  
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

ajR4.open("GET", "delfieldajax.php?constypeid=" + ghi, true);
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

ajR3.open("GET", "delfieldajax1.php?constypeid=" + abc + "&topicid=" + def, true);
ajR3.send(null);
};
  </script>
  
  <script>
  	function getfield()
{
	var jkl = document.getElementById("sel1").value;
	var mno = document.getElementById("sel2").value;
	var pqr = document.getElementById("sel3").value;
	try 
    { /*Generally non IE browsers*/
     ajR5 = new XMLHttpRequest();
    }
catch (e)
    { /*IE 6 and down*/try 
        {ajR5 = new ActiveXObject("Msxml2.XMLHTTP");
        }
    catch (e)
        {try 
            {ajR5 = new ActiveXObject("Microsoft.XMLHTTP");
            }
        catch (e)
            { /*Failure to define ajax (old or broken browser)*/
             alert("Your browser is too old, or is misconfigured");
             return false;
            }
        }
    }
//receive data
ajR5.onreadystatechange = function()
{
	if(ajR5.readyState == 4){
		document.getElementById("topicajax3").innerHTML = ajR5.responseText;
	}
};

ajR5.open("GET", "delfieldajax2.php?constypeid=" + jkl + "&topicid=" + mno + "&subtopicid=" + pqr, true);
ajR5.send(null);
};
  </script>
  
  <?php
  	$obj1 = new delfield;
	
	$constypeidsta = "";
	$topicidsta = "";
	$subtopicidsta = "";
	$fieldidsta = "";
	
	$constypeid = "";
	$topicid = "";
	$subtopicid = "";
	$fieldid = "";
	
	$outsta = "";
	$e = 0;
	
	if (isset($_POST['sub1'])){
		
		//Get input
		$constypeid = $_POST['constype'];
		$topicid = $_POST['topic'];
		$subtopicid = $_POST['subtopic'];
		$fieldid = $_POST['field'];
		
		//Clean input
		
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
		
		$fieldidsta = $obj1->vfieldid($fieldid);
		if ($fieldidsta != ""){
			$e++;
		}
		
		//All is well
		if ($e == 0){
			
			$res1 = $obj1->delfield1($fieldid);
			if ($res1){
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
					$outsta = "Field deleted successfully";
				}
				else{
					$outsta = "Error writing to log table";
				}
			}
			else{
				$outsta = "Error deleting field";
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
					<form name="frmtopic" id="topicfrom" action="delfield.php" method="post">
						<fieldset>
							<legend>Delete Field</legend>
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
									<label>Field</label>
								</div>
								<div class="four columns" id="topicajax3">
									<?php $obj1->printinitfieldlist(); ?>
								</div>
								<div class="five columns">
									<?php print $fieldidsta; ?>
								</div>
							</div>
							<div class="row">
								<div class="three columns">
									<label></label>
								</div>
								<div class="four columns">
									<input type="submit" name="sub1" id="but1" tabindex="5" value="Delete" class="success button"/>
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
