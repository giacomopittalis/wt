<?phpsession_start();//error_reporting(E_ALL);//ini_set('display_errors', 1);include 'sessionclass.php';include 'crhconsultclass.php';$obj = new session;$seadmin = $obj->seadmin();?><!DOCTYPE html>     <html class="no-js" lang="en">    <head>        <meta charset="utf-8" />        <meta name="viewport" content="width=device-width" />        <title>Wellness - Admin Dashboard</title>        <link rel="stylesheet" href="stylesheets/foundation.min.css">        <link rel="stylesheet" href="stylesheets/app.css">        <script src="javascripts/modernizr.foundation.js"></script>        <link rel="stylesheet" href="style-G.css">                                  <meta charset="utf-8" />  <!-- Set the viewport width to device width for mobile -->  <meta name="viewport" content="width=device-width" />  <title>Wellness - Create New Employee</title>    <!-- Included CSS Files (Uncompressed) -->  <!--  <link rel="stylesheet" href="stylesheets/foundation.css">  -->    <!-- Included CSS Files (Compressed) -->  <link rel="stylesheet" href="stylesheets/foundation.min.css">  <link rel="stylesheet" href="stylesheets/app.css">  <script src="javascripts/modernizr.foundation.js"></script><script>  	function getloc(){	var ghi = document.getElementById("sel1").value;	try     { /*Generally non IE browsers*/     ajR4 = new XMLHttpRequest();    }catch (e)    { /*IE 6 and down*/try         {ajR4 = new ActiveXObject("Msxml2.XMLHTTP");        }    catch (e)        {try             {ajR4 = new ActiveXObject("Microsoft.XMLHTTP");            }        catch (e)            { /*Failure to define ajax (old or broken browser)*/             alert("Your browser is too old, or is misconfigured");             return false;            }        }    }//receive dataajR4.onreadystatechange = function(){	if(ajR4.readyState == 4){		document.getElementById("consultajax1").innerHTML = ajR4.responseText;	}};ajR4.open("GET", "crhconsultajax.php?clid=" + ghi, true);ajR4.send(null);};  </script>    <script>  	function getcon(){	var abc = document.getElementById("sel1").value;	var def = document.getElementById("sel2").value;	try     { /*Generally non IE browsers*/     ajR3 = new XMLHttpRequest();    }catch (e)    { /*IE 6 and down*/try         {ajR3 = new ActiveXObject("Msxml2.XMLHTTP");        }    catch (e)        {try             {ajR3 = new ActiveXObject("Microsoft.XMLHTTP");            }        catch (e)            { /*Failure to define ajax (old or broken browser)*/             alert("Your browser is too old, or is misconfigured");             return false;            }        }    }//receive dataajR3.onreadystatechange = function(){	if(ajR3.readyState == 4){		document.getElementById("consultajax2").innerHTML = ajR3.responseText;	}};ajR3.open("GET", "crhconsultajax1.php?clid=" + abc + "&locid=" + def, true);ajR3.send(null);};  </script>    <?php  	  	$obj1 = new crhconsult;  	$e = 0;		$outsta = "";	$clidsta = "";	$locidsta = "";	$conidsta = "";		$clid = "";	$locid = "";	$conid = "";			if (isset($_POST['sub1'])){				//Get And Clean Input				$input = $obj1->getinput();				//Validate input		$clidsta = $obj1->vclid($input['general']['clid']);		if ($clidsta != ""){			$e++;		}				$locidsta = $obj1->vlocid($input['general']['locid']);		if ($locidsta != ""){			$e++;		}				$conidsta = $obj1->vconid($input['general']['conid']);		if ($conidsta != ""){			$e++;		}				//All is well				if ($e == 0){			$res = $obj1->crhc($input);			if ($res){				$outsta = "Health consult successfully created";			}			else{				$outsta = "Health consult could not be created";			}		}		$_SESSION['client'] = $input['general']['clid'];		$_SESSION['location'] = $input['general']['locid'];		$_SESSION['contact'] = $input['general']['conid'];			}  	  ?>  </head>    <body>        <?php include('header.php'); ?>         <script src="javascripts/foundation.min.js"></script>        <script src="javascripts/app.js"></script>                         <div class="left-column">            <?php include "inc_left_column.php" ?>        </div>        <div class="right-column">            <div id="activity-feed">                 <div id="activity-feed-title">                      New Health Consult                 </div>                <div id="create-employee">            <form name="hconsultfrm" id="frmhconsult" action="crhconsult.php" method="post">				<fieldset>                                    <legend>Client information</legend>                                                                        <div  id="adminobj0x" style=" width: 40%!important; float:left!important;">                                     <label>Client</label>                                         <?php $obj1->printlinkedclientlist(); ?>                                     <label><?php print $clidsta ?></label>                                     <label>Contact ID</label>                                     <div id="consultajax2">                                         <?php $obj1->printinitconlist(); ?>                                     </div>                                     <label><?php print $conidsta ?></label>                                     <input type="checkbox" name="umc" id="cb1" tabindex="4" value="yes" />                                      Under Medical Care?                                                                         </div>                                                                        <div  id="adminobj0y" style="width: 40%!important; float:left!important;">                                        <label>Location</label>                                        <div id="consultajax1">                                            <?php $obj1->printinitloclist(); ?>                                        </div>                                        <label><?php print $locidsta ?></label>                                    </div>                                                                        									</fieldset>			<div class="delim">                </div>                <fieldset>						<dl class="tabs" style="width:10%!important; float:left!important; margin-right: 50px;">					<dd class="active"><a href="#frmcuserpg1">Info</a></dd>					<dd><a href="#frmcuserpg2">Topics</a></dd>					<dd><a href="#frmcuserpg3">SOAP</a></dd>				</dl>				<ul class="tabs-content" style="float:left!important;">					<li class="active" id="frmcuserpg1Tab">						<?php							$obj1->printhctonee();						?>					</li>					<li id="frmcuserpg2Tab">						<?php							$obj1->printelements();						?>					</li>					<li id="frmcuserpg3Tab">						<div class="row">							<div class="twelve columns">								<input type="checkbox" name="soap" value="yes"  id="soapid1" tabindex="1"/>SOAP NOTES								<div class="row" id="soap2">									<div class="twelve columns">										<div class="row">											<div class="twelve columns">												<input type="checkbox" name="subjective" id="soapid2" value="yes" tabindex="2"/>S-Subjective												<div class="row" id="soap3">													<div class="twelve columns">														<div class="row">															<div class="two columns">																															</div>															<div class="two columns">																<label>Comment Box</label>															</div>															<div class="five columns">																<textarea name="scommb" tabindex="16" rows="8" cols="10"></textarea>															</div>															<div class="five columns">																															</div>														</div>													</div>												</div>											</div>										</div>										<div class="row">											<div class="twelve columns">												<input type="checkbox" name="objective" value="yes" id="soapid3" tabindex="16"/>O-Objective												<div class="row" id="soap4">													<div class="twelve columns">														<div class="row">															<div class="two columns">																															</div>															<div class="two columns">																<label>Comment Box</label>															</div>															<div class="five columns">																<textarea name="ocommb" tabindex="36" rows="8" cols="10"></textarea>															</div>															<div class="five columns">																															</div>														</div>													</div>												</div>											</div>										</div>										<div class="row">											<div class="twelve columns">												<input type="checkbox" name="assessment" id="soapid4" value="yes" tabindex="37"/>A-Assessment												<div class="row" id="soap5">													<div class="twelve columns">														<div class="row">															<div class="two columns">																															</div>															<div class="two columns">																<label>Comment Box</label>															</div>															<div class="five columns">																<textarea name="acommb" tabindex="56" rows="8" cols="10"></textarea>															</div>															<div class="five columns">																															</div>														</div>													</div>												</div>											</div>										</div>										<div class="row">											<div class="twelve columns">												<input type="checkbox" name="plan" id="soapid5" value="yes" tabindex="57"/>P-Plan												<div class="row" id="soap6">													<div class="twelve columns">														<div class="row">															<div class="two columns">																															</div>															<div class="two columns">																<label>Comment Box</label>															</div>															<div class="five columns">																<textarea name="pcommb" tabindex="16" rows="8" cols="10"></textarea>															</div>															<div class="five columns">																															</div>														</div>													</div>												</div>											</div>										</div>									</div>								</div>							</div>						</div>					</li>				</ul>                </fieldset>                <fieldset>					<div class="row">						<div class="three columns">							<label></label>						</div>						<div class="four columns">							<input type="checkbox" name="fuc" id="fuc" value="yes" />Follow Up						</div>						<div class="five columns">													</div>					</div>					<div class="row">						<div class="three columns">							<label>Follow Up Notes</label>						</div>						<div class="four columns">							<textarea name="fun" id="fun"></textarea>						</div>						<div class="five columns">													</div>					</div>				</fieldset><div class="delim">                </div>				<fieldset>					<div class="row">						<div class="three columns">							<label></label>						</div>						<div class="four columns">							               <div style="width:250px; margin-left:550px; float:left;">                                                                    <input type="reset" name="sub1" id="butreset" tabindex="18" value=""  style="float:left;"  />      <input type="submit" name="sub1" id="butcreate" tabindex="18" value="" style="margin-left: 10px; float:left;" />                                                                    </div>						</div>						<div class="five columns">							<label><?php print $outsta ?></label>						</div>					</div>				</fieldset>			</form>                </div>            </div>                    </div>    </body></html>