<?php
	session_start();
	include 'sessionclass.php';
	include 'crpconsultclass.php';
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

  <title>Wellness - Create New Proactive Consult</title>
  
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

ajR4.open("GET", "crpconsultajax.php?clid=" + ghi, true);
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

ajR3.open("GET", "crpconsultajax1.php?clid=" + abc + "&locid=" + def, true);
ajR3.send(null);
};
  </script>
  
  <?php
  	
  	$obj1 = new crpconsult;
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
			$res = $obj1->crpc($input);
			if ($res){
				$outsta = "Proactive consult successfully created";
			}
			else{
				$outsta = "Proactive consult could not be created";
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
			<form name="iconsultfrm" id="frmiconsult" action="crpconsult.php" method="post">
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
					<div class="row">
						<div class="three columns">
							<label>Selection</label>
						</div>
						<div class="three columns">
							<select name="sel" id="sel" tabindex="4">
								<option value="0">Please Select</option>
								<option value="AED">AED</option>
<option value="Arthritis">Arthritis</option>
<option value="Blood Pressure">Blood Pressure</option>
<option value="Breakfast">Breakfast</option>
<option value="Breast Cancer">Breast Cancer</option>
<option value="Choking">Choking</option>
<option value="Cholesterol">Cholesterol</option>
<option value="CPR">CPR</option>
<option value="Decerase Trans Saturated Flyer">Decerase Trans/Saturated  Flyer</option>
<option value="Decrease Triglycerides: Tips Flyer">Decrease Triglycerides: Tips Flyer</option>
<option value="Diabetes">Diabetes</option>
<option value="Diabetes Management">Diabetes Management</option>
<option value="Easter Eggs">Easter Eggs</option>
<option value="Eating Out: This Choice Not That">Eating Out: This Choice Not That</option>
<option value="Energy Drinks">Energy Drinks</option>
<option value="Energy Supplements">Energy Supplements</option>
<option value="Face the Fats Quiz">Face the Fats Quiz</option>
<option value="Fats">Fats</option>
<option value="Fiber">Fiber</option>
<option value="First Aid - Low Back">First Aid - Low Back</option>
<option value="First Aid - Ankle ">First Aid - Ankle </option>
<option value="First Aid - Elbow ">First Aid - Elbow </option>
<option value="First Aid - Head Injury">First Aid - Head Injury</option>
<option value="First Aid - Knee">First Aid - Knee</option>
<option value="First Aid - Musculoskeletal">First Aid - Musculoskeletal</option>
<option value="First Aid - Neck">First Aid - Neck</option>
<option value="First Aid - Shoulder">First Aid - Shoulder</option>
<option value="First Aid - Thigh">First Aid - Thigh</option>
<option value="First Aid - Wound Care">First Aid - Wound Care</option>
<option value="First Aid - Wrist/ Hand">First Aid - Wrist/ Hand</option>
<option value="Food Journal">Food Journal</option>
<option value="Food Labels">Food Labels</option>
<option value="Fruits List">Fruits List</option>
<option value="Gardening 101">Gardening 101</option>
<option value="Go Green">Go Green</option>
<option value="Health Risk Assessment">Health Risk Assessment</option>
<option value="Healthy Eating on the Go">Healthy Eating on the Go</option>
<option value="Healthy Grilling">Healthy Grilling</option>
<option value="Healthy Ingredient Substitutions">Healthy Ingredient Substitutions</option>
<option value="Healthy Lunches">Healthy Lunches</option>
<option value="Healthy Snacking">Healthy Snacking</option>
<option value="Heart Attacks">Heart Attacks</option>
<option value="Heart Attacks - Prevention">Heart Attacks - Prevention</option>
<option value="Heart Disease">Heart Disease</option>
<option value="Heat Illness">Heat Illness</option>
<option value="High and Low Sugar Beverages">High and Low Sugar Beverages</option>
<option value="High Intensity Training">High Intensity Training</option>
<option value="High Protein Breakfast Foods">High Protein Breakfast Foods</option>
<option value="Holiday Eating ">Holiday Eating </option>
<option value="Holiday Foods: This Choice Not That">Holiday Foods: This Choice Not That</option>
<option value="Hydration">Hydration</option>
<option value="Increase Healthy Fats : Tips Flyer">Increase Healthy Fats : Tips Flyer</option>
<option value="Increasing Activity: Tips Flyer">Increasing Activity: Tips Flyer</option>
<option value="Increasing Physical Activity">Increasing Physical Activity</option>
<option value="Insect Repellent">Insect Repellent</option>
<option value="Irritable Bowel">Irritable Bowel</option>
<option value="Low Carb  Foods">Low Carb  Foods</option>
<option value="Men's Health">Men's Health</option>
<option value="New Years Solutions">New Years Solutions</option>
<option value="Organic Foods">Organic Foods</option>
<option value="Portion Control">Portion Control</option>
<option value="Preventative Screenings">Preventative Screenings</option>
<option value="Prostate Cancer">Prostate Cancer</option>
<option value="Protein">Protein</option>
<option value="Skin Cancer ID">Skin Cancer ID</option>
<option value="Skin Type - Quiz">Skin Type - Quiz</option>
<option value="SMART Goals">SMART Goals</option>
<option value="Sodium: Tips Flyer">Sodium: Tips Flyer</option>
<option value="Spring Cleaning">Spring Cleaning</option>
<option value="Stress  - Managing">Stress  - Managing</option>
<option value="Stress - Holiday Stress">Stress - Holiday Stress</option>
<option value="Stretching">Stretching</option>
<option value="Stroke">Stroke</option>
<option value="Sugar">Sugar</option>
<option value="Sugar Substitutes">Sugar Substitutes</option>
<option value="Sunscreen">Sunscreen</option>
<option value="Top 12 Health Investments">Top 12 Health Investments</option>
<option value="Tricks for Treats">Tricks for Treats</option>
<option value="Triglycerides">Triglycerides</option>
<option value="Urgent Care">Urgent Care</option>
<option value="Weight Management">Weight Management</option>
<option value="WellGuide Introduction">WellGuide Introduction</option>
<option value="Whole Foods">Whole Foods</option>
<option value="Whole Foods Comparison Plans">Whole Foods Comparison Plans</option>
<option value="Women's Health">Women's Health</option>

							</select>
						</div>
						<div class="five columns">
							
						</div>
					</div>
					<div class="row">
						<div class="three columns">
							<label>Comments</label>
						</div>
						<div class="three columns">
							<textarea name="comm" id="comm" tabindex="5" rows="10" cols="30"></textarea>
						</div>
						<div class="five columns">
							
						</div>
					</div>
				</fieldset>
				<fieldset>
					<div class="row">
						<div class="three columns">
							<label></label>
						</div>
						<div class="four columns">
							<input type="checkbox" name="fuc" id="fuc" value="yes" />Follow Up
						</div>
						<div class="five columns">
							
						</div>
					</div>
					<div class="row">
						<div class="three columns">
							<label>Follow Up Notes</label>
						</div>
						<div class="four columns">
							<textarea name="fun" id="fun"></textarea>
						</div>
						<div class="five columns">
							
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