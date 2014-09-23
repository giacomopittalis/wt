<?php
	session_start();
	include 'sessionclass.php';
	include 'edithconsultclass.php';
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

  <title>Wellness - Edit Health Consult</title>
  
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

ajR4.open("GET", "edithconsultajax.php?clid=" + ghi, true);
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

ajR3.open("GET", "edithconsultajax1.php?clid=" + abc + "&locid=" + def, true);
ajR3.send(null);
};
  </script>
  
  <?php $obj1 = new edithconsult; ?>
  
  <?php $obj1->printjsonscript() ?>
  
  <?php
  	
  	$e = 0;
	
	$outsta = "";
	$clidsta = "";
	$locidsta = "";
	$hcidsta = "";
	
	$clid = "";
	$locid = "";
	$hcid = "";
	
	
	if (isset($_POST['sub1'])){
		
		//Get And Clean Input
		
		$input = $obj1->getinput();
		
		//Validate input
		$clidsta = $obj1->vclid($input['general']['clid']);
		if ($clidsta != ""){
			$e++;
		}
		
		$locidsta = $obj1->vlocid($input['general']['locid']);
		if ($locidsta != ""){
			$e++;
		}
		
		$hcidsta = $obj1->vhcid($input['general']['hcid']);
		if ($hcidsta != ""){
			$e++;
		}
		
		//All is well
		
		if ($e == 0){
			$res = $obj1->edithc($input);
			if ($res){
				$outsta = "Health consult successfully edited";
			}
			else{
				$outsta = "Health consult could not be edited";
			}
		}
		$_SESSION['client'] = $input['general']['clid'];
		$_SESSION['location'] = $input['general']['locid'];
		
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
			<form name="hconsultfrm" id="frmhconsult" action="edithconsult.php" method="post">
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
							<label>Select Health Consult</label>
						</div>
						<div class="four columns" id="consultajax2">
							<?php $obj1->printinithclist(); ?>
						</div>
						<div class="five columns">
							<label><?php print $hcidsta ?></label>
						</div>
					</div>
				</fieldset>
				<fieldset>
					<div class="row">
						<div class="three columns">
							<label>Under Medical Care?</label>
						</div>
						<div class="four columns">
							<input type="checkbox" name="umc" id="cb1" tabindex="4" value="yes"/>
						</div>
						<div class="five columns">
							
						</div>
					</div>
				</fieldset>
				<dl class="tabs">
					<dd class="active"><a href="#frmcuserpg1">Info</a></dd>
					<dd><a href="#frmcuserpg2">Topics</a></dd>
					<dd><a href="#frmcuserpg3">SOAP</a></dd>
				</dl>
				<ul class="tabs-content">
					<li class="active" id="frmcuserpg1Tab">
						<?php
							$obj1->printhctonee();
						?>
					</li>
					<li id="frmcuserpg2Tab">
						<?php
							$obj1->printelements();
						?>
					</li>
					<li id="frmcuserpg3Tab">
						<div class="row">
							<div class="twelve columns">
								<input type="checkbox" name="soap" value="yes"  id="soapid1" tabindex="1"/>SOAP NOTES
								<div class="row" id="soap2">
									<div class="twelve columns">
										<div class="row">
											<div class="twelve columns">
												<input type="checkbox" name="subjective" id="soapid2" value="yes" tabindex="2"/>S-Subjective
												<div class="row" id="soap3">
													<div class="twelve columns">
														<div class="row">
															<div class="two columns">
																
															</div>
															<div class="two columns">
																<label>Comment Box</label>
															</div>
															<div class="five columns">
																<textarea name="scommb" id="scommb" tabindex="16" rows="8" cols="10"></textarea>
															</div>
															<div class="five columns">
																
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="twelve columns">
												<input type="checkbox" name="objective" value="yes" id="soapid3" tabindex="16"/>O-Objective
												<div class="row" id="soap4">
													<div class="twelve columns">
														<div class="row">
															<div class="two columns">
																
															</div>
															<div class="two columns">
																<label>Comment Box</label>
															</div>
															<div class="five columns">
																<textarea name="ocommb" id="ocommb" tabindex="36" rows="8" cols="10"></textarea>
															</div>
															<div class="five columns">
																
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="twelve columns">
												<input type="checkbox" name="assessment" id="soapid4" value="yes" tabindex="37"/>A-Assessment
												<div class="row" id="soap5">
													<div class="twelve columns">
														<div class="row">
															<div class="two columns">
																
															</div>
															<div class="two columns">
																<label>Comment Box</label>
															</div>
															<div class="five columns">
																<textarea name="acommb" id="acommb" tabindex="56" rows="8" cols="10"></textarea>
															</div>
															<div class="five columns">
																
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="twelve columns">
												<input type="checkbox" name="plan" id="soapid5" value="yes" tabindex="57"/>P-Plan
												<div class="row" id="soap6">
													<div class="twelve columns">
														<div class="row">
															<div class="two columns">
																
															</div>
															<div class="two columns">
																<label>Comment Box</label>
															</div>
															<div class="five columns">
																<textarea name="pcommb" id="pcommb" tabindex="16" rows="8" cols="10"></textarea>
															</div>
															<div class="five columns">
																
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</li>
				</ul>
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
							<input type="submit" name="sub1" id="but1" tabindex="6" value="Edit" class="success button"/>
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
  
  <?php $obj1->printflhidescript(); ?>
  <?php $obj1->printhidescript(); ?>
  <?php $obj1->printchangescript(); ?>
  <?php $obj1->printflchangescript(); ?>
  
  <script>
  	$(document).ready(function(){
  		$('#soap2').hide();
  	});
  </script>
  
  <script>
  	$(document).ready(function(){
  		$('#soapid1').change(function(){
  			if(this.checked){
  				$('#soap2').show();
  				$('#soap3').hide();
  				$('#soap4').hide();
  				$('#soap5').hide();
  				$('#soap6').hide();
  			}
  			else{
  				$('#soap2').hide();
  			}
  		});
  	});
  </script>
  
  <script>
  	$(document).ready(function(){
  		$('#soapid2').change(function(){
  			if(this.checked){
  				$('#soap3').show();
  			}
  			else{
  				$('#soap3').hide();
  			}
  		});
  	});
  </script>
  
  <script>
  	$(document).ready(function(){
  		$('#soapid3').change(function(){
  			if(this.checked){
  				$('#soap4').show();
  			}
  			else{
  				$('#soap4').hide();
  			}
  		});
  	});
  </script>
  
  <script>
  	$(document).ready(function(){
  		$('#soapid4').change(function(){
  			if(this.checked){
  				$('#soap5').show();
  			}
  			else{
  				$('#soap5').hide();
  			}
  		});
  	});
  </script>
  
  <script>
  	$(document).ready(function(){
  		$('#soapid5').change(function(){
  			if(this.checked){
  				$('#soap6').show();
  			}
  			else{
  				$('#soap6').hide();
  			}
  		});
  	});
  </script>
  
</body>
</html>