<?php// DASHBOARD OF THE SITE// must be developed the Activity Feed featuresession_start();error_reporting(E_ALL);ini_set('display_errors', 1);include 'sessionclass.php';$obj = new session;$seadmin = $obj->seadmin();?><!DOCTYPE html>    <html class="no-js" lang="en">    <head>        <meta charset="utf-8" />        <meta name="viewport" content="width=device-width" />        <title>Wellness - Admin Dashboard</title>        <link rel="stylesheet" href="stylesheets/foundation.min.css">        <link rel="stylesheet" href="style-G.css"><!--        <link rel="stylesheet" href="stylesheets/app.css">-->        <script src="javascripts/modernizr.foundation.js"></script>    </head>    <body>        <?php include('header.php'); ?>         <script src="javascripts/foundation.min.js"></script>        <script src="javascripts/app.js"></script>                         <div class="left-column">            <?php include "inc_left_column.php" ?>        </div>        <div class="right-column">            <div id="activity-feed">                                   <form name="repfrm1" id="frmrep1" method="post" action="mlconrep.php">				<div class="row">					<div class="three columns">						<label>Select Client</label>					</div>					<div class="four columns">						<?php $obj1->printlinkedclientlist(); ?>					</div>					<div class="five columns">						<label><?php print $clidsta; ?></label>					</div>				</div>				<div class="row">					<div class="three columns">						<label>Select Location</label>					</div>					<div class="four columns" id="repobj1">						<select name="lid" id="sel2" tabindex="2">							<option value="0">All Locations</option>						</select>					</div>					<div class="five columns">										</div>				</div>				<div class="row">					<div class="three columns">						<label>Select Gender</label>					</div>					<div class="four columns">						<select name="sex" id="sel3" tabindex="3">							<option value="0">All</option>							<option value="female">Female</option>							<option value="male">Male</option>							<option value="neuter">Neuter</option>						</select>					</div>					<div class="five columns">											</div>				</div>				<div class="row">					<div class="three columns">						<label>Select Lower Age Range</label>					</div>					<div class="four columns">						<?php $obj1->printarl(); ?>					</div>					<div class="five columns">											</div>				</div>				<div class="row">					<div class="three columns">						<label>Select Higher Age Range</label>					</div>					<div class="four columns">						<?php $obj1->printarh(); ?>					</div>					<div class="five columns">											</div>				</div>				<div class="row">					<div class="three columns">						<label>Year</label>					</div>					<div class="four columns">						<?php $obj1->printyear(); ?>					</div>					<div class="five columns">											</div>				</div>				<div class="row">					<div class="three columns">						<label>Month</label>					</div>					<div class="four columns">						<?php $obj1->printmonth(); ?>					</div>					<div class="five columns">											</div>				</div>				<div class="row">					<div class="three columns">						<label>Select Chart</label>					</div>					<div class="four columns">						<select name="chart" id="sel8" tabindex="3">							<option value="0">Select Chart</option>							<option value="1">Pie Chart</option>							<option value="2">3D Pie Chart</option>							<option value="3">Vertical Bar Chart</option>							<option value="4">Horizontal Bar Chart</option>						</select>					</div>					<div class="five columns">											</div>				</div>				<div class="row">					<div class="three columns">						<label></label>					</div>					<div class="four columns">						<input type="submit" name="sub1" id="but1" value="Generate" class="success button" />					</div>					<div class="five columns">											</div>				</div>				<div class="row">					<div class="one columns">											</div>					<div class="ten columns">						<br />						<br />						<?php							foreach ($cap as $key => $value){								print "<h6>".$key." :  ".$value."</h6>"."<br />";							}							if ($res != ""){								print "<h5>"."Contacts :  ".$y."</h5>"."<br />";							}						?>						<br />						<br />					</div>					<div class="one columns">											</div>				</div>				<div class="row">					<div class="one columns">						<label></label>					</div>					<div class="ten columns">						<?php							if ($chart != "0"){																if ($chart == "1"){									$pichart = new gPieChart();									$pichart->addDataSet($res);									$pichart->setLegend($leg);									$pichart->setLabels($res);									$pichart->setColors($rca);									$pichart->setDimensions(900, 310);									print "<img src=\"".$pichart->getUrl()."\" />";								}																if ($chart == "2"){									$pie3dChart = new gPie3DChart();									$pie3dChart->addDataSet($res);									$pie3dChart->setLegend($leg);									$pie3dChart->setLabels($res);									$pie3dChart->setColors($rca);									print "<img src=\"".$pie3dChart->getUrl()."\" />";								}																if ($chart == "3"){									$barChart = new gBarChart(500,150,'g');									foreach ($res as $value){										$barChart->addDataSet(array($value));									}									$barChart->setColors($rca);									$barChart->setLegend($leg);									$barChart->setVisibleAxes(array("x", "y"));									$barChart->setDataRange(0, $max);									$barChart->addAxisRange(0, 0, 0);									$barChart->addAxisRange(1, 0, $max);									//$barChart->setGradientFill('c',0,array('FFE7C6',0,'76A4FB',1));									$barChart->setAutoBarWidth();									print "<img src=\"".$barChart->getUrl()."\" />";								}																if ($chart == "4"){									$barChart = new gBarChart(150,500,'g','h');									foreach ($res as $value){										$barChart->addDataSet(array($value));									}									$barChart->setColors($rca);									$barChart->setLegend($leg);									$barChart->setDataRange(0, $max);									//$barChart->setGradientFill('c',0,array('FFE7C6',0,'76A4FB',1));									$barChart->setAutoBarWidth();									print "<img src=\"".$barChart->getUrl()."\" />";								}															}						?>					</div>					<div class="one columns">											</div>				</div>			</form>                            </div>                    </div>    </body></html>