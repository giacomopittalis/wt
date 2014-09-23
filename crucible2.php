<?php
    include 'crucible2class.php';
?>
<!DOCTYPE html>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8" />

  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width" />

  <title>Wellness - Crucible</title>
  
  <!-- Included CSS Files (Uncompressed) -->
  <!--
  <link rel="stylesheet" href="stylesheets/foundation.css">
  -->
  
  <!-- Included CSS Files (Compressed) -->
  <link rel="stylesheet" href="stylesheets/foundation.min.css">
  <link rel="stylesheet" href="stylesheets/app.css">

  <script src="javascripts/modernizr.foundation.js"></script>
  
  <?php
    $obj = new crucible2;
    $outsta = "";
    
    if (isset($_POST['sub1'])){
        
        
            $res = $obj->inscru();
            if ($res){
                $outsta = "Crucible data successfully inserted";
            }
            else{
                $outsta = "Could not insert Crucible data";
            }
        
        //All is well
        
    }
  ?>
</head>
<body>
    
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
                    <form name="frmunlock" id="unlockfrom" action="crucible2.php" method="post">
                        <fieldset>
                            <legend>Crucible</legend>
                            <div class="row" id="unlk5">
                                <div class=" twelve columns" id="unlk5a">
                                    
                                </div>
                            </div>
                            <div class="row" id="unlk2">
                                <div class=" twelve columns" id="unlk2a">
                                    <input type="submit" name="sub1" id="but1" tabindex="1" class="success button" value="Insert" />
                                </div>
                            </div>
                            <div class="row" id="unlk3">
                                <div class=" twelve columns" id="unlk3a">
                                    <label class="unlksta"><?php print $outsta; ?></label>
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