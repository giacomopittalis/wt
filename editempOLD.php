<?php
	session_start();
	include 'sessionclass.php';
	include 'editempclass.php';
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

  <title>Wellness - Edit Employee</title>
  
  <!-- Included CSS Files (Uncompressed) -->
  <!--
  <link rel="stylesheet" href="stylesheets/foundation.css">
  -->
  
  <!-- Included CSS Files (Compressed) -->
  <link rel="stylesheet" href="stylesheets/foundation.min.css">
  <link rel="stylesheet" href="stylesheets/app.css">

  <script src="javascripts/modernizr.foundation.js"></script>
  
  <script src="javascripts/jquery.js"></script>
  
  <script>
  	$(document).ready(function(){
  		$("#adminobj0zb").delegate("#sel10", "change", function(e){
  			$.getJSON("editempajax2.php?empid=" + $("#sel10").val(),
  			function(data){
  				$.each(data, function(i, item){
  					if(item.field == "fname"){
  						$("#txt1").val(item.value);
  					}
  					if(item.field == "mname"){
  						$("#txt2").val(item.value);
  					}
  					if(item.field == "lname"){
  						$("#txt3").val(item.value);
  					}
  					if(item.field == "sex"){
  						$("#sel7").val(item.value);
  					}
  					if(item.field == "dob"){
  						$("#txt7").val(item.value);
  					}
  					if(item.field == "dept"){
  						$("#txt4").val(item.value);
  					}
  					if(item.field == "pos"){
  						$("#txt37").val(item.value);
  					}
  					if(item.field == "desg"){
  						$("#txt5").val(item.value);
  					}
  					if(item.field == "hyear"){
  						$("#sel9").val(item.value);
  					}
  					if(item.field == "htype"){
  						$("#sel8").val(item.value);
  					}
  					if(item.field == "hplan"){
  						$("#txt6").val(item.value);
  					}
  				});
  			});
  		});
  	});
  </script>
  
  <script>
  	function getemp()
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
		document.getElementById("adminobj0zb").innerHTML = ajR3.responseText;
	}
};

ajR3.open("GET", "editempajax.php?clid=" + abc + "&locid=" + def, true);
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

ajR4.open("GET", "editempajax1.php?clid=" + ghi, true);
ajR4.send(null);
};
  </script>
  
  <?php
  
  	$obj1 = new editemp;
  
  	$outsta = "";
	$e = 0;
	
	$clidsta = "";
	$locidsta = "";
	$empsta = "";
	$fnamesta = "";
	$mnamesta = "";
	$lnamesta = "";
	$sexsta = "";
	$dobsta = "";
	$possta = "";
	$deptsta = "";
	$desgsta = "";
	$hyearsta = "";
	$htypesta = "";
	$hplansta = "";
	
	$clid = "";
	$locid = "";
	$emp = "";
	$fname = "";
	$mname = "";
	$lname = "";
	$sex = "";
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
		$emp = $_POST['emp'];
		$fname = $_POST['fname'];
		$mname = $_POST['mname'];
		$lname = $_POST['lname'];
		$sex = $_POST['sex'];
		$dob = $_POST['dob'];
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
		$dob = $obj1->cleaninput($dob);
		$dept = $obj1->cleaninput($dept);
		$desg = $obj1->cleaninput($desg);
		$pos = $obj1->cleaninput($pos);
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
		
		$empsta = $obj1->vemp($emp);
		if ($empsta != ""){
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
		
		$dobsta = $obj1->vdob($dob);
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
		
		//All is well
		if ($e == 0){
			
			$res1 = $obj1->editemp1($emp, $fname, $mname, $lname, $dob, $sex, $dept, $pos, $desg, $htype, $hyear, $hplan);
			if ($res1){
				$suname = $_SESSION['uname'];
				$ipadd = $_SESSION['ipadd'];
				$timeformat = "d-m-Y G-i-s";
				$dts = date($timeformat);
				$dts = (string)$dts;
				$dts = $obj1->encode($dts);
				$action = "editemp";
				$action = $obj1->encode($action);
				$res2 = $obj1->upemplog($suname, $ipadd, $dts, $action, $emp);
				if ($res2){
					$outsta = "Employee successfully edited";
					
					$e = 0;
			
					$clidsta = "";
					$locidsta = "";
					$empsta = "";
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
	
					$clid = "";
					$locid = "";
					$emp = "";
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
					$outsta = "Could not edit employee";
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
					<form name="adminonefrm" id="frmadminone" action="editemp.php" method="post">
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
							<div class="row" id="adminobj0z">
								<div class="three columns" id="adminobj0za">
									<label class="adminlkey">Employee</label>
								</div>
								<div class="four columns" id="adminobj0zb">
									<select name="emp" id="sel10" tabindex="3">
										<option value="0">Select Employee</option>
									</select>
								</div>
								<div class="five columns" id="loginobj0zc">
									<label class="adminlval"><?php print $empsta; ?></label>
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
								<div class="four columns" id="adminobj18b">
									<input type="text" name="dob" id="txt7" maxlength="20" value="<?php print $dob; ?>"/>
								</div>
								<div class="five columns" id="loginobj18c">
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
							<div class="row" id="adminobj17">
								<div class="three columns" id="adminobj17a">
									
								</div>
								<div class="four columns" id="adminobj17b">
									<input type="submit" name="sub1" id="but1" tabindex="18" value="Edit" class="success button" />
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