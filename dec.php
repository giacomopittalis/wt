<?php
	include 'decclass.php';
?>
<!DOCTYPE html>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8" />

  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width" />

  <title>Wellness - Decode</title>
  
  <!-- Included CSS Files (Uncompressed) -->
  <!--
  <link rel="stylesheet" href="stylesheets/foundation.css">
  -->
  
  <!-- Included CSS Files (Compressed) -->
  <link rel="stylesheet" href="stylesheets/foundation.min.css">
  <link rel="stylesheet" href="stylesheets/app.css">

  <script src="javascripts/modernizr.foundation.js"></script>
  
  <?php
  	$obj = new dec;
	$tbsta = "";
	$e = 0;
    $dtb = "";
	
	if (isset($_POST['sub1'])){
		
		//Get input
		$tb = $_POST['tb'];
        
        if ($tb == ""){
            $tbsta = "Text box cannot be empty";
            $e++;
        }
		
		//All is well
		if ($e == 0){
		    $dtb = $obj->decy($tb);
		}
	}
  ?>
</head>
<body><?php include('header.php'); ?> 
	
	<div class="row" id="container1">
		<div class="twelve columns" id="container1a">
			<div class="row" id="head1">
				<div class="twelve columns" id="head1a">
					<br />
					<br />
				</div>
			</div>
			<div class="row" id="contentunlk5">
				<div class="four columns centered" id="contentunlk5a">
					<form name="frmunlock" id="unlockfrom" action="dec.php" method="post">
						<fieldset>
							<legend>Decode</legend>
							<div class="row" id="unlk1">
								<div class=" twelve columns" id="unlk1a">
									<input type="text" name="tb" id="txt1" tabindex="1" maxlength="60" placeholder="Encoded Text" />
									<br />
									<br />
								</div>
							</div>
							<div class="row" id="unlk5">
								<div class=" twelve columns" id="unlk5a">
									<?php print $tbsta; ?>
								</div>
							</div>
							<div class="row" id="unlk2">
								<div class=" twelve columns" id="unlk2a">
									<input type="submit" name="sub1" id="but1" tabindex="2" class="success button" value="Decode" />
								</div>
							</div>
							<div class="row" id="unlk3">
								<div class=" twelve columns" id="unlk3a">
									<label class="unlksta"><?php print $dtb; ?></label>
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
