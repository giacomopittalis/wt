<?php
	session_start();
	include 'sessionclass.php';
	include 'criconsultclass.php';
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

  <title>Wellness - Create New Injury Consult</title>
  
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

ajR4.open("GET", "criconsultajax.php?clid=" + ghi, true);
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

ajR3.open("GET", "criconsultajax1.php?clid=" + abc + "&locid=" + def, true);
ajR3.send(null);
};
  </script>
  
  <script>
  	function getij()
{
	var ghi = document.getElementById("sel4").value;
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
		document.getElementById("inj1").innerHTML = ajR2.responseText;
	}
};

ajR2.open("GET", "criconsultajax2.php?bpid=" + ghi, true);
ajR2.send(null);
};
  </script>
  
  <?php
  	
  	$obj1 = new criconsult;
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
		$clidsta = $obj1->vclid($input['general']['clid']);
		if ($clidsta != ""){
			$e++;
		}
		
		$locidsta = $obj1->vlocid($input['general']['locid']);
		if ($locidsta != ""){
			$e++;
		}
		
		$conidsta = $obj1->vconid($input['general']['conid']);
		if ($conidsta != ""){
			$e++;
		}
		
		//All is well
		
		if ($e == 0){
			$res = $obj1->cric($input);
			if ($res){
				$outsta = "Injury consult successfully created";
			}
			else{
				$outsta = "Injury consult could not be created";
			}
		}
		$_SESSION['client'] = $input['general']['clid'];
		$_SESSION['location'] = $input['general']['locid'];
		$_SESSION['contact'] = $input['general']['conid'];
		
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
			<form name="iconsultfrm" id="frmiconsult" action="criconsult.php" method="post">
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
						<div class="row">
							<div class="twelve columns">
								<input type="checkbox" name="wnw" value="work"  id="t1cb1" tabindex="1"/>Work vs. Non Work - Check for work
							</div>
						</div>
						<div class="row">
							<div class="twelve columns">
								<input type="checkbox" name="xpx" value="existing"  id="t1cb2" tabindex="1"/>Existing vs. Pre Existing - Check for Existing
							</div>
						</div>
						<fieldset>
							<div class="row">
								<div class="three columns">
									<label>MOI</label>
								</div>
								<div class="four columns">
									<textarea name="moi1" id="moi1" rows="10" cols="30"></textarea>
								</div>
								<div class="five columns">
								
								</div>
							</div><hr>

							<div class="row">
								<div class="twelve columns">
									<div class="row">

										<div class="two columns">
																
										</div>
										<div class="two columns">
											<input type="checkbox" name="sacute" value="yes" tabindex="4"/>Acute
										</div>
										<div class="two columns">
											<input type="checkbox" name="schronic" value="yes" tabindex="5"/>Chronic
										</div>
										<div class="two columns">
											<input type="checkbox" name="sbltr" value="yes" tabindex="6"/>Blunt Trauma
										</div>
										<div class="two columns">
											<input type="checkbox" name="scbet" value="yes" tabindex="7"/>Caught Between
										</div>
										<div class="two columns">
											<input type="checkbox" name="soveru" value="yes" tabindex="8"/>Overuse
										</div>
									</div>
									<div class="row">
										<div class="two columns">
																
										</div>
										<div class="two columns">
											<input type="checkbox" name="twisting" value="yes" tabindex="9"/>Twisting
										</div>
										<div class="two columns">
											<input type="checkbox" name="sheerf" value="yes" tabindex="10"/>Sheer Force
										</div>
										<div class="two columns">
											<input type="checkbox" name="overx" value="yes" tabindex="11"/>Over Exertion
										</div>
										<div class="two columns">
											<input type="checkbox" name="overstr" value="yes" tabindex="12"/>Over Stretching
										</div>
										<div class="two columns">
											<input type="checkbox" name="slipfall" value="yes" tabindex="13"/>Slip / Fall
										</div>
									</div>
									<div class="row">
										<div class="two columns">
																
										</div>
										<div class="two columns">
											<input type="checkbox" name="equip" value="yes" tabindex="14"/>Equipment
										</div>
										<div class="two columns">
											<input type="checkbox" name="sother" value="yes" tabindex="15"/>Other
										</div>
<hr></br>
					
<div class="six columns">
																
										</div>
									</div>
<div class="row">
<div class="two columns">
											<select name="opl" tabindex="24">
												<option value="0">Select Pain Level</option>
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
												<option value="6">6</option>
												<option value="7">7</option>
												<option value="8">8</option>
												<option value="9">9</option>
												<option value="10">10</option>
											</select>
										</div>					
</div>
									<div class="row">


										<div class="two columns">
											
										</div>
										<div class="two columns">
											<input type="checkbox" name="swelling" value="yes" tabindex="17"/>Swelling
										</div>
										<div class="two columns">
											<input type="checkbox" name="erythema" value="yes" tabindex="18"/>Erythema
										</div>
										<div class="two columns">
											<input type="checkbox" name="numbness" value="yes" tabindex="19"/>Numbness
										</div>
										<div class="two columns">
											<input type="checkbox" name="olof" value="yes" tabindex="20"/>Loss of Function
										</div>
										<div class="two columns">
											<input type="checkbox" name="odrom" value="yes" tabindex="21"/>Decreased ROM
										</div>
									</div>
									<div class="row">
										<div class="two columns">
											
										</div>
										<div class="two columns">
											<input type="checkbox" name="olos" value="yes" tabindex="22"/>Loss of Strength
										</div>
										<div class="two columns">
											<input type="checkbox" name="olosen" value="yes" tabindex="23"/>Loss of Sensation
										</div>
										
										<div class="two columns">
											<input type="checkbox" name="burning" value="yes" tabindex="25"/>Burning
										</div>
										<div class="two columns">
											<input type="checkbox" name="deformity" value="yes" tabindex="26"/>Deformity
										</div>
									</div>
									<div class="row">
										<div class="two columns">
											
										</div>
										<div class="two columns">
											<input type="checkbox" name="crepitus" value="yes" tabindex="27"/>Crepitus
										</div>
										<div class="two columns">
											<input type="checkbox" name="laxity" value="yes" tabindex="28"/>Laxity
										</div>
										<div class="two columns">
											<input type="checkbox" name="bleeding" value="yes" tabindex="29"/>Bleeding
										</div>
										<div class="two columns">
											<input type="checkbox" name="hematoma" value="yes" tabindex="30"/>Hematoma
										</div>
										<div class="two columns">
											<input type="checkbox" name="contusion" value="yes" tabindex="31"/>Contusion
										</div>
									</div>
									<div class="row">
										<div class="two columns">
											
									</div>
										<div class="two columns">
											<input type="checkbox" name="discoloration" value="yes" tabindex="32"/>Discoloration
										</div>
										<div class="two columns">
											<input type="checkbox" name="cromping" value="yes" tabindex="33"/>Cromping
										</div>
										<div class="two columns">
											<input type="checkbox" name="tightness" value="yes" tabindex="34"/>Tightness
										</div>
										<div class="two columns">
											<input type="checkbox" name="oother" value="yes" tabindex="35"/>Other
										</div></br><hr></br>
										<div class="two columns">
											
										</div>
									</div>
									<div class="row">
										<div class="two columns">
											
										</div>
										<div class="two columns">
											<input type="checkbox" name="sprain" value="yes" tabindex="38"/>Sprain
										</div>
										<div class="two columns">
											<input type="checkbox" name="Strain" value="yes" tabindex="39"/>Strain
										</div>
										<div class="two columns">
											<input type="checkbox" name="fracture" value="yes" tabindex="40"/>Fracture
										</div>
										<div class="two columns">
											<input type="checkbox" name="stressfrac" value="yes" tabindex="41"/>Stress Fracture
										</div>
										<div class="two columns">
											<input type="checkbox" name="acontusion" value="yes" tabindex="42"/>Contusion
										</div>
									</div>
									<div class="row">
										<div class="two columns">
											
										</div>
										<div class="two columns">
											<input type="checkbox" name="ahematoma" value="yes" tabindex="43"/>Hematoma
										</div>
										<div class="two columns">
											<input type="checkbox" name="laceration" value="yes" tabindex="44"/>Laceration
										</div>
										<div class="two columns">
											<input type="checkbox" name="avulsion" value="yes" tabindex="45"/>Avulsion
										</div>
										<div class="two columns">
											<input type="checkbox" name="tendinitis" value="yes" tabindex="46"/>Tendinitis
										</div>
										<div class="two columns">
											<input type="checkbox" name="bursitis" value="yes" tabindex="47"/>Bursitis
										</div>
									</div>
									<div class="row">
										<div class="two columns">
											
										</div>
										<div class="two columns">
											<input type="checkbox" name="asoreness" value="yes" tabindex="48"/>Soreness
										</div>
										<div class="two columns">
											<input type="checkbox" name="aburn" value="yes" tabindex="49"/>Burn
										</div>
										<div class="two columns">
											<input type="checkbox" name="ainfection" value="yes" tabindex="50"/>Infection
										</div>
										<div class="two columns">
											<input type="checkbox" name="aspasm" value="yes" tabindex="51"/>Spasm
										</div>
										<div class="two columns">
											<input type="checkbox" name="acramp" value="yes" tabindex="52"/>Cramp
										</div>
									</div>
									<div class="row">
										<div class="two columns">
											
										</div>
										<div class="two columns">
											<input type="checkbox" name="subluxation" value="yes" tabindex="53"/>Subluxation
										</div>
										<div class="two columns">
											<input type="checkbox" name="dislocation" value="yes" tabindex="54"/>Dislocation
										</div>
										<div class="two columns">
											<input type="checkbox" name="aother" value="yes" tabindex="55"/>Other
										</div></br><hr></br>
										<div class="four columns">
											
										</div>
									</div>
									<div class="row">
										<div class="two columns">
											
										</div>
										<div class="two columns">
											<input type="checkbox" name="pstretch" value="yes" tabindex="58"/>Stretch
										</div>
										<div class="two columns">
											<input type="checkbox" name="ice" value="yes" tabindex="59"/>Ice
										</div>
										<div class="two columns">
											<input type="checkbox" name="pcompression" value="yes" tabindex="60"/>Compression
										</div>
										<div class="two columns">
											<input type="checkbox" name="pheat" value="yes" tabindex="61"/>Heat
										</div>
										<div class="two columns">
											<input type="checkbox" name="prest" value="yes" tabindex="62"/>Rest
										</div>
									</div>
									<div class="row">
										<div class="two columns">
											
										</div>
										<div class="two columns">
											<input type="checkbox" name="pwcare" value="yes" tabindex="63"/>Wound Care
										</div>
										<div class="two columns">
											<input type="checkbox" name="psplinting" value="yes" tabindex="64"/>Splinting
										</div>
										<div class="two columns">
											<input type="checkbox" name="pbracing" value="yes" tabindex="65"/>Bracing
										</div>
										<div class="two columns">
											<input type="checkbox" name="mdref" value="yes" tabindex="66"/>MD Referral
										</div>
										<div class="two columns">
											<input type="checkbox" name="pstrex" value="yes" tabindex="67"/>Strength Exercises
										</div>
									</div>
									<div class="row">
										<div class="two columns">
											
										</div>
										<div class="two columns">
											<input type="checkbox" name="vhi" value="yes" tabindex="68"/>VHI Routine
										</div>
										<div class="two columns">
											<input type="checkbox" name="pother" value="yes" tabindex="69"/>Other
										</div>
										<div class="six columns">
											
										</div>
									</div>
								</div>
							</div>
						</fieldset>
						
						<div class="row">
							<div class="three columns">
								<label>Lost Time</label>
							</div>
							<div class="four columns">
								<input type="text" name="ltm"  id="t1cb3" tabindex="1" maxlength="10"/>
							</div>
							<div class="five columns">
								
							</div>
						</div>
						<div class="row">
							<div class="twelve columns">
								<input type="checkbox" name="mds" value="yes"  id="t1cb1" tabindex="1"/>MD Seen
							</div>
						</div>
						<div class="row">
							<div class="three columns">
								<label>Body Part</label>
							</div>
							<div class="four columns">
								<?php $obj1->printinitbplist() ?>
							</div>
							<div class="five columns">
								
							</div>
						</div>
						<div class="row">
							<div class="three columns">
								<label>Injury Type</label>
							</div>
							<div class="four columns" id="inj1">
								<?php $obj1->printinitijlist() ?>
							</div>
							<div class="five columns">
								
							</div>
						</div>
						<div class="row">
							<div class="three columns">
								<label>Severity Rate</label>
							</div>
							<div class="four columns">
								<select name="svr" id="svr">
									<option value="0">Select Severity Rate</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
								</select>
							</div>
							<div class="five columns">
								
							</div>
						</div>
						<div class="row">
							<div class="three columns">
								<label>Pain Rate</label>
							</div>
							<div class="four columns">
								<select name="pnr" id="pnr">
									<option value="0">Select Pain Rate</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
								</select>
							</div>
							<div class="five columns">
								
							</div>
						</div>
						<div class="row">
							<div class="three columns">
								<label>Improvement Level</label>
							</div>
							<div class="four columns">
								<select name="iml" id="iml">
									<option value="0">Select Improvement Level</option>
									<option value="worse">Worse</option>
									<option value="unchanged">Unchanged</option>
									<option value="improved">Improved</option>
									<option value="resolved">Resolved</option>
								</select>
							</div>
							<div class="five columns">
								
							</div>
						</div>
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
																<textarea name="scommb" tabindex="16" rows="8" cols="10"></textarea>
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
																<textarea name="ocommb" tabindex="36" rows="8" cols="10"></textarea>
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
																<textarea name="acommb" tabindex="56" rows="8" cols="10"></textarea>
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
																<textarea name="pcommb" tabindex="16" rows="8" cols="10"></textarea>
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
  
  <script src="javascripts/jquery.js"></script>
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