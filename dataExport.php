<?php
	session_start();
	include 'sessionclass.php';
	include 'dataExportClass.php';
	$obj = new session;
	$seadminguide = $obj->seadminguide();
	$_SESSION['csvText']= "";
	//$seadminguide = $obj->seadminguide();
?>
<!DOCTYPE html>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8" />

  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width" />

  <title>Wellness - Data Export</title>


  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>  
  <!-- Included CSS Files (Uncompressed) -->
  <!--
  <link rel="stylesheet" href="stylesheets/foundation.css">
  -->
  
  <!-- Included CSS Files (Compressed) -->

  <link rel="stylesheet" href="stylesheets/foundation.min.css">
  <link rel="stylesheet" href="stylesheets/app.css">

  <link rel="stylesheet" href="stylesheets/dateRangeSelect.css">
  <script src="javascripts/dateRangeSelect.js"></script>

  <script src="javascripts/locationCheckboxesSelect.js"></script>
  
  


  <style>
	.hidden {display:none;}
	.reportexample{border:solid green 2px;background-color:rgba(60,60,60,0.08);border-spacing:0px;margin-left:auto;margin-right:auto;};
	.reportexample .tag{background:green;}
	.reportexample .tag .ex{text-align:center;font-weight:600;font-size:24px;color:white;column-span:all}
  </style>

  <script src="javascripts/modernizr.foundation.js"></script>

  
  
  
  <?php
  	$dataExport = new dataExport;
  	$outsta = "";
	$e = 0;
	$f = 0;
	$clidsta = "";
	$locidsta = "";
	$clid = "";
	$locid = "";
	/*
	if (isset($_POST['generateANDexportData'])){
		//echo ("Data Export Requested<br/>");
		//echo($dataExport->printlinkedclientlist());
		$clientID = $_POST['lc'];
		//echo("client ID = ".$clientID);
		$csvText =	$dataExport->createClientCSV($clientID);
		//echo("<br/>");
		//echo($csvText);
		$_SESSION['csvText']= $csvText;
	}
  	*/
  ?>
</head>
<body><?php include('header.php'); ?> 
	
	<div class="row" id="container1">
		<div class="ten columns centered" id="container1a">

			<div class="row" id="head1">
				<div class="twelve columns" id="head1a">

					<a href="logout.php">Logout</a>
				</div>
			</div>
			<div class="row" id="content3">
				<div class="twelve columns" id="content3a">
					<form name="adminonefrm" id="frmadminone" action="csvDownload.php" method="post" onsubmit="return showWaitScreen();" enctype="multipart/form-data">
						<fieldset>
							<legend>Data Export</legend>
							<div class="row" id="adminobj0x">
								<div class="three columns" id="adminobj0xa">
									<label class="adminlkey">Client</label>
								</div>
								<div class="four columns" id="adminobj0xb">
									<?php
										$dataExport->printlinkedclientlist();
									?>
								</div>
								<div class="five columns" id="loginobj0xc">
									<label class="adminlval"><?php print $clidsta; ?></label>
								</div>
							</div>
							<!-- Report Type-->
							<div class="row" style="margin-top:10px;">
								<div class="three columns" id="adminobj0xa">
									<label>Report Type</label>
								</div>
								<div class="four columns" id="adminobj0xb">
									<select style="width:auto;"id="reportType" name="reportType" />
						          		<option value="Full" selected>Full Employee Report</option>      
						          		<option value="ContactConsultOverview">Contacts and Consults Overview </option>
										<option value="ContactMethodOverview">Contact Methods Overview</option>
						          		<option value="ParticipationByLocation">Participation by Location</option>
						          		<option value="Test">Test</option> 
						          		<option value="HealthConsultTopics">Health Consult Topics</option>
						          		<option value="ProactiveConsultTopics">Proactive Consult Topics</option>
						          		<option value="InjuryConsultTopics">Injury Consult Topics</option> 
						          		<option value="ExecutiveSummary">Executive Summary</option>
						          		<option value="Metrics">Metrics</option>         
						        	</select> &nbsp;
								</div>
								<div class="five columns" id="loginobj0xc">
									<label class="adminlval"></label>
								</div>
							</div>

							<div id="reportpreview" style="margin:20px;">

								<table id="reportpreviewFull" class="reportexample hidden">
									<tr class='tag' style="background-color:green;">
										<td colspan="100" class="ex">Example: Full Employee Report</td><td></td>
									</tr>
									<tr>
										<td><b>Employee:</b>
										</td>
										<td>Name
										</td>
										<td>DOB
										</td>
										<td>Gender
										</td>
										<td>Department
										</td>
										<td>Year Hired
										</td>
										<td>Status
										</td>
									</tr>
									<tr>
										<td style="text-align:center;transform:rotate(180deg);-ms-transform:rotate(180deg);-webkit-transform:rotate(180deg);">&not;
										</td>
										<td><b>Contact:</b>
										</td>
										<td>Date
										</td>
										<td>Location
										</td>
										<td>Mode
										</td>
									</tr>
									<tr>
										<td>
										</td>
										<td style="text-align:center;transform:rotate(180deg);-ms-transform:rotate(180deg);-webkit-transform:rotate(180deg);">&not;
										</td>
										<td><b>Consult:</b>
										</td>
										<td>Type
										</td>
										<td>?
										</td>
										<td>?
										</td>
									</tr>
								</table>

								<table id="reportpreviewExecSummary" class="reportexample hidden">
									<tr class='tag' style="background-color:green;">
										<td colspan="100" class="ex">Example: Executive Summary</td><td></td>
									</tr>
									<tr>
										<td><b>Reporting Period:</b>
										</td>
										<td>'All Records' or m.d.y - m.d.y
										</td>
									</tr>
									<tr>
										<td><b>Date Range of WellGuide Contacts</b>
										</td>
										<td >m.d.y - m.d.y (first contact to last contact within Reporting Period)
										</td>
									</tr>
									<tr>
										<td><b>Total Employees Participating in Screenings </b>
										</td>
										<td ># of Employees with contacts within Reporting Period
										</td>
									</tr>
									<tr>
										<td><b>Total Employees Participating in WellGuide </b>
										</td>
										<td ># of active Employees within Reporting Period
										</td>
									</tr>
									<tr>
										<td><b>Total Contacts </b>
										</td>
										<td >xxxx
										</td>
									</tr>
									<tr>
										<td><b>Average Contacts per Participating Employee </b>
										</td>
										<td >x/y ?(y = # Participating in Screenings or WellGuide?)
										</td>
									</tr>
									<tr>
										<td><b>Total Consults </b>
										</td>
										<td >xxxx
										</td>
									</tr>
									<tr>
										<td><b>Average Consults per Participating Employee </b>
										</td>
										<td >x/y ?(y = # Participating in Screenings or WellGuide? I would guess screenings but please clarify.)
										</td>
									</tr>
								</table>

								<table id="reportpreviewContactsConsultsOverview" class="reportexample hidden">
									<tr class='tag' style="background-color:green;">
										<td colspan="100" class="ex">Example: Contacts and Consults Overview</td><td></td>
									</tr>
									<tr>
										<td><b>Total Contacts:</b>
										</td>
										<td>x
										</td>
									</tr>
									<tr>
										<td><b>Total Consults:</b>
										</td>
										<td>x
										</td>
									</tr>
									<tr>
										<td>
										</td>
									</tr>
									<tr>
										<td><b><u>Consults Type</u></b>
										</td>
										<td><b>Total of Type</b>
										</td>
										<td><b>% of all Consults</b>
										</td>
									</tr>
									<tr>
										<td><b>Proactive:</b>
										</td>
										<td>x
										</td>
										<td>x%
										</td>
									</tr>
									<tr>
										<td><b>Health:</b>
										</td>
										<td>x
										</td>
										<td>x%
										</td>
									</tr>
									<tr>
										<td><b>Injury:</b>
										</td>
										<td>x
										</td>
										<td>x%
										</td>
									</tr>
									<tr>
										<td><b>Opportunity:</b>
										</td>
										<td>x
										</td>
										<td>x%
										</td>
									</tr>
								</table>

								<table id="reportpreviewContactMethodOverview" class="reportexample hidden">
									<tr class='tag' style="background-color:green;">
										<td colspan="100" class="ex">Example: Contact Methods Overview</td><td></td>
									</tr>
									<tr>
										<td><b><u>Contact Method</u></b>
										</td>
										<td><b>Total of Type</b>
										</td>
										<td><b>% of all Types</b>
										</td>
									</tr>
									<tr>
										<td><b>One on One:</b>
										</td>
										<td>x
										</td>
										<td>x%
										</td>
									</tr>
									<tr>
										<td><b>Telephone:</b>
										</td>
										<td>x
										</td>
										<td>x%
										</td>
									</tr>
									<tr>
										<td><b>Email:</b>
										</td>
										<td>x
										</td>
										<td>x%
										</td>
									</tr>
									<tr>
										<td><b>Group:</b>
										</td>
										<td>x
										</td>
										<td>x%
										</td>
									</tr>
								</table>

								<table id="reportpreviewParticipationByLocation" class="reportexample hidden">
									<tr class='tag' style="background-color:green;">
										<td colspan="100" class="ex">Example: Participation by Location</td><td></td>
									</tr>
									<tr>
										<td><b><u>Location Name</u></b>
										</td>
										<td><b>Total Employees</b>
										</td>
										<td><b>Total Contacts</b>
										</td>
										<td><b>Average Contacts per Employee</b>
										</td>
										<td><b>First Contact Date</b>
										</td>
										<td><b>Last Contact Date</b>
										</td>
									</tr>
									<tr>
										<td>"Location X"
										</td>
										<td>x
										</td>
										<td>x
										</td>
										<td>x/x
										</td>
										<td>m.d.y
										</td>
										<td>m.d.y
										</td>
									</tr>
								</table>

								<table id="reportpreviewTest" style="width:80%;" class="reportexample hidden">
									<tr class='tag' style="background-color:green;">
										<td colspan="100" class="ex">Test</td><td></td>
									</tr>
								</table>

								<table id="reportpreviewHealthConsultTopics" class="reportexample hidden">
									<tr class='tag' style="background-color:green;">
										<td colspan="100" class="ex">Example: Health Consult Topics</td><td></td>
									</tr>
									<tr>
										<td><b>Total Health Consults</b>
										</td>
										<td>#[Total Health Consults]
										</td>
									</tr>
									<tr>
										<td><b>Health Consult Topics</b>
										</td>
										<td><b>Frequency</b>
										</td>
										<td><b>Rank</b>
										</td>
									</tr>
									<tr>
										<td>TEXT[Topic Name]
										</td>
										<td>#[Frequency]
										</td>
										<td>#[Rank]
										</td>
									</tr>
								</table>

								<table id="reportpreviewProactiveConsultTopics" class="reportexample hidden">
									<tr class='tag' style="background-color:green;">
										<td colspan="100" class="ex">Example: Proactive Consult Topics</td><td></td>
									</tr>
									<tr>
										<td><b>Total Proactive Consults</b>
										</td>
										<td>#[Total Proactive Consults]
										</td>
									</tr>
									<tr>
										<td><b>Proactive Consult Topics</b>
										</td>
										<td><b>Frequency</b>
										</td>
										<td><b>Rank</b>
										</td>
									</tr>
									<tr>
										<td>TEXT[Topic Name]
										</td>
										<td>#[Frequency]
										</td>
										<td>#[Rank]
										</td>
									</tr>
								</table>

								<table id="reportpreviewInjuryConsultTopics" class="reportexample hidden">
									<tr class='tag' style="background-color:green;">
										<td colspan="100" class="ex">Example: Injury Consult Topics</td><td></td>
									</tr>
									<tr>
										<td><b>Total Injury Consults</b>
										</td>
										<td>#[Total Injury Consults]
										</td>
									</tr>
									<tr>
										<td><b>Injury Consult Topics</b>
										</td>
										<td><b>Rank</b>
										</td>
										<td><b>Frequency</b>
										</td>
									</tr>
									<tr>
										<td>TEXT[Topic Name]
										</td>
										<td>#[Frequency]
										</td>
										<td>#[Rank]
										</td>
									</tr>
								</table>

								<table id="reportpreviewMetrics" class="reportexample hidden">
									<tr class='tag' style="background-color:green;">
										<td colspan="100" class="ex">Example: Metrics</td><td></td>
									</tr>
									<tr>
										<td><b>Total Sustained Weight Lost:</b>
										</td>
										<td>#[Total Weight Lost Of All Employees Who Lost Weight]

									</tr>
									<tr>
										<td><b>Total Sustained % Body Fat Lost:</b>
										</td>
										<td>#[Total % Body Fat Lost Of All Employees Who Lost Body Fat]
									</tr>
									<tr>
										<td><b>Total Metabolic Years Lost:</b>
										</td>
										<td>#[Total Metabolic Years Lost Of All Employees Who Lost Metabolic Years]
									</tr>
									<tr>
										<td><b>Total Employees Who Quit Tobacco:</b>
										</td>
										<td>#[Total Employees Who Have Been Recorded Smoking But Are Currently Reported As Not Smoking]
									</tr>
									
								</table>

							</div>

							<!-- End Report Type-->
							<!--  DateRangeSelect      -->
							<fieldset>
								<legend>Options</legend>

								<b>Filter by Date Range: </b><input id="useDateRange" name="useDateRange" type="checkbox" autocomplete="off" />

								<span id="dateRangeSelect" class='hidden'>
							    	<fieldset class="date">
							        	<legend>Start Date </legend>
							        	<label for="startMonth">Month</label>
							        	<select id="startMonth" name="startMonth" />
							          		<option selected>January</option>      
							          		<option>February</option>      
							          		<option>March</option>      
							          		<option>April</option>      
							  		        <option>May</option>      
							   		        <option>June</option>      
							    		    <option>July</option>      
							          		<option>August</option>      
							          		<option>September</option>      
							          		<option>October</option>      
							          		<option>November</option>      
							          		<option>December</option>      
							        	</select> &nbsp;
							        	<label for="startDay">Day</label>
							        	<select id="startDay" name="startDay" />
							          		<option selected>1</option>      
							          		<option>2</option>      
							          		<option>3</option>      
							          		<option>4</option>      
							          		<option>5</option>      
							          		<option>6</option>      
							          		<option>7</option>      
							          		<option>8</option>      
							          		<option>9</option>      
							          		<option>10</option>      
							         		<option>11</option>      
							          		<option>12</option>      
							          		<option>13</option>      
							          		<option>14</option>      
							          		<option>15</option>      
							          		<option>16</option>      
							          		<option>17</option>      
							          		<option>18</option>      
							          		<option>19</option>      
							          		<option>20</option>      
							          		<option>21</option>      
							          		<option>22</option>      
							          		<option>23</option>      
							          		<option>24</option>      
							          		<option>25</option>      
							          		<option>26</option>      
							          		<option>27</option>      
							          		<option>28</option>      
							          		<option>29</option>      
							          		<option>30</option>      
							          		<option>31</option>      
							        	</select> &nbsp;
							        	<label for="startYear">Year</label>
							        	<select id="startYear" name="startYear" />
								            <option selected>2000</option>      
								            <option>2001</option>      
								            <option>2002</option>      
								            <option>2003</option>      
								            <option>2004</option>      
								            <option>2005</option>      
								            <option>2006</option>      
								            <option>2007</option>      
								            <option>2008</option>
								            <option>2009</option>      
								            <option>2010</option>      
								            <option>2011</option>      
								            <option>2012</option>      
								            <option>2013</option>      
								            <option>2014</option>      
								            <option>2015</option>      
								            <option>2016</option>      
								            <option>2017</option>      
								            <option>2018</option>      
							        	</select>
							      	</fieldset>

							      	<fieldset class="date">
							        	<legend>End Date </legend>
							        	<label for="endMonth">Month</label>
							        	<select id="endMonth" name="endMonth" />
							          		<option>January</option>      
							          		<option>February</option>      
							          		<option>March</option>      
							          		<option>April</option>      
							          		<option>May</option>      
							          		<option>June</option>      
							         		<option>July</option>      
							          		<option>August</option>      
							          		<option>September</option>      
							          		<option>October</option>      
							          		<option>November</option>      
							          		<option selected>December</option>      
							        	</select> &nbsp;
							        	<label for="endDay">Day</label>
							        	<select id="endDay" name="endDay" />
							            	<option>1</option>      
							            	<option>2</option>      
							            	<option>3</option>      
							            	<option>4</option>      
							            	<option>5</option>      
							            	<option>6</option>      
							            	<option>7</option>      
							            	<option>8</option>      
							            	<option>9</option>      
							            	<option>10</option>      
							            	<option>11</option>      
							            	<option>12</option>      
							            	<option>13</option>      
							            	<option>14</option>      
							            	<option>15</option>      
							            	<option>16</option>      
							            	<option>17</option>      
							            	<option>18</option>      
							            	<option>19</option>      
							            	<option>20</option>      
							            	<option>21</option>      
							            	<option>22</option>      
							            	<option>23</option>      
							            	<option>24</option>      
							            	<option>25</option>      
							            	<option>26</option>      
							            	<option>27</option>      
							            	<option>28</option>      
							            	<option>29</option>      
							            	<option>30</option>      
							            	<option selected>31</option>   
							        	</select> &nbsp;
							        	<label for="endYear">Year</label>
							        	<select id="endYear" name="endYear" />
								            <option>2000</option>      
								            <option>2001</option>      
								            <option>2002</option>      
								            <option>2003</option>      
								            <option>2004</option>      
								            <option>2005</option>      
								            <option>2006</option>      
								            <option>2007</option>      
								            <option>2008</option>
								            <option>2009</option>      
								            <option>2010</option>      
								            <option>2011</option>      
								            <option>2012</option>      
								            <option>2013</option>      
								            <option>2014</option>      
								            <option>2015</option>      
								            <option>2016</option>      
								            <option>2017</option>      
								            <option selected>2018</option>      
							        	</select>
							      	</fieldset>
							    </span>
							
						<!--  end DateRangeSelect      -->

								<p><b>Specify Locations: </b><input id="useLocationSelect" name="useLocationSelect" type="checkbox" autocomplete="off" /></p>

								<span id="locationSelect" class='hidden'>
							    	<fieldset class="checkboxes">
							        	<legend>Locations </legend>
							        	<span id="locationCheckboxes">
							        	</span>
							      	</fieldset>
							    </span>
							</fieldset>

						</fieldset>
						<fieldset>
							<div class="row" id="adminobj17">
								<div class="three columns" id="adminobj17a">
									
								</div>
								<div class="four columns" id="adminobj17b">
									<input type="submit" name="generateANDexportData" id="but1" tabindex="18" value="Generate Report" class="success button" />
									
								</div>
								<div style="float:left;clear:both;margin-top:10px;margin-left:100px;"> 
									<!--
									<p>Please be patient while your report is being generated</p>
									<p>When it completes click the 'CSV Download' button that will appear below.</p>
									-->
								</div>
								<div class="five columns" id="loginobj17c">
									<label class="adminlval"><?php print $outsta; ?></label>
								</div>
							</div>
						</fieldset>
					</form>
					
				</div>
			</div>
			<div id="waitmessage" class="hidden">
				<div class="twelve columns">
					<form >
						<fieldset>
							<div class="row" id="adminobj0x">
								<div style="margin-left:100px;font-weight:800;">
									Please be patient while your download is generated.<br/>
									It may take up to several minutes.<br/>
									<!--<form action="dataExport.php">
    									<input type="submit" value="Cancel Request and Return">
									</form>
									<button onclick="generatesCSV()">generateCSV</button>
									-->
								</div>
							</div>
						</fieldset>
					</form>
				</div>
			</div>

			<div class="row">
				<div class="four columns" id="asd">
				</div>
				<script>
					function generatesCSV(){
						var clientID = document.getElementById('sel1').value;
						//console.log(clientID);
						//console.log("anything");

					}
					function showWaitScreen(){
						//console.log("showWaitScreen()");
						addClass('hidden' , document.getElementById('content3a') );
						removeClass('hidden' , document.getElementById('waitmessage') );
						return true;
					}
					function addClass( classname, element ) {
					    var cn = element.className;
					    //test for existance
					    if( cn.indexOf( classname ) != -1 ) {
					    	return;
					    }
					    //add a space if the element already has class
					    if( cn != '' ) {
					    	classname = ' '+classname;
					    }
					    element.className = cn+classname;
					}
					function removeClass( classname, element ) {
					    var cn = element.className;
					    var rxp = new RegExp( "\\s?\\b"+classname+"\\b", "g" );
					    cn = cn.replace( rxp, '' );
					    element.className = cn;
					}
				</script>
				
				<?php
						if (isset($_POST['generateANDexportData'])){
								//echo ("Data Export Requested<br/>");
								//echo("<p>Please be patient while your report is being generated</p><p>When it completes click the 'CSV Download' button.</p>");
								echo('<button onclick="csvDownload();" style="margin-left:0px;">CSV Download</button>');
								$clientID = $_POST['lc'];
								echo("<br/>StartDay :".$_POST['startDay']);
								//echo("client ID = ".$clientID);
								$csvText =	$dataExport->createClientCSV($clientID,$_POST['startMonth'],$_POST['startDay']);
								$_SESSION['csvText']= $csvText;
						}
				?>
				
			</div>
		</div>
	</div>
	
	<script>
	function csvDownload(){
		//set $_SESSION['csvFileName'] it is used in csvDownload.php - set in $dataExport->createClientCSV($clientID)
		self.location="csvDownload.php";
	}

	function showPreviewReport(rt){
		//alert(rt);
		var html ="";
		$('#reportpreview').children('table').addClass('hidden')
		switch(rt){
			case "Full":
			    $('#reportpreviewFull').removeClass('hidden');
			    break;
			case "ContactConsultOverview":
			    $('#reportpreviewContactsConsultsOverview').removeClass('hidden');
			    break;
			case "ContactMethodOverview":
				$('#reportpreviewContactMethodOverview').removeClass('hidden');
			    break;
			case "ParticipationByLocation":
			    $('#reportpreviewParticipationByLocation').removeClass('hidden');
			    break;
			case "Test":
			    $('#reportpreviewTest').removeClass('hidden');
			    break;
			case "HealthConsultTopics":
			    $('#reportpreviewHealthConsultTopics').removeClass('hidden');
			    break;
			case "ProactiveConsultTopics":
			    $('#reportpreviewProactiveConsultTopics').removeClass('hidden');
			    break;
			case "InjuryConsultTopics":
			    $('#reportpreviewInjuryConsultTopics').removeClass('hidden');
			    break;
			case "ExecutiveSummary":
			    $('#reportpreviewExecSummary').removeClass('hidden');
			    break;
			case "Metrics":
			    $('#reportpreviewMetrics').removeClass('hidden');
			    break;
			    
			default:
			    //code block
			    break;
		} 
	}

	showPreviewReport($('#reportType').val());
	$('#reportType').change(function() {
		var reportType = $('#reportType').val();
		showPreviewReport(reportType);
		//$('#reportpreview').html("Put the example here");
	});


	</script>
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