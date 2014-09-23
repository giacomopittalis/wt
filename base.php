<?php
	session_start();
	include 'suclass.php';
	$obj = new su;
	$sss = $obj->susss();
	if(!$sss){
		header("location: sulogout.php");
	}
	$sto = $obj->sutimeout();
	if (!$sto){
		header("location: sulogout.php");
	}
	$_SESSION['timeout'] = time();
?>
<!DOCTYPE html>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8" />

  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width" />

  <title>Wellness - Base</title>
  
  <!-- Included CSS Files (Uncompressed) -->
  <!--
  <link rel="stylesheet" href="stylesheets/foundation.css">
  -->
  
  <!-- Included CSS Files (Compressed) -->
  <link rel="stylesheet" href="stylesheets/foundation.min.css">
  <link rel="stylesheet" href="stylesheets/app.css">

  <script src="javascripts/modernizr.foundation.js"></script>
  <?php
  	include 'baseclass.php';
	$obj = new base;
	$res1 = "";
	$res2 = "";
	$res3 = "";
	$res4 = "";
	$res5 = "";
	$res6 = "";
	$res7 = "";
	$res8 = "";
	$res9 = "";
	$res10 = "";
	$res11 = "";
	$res12 = "";
	$res13 = "";
	$res14 = "";
	$res15 = "";
	$res16 = "";
	$res17 = "";
	$res18 = "";
	$res19 = "";
	$res20 = "";
	$res21 = "";
	$res22 = "";
	$res23 = "";
	$res24 = "";
	$res25 = "";
	$res26 = "";
	$res27 = "";
	$res28 = "";
	$res29 = "";
	$res30 = "";
	$res31 = "";
	$res32 = "";
	$res33 = "";
	$res34 = "";
	$res35 = "";
	$res36 = "";
	$res37 = "";
	$res38 = "";
	$res39 = "";
	$res40 = "";
	$res41 = "";
	$res42 = "";
	$res43 = "";
	$res44 = "";
	$res45 = "";
	$res46 = "";
	$res47 = "";
	$res48 = "";
	$res49 = "";
	$res50 = "";
	$res51 = "";
	$res52 = "";
	$res53 = "";
	$res54 = "";
	$res55 = "";
	$res56 = "";
	$res57 = "";
	$res58 = "";
	$res59 = "";
	
	if(isset($_POST['sub1'])){
		$res1 = $obj->crdb();
	}
	
	if(isset($_POST['sub2'])){
		$res2 = $obj->checkdb();
	}
	
	if(isset($_POST['sub3'])){
		$res3 = $obj->crusertable();
	}
	
	if(isset($_POST['sub4'])){
		$res4 = $obj->crloginlogtable();
	}
	
	if(isset($_POST['sub5'])){
		$res5 = $obj->crloginattempttable();
	}
	
	if(isset($_POST['sub6'])){
		$res6 = $obj->crlogincounttable();
	}
	
	if(isset($_POST['sub7'])){
		$res7 = $obj->crsessiondatatable();
	}
	
	if(isset($_POST['sub8'])){
		$res8 = $obj->cripuatable();
	}
	
	if(isset($_POST['sub9'])){
		$res9 = $obj->crcrlogtable();
	}
	
	if(isset($_POST['sub10'])){
		$res10 = $obj->crunlocklogtable();
	}
	
	if(isset($_POST['sub11'])){
		$res11 = $obj->crlocklogtable();
	}
	
	if(isset($_POST['sub12'])){
		$res12 = $obj->crdellogtable();
	}
	
	if(isset($_POST['sub13'])){
		$res13 = $obj->creditlogtable();
	}
	
	if(isset($_POST['sub14'])){
		$res14 = $obj->crcplogtable();
	}
	
	if(isset($_POST['sub15'])){
		$res15 = $obj->creditpiclogtable();
	}
	
	if(isset($_POST['sub16'])){
		$res16 = $obj->crclienttable();
	}
	
	if(isset($_POST['sub17'])){
		$res17 = $obj->crclientlogtable();
	}
	
	if(isset($_POST['sub18'])){
		$res18 = $obj->crclientloctable();
	}
	
	if(isset($_POST['sub19'])){
		$res19 = $obj->crclientloclogtable();
	}
	
	if(isset($_POST['sub20'])){
		$res20 = $obj->cremptable();
	}
	
	if(isset($_POST['sub21'])){
		$res21 = $obj->cremplogtable();
	}
	
	if(isset($_POST['sub22'])){
		$res22 = $obj->cregrtable();
	}
	
	if(isset($_POST['sub23'])){
		$res23 = $obj->cregrlogtable();
	}
	
	if(isset($_POST['sub24'])){
		$res24 = $obj->crcontable();
	}
	
	if(isset($_POST['sub25'])){
		$res25 = $obj->crconlogtable();
	}
	
	if(isset($_POST['sub26'])){
		$res26 = $obj->comconstype();
	}
	
	if(isset($_POST['sub27'])){
		$res27 = $obj->crtopictable();
	}
	
	if(isset($_POST['sub28'])){
		$res28 = $obj->crtopiclogtable();
	}
	
	if(isset($_POST['sub29'])){
		$res29 = $obj->crsubtopictable();
	}
	
	if(isset($_POST['sub30'])){
		$res30 = $obj->crsubtopiclogtable();
	}
	
	if(isset($_POST['sub31'])){
		$res31 = $obj->crfieldstable();
	}
	
	if(isset($_POST['sub32'])){
		$res32 = $obj->crfieldslogtable();
	}
	
	if(isset($_POST['sub33'])){
		$res33 = $obj->crhcmaintable();
	}
	
	if(isset($_POST['sub34'])){
		$res34 = $obj->crhcdumptable();
	}
	
	if(isset($_POST['sub35'])){
		$res35 = $obj->crhcsoaptable();
	}
	
	if(isset($_POST['sub36'])){
		$res36 = $obj->crhclogtable();
	}
	
	if(isset($_POST['sub37'])){
		$res37 = $obj->crbptable();
	}
	
	if(isset($_POST['sub38'])){
		$res38 = $obj->crbplogtable();
	}
	
	if(isset($_POST['sub39'])){
		$res39 = $obj->crinjurytable();
	}
	
	if(isset($_POST['sub40'])){
		$res40 = $obj->crijlogtable();
	}
	
	if(isset($_POST['sub41'])){
		$res41 = $obj->cricmaintable();
	}
	
	if(isset($_POST['sub42'])){
		$res42 = $obj->cricdumptable();
	}
	
	if(isset($_POST['sub43'])){
		$res43 = $obj->cricsoaptable();
	}
	
	if(isset($_POST['sub44'])){
		$res44 = $obj->criclogtable();
	}
	
	if(isset($_POST['sub45'])){
		$res45 = $obj->crocmaintable();
	}
	
	if(isset($_POST['sub46'])){
		$res46 = $obj->crocdumptable();
	}
	
	if(isset($_POST['sub47'])){
		$res47 = $obj->croclogtable();
	}
	
	if(isset($_POST['sub48'])){
		$res48 = $obj->crpcmaintable();
	}
	
	if(isset($_POST['sub49'])){
		$res49 = $obj->crpcdumptable();
	}
	
	if(isset($_POST['sub50'])){
		$res50 = $obj->crpclogtable();
	}
	
	if(isset($_POST['sub51'])){
		$res51 = $obj->crhctoneetable();
	}
	
	if(isset($_POST['sub52'])){
		$res52 = $obj->crhctoneelogtable();
	}
	
	if(isset($_POST['sub53'])){
		$res53 = $obj->crwcetable();
	}
	
	if(isset($_POST['sub54'])){
		$res54 = $obj->crwcelogtable();
	}
	
	if(isset($_POST['sub55'])){
		$res55 = $obj->crwcmaintable();
	}
	
	if(isset($_POST['sub56'])){
		$res56 = $obj->crwcdumptable();
	}
	
	if(isset($_POST['sub57'])){
		$res57 = $obj->crwclogtable();
	}
	
	if(isset($_POST['sub58'])){
		$res58 = $obj->crwcrtable();
	}
	
	if(isset($_POST['sub59'])){
		$res59 = $obj->crwcrlogtable();
	}
  ?>
</head>
<body>
	<?php include('header.php'); ?> 
	<div class="row" id="container2">
		<div class="twelve columns" id="container2a">
			<div class="row" id="head1">
				<div class="twelve columns" id="head1a">
					<br />
					<br />
				</div>
			</div>
			<div class="row" id="content2">
				<div class="twelve columns" id="content2a">
					<form name="basefrm1" id="frmbase1" action="base.php" method="post">
						<fieldset>
							<legend>Create Database</legend>
							<div class="row" id="baseobj1">
								<div class="six columns" id="baseobj1a">
									<input type="submit" name="sub1" id="but1" tabindex="1" value="Create Database" class="success button"/>
								</div>
								<div class="six columns" id="baseobj1b">
									<label class="baselval"><?php print $res1; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Check Database Link</legend>
							<div class="row" id="baseobj2">
								<div class="six columns" id="baseobj2a">
									<input type="submit" name="sub2" id="but2" tabindex="2" value="Check Database Link" class="success button"/>
								</div>
								<div class="six columns" id="baseobj2b">
									<label class="baselval"><?php print $res2; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create User Table</legend>
							<div class="row" id="baseobj3">
								<div class="six columns" id="baseobj3a">
									<input type="submit" name="sub3" id="but3" tabindex="3" value="Create User Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj3b">
									<label class="baselval"><?php print $res3; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Login Log Table</legend>
							<div class="row" id="baseobj4">
								<div class="six columns" id="baseobj4a">
									<input type="submit" name="sub4" id="but4" tabindex="4" value="Create Login Log Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj4b">
									<label class="baselval"><?php print $res4; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Login Attempt Table</legend>
							<div class="row" id="baseobj5">
								<div class="six columns" id="baseobj5">
									<input type="submit" name="sub5" id="but5" tabindex="5" value="Create Login Attempt Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj5b">
									<label class="baselval"><?php print $res5; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Login Count Table</legend>
							<div class="row" id="baseobj6">
								<div class="six columns" id="baseobj6a">
									<input type="submit" name="sub6" id="but6" tabindex="6" value="Create Login Count Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj6b">
									<label class="baselval"><?php print $res6; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Session Data Table</legend>
							<div class="row" id="baseobj7">
								<div class="six columns" id="baseobj7a">
									<input type="submit" name="sub7" id="but7" tabindex="7" value="Create Session Data Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj7b">
									<label class="baselval"><?php print $res7; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create IP / UA Log Table</legend>
							<div class="row" id="baseobj8">
								<div class="six columns" id="baseobj8a">
									<input type="submit" name="sub8" id="but8" tabindex="8" value="Create IP / UA Log Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj8b">
									<label class="baselval"><?php print $res8; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create User Creation Log Table</legend>
							<div class="row" id="baseobj9">
								<div class="six columns" id="baseobj9a">
									<input type="submit" name="sub9" id="but9" tabindex="9" value="Create User Creation Log Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj9b">
									<label class="baselval"><?php print $res9; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create User Unlock Log Table</legend>
							<div class="row" id="baseobj10">
								<div class="six columns" id="baseobj10a">
									<input type="submit" name="sub10" id="but10" tabindex="10" value="Create User Unlock Log Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj10b">
									<label class="baselval"><?php print $res10; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create User Lock Log Table</legend>
							<div class="row" id="baseobj11">
								<div class="six columns" id="baseobj11a">
									<input type="submit" name="sub11" id="but11" tabindex="11" value="Create User Lock Log Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj11b">
									<label class="baselval"><?php print $res11; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create User Delete Log Table</legend>
							<div class="row" id="baseobj12">
								<div class="six columns" id="baseobj12a">
									<input type="submit" name="sub12" id="but12" tabindex="12" value="Create User Delete Log Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj12b">
									<label class="baselval"><?php print $res12; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create User Edit Log Table</legend>
							<div class="row" id="baseobj13">
								<div class="six columns" id="baseobj13a">
									<input type="submit" name="sub13" id="but13" tabindex="13" value="Create User Edit Log Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj13b">
									<label class="baselval"><?php print $res13; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create User Change Password Log Table</legend>
							<div class="row" id="baseobj14">
								<div class="six columns" id="baseobj14a">
									<input type="submit" name="sub14" id="but14" tabindex="14" value="Create User Change Password Log Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj14b">
									<label class="baselval"><?php print $res14; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create User Edit Pic Log Table</legend>
							<div class="row" id="baseobj15">
								<div class="six columns" id="baseobj15a">
									<input type="submit" name="sub15" id="but15" tabindex="15" value="Create Edit Pic Log Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj15b">
									<label class="baselval"><?php print $res15; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Client Table</legend>
							<div class="row" id="baseobj16">
								<div class="six columns" id="baseobj16a">
									<input type="submit" name="sub16" id="but16" tabindex="16" value="Create Client Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj16b">
									<label class="baselval"><?php print $res16; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Client Log Table</legend>
							<div class="row" id="baseobj17">
								<div class="six columns" id="baseobj17a">
									<input type="submit" name="sub17" id="but17" tabindex="17" value="Create Client Log Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj17b">
									<label class="baselval"><?php print $res17; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Client Location Table</legend>
							<div class="row" id="baseobj18">
								<div class="six columns" id="baseobj18a">
									<input type="submit" name="sub18" id="but18" tabindex="18" value="Create Client Location Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj18b">
									<label class="baselval"><?php print $res18; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Client Location Log Table</legend>
							<div class="row" id="baseobj19">
								<div class="six columns" id="baseobj19a">
									<input type="submit" name="sub19" id="but19" tabindex="19" value="Create Client Location Log Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj19b">
									<label class="baselval"><?php print $res19; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Employee Table</legend>
							<div class="row" id="baseobj20">
								<div class="six columns" id="baseobj20a">
									<input type="submit" name="sub20" id="but20" tabindex="20" value="Create Employee Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj20b">
									<label class="baselval"><?php print $res20; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Employee Log Table</legend>
							<div class="row" id="baseobj21">
								<div class="six columns" id="baseobj21a">
									<input type="submit" name="sub21" id="but21" tabindex="21" value="Create Employee Log Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj21b">
									<label class="baselval"><?php print $res21; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Entity Guide Relationship Table</legend>
							<div class="row" id="baseobj22">
								<div class="six columns" id="baseobj22a">
									<input type="submit" name="sub22" id="but22" tabindex="22" value="Create Entity Guide Relationship Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj22b">
									<label class="baselval"><?php print $res22; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Entity Guide Relationship Log Table</legend>
							<div class="row" id="baseobj23">
								<div class="six columns" id="baseobj23a">
									<input type="submit" name="sub23" id="but23" tabindex="23" value="Create Entity Guide Relationship Log Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj23b">
									<label class="baselval"><?php print $res23; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Contact Table</legend>
							<div class="row" id="baseobj24">
								<div class="six columns" id="baseobj24a">
									<input type="submit" name="sub24" id="but24" tabindex="24" value="Create Contact Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj24b">
									<label class="baselval"><?php print $res24; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Contact Log Table</legend>
							<div class="row" id="baseobj25">
								<div class="six columns" id="baseobj25a">
									<input type="submit" name="sub25" id="but25" tabindex="25" value="Create Contact Log Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj25b">
									<label class="baselval"><?php print $res25; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create And Populate Consult Type Table</legend>
							<div class="row" id="baseobj26">
								<div class="six columns" id="baseobj26a">
									<input type="submit" name="sub26" id="but26" tabindex="26" value="Create And Populate Consult Type Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj26b">
									<label class="baselval"><?php print $res26; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Topic Table</legend>
							<div class="row" id="baseobj27">
								<div class="six columns" id="baseobj27a">
									<input type="submit" name="sub27" id="but27" tabindex="27" value="Create Topic Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj27b">
									<label class="baselval"><?php print $res27; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Topic Log Table</legend>
							<div class="row" id="baseobj28">
								<div class="six columns" id="baseobj28a">
									<input type="submit" name="sub28" id="but28" tabindex="28" value="Create Topic Log Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj28b">
									<label class="baselval"><?php print $res28; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Sub-Topic Table</legend>
							<div class="row" id="baseobj29">
								<div class="six columns" id="baseobj29a">
									<input type="submit" name="sub29" id="but29" tabindex="29" value="Create Sub-Topic Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj29b">
									<label class="baselval"><?php print $res29; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Sub-Topic Log Table</legend>
							<div class="row" id="baseobj30">
								<div class="six columns" id="baseobj30a">
									<input type="submit" name="sub30" id="but30" tabindex="30" value="Create Sub-Topic Log Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj30b">
									<label class="baselval"><?php print $res30; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Fields Table</legend>
							<div class="row" id="baseobj31">
								<div class="six columns" id="baseobj31a">
									<input type="submit" name="sub31" id="but31" tabindex="31" value="Create Fields Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj31b">
									<label class="baselval"><?php print $res31; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Fields Log Table</legend>
							<div class="row" id="baseobj32">
								<div class="six columns" id="baseobj32a">
									<input type="submit" name="sub32" id="but32" tabindex="32" value="Create Fields Log Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj32b">
									<label class="baselval"><?php print $res32; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Hctonee Table</legend>
							<div class="row" id="baseobj51">
								<div class="six columns" id="baseobj51a">
									<input type="submit" name="sub51" id="but51" tabindex="51" value="Create Hctonee Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj51b">
									<label class="baselval"><?php print $res51; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Hctonee Log Table</legend>
							<div class="row" id="baseobj52">
								<div class="six columns" id="baseobj52a">
									<input type="submit" name="sub52" id="but52" tabindex="52" value="Create Hctonee Log Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj52b">
									<label class="baselval"><?php print $res52; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Wce Table</legend>
							<div class="row" id="baseobj53">
								<div class="six columns" id="baseobj53a">
									<input type="submit" name="sub53" id="but53" tabindex="53" value="Create Wce Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj53b">
									<label class="baselval"><?php print $res53; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Wce Log Table</legend>
							<div class="row" id="baseobj54">
								<div class="six columns" id="baseobj54a">
									<input type="submit" name="sub54" id="but54" tabindex="54" value="Create Wce Log Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj54b">
									<label class="baselval"><?php print $res54; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Health Consult Main Table</legend>
							<div class="row" id="baseobj33">
								<div class="six columns" id="baseobj33a">
									<input type="submit" name="sub33" id="but33" tabindex="33" value="Create Health Consult Main Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj33b">
									<label class="baselval"><?php print $res33; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Health Consult Dump Table</legend>
							<div class="row" id="baseobj34">
								<div class="six columns" id="baseobj34a">
									<input type="submit" name="sub34" id="but34" tabindex="34" value="Create Health Consult Dump Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj34b">
									<label class="baselval"><?php print $res34; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Health Consult SOAP Table</legend>
							<div class="row" id="baseobj35">
								<div class="six columns" id="baseobj35a">
									<input type="submit" name="sub35" id="but35" tabindex="35" value="Create Health Consult SOAP Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj35b">
									<label class="baselval"><?php print $res35; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Health Consult Log Table</legend>
							<div class="row" id="baseobj36">
								<div class="six columns" id="baseobj36a">
									<input type="submit" name="sub36" id="but36" tabindex="36" value="Create Health Consult Log Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj36b">
									<label class="baselval"><?php print $res36; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Body Part Table</legend>
							<div class="row" id="baseobj37">
								<div class="six columns" id="baseobj37a">
									<input type="submit" name="sub37" id="but37" tabindex="37" value="Create Body Part Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj37b">
									<label class="baselval"><?php print $res37; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Body Part Log Table</legend>
							<div class="row" id="baseobj38">
								<div class="six columns" id="baseobj38a">
									<input type="submit" name="sub38" id="but38" tabindex="38" value="Create Body Part Log Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj38b">
									<label class="baselval"><?php print $res38; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Injury Table</legend>
							<div class="row" id="baseobj39">
								<div class="six columns" id="baseobj39a">
									<input type="submit" name="sub39" id="but39" tabindex="39" value="Create Injury Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj39b">
									<label class="baselval"><?php print $res39; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Injury Log Table</legend>
							<div class="row" id="baseobj40">
								<div class="six columns" id="baseobj40a">
									<input type="submit" name="sub40" id="but40" tabindex="40" value="Create Injury Log Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj40b">
									<label class="baselval"><?php print $res40; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Injury Consult Main Table</legend>
							<div class="row" id="baseobj41">
								<div class="six columns" id="baseobj41a">
									<input type="submit" name="sub41" id="but41" tabindex="41" value="Create Injury Consult Main Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj41b">
									<label class="baselval"><?php print $res41; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Injury Consult Dump Table</legend>
							<div class="row" id="baseobj42">
								<div class="six columns" id="baseobj42a">
									<input type="submit" name="sub42" id="but42" tabindex="42" value="Create Injury Consult Dump Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj42b">
									<label class="baselval"><?php print $res42; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Injury Consult SOAP Table</legend>
							<div class="row" id="baseobj43">
								<div class="six columns" id="baseobj43a">
									<input type="submit" name="sub43" id="but43" tabindex="43" value="Create Injury Consult SOAP Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj43b">
									<label class="baselval"><?php print $res43; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Injury Consult Log Table</legend>
							<div class="row" id="baseobj44">
								<div class="six columns" id="baseobj44a">
									<input type="submit" name="sub44" id="but44" tabindex="44" value="Create Injury Consult Log Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj44b">
									<label class="baselval"><?php print $res44; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Opportunity Consult Main Table</legend>
							<div class="row" id="baseobj45">
								<div class="six columns" id="baseobj45a">
									<input type="submit" name="sub45" id="but45" tabindex="45" value="Create Opportunity Consult Main Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj45b">
									<label class="baselval"><?php print $res45; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Opportunity Consult Dump Table</legend>
							<div class="row" id="baseobj46">
								<div class="six columns" id="baseobj46a">
									<input type="submit" name="sub46" id="but46" tabindex="46" value="Create Opportunity Consult Dump Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj46b">
									<label class="baselval"><?php print $res46; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Opportunity Consult Log Table</legend>
							<div class="row" id="baseobj47">
								<div class="six columns" id="baseobj47a">
									<input type="submit" name="sub47" id="but47" tabindex="47" value="Create Opportunity Consult Log Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj47b">
									<label class="baselval"><?php print $res47; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Proactive Consult Main Table</legend>
							<div class="row" id="baseobj48">
								<div class="six columns" id="baseobj48a">
									<input type="submit" name="sub48" id="but48" tabindex="48" value="Create Proactive Consult Main Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj48b">
									<label class="baselval"><?php print $res48; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Proactive Consult Dump Table</legend>
							<div class="row" id="baseobj49">
								<div class="six columns" id="baseobj49a">
									<input type="submit" name="sub49" id="but49" tabindex="49" value="Create Proactive Consult Dump Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj49b">
									<label class="baselval"><?php print $res49; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Proactive Consult Log Table</legend>
							<div class="row" id="baseobj50">
								<div class="six columns" id="baseobj50a">
									<input type="submit" name="sub50" id="but50" tabindex="50" value="Create Proactive Consult Log Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj50b">
									<label class="baselval"><?php print $res50; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Well Credit Main Table</legend>
							<div class="row" id="baseobj55">
								<div class="six columns" id="baseobj55a">
									<input type="submit" name="sub55" id="but55" tabindex="55" value="Create Well Credit Main Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj55b">
									<label class="baselval"><?php print $res55; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Well Credit Dump Table</legend>
							<div class="row" id="baseobj56">
								<div class="six columns" id="baseobj56a">
									<input type="submit" name="sub56" id="but56" tabindex="56" value="Create Well Credit Dump Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj56b">
									<label class="baselval"><?php print $res56; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Well Credit Log Table</legend>
							<div class="row" id="baseobj57">
								<div class="six columns" id="baseobj57a">
									<input type="submit" name="sub57" id="but57" tabindex="57" value="Create Well Credit Log Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj57b">
									<label class="baselval"><?php print $res57; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Wcr Table</legend>
							<div class="row" id="baseobj53">
								<div class="six columns" id="baseobj53a">
									<input type="submit" name="sub58" id="but58" tabindex="58" value="Create Wcr Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj58b">
									<label class="baselval"><?php print $res58; ?></label>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Create Wcr Log Table</legend>
							<div class="row" id="baseobj59">
								<div class="six columns" id="baseobj59a">
									<input type="submit" name="sub59" id="but59" tabindex="59" value="Create Wcr Log Table" class="success button"/>
								</div>
								<div class="six columns" id="baseobj59b">
									<label class="baselval"><?php print $res59; ?></label>
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
