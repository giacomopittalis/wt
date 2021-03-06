<?php
	session_start();
	include 'sessionclass.php';
	include 'crempclass.php';
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

  <title>Wellness - Create New Employee</title>
  
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
	var abc = document.getElementById("sel4").value;
	var def = document.getElementById("sel5").value;
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
		document.getElementById("adminobj18d").innerHTML = ajR3.responseText;
	}
};

ajR3.open("GET", "crempajax.php?month=" + def + "&year=" + abc, true);
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

ajR4.open("GET", "crempajax1.php?clid=" + ghi, true);
ajR4.send(null);
};
  </script>
  
  <?php
  
  	$obj1 = new cremp;
  
  	$outsta = "";
	$e = 0;
	$f = 0;
	
	$clidsta = "";
	$locidsta = "";
	$fnamesta = "";
	$mnamesta = "";
	$lnamesta = "";
	$sexsta = "";
	$dobsta = "";
	$deptsta = "";
	$possta = "";
	$desgsta = "";
	$hyearsta = "";
	$htypesta = "";
	$hplansta = "";
	$picsta = "";
	
	$clid = "";
	$locid = "";
	$fname = "";
	$mname = "";
	$lname = "";
	$sex = "";
	$year = "";
	$month = "";
	$day = "";
	$dob = "";
	$dept = "";
	$pos = "";
	$desg = "";
	$hyear = "";
	$htype = "";
	$hplan = "";
	
	
	if (isset($_POST['sub1'])){
		
		//Get input
		$clid = $_POST['lc'];
		$locid = $_POST['lid'];
		$fname = $_POST['fname'];
		$mname = $_POST['mname'];
		$lname = $_POST['lname'];
		$sex = $_POST['sex'];
		$year = $_POST['year'];
		$month = $_POST['month'];
		$day = $_POST['day'];
		$dept = $_POST['dept'];
		$pos = $_POST['pos'];
		$desg = $_POST['desg'];
		$hyear = $_POST['hyear'];
		$htype = $_POST['htype'];
		$hplan = $_POST['hplan'];
		
		
		//Clean input
		
		$fname = $obj1->cleaninput($fname);
		$mname = $obj1->cleaninput($mname);
		$lname = $obj1->cleaninput($lname);
		$dept = $obj1->cleaninput($dept);
		$pos = $obj1->cleaninput($pos);
		$desg = $obj1->cleaninput($desg);
		$hplan = $obj1->cleaninput($hplan);
		
		//Validate Input
		
		$clidsta = $obj1->vclid($clid);
		if ($clidsta != ""){
			$e++;
		}
		
		$locidsta = $obj1->vlocid($locid);
		if ($locidsta != ""){
			$e++;
		}
		
		$fnamesta = $obj1->vfname($fname);
		if ($fnamesta != ""){
			$e++;
		}
		
		$mnamesta = $obj1->vmname($mname);
		if ($mnamesta != ""){
			$e++;
		}
		
		$lnamesta = $obj1->vlname($lname);
		if ($lnamesta != ""){
			$e++;
		}
		
		$sexsta = $obj1->vsex($sex);
		if ($sexsta != ""){
			$e++;
		}
		
		$dobsta = $obj1->vdate($year, $month, $day);
		if ($dobsta != ""){
			$e++;
		}
		
		$deptsta = $obj1->vdept($dept);
		if ($deptsta != ""){
			$e++;
		}
		
		$possta = $obj1->vpos($pos);
		if ($possta != ""){
			$e++;
		}
		
		$desgsta = $obj1->vdesg($desg);
		if ($desgsta != ""){
			$e++;
		}
		
		$hyearsta = $obj1->vhyear($hyear);
		if ($hyearsta != ""){
			$e++;
		}
		
		$htypesta = $obj1->vhtype($htype);
		if ($htypesta != ""){
			$e++;
		}
		
		$hplansta = $obj1->vhplan($hplan);
		if ($hplansta != ""){
			$e++;
		}
		
		//Validate image
		//Check if user has selected a file and file size is greater than zero
		if(isset($_FILES['pic']) && $_FILES['pic']['size'] > 0){
			$photoname = $_FILES['pic']['name'];
			$photosize = $_FILES['pic']['size'];
			$phototmp = $_FILES['pic']['tmp_name'];
			$photomime = $_FILES['pic']['type'];
			$ext = pathinfo($photoname, PATHINFO_EXTENSION);
			$maxsize = "10240000";//In bytes
			$atypes = array("jpeg", "png", "gif", "jpg", "bmp", "JPG", "PNG");
			//Check allowed file types
			if(in_array($ext, $atypes)){
				//Check file size	
				if($photosize > $maxsize){
					$picsta = "Image size is too big";
					$e++;
				}
				//All is well
				else{
					$fh = fopen($phototmp, 'r');
					$photodata = fread($fh, $photosize);
					$photodata = addslashes($photodata);
				}
			}
			else{
				$picsta = "Only Images can be selected";
				$e++;
			}
		}
		else{
			$f = 1;
		}
		
		//All is well
		if ($e == 0){
			$dob = $month."/".$day."/".$year;
			$destination = "";
			$dirname = "images/".$clid;
			if (!is_dir($dirname)){
				mkdir($dirname);
			}
			$max = $obj1->getmaxid();
			$next = $max + 1;
			if ($f == 0){
				$phopath = $dirname."/";
				$newphotoname = $clid."-".$next.".".$ext;
				$destination = $phopath.$newphotoname;
				move_uploaded_file($phototmp, $destination);
				$obj2 = new SimpleImage;
				$obj2->load($destination);
				$width = 600;
				$height = 600;
				$obj2->resize($width, $height);
				$obj2->save($destination);
			}
			else{
				$destination = "images/noimage.jpg";
			}
			
			$status = "active";
			
			$res1 = $obj1->cremp1($clid, $locid, $fname, $mname, $lname, $dob, $sex, $dept, $pos, $desg, $htype, $hyear, $destination, $hplan, $status);
			if ($res1){
				$suname = $_SESSION['uname'];
				$ipadd = $_SESSION['ipadd'];
				$timeformat = "d-m-Y G-i-s";
				$dts = date($timeformat);
				$dts = (string)$dts;
				$dts = $obj1->encode($dts);
				$action = "cremp";
				$action = $obj1->encode($action);
				$res2 = $obj1->upemplog($suname, $ipadd, $dts, $action, $next);
				if ($res2){
					$outsta = "Employee successfully created";
					
					$e = 0;
					$f = 0;
			
					$clidsta = "";
					$locidsta = "";
					$fnamesta = "";
					$mnamesta = "";
					$lnamesta = "";
					$sexsta = "";
					$dobsta = "";
					$deptsta = "";
					$possta = "";
					$desgsta = "";
					$hyearsta = "";
					$htypesta = "";
					$hplansta = "";
					$picsta = "";
	
					$clid = "";
					$locid = "";
					$fname = "";
					$mname = "";
					$lname = "";
					$sex = "";
					$year = "";
					$month = "";
					$day = "";
					$dob = "";
					$dept = "";
					$pos = "";
					$desg = "";
					$hyear = "";
					$htype = "";
					$hplan = "";
				}
				else{
					$outsta = "Could not create employee";
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
					<form name="adminonefrm" id="frmadminone" action="cremp.php" method="post" enctype="multipart/form-data">
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
						</fieldset>
						<fieldset>
							<legend>Nomenclature</legend>
							<div class="row" id="adminobj1">
								<div class="three columns" id="adminobj1a">
									<label class="adminlkey">First Name</label>
								</div>
								<div class="four columns" id="adminobj1b">
									<input type="text" name="fname" id="txt1" tabindex="1" maxlength="30" placeholder="First Name" value="<?php print $fname; ?>"/>
								</div>
								<div class="five columns" id="loginobj1c">
									<label class="adminlval"><?php print $fnamesta; ?></label>
								</div>
							</div>
							<div class="row" id="adminobj2">
								<div class="three columns" id="adminobj2a">
									<label class="adminlkey">Middle Name</label>
								</div>
								<div class="four columns" id="adminobj2b">
									<input type="text" name="mname" id="txt2" tabindex="2" maxlength="30" placeholder="Middle Name" value="<?php print $mname; ?>"/>
								</div>
								<div class="five columns" id="loginobj2c">
									<label class="adminlval"><?php print $mnamesta; ?></label>
								</div>
							</div>
							<div class="row" id="adminobj3">
								<div class="three columns" id="adminobj3a">
									<label class="adminlkey">Last Name</label>
								</div>
								<div class="four columns" id="adminobj3b">
									<input type="text" name="lname" id="txt3" tabindex="3" maxlength="30" placeholder="Last Name" value="<?php print $lname; ?>"/>
								</div>
								<div class="five columns" id="loginobj3c">
									<label class="adminlval"><?php print $lnamesta; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Personal Demographics</legend>
							<div class="row" id="adminobj1">
								<div class="three columns" id="adminobj4a">
									<label class="adminlkey">Sex</label>
								</div>
								<div class="four columns" id="adminobj4b">
									<select name="sex" id="sel7">
										<option value="0">Select Sex</option>
										<option value="female">Female</option>
										<option value="male">Male</option>
										<option value="neuter">Neuter</option>
									</select>
								</div>
								<div class="five columns" id="loginobj4c">
									<label class="adminlval"><?php print $sexsta; ?></label>
								</div>
							</div>
							<div class="row" id="adminobj18">
								<div class="three columns" id="adminobj18a">
									<label class="adminlkey">Date of Birth</label>
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
									<label class="adminlval"><?php print $dobsta; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Official Demographics</legend>
							<div class="row" id="adminobj11">
								<div class="three columns" id="adminobj11a">
									<label class="adminlkey">Department</label>
								</div>
								<div class="four columns" id="adminobj11b">
									<input type="text" name="dept" id="txt4" tabindex="11" maxlength="50" placeholder="Department" value="<?php print $dept; ?>"/>
								</div>
								<div class="five columns" id="loginobj11c">
									<label class="adminlval"><?php print $deptsta; ?></label>
								</div>
							</div>
							<div class="row" id="adminobj37">
								<div class="three columns" id="adminobj37a">
									<label class="adminlkey">Position</label>
								</div>
								<div class="four columns" id="adminobj37b">
									<input type="text" name="pos" id="txt37" tabindex="12" maxlength="60" placeholder="Position" value="<?php print $pos; ?>"/>
								</div>
								<div class="five columns" id="loginobj37c">
									<label class="adminlval"><?php print $possta; ?></label>
								</div>
							</div>
							<div class="row" id="adminobj12">
								<div class="three columns" id="adminobj12a">
									<label class="adminlkey">Employee Number</label>
								</div>
								<div class="four columns" id="adminobj12b">
									<input type="text" name="desg" id="txt5" tabindex="12" maxlength="30" placeholder="Designation" value="<?php print $desg; ?>"/>
								</div>
								<div class="five columns" id="loginobj12c">
									<label class="adminlval"><?php print $desgsta; ?></label>
								</div>
							</div>
							<div class="row" id="adminobj18x">
								<div class="three columns" id="adminobj18xa">
									<label class="adminlkey">Hire Year</label>
								</div>
								<div class="two columns" id="adminobj18xb">
									<?php $obj1->printyear1() ?>
								</div>
								
								<div class="seven columns" id="loginobj18xc">
									<label class="adminlval"><?php print $hyearsta; ?></label>
								</div>
							</div>
							<div class="row" id="adminobj18y">
								<div class="three columns" id="adminobj18ya">
									<label class="adminlkey">Hire Type</label>
								</div>
								<div class="three columns" id="adminobj18yb">
									<select name="htype" id="sel8">
										<option value="0">Select Hire Type</option>
										<option value="hourly">Hourly</option>
										<option value="salary">Salary</option>
										<option value="union">Union</option>
									</select>
								</div>
								<div class="six columns" id="loginobj18yc">
									<label class="adminlval"><?php print $htypesta; ?></label>
								</div>
							</div>
							<div class="row" id="adminobj18z">
								<div class="three columns" id="adminobj18za">
									<label class="adminlkey">Health Plan</label>
								</div>
								<div class="four columns" id="adminobj18yz">
									<input name="hplan" id="txt6" maxlength="60" value="<?php print $hplan; ?>"/>
								</div>
								<div class="five columns" id="loginobj18yc">
									<label class="adminlval"><?php print $hplansta; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Identification</legend>
							<div class="row" id="adminobj16">
								<div class="three columns" id="adminobj16a">
									<label class="adminlkey">Photograph</label>
								</div>
								<div class="four columns" id="adminobj16b">
									<input type="hidden" name="MAX_FILE_SIZE" value="1024000" />
									<input type="file" name="pic" id="pic1" tabindex="17"/>
								</div>
								<div class="five columns" id="loginobj16c">
									<label class="adminlval"><?php print $picsta; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<div class="row" id="adminobj17">
								<div class="three columns" id="adminobj17a">
									
								</div>
								<div class="four columns" id="adminobj17b">
									<input type="submit" name="sub1" id="but1" tabindex="18" value="Create" class="success button" />
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