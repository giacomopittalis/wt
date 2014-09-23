<!DOCTYPE html>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta http-equiv="Content-Language" content="EN" />
  <meta name="robots" content="index, follow" />
  <meta name="author" content="Purnima Progressive" />
  <meta name="keywords" content="Purnima Progressive, google charts, google charts api" />
  <meta name="description" content="Purnima Progressive demonstrates an implementation of google charts" />
  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width" />

  <title>Purnima Progressive - Demos - Google Charts Demo</title>
  
  <!-- Included CSS Files (Uncompressed) -->
  <!--
  <link rel="stylesheet" href="stylesheets/foundation.css">
  -->
  
  <!-- Included CSS Files (Compressed) -->
  <link rel="stylesheet" href="stylesheets/foundation.min.css">
  <link rel="stylesheet" href="stylesheets/app.css">
  <link rel="stylesheet" href="stylesheets/fc-webicons.css">
  <link rel="stylesheet" href="stylesheets/colorbox.css">

  <script src="javascripts/modernizr.foundation.js"></script>
  
  

  <!-- IE Fix for HTML5 Tags -->
  <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
  
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-31296055-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
</head>
<body>

  <div class="row" id="d1">
  	<div class="nine columns" id="d1a">
  		<div class="row" id="d1a1">
  			<div class="twelve columns" id="d1a1a">
  				<img src="images/logo1.png" alt="Purnima Progressive"/>
  			</div>
  		</div>
  		<div class="row" id="d1a2">
  			<div class="twelve columns" id="d1a2a">
  				<ul>
  					<li><g:plusone size="medium"></g:plusone></li>
  					<li><a href="https://twitter.com/share" class="twitter-share-button" data-via="purnimapro" data-related="purnimapro" data-hashtags="technology">Tweet</a></li>
  					<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
  					<li id="like-button"></li>
  				</ul>
  			</div>
  		</div>
  	</div>
  	<div class="three columns" id="d1b">
  		<div class="row" id="d1b1">
  			<div class="twelve columns" id="d1b1a">
  				<ul>
  					<li><a href="http://www.facebook.com/purnimapro" class="fc-webicon facebook small">Like us on Facebook</a></li>
  					<li><a href="http://twitter.com/#!/purnimapro" class="fc-webicon twitter small">Follow us on Twitter</a></li>
  					<li><a href="http://www.youtube.com/user/purnimapro" class="fc-webicon youtube small">View us on Youtube</a></li>
  					<li><a href="http://plus.google.com/109561002530709472999" class="fc-webicon googleplus small">Connect with us on Google Plus</a></li>
  				</ul>
  			</div>
  		</div>
  		<div class="row" id="d1b2">
  			<div class="twelve columns" id="d1b2a">
  				<ul>
  					<li><a href="http://www.purnimapro.com/enquiry.php" title="Enquiry">Enquiry</a></li>
  					<li><a href="http://www.purnimapro.com/contact.php" title="Contact">Contact</a></li>
  					<li><a href="http://www.purnimapro.com/careers.html" title="Careers">Careers</a></li>
  				</ul>
  			</div>
  		</div>
  		<div class="row" id="d1b3">
  			<div class="twelve columns" id="d1b3a">
  				<iframe src="http://www.google.com/talk/service/badge/Show?tk=z01q6amlq0v27fmmfl7bcppcng2n70qn78md381r59mti3evsvbnhlp81j0efp0krf0mjkbh9ad1udfulpj2sokhqpe7i5udivuonddcf9j3mp8as95b52s222vs5o9arv6c059p97vaf3dejcsnfmnt0girpl36mqm8ijl62h2gq3to71lafj07jlcar66rons&amp;w=200&amp;h=60" frameborder="0" allowtransparency="true" width="200" height="60"></iframe>
  			</div>
  		</div>
  	</div>
  </div>
  <div class="row" id="d2">
<ul id="menu">
	<li><a href="http://www.purnimapro.com/index.html" title="Home">Home</a></li>
	<li>
		<a href="http://www.purnimapro.com/about.html" title="About">About</a>
			<ul>
        		<li><a href="http://www.purnimapro.com/spendless.html" title="Spend Less">Spend Less</a></li>
        		<li><a href="http://www.purnimapro.com/addvalue.html" title="Add Value">Add Value</a></li>
        		<li><a href="http://www.purnimapro.com/pedi.html" title="Purnima Entrepreneurship Development Initiative">PEDI</a></li>
        		<li><a href="http://www.purnimapro.com/opensource.html" title="Open Source">Open Source</a></li>
        		<li><a href="http://www.purnimapro.com/sitemap.html" title="Site Map">Site Map</a></li>
        		<li><a href="http://www.purnimapro.com/demos.html" title="Demos">Demos</a></li>
        	</ul>
	</li>
	<li>
		<a href="http://www.purnimapro.com/services.html" title="Services">Services</a>
		<ul>
			<li><a href="http://www.purnimapro.com/database.html" title="Database Services">Database Services</a></li>
        	<li><a href="http://www.purnimapro.com/itconsulting.html" title="It Consulting">IT Consulting</a></li>
        	<li><a href="http://www.purnimapro.com/softdev.html" title="Software Development">Software Development</a></li>
        	<li><a href="http://www.purnimapro.com/websol.html" title="Web Solutions">Web Solutions</a></li>
        	<li><a href="http://www.purnimapro.com/ivalid.html" title="Independent Validation">Independent Validation</a></li>
        	<li><a href="http://www.purnimapro.com/digimdev.html" title="Digital Media Development">Digital Media Development</a></li>
        	<li><a href="http://www.purnimapro.com/geois.html" title="GIS">GIS</a></li>
        	<li><a href="http://www.purnimapro.com/conman.html" title="Content Management">Content Management</a></li>
        	<li><a href="http://www.purnimapro.com/mobsol.html" title="Mobile Solutions">Mobile Solutions</a></li>
        	<li><a href="http://www.purnimapro.com/closol.html" title="Cloud Solutions">Cloud Solutions</a></li>
        	<li><a href="http://www.purnimapro.com/bposerv.html" title="BPO">BPO</a></li>
		</ul>
	</li>
	<li>
		<a href="http://www.purnimapro.com/solutions.html" title="Solutions">Solutions</a>
		<ul>
			<li><a href="http://www.purnimapro.com/communication.html" title="Communication">Communication</a></li>
        	<li><a href="http://www.purnimapro.com/healthcare.html" title="Healthcare">Healthcare</a></li>
        	<li><a href="http://www.purnimapro.com/telehealth.html" title="Tele-Healthcare">Tele-Healthcare</a></li>
        	<li><a href="http://www.purnimapro.com/mobile.html" title="Mobile">Mobile</a></li>
        	<li><a href="http://www.purnimapro.com/accounts.html" title="Accounting">Accounting</a></li>
        	<li><a href="http://www.purnimapro.com/eticket.html" title="Barcode ETicket">E-Ticketing</a></li>
		</ul>
	</li>
	<li>
		<a href="http://www.purnimapro.com/contact.html" title="Contact">Contact</a>
		<ul>
        	<li><a href="http://www.purnimapro.com/contact.php" title="Contact">Contact</a></li>
        	<li><a href="http://www.purnimapro.com/enquiry.php" title="Enquiry">Enquiry</a></li>
        	<li><a href="http://www.purnimapro.com/careers.html" title="Careers">Careers</a>
        		<ul>
        			<li><a href="http://www.purnimapro.com/jobseek.php" title="Job Seekers">Job Seekers</a></li>
        			<li><a href="http://www.purnimapro.com/plagency.php" title="Placement Agencies">Placement Agencies</a></li>
        		</ul>
        	</li>
		</ul>
	</li>
</ul>
  </div>
  <div class="row" id="lpd1">
  	<div class="twelve columns" id="lpd1a">
  		<h4>Google Charts Demo</h4>
  		<br />
  		<br />
  		<h5>Pie Chart</h5>
  		<?php
  			
  			include 'gchart/gChart.php';
  			$pichart = new gPieChart();
			$pichart->addDataSet(array(112,315,66,40));
			$pichart->setLegend(array("first", "second", "third","fourth"));
			$pichart->setLabels(array("first", "second", "third","fourth"));
			$pichart->setColors(array("ff3344", "11ff11", "22aacc", "3333aa"));
  		?>
  		<img src="<?php print $pichart->getUrl();  ?>" />
  		<br />
  		<br />
  		<h5>3D Pie Chart</h5>
  		<?php
			$pie3dChart = new gPie3DChart();
			$pie3dChart->addDataSet(array(112,315,66,40));
			$pie3dChart->setLegend(array("first", "second", "third","fourth"));
			$pie3dChart->setLabels(array("first", "second", "third","fourth"));
			$pie3dChart->setColors(array("ff3344", "11ff11", "22aacc", "3333aa"));
		?>
		<img src="<?php print $pie3dChart->getUrl();  ?>" />
		<br />
  		<br />
  		<h5>Concentric Pie Chart</h5>
  		<?php
			$CPChart = new gConcentricPieChart();
			$CPChart->addDataSet(array(112,315,66,40));
			$CPChart->addDataSet(array(100,235,346,50));
			$CPChart->addColors(array("008800", "880000"));
			$CPChart->addColors(array("000088", "888800"));
			$CPChart->addLegend(array('1', '2', '3', '4'));
			$CPChart->addLegend(array('1a', '2a', '3a', '4a'));
		?>
		<img src="<?php print $CPChart->getUrl();  ?>" />
		<br />
  		<br />
  		<h5>Line Chart</h5>
  		<?php
			$lineChart = new gLineChart(300,300);
			$lineChart->addDataSet(array(112,315,66,40));
			$lineChart->addDataSet(array(212,115,366,140));
			$lineChart->addDataSet(array(112,95,116,140));
			$lineChart->setLegend(array("first", "second", "third","fourth"));
			$lineChart->setColors(array("ff3344", "11ff11", "22aacc", "3333aa"));
			$lineChart->setVisibleAxes(array('x','y'));
			$lineChart->setDataRange(30,400);
			$lineChart->addAxisRange(0, 1, 4, 1);
			$lineChart->addAxisRange(1, 30, 400);
			$lineChart->addBackgroundFill('bg', 'EFEFEF');
			$lineChart->addBackgroundFill('c', '000000');
		?>
		<img src="<?php print $lineChart->getUrl();  ?>" />
		<br />
  		<br />
  		<h5>Line Chart with Strip Fill</h5>
  		<?php
			$lineChart = new gLineChart(300,300);
			$lineChart->addDataSet(array(112,315,66,40));
			$lineChart->addDataSet(array(212,115,366,140));
			$lineChart->addDataSet(array(112,95,116,140));
			$lineChart->setLegend(array("first", "second", "third","fourth"));
			$lineChart->setColors(array("ff3344", "11ff11", "22aacc", "3333aa"));
			$lineChart->setVisibleAxes(array('x','y'));
			$lineChart->setDataRange(30,400);
			$lineChart->addAxisLabel(0, array("This", "axis", "has", "labels!"));
			$lineChart->addAxisRange(1, 30, 400);
			$lineChart->setStripFill('bg',0,array('CCCCCC',0.15,'FFFFFF',0.1));
		?>
		<img src="<?php print $lineChart->getUrl();  ?>" />
		<br />
  		<br />
  		<h5>Line Chart with Line Fill</h5>
  		<?php
			$lineChart = new gLineChart(300,300);
			$lineChart->addDataSet(array(112,125,66,40));
			$lineChart->setLegend(array("first"));
			$lineChart->setColors(array("ff3344"));
			$lineChart->setVisibleAxes(array('x','y'));
			$lineChart->setDataRange(30,130);
			$lineChart->addAxisRange(0, 1, 4, 1);
			$lineChart->addAxisRange(1, 30, 130);
			$lineChart->addLineFill('B','76A4FB',0,0);
		?>
		<img src="<?php print $lineChart->getUrl();  ?>" />
		<br />
  		<br />
  		<h5>Line Chart with Grid Lines</h5>
  		<?php
			$lineChart = new gLineChart(300,300);
			$lineChart->addDataSet(array(112,315,66,40));
			$lineChart->addDataSet(array(212,115,366,140));
			$lineChart->addDataSet(array(112,95,116,140));
			$lineChart->setLegend(array("first", "second", "third","fourth"));
			$lineChart->setColors(array("ff3344", "11ff11", "22aacc", "3333aa"));
			$lineChart->setVisibleAxes(array('x','y'));
			$lineChart->setDataRange(0,400);
			$lineChart->addAxisRange(0, 1, 4, 1);
			$lineChart->addAxisRange(1, 0, 400);
			$lineChart->setGridLines(33,10);
		?>
		<img src="<?php print $lineChart->getUrl();  ?>" />
		<br />
  		<br />
  		<h5>Grouped Bar Chart</h5>
  		<?php
			$barChart = new gBarChart(500,150,'g');
			$barChart->addDataSet(array(112,315,66,40));
			$barChart->addDataSet(array(212,115,366,140));
			$barChart->addDataSet(array(112,95,116,140));
			$barChart->setColors(array("ff3344", "11ff11", "22aacc"));
			$barChart->setLegend(array("first", "second", "third"));
			$barChart->setGradientFill('c',0,array('FFE7C6',0,'76A4FB',1));
			$barChart->setAutoBarWidth();
		?>
		<img src="<?php print $barChart->getUrl();  ?>" />
		<br />
  		<br />
  		<h5>Horizontal Grouped Bar Chart</h5>
  		<?php
			$barChart = new gBarChart(150,500,'g','h');
			$barChart->addDataSet(array(112,315,66,40));
			$barChart->addDataSet(array(212,115,366,140));
			$barChart->addDataSet(array(112,95,116,140));
			$barChart->setColors(array("ff3344", "11ff11", "22aacc"));
			$barChart->setLegend(array("first", "second", "third"));
			$barChart->setGradientFill('c',0,array('FFE7C6',0,'76A4FB',1));
			$barChart->setLegend(array("fourth", "fifth", "sixth"));
		?>
		<img src="<?php print $barChart->getUrl();  ?>" />
		<br />
  		<br />
  		<h5>Stacked Bar Chart</h5>
  		<?php
			$barChart = new gStackedBarChart(450,350);
			$barChart->addDataSet(array(112,315,66,40));
			$barChart->addDataSet(array(212,115,366,140));
			$barChart->addDataSet(array(112,95,116,140));
			$barChart->setLegend(array("first", "second", "third","fourth"));
			$barChart->setColors(array("ff3344", "11ff11", "22aacc", "3333aa"));
			$barChart->setTitle("A multiline\r\nA Title");
		?>
		<img src="<?php print $barChart->getUrl();  ?>" />
		<br />
  		<br />
  		<h5>Horizontal Stacked Bar Chart</h5>
  		<?php
			$barChart->setHorizontal(true);
			$barChart->groupSpacerWidth = 10;
		?>
		<img src="<?php print $barChart->getUrl();  ?>" />
		<br />
  		<br />
  		<h5>Venn Diagram</h5>
  		<?php
			$vennDiagram = new gVennDiagram();
			$vennDiagram->setSizes(1120,3150);
			$vennDiagram->setIntersections(220, 320);
			$vennDiagram->setEncodingType('s');
			$vennDiagram->setColors(array("ff3344", "11ff11", "22aacc", "3333aa"));
		?>
		<img src="<?php print $vennDiagram->getUrl();  ?>" />
		<br />
  		<br />
  		<h5>Venn Diagram</h5>
  		<?php
			$vennDiagram = new gVennDiagram();
			$vennDiagram->setSizes(20, 20, 20);
			$vennDiagram->setIntersections(0, 4, 6, 2);
			$vennDiagram->setColors(array("ff3344", "11ff11", "22aacc", "3333aa"));
		?>
		<img src="<?php print $vennDiagram->getUrl();  ?>" />
		<br />
  		<br />
  		<h5>Latex Formula</h5>
  		<?php
			$latex = new gFormula();
			$latex -> setLatexCode('\cos(x)^2+\sin(x)^2=1');
		?>
		<img src="<?php print $latex->getUrl();  ?>" />
		<br />
  		<br />
  		<h5>QR Code</h5>
  		<?php
			$qr = new gQRCode();
			$qr -> setQRCode('Purnima');
		?>
		<img src="<?php print $qr->getUrl();  ?>" />
		<br />
  		<br />
  		<h5>Google-o-Meter</h5>
  		<?php
			$meter = new gMeterChart();
			$meter -> addDataSet(array(10, 50, 90));
			$meter -> setColors(array('FFFFFF','000000'));
		?>
		<img src="<?php print $meter->getUrl();  ?>" />
		<br />
  		<br />
  		<h5>Map Chart</h5>
  		<?php
			$map = new gMapChart();
			$map -> setZoomArea('usa');
			$map -> setStateCodes(array('CA', 'TX', 'NY', 'UT', 'NV'));
			$map -> addDataSet(array(23, 32, 12, 54, 23));
			$map -> setColors('342544', array('BE3481','34BE12'));
		?>
		<img src="<?php print $map->getUrl();  ?>" />
		<br />
  		<br />
  		<h5>Scatter Chart</h5>
  		<?php
			$scatter = new gScatterChart();
			$scatter -> addDataSet(array(12,87,75,41,23,96,68,71,34,9));
			$scatter -> addDataSet(array(98,60,27,34,56,79,58,74,18,76));
			$scatter -> addValueMarkers('d','FF0000',0,-1,15);
			$scatter -> setVisibleAxes(array('x','y'));
			$scatter -> addAxisRange(0, 0, 100);
			$scatter -> addAxisRange(1, 0, 100);
		?>
		<img src="<?php print $scatter->getUrl();  ?>" />
		<br />
  		<br />
  		<h5>Grouped Bar Chart</h5>
  		<?php
			$barChart = new gBarChart(250,250,'s');
			$barChart->addDataSet(array(0,10,20,30,20,70,80));
			$barChart->addDataSet(array(0,20,10,5,20,30,10));
			$barChart->addHiddenDataSet(array(10,0,20,15,60,40,30));
			$barChart->addValueMarkers('D','76A4FB',2,0,3);
			$barChart->setAutoBarWidth();
		?>
		<img src="<?php print $barChart->getUrl();  ?>" />
		<br />
  		<br />
  		<h5>Candlestick Chart</h5>
  		<?php
			$candlestick = new gLineChart(200,125);
			$candlestick -> addDataSet(array(90,80,70,50,40,30,20,10));
			$candlestick -> addHiddenDataSet(array(0,5,10,0,5,10,0));
			$candlestick -> addHiddenDataSet(array(2,15,20,5,15,40,0));
			$candlestick -> addHiddenDataSet(array(5,35,20,2,35,20,0));
			$candlestick -> addHiddenDataSet(array(15,40,30,15,40,50,0));
			$candlestick -> addValueMarkers('F','000000',1,'1:-2',20);
			$candlestick -> setVisibleAxes(array('y'));
			$candlestick -> addAxisRange(0, 0, 100);
		?>
		<img src="<?php print $candlestick->getUrl();  ?>" />
  	</div>
  </div>
  <div class="row" id="lpd2">
  	<div class="twelve columns" id="lpd2a">
  		<a href="http://www.purnimapro.com/remoin.php?sub=dVvL9qkRWAwtjqb9o_ubH1Ml-ptmTp1oaJDo_Bf6MWY" title="Purnima Progressive : Request more information">Request more information</a>
  	</div>
  </div>
  <div class="row" id="d5">
  	<div class="three columns" id="d5a">
  		<ul>
        	<li><a href="http://www.purnimapro.com/index.html" title="Home">Home</a></li>
        	<li><a href="http://www.purnimapro.com/about.html" title="About">About</a></li>
        	<li><a href="http://www.purnimapro.com/spendless.html" title="Spend Less">Spend Less</a></li>
        	<li><a href="http://www.purnimapro.com/addvalue.html" title="Add Value">Add Value</a></li>
        	<li><a href="http://www.purnimapro.com/pedi.html" title="Purnima Entrepreneurship Development Initiative">PEDI</a></li>
        	<li><a href="http://www.purnimapro.com/opensource.html" title="Open Source">Open Source</a></li>
        	<li><a href="http://www.purnimapro.com/demos.html" title="Demos">Demos</a></li>
        </ul>
  	</div>
  	<div class="three columns" id="d5b">
  		 <ul>
        	<li><a href="http://www.purnimapro.com/services.html" title="Services">Services</a></li>
        	<li><a href="http://www.purnimapro.com/database.html" title="Database Services">Database Services</a></li>
        	<li><a href="http://www.purnimapro.com/itconsulting.html" title="It Consulting">IT Consulting</a></li>
        	<li><a href="http://www.purnimapro.com/softdev.html" title="Software Development">Software Development</a></li>
        	<li><a href="http://www.purnimapro.com/websol.html" title="Web Solutions">Web Solutions</a></li>
        	<li><a href="http://www.purnimapro.com/ivalid.html" title="Independent Validation">Independent Validation</a></li>
        	<li><a href="http://www.purnimapro.com/digimdev.html" title="Digital Media Development">Digital Media Development</a></li>
        	<li><a href="http://www.purnimapro.com/geois.html" title="GIS">GIS</a></li>
        	<li><a href="http://www.purnimapro.com/conman.html" title="Content Management">Content Management</a></li>
        	<li><a href="http://www.purnimapro.com/mobsol.html" title="Mobile Solutions">Mobile Solutions</a></li>
        	<li><a href="http://www.purnimapro.com/closol.html" title="Cloud Solutions">Cloud Solutions</a></li>
        	<li><a href="http://www.purnimapro.com/bposerv.html" title="BPO">BPO</a></li>
        </ul>
  	</div>
  	<div class="three columns" id="d5c">
  		<ul>
        	<li><a href="http://www.purnimapro.com/solutions.html" title="Solutions">Solutions</a></li>
        	<li><a href="http://www.purnimapro.com/communication.html" title="Communication">Communication</a></li>
        	<li><a href="http://www.purnimapro.com/healthcare.html" title="Healthcare">Healthcare</a></li>
        	<li><a href="http://www.purnimapro.com/telehealth.html" title="Tele-Healthcare">Tele-Healthcare</a></li>
        	<li><a href="http://www.purnimapro.com/mobile.html" title="Mobile">Mobile</a></li>
        	<li><a href="http://www.purnimapro.com/accounts.html" title="Accounting">Accounting</a></li>
        	<li><a href="http://www.purnimapro.com/eticket.html" title="Barcode ETicket">E-Ticketing</a></li>
        </ul>
  	</div>
  	<div class="three columns" id="d5d">
  		<ul>
        	<li><a href="http://www.purnimapro.com/contact.php" title="Contact">Contact</a></li>
        	<li><a href="http://www.purnimapro.com/enquiry.php" title="Enquiry">Enquiry</a></li>
        	<li><a href="http://www.purnimapro.com/careers.html" title="Careers">Careers</a></li>
        </ul>
  	</div>
  </div>
  <div class="row" id="d6">
  	<div class="eight columns" id="d6a">
  		<img src="images/logofooter.png" />
  		<p>&copy; 2012-2013 Purnima Progressive. All Rights Reserved</p>
  	</div>
  	<div class="four columns" id="d6b">
  		<ul>
        	<li><a href="http://www.purnimapro.com/terms.html" title="Terms Of Use">Terms of Use</a></li>
        	<li><a href="http://www.purnimapro.com/privacy.html" title="Privacy Policy">Privacy Policy</a></li>
        	<li><a href="http://www.purnimapro.com/sitemap.html" title="Site Map">Site Map</a></li>
        </ul>
  	</div>
  </div>
  <!-- Included JS Files (Uncompressed) -->
  <!--
  
  <script src="javascripts/jquery.js"></script>
  
  <script src="javascripts/jquery.foundation.mediaQueryToggle.js"></script>
  
  <script src="javascripts/jquery.foundation.forms.js"></script>
  
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
  <script src="javascripts/jquery.js"></script>
  <script src="javascripts/foundation.min.js"></script>
  
  <!-- Initialize JS Plugins -->
  <script src="javascripts/app.js"></script>
  
  <!-- Menu -->
  <script src="javascripts/menu.js"></script>
  
  <!-- Colorbox-->
  <script src="javascripts/jquery.colorbox.js"></script>
  
  
  <script>
    $(window).load(function(){
      $("#d3a").orbit({
      	animation: 'fade',
      	animationSpeed: 1200,
      	directionalNav: false,
      });
    });
    </script> 
    
    <script>
			$(document).ready(function(){
				$(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
			});
		</script>
   
<script type="text/javascript">
$(function(){
$('<iframe scrolling="no" frameborder="0" style="border: none; width: 300px; height: 20px;'+
'" src="http://www.facebook.com/plugins/like.php?href='+
encodeURIComponent(location.href)+
'"></iframe>').appendTo('#like-button')
})
</script>

</body>
</html>
