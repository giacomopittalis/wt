<?phpsession_start();//error_reporting(E_ALL);//ini_set('display_errors', 1);include 'sessionclass.php';include 'editpconsultclass.php';$obj = new session;$seadmin = $obj->seadmin();?><!DOCTYPE html>     <html class="no-js" lang="en">    <head>        <meta charset="utf-8" />        <meta name="viewport" content="width=device-width" />        <title>Wellness - Admin Dashboard</title>        <link rel="stylesheet" href="stylesheets/foundation.min.css">        <link rel="stylesheet" href="stylesheets/app.css">        <script src="javascripts/modernizr.foundation.js"></script>        <link rel="stylesheet" href="style-G.css">          <script>  	function getloc(){	var ghi = document.getElementById("sel1").value;	try     { /*Generally non IE browsers*/     ajR4 = new XMLHttpRequest();    }catch (e)    { /*IE 6 and down*/try         {ajR4 = new ActiveXObject("Msxml2.XMLHTTP");        }    catch (e)        {try             {ajR4 = new ActiveXObject("Microsoft.XMLHTTP");            }        catch (e)            { /*Failure to define ajax (old or broken browser)*/             alert("Your browser is too old, or is misconfigured");             return false;            }        }    }//receive dataajR4.onreadystatechange = function(){	if(ajR4.readyState == 4){		document.getElementById("consultajax1").innerHTML = ajR4.responseText;	}};ajR4.open("GET", "editpconsultajax.php?clid=" + ghi, true);ajR4.send(null);};  </script>    <script>  	function getcon(){	var abc = document.getElementById("sel1").value;	var def = document.getElementById("sel2").value;	try     { /*Generally non IE browsers*/     ajR3 = new XMLHttpRequest();    }catch (e)    { /*IE 6 and down*/try         {ajR3 = new ActiveXObject("Msxml2.XMLHTTP");        }    catch (e)        {try             {ajR3 = new ActiveXObject("Microsoft.XMLHTTP");            }        catch (e)            { /*Failure to define ajax (old or broken browser)*/             alert("Your browser is too old, or is misconfigured");             return false;            }        }    }//receive dataajR3.onreadystatechange = function(){	if(ajR3.readyState == 4){		document.getElementById("consultajax2").innerHTML = ajR3.responseText;	}};ajR3.open("GET", "editpconsultajax1.php?clid=" + abc + "&locid=" + def, true);ajR3.send(null);};  </script>    <?php $obj1 = new editpconsult; ?>    <?php $obj1->printjsonscript() ?>    <?php  	  	$e = 0;		$outsta = "";	$clidsta = "";	$locidsta = "";	$pcidsta = "";		$clid = "";	$locid = "";	$pcid = "";			if (isset($_POST['sub1'])){				//Get And Clean Input				$input = $obj1->getinput();				//Validate input		$clidsta = $obj1->vclid($input['clid']);		if ($clidsta != ""){			$e++;		}				$locidsta = $obj1->vlocid($input['locid']);		if ($locidsta != ""){			$e++;		}				$pcidsta = $obj1->vpcid($input['pcid']);		if ($pcidsta != ""){			$e++;		}				//All is well				if ($e == 0){			$res = $obj1->editpc($input);			if ($res){				$outsta = "Proactive consult successfully edited";			}			else{				$outsta = "Proactive consult could not be edited";			}		}		$_SESSION['client'] = $input['clid'];		$_SESSION['location'] = $input['locid'];			}  	  ?>    </head><style>        #activity-feed legend {        width:20%;        float:left;;        color:#5F6878;        font-family: arial;        font-size: 14px;        font-weight: normal;    }     select {    border: 1px solid #cccccc;    border-radius: 5px 5px 5px 5px;    height: 40px;    margin: 0 0 0 0px;    padding: 10px;    width: 250px;     -webkit-appearance: none!important;  /*Removes default chrome and safari style*/      -moz-appearance: none!important; /* Removes Default Firefox style*/      background: url('img/dropdown_arrow.jpg') no-repeat #F8F8F8!important;  /*Adds background-image*/      background-position: 230px 7px!important;  /*Position of the background-image*/      text-indent: 0.01px!important; /* Removes default arrow from firefox*/      text-overflow: "";  /*Removes default arrow from firefox*/}#adminobj18 select {    border: 1px solid #cccccc;    border-radius: 5px 5px 5px 5px;    height: 40px;    margin: 0 0 0 0px;    padding: 10px;    width: 100px;     -webkit-appearance: none;  /*Removes default chrome and safari style*/      -moz-appearance: none; /* Removes Default Firefox style*/      background: url('img/dropdown_arrow.jpg') no-repeat #F8F8F8;  /*Adds background-image*/      background-position: 85px 7px;  /*Position of the background-image*/      text-indent: 0.01px; /* Removes default arrow from firefox*/      text-overflow: "";  /*Removes default arrow from firefox*/}.delim {    border-bottom: 1px solid #DEE5EB!important;}input[type="text"] {    width:250px!important;}.tabs dd.active, .tabs li.active {border-top: 0px!important;border-left:3px solid #8DC526!important; background-color: #FAFBF6!important;height: 31px!important;}</style>    <body>        <?php include('header.php'); ?>         <script src="javascripts/foundation.min.js"></script>        <script src="javascripts/app.js"></script>                         <div class="left-column">            <?php include "inc_left_column.php" ?>        </div>        <div class="right-column">            <div id="activity-feed">                 <div id="activity-feed-title">                      Edit proactive consult                 </div>                <div id="create-employee">     				<form name="iconsultfrm" id="frmiconsult" action="editpconsult.php" method="post">				<fieldset>					<div class="row">						<div class="three columns">							<label>Client</label>						</div>						<div class="four columns">							<?php $obj1->printlinkedclientlist(); ?>						</div>						<div class="five columns">							<label><?php print $clidsta ?></label>						</div>					</div>				</fieldset>				<fieldset>					<div class="row">						<div class="three columns">							<label>Location</label>						</div>						<div class="four columns" id="consultajax1">							<?php $obj1->printinitloclist(); ?>						</div>						<div class="five columns">							<label><?php print $locidsta ?></label>						</div>					</div>				</fieldset>				<fieldset>					<div class="row">						<div class="three columns">							<label>Select Proactive Consult</label>						</div>						<div class="four columns" id="consultajax2">							<?php $obj1->printinitpclist(); ?>						</div>						<div class="five columns">							<label><?php print $pcidsta ?></label>						</div>					</div>				</fieldset>				<fieldset>					<div class="row">						<div class="three columns">							<label>Selection</label>						</div>						<div class="three columns">							<select name="sel" id="sel" tabindex="4">								<option value="0">Please Select</option>								<option value="AED">AED</option><option value="Arthritis">Arthritis</option><option value="Blood Pressure">Blood Pressure</option><option value="Breakfast">Breakfast</option><option value="Breast Cancer">Breast Cancer</option><option value="Choking">Choking</option><option value="Cholesterol">Cholesterol</option><option value="CPR">CPR</option><option value="Decerase Trans Saturated Flyer">Decerase Trans/Saturated  Flyer</option><option value="Decrease Triglycerides: Tips Flyer">Decrease Triglycerides: Tips Flyer</option><option value="Diabetes">Diabetes</option><option value="Diabetes Management">Diabetes Management</option><option value="Easter Eggs">Easter Eggs</option><option value="Eating Out: This Choice Not That">Eating Out: This Choice Not That</option><option value="Energy Drinks">Energy Drinks</option><option value="Energy Supplements">Energy Supplements</option><option value="Face the Fats Quiz">Face the Fats Quiz</option><option value="Fats">Fats</option><option value="Fiber">Fiber</option><option value="First Aid - Low Back">First Aid - Low Back</option><option value="First Aid - Ankle ">First Aid - Ankle </option><option value="First Aid - Elbow ">First Aid - Elbow </option><option value="First Aid - Head Injury">First Aid - Head Injury</option><option value="First Aid - Knee">First Aid - Knee</option><option value="First Aid - Musculoskeletal">First Aid - Musculoskeletal</option><option value="First Aid - Neck">First Aid - Neck</option><option value="First Aid - Shoulder">First Aid - Shoulder</option><option value="First Aid - Thigh">First Aid - Thigh</option><option value="First Aid - Wound Care">First Aid - Wound Care</option><option value="First Aid - Wrist/ Hand">First Aid - Wrist/ Hand</option><option value="Food Journal">Food Journal</option><option value="Food Labels">Food Labels</option><option value="Fruits List">Fruits List</option><option value="Gardening 101">Gardening 101</option><option value="Go Green">Go Green</option><option value="Health Risk Assessment">Health Risk Assessment</option><option value="Healthy Eating on the Go">Healthy Eating on the Go</option><option value="Healthy Grilling">Healthy Grilling</option><option value="Healthy Ingredient Substitutions">Healthy Ingredient Substitutions</option><option value="Healthy Lunches">Healthy Lunches</option><option value="Healthy Snacking">Healthy Snacking</option><option value="Heart Attacks">Heart Attacks</option><option value="Heart Attacks - Prevention">Heart Attacks - Prevention</option><option value="Heart Disease">Heart Disease</option><option value="Heat Illness">Heat Illness</option><option value="High and Low Sugar Beverages">High and Low Sugar Beverages</option><option value="High Intensity Training">High Intensity Training</option><option value="High Protein Breakfast Foods">High Protein Breakfast Foods</option><option value="Holiday Eating ">Holiday Eating </option><option value="Holiday Foods: This Choice Not That">Holiday Foods: This Choice Not That</option><option value="Hydration">Hydration</option><option value="Increase Healthy Fats : Tips Flyer">Increase Healthy Fats : Tips Flyer</option><option value="Increasing Activity: Tips Flyer">Increasing Activity: Tips Flyer</option><option value="Increasing Physical Activity">Increasing Physical Activity</option><option value="Insect Repellent">Insect Repellent</option><option value="Irritable Bowel">Irritable Bowel</option><option value="Low Carb  Foods">Low Carb  Foods</option><option value="Men's Health">Men's Health</option><option value="New Years Solutions">New Years Solutions</option><option value="Organic Foods">Organic Foods</option><option value="Portion Control">Portion Control</option><option value="Preventative Screenings">Preventative Screenings</option><option value="Prostate Cancer">Prostate Cancer</option><option value="Protein">Protein</option><option value="Skin Cancer ID">Skin Cancer ID</option><option value="Skin Type - Quiz">Skin Type - Quiz</option><option value="SMART Goals">SMART Goals</option><option value="Sodium: Tips Flyer">Sodium: Tips Flyer</option><option value="Spring Cleaning">Spring Cleaning</option><option value="Stress  - Managing">Stress  - Managing</option><option value="Stress - Holiday Stress">Stress - Holiday Stress</option><option value="Stretching">Stretching</option><option value="Stroke">Stroke</option><option value="Sugar">Sugar</option><option value="Sugar Substitutes">Sugar Substitutes</option><option value="Sunscreen">Sunscreen</option><option value="Top 12 Health Investments">Top 12 Health Investments</option><option value="Tricks for Treats">Tricks for Treats</option><option value="Triglycerides">Triglycerides</option><option value="Urgent Care">Urgent Care</option><option value="Weight Management">Weight Management</option><option value="WellGuide Introduction">WellGuide Introduction</option><option value="Whole Foods">Whole Foods</option><option value="Whole Foods Comparison Plans">Whole Foods Comparison Plans</option><option value="Women's Health">Women's Health</option>							</select>						</div>						<div class="five columns">													</div>					</div>					<div class="row">						<div class="three columns">							<label>Comments</label>						</div>						<div class="three columns">							<textarea name="comm" id="comm" tabindex="5" rows="10" cols="30"></textarea>						</div>						<div class="five columns">													</div>					</div>				</fieldset>				<fieldset>					<div class="row">						<div class="three columns">							<label></label>						</div>						<div class="four columns">							<input type="checkbox" name="fuc" id="fuc" value="yes" />Follow Up						</div>						<div class="five columns">													</div>					</div>					<div class="row">						<div class="three columns">							<label>Follow Up Notes</label>						</div>						<div class="four columns">							<textarea name="fun" id="fun"></textarea>						</div>						<div class="five columns">													</div>					</div>				</fieldset>				<fieldset>					<div class="row">						<div class="three columns">							<label></label>						</div>						<div class="four columns">							<input type="submit" name="sub1" id="butedit" tabindex="18" value="" style="margin-left:600px;" />						</div>						<div class="five columns">							<label><?php print $outsta ?></label>						</div>					</div>				</fieldset>			</form>  <script src="javascripts/foundation.min.js"></script>    <!-- Initialize JS Plugins -->  <script src="javascripts/app.js"></script>   </div>            </div>                    </div>    </body></html>