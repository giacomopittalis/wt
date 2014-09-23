<?php
	session_start();
	include 'sessionclass.php';
	include 'editlocclass.php';
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

  <title>Wellness - Edit Location</title>
  
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

ajR3.open("GET", "editlocajax.php?clid=" + def, true);
ajR3.send(null);
};
  </script>
  
  <script src="javascripts/jquery.js"></script>
  
  <script>
  	$(document).ready(function(){
  		$("#unlk4a").delegate("#sel2", "change", function(e){
  			$.getJSON("editlocajax1.php?locid1=" + $("#sel2").val(),
  			function(data){
  				$.each(data, function(i, item){
  					if(item.field == "street"){
  						$("#txt2").val(item.value);
  					}
  					if(item.field == "city"){
  						$("#txt3").val(item.value);
  					}
  					if(item.field == "zip"){
  						$("#txt4").val(item.value);
  					}
  					if(item.field == "state"){
  						$("#sel3").val(item.value);
  					}
  				});
  			});
  		});
  	});
  </script>
  
  <?php
  	$obj1 = new editloc;
	
	$outsta = "";
	$clidsta = "";
	$locidsta = "";
	$streetsta = "";
	$citysta = "";
	$zipsta = "";
	$statesta = "";
	
	$clid = "";
	$locid = "";
	$street = "";
	$city = "";
	$zip = "";
	$state = "";
	
	$e = 0;
	
	if (isset($_POST['sub1'])){
		
		//Get input
		$clid = $_POST['lc'];
		$locid = $_POST['lid'];
		$street = $_POST['street'];
		$city = $_POST['city'];
		$zip = $_POST['zip'];
		$state = $_POST['state'];
		
		//Clean input
		$locid = $obj1->cleaninput($locid);
		$street = $obj1->cleaninput($street);
		$city = $obj1->cleaninput($city);
		$zip = $obj1->cleaninput($zip);
		
		//validate input
		
		$clidsta = $obj1->vclid($clid);
		if ($clidsta != ""){
			$e++;
		}
		
		$locidsta = $obj1->vlocid($locid);
		if ($locidsta != ""){
			$e++;
		}
		
		$streetsta = $obj1->vstreet($street);
		if ($streetsta != ""){
			$e++;
		}
		
		$citysta = $obj1->vcity($city);
		if ($citysta != ""){
			$e++;
		}
		
		$zipsta = $obj1->vzip($zip);
		if ($zipsta != ""){
			$e++;
		}
		
		$statesta = $obj1->vstate($state);
		if ($statesta != ""){
			$e++;
		}
		
		//All is well
		if ($e == 0){
			$res1 = $obj1->editloc1($locid, $street, $city, $zip, $state);
			if ($res1){
				$uname = $_SESSION['uname'];
				$ipadd = $_SESSION['ipadd'];
				$timeformat = "d-m-Y G-i-s";
				$dts = date($timeformat);
				$dts = (string)$dts;
				$dts = $obj1->encode($dts);
				$elocid = $obj1->getlocid($locid);
				$action = "editloc";
				$eaction = $obj1->encode($action);
				
				$res2 = $obj1->upclientloclog($uname, $ipadd, $dts, $eaction, $elocid);
				
				if ($res2){
					$outsta = "Client Loaction Successfully Edited";
					
					$clidsta = "";
					$locidsta = "";
					$streetsta = "";
					$citysta = "";
					$zipsta = "";
					$statesta = "";
	
					$clid = "";
					$locid = "";
					$street = "";
					$city = "";
					$zip = "";
					$state = "";
				}
				else{
					$outsta = "Client Location could not be Edited";
				}
			}
		}
	}
  ?>
</head>
<body>
	<?php include('header.php'); ?> 
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
					<form name="frmunlock" id="unlockfrom" action="editloc.php" method="post">
						<fieldset>
							<legend>Edit Client Location</legend>
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
									<select name="locid" id="sel2" tabindex="2" >
										<option value ="0">Select Client First</option>
									</select>
									<br />
									<br />
								</div>
								<div class="six columns" id="unlk4b">
									<?php
										print $locidsta;
									?>
									<br />
									<br />
								</div>
							</div>
							<div class="row" id="unlk5">
								<div class="six columns" id="unlk5a">
									<input type="text" name="street" id="txt2" tabindex="3" maxlength="100" placeholder="Street" value="<?php print $street; ?>"/>
									<br />
									<br />
								</div>
								<div class="six columns" id="unlk5b">
									<?php
										print $streetsta;
									?>
									<br />
									<br />
								</div>
							</div>
							<div class="row" id="unlk6">
								<div class="six columns" id="unlk6a">
									<input type="text" name="city" id="txt3" tabindex="4" maxlength="50" placeholder="City" value="<?php print $city; ?>" />
									<br />
									<br />
								</div>
								<div class="six columns" id="unlk6b">
									<?php
										print $citysta;
									?>
									<br />
									<br />
								</div>
							</div>
							<div class="row" id="unlk7">
								<div class="six columns" id="unlk7a">
									<input type="text" name="zip" id="txt4" tabindex="5" maxlength="10" placeholder="Zip" value="<?php print $zip; ?>"/>
									<br />
									<br />
								</div>
								<div class="six columns" id="unlk7b">
									<?php
										print $zipsta;
									?>
									<br />
									<br />
								</div>
							</div>
							<div class="row" id="unlk8">
								<div class="six columns" id="unlk8a">
									<select name="state" id="sel3" tabindex="6">
										<option value="0" selected="selected">Select State</option>
										<option value="Alabama">Alabama</option>
										<option value="Alaska">Alaska</option>
										<option value="Arizona">Arizona</option>
										<option value="Arkansas">Arkansas</option>
										<option value="California">California</option>
										<option value="Colorado">Colorado</option>
										<option value="Connecticut">Connecticut</option>
										<option value="Delaware">Delaware</option>
										<option value="Florida">Florida</option>
										<option value="Georgia">Georgia</option>
										<option value="Hawaii">Hawaii</option>
										<option value="Idaho">Idaho</option>
										<option value="Illinois">Illinois</option>
										<option value="Indiana">Indiana</option>
										<option value="Iowa">Iowa</option>
										<option value="Kansas">Kansas</option>
										<option value="Kentucky">Kentucky</option>
										<option value="Louisiana">Louisiana</option>
										<option value="Maine">Maine</option>
										<option value="Maryland">Maryland</option>
										<option value="Massachussetts">Massachusetts</option>
										<option value="Michigan">Michigan</option>
										<option value="Minnesota">Minnesota</option>
										<option value="Mississippi">Mississippi</option>
										<option value="Missouri">Missouri</option>
										<option value="Montana">Montana</option>
										<option value="Nebraska">Nebraska</option>
										<option value="Nevada">Nevada</option>
										<option value="New Hampshire">New Hampshire</option>
										<option value="New Jersey">New Jersey</option>
										<option value="New Mexico">New Mexico</option>
										<option value="New York">New York</option>
										<option value="North Carolina">North Carolina</option>
										<option value="North Dakota">North Dakota</option>
										<option value="Ohio">Ohio</option>
										<option value="Oklahoma">Oklahoma</option>
										<option value="Oregon">Oregon</option>
										<option value="Pennsylvania">Pennsylvania</option>
										<option value="Rhode Island">Rhode Island</option>
										<option value="South Carolina">South Carolina</option>
										<option value="South Dakota">South Dakota</option>
										<option value="Tennessee">Tennessee</option>
										<option value="Texas">Texas</option>
										<option value="Utah">Utah</option>
										<option value="Vermont">Vermont</option>
										<option value="Virginia">Virginia</option>
										<option value="Washington">Washington</option>
										<option value="West Virginia">West Virginia</option>
										<option value="Wisconsin">Wisconsin</option>
										<option value="Wyoming">Wyoming</option>
									</select>
									<br />
									<br />
								</div>
								<div class="six columns" id="unlk8b">
									<?php
										print $statesta;
									?>
									<br />
									<br />
								</div>
							</div>
							<div class="row" id="unlk2">
								<div class=" twelve columns" id="unlk2a">
									<input type="submit" name="sub1" id="but1" tabindex="7" class="success button" value="Edit" />
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
