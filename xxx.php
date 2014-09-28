<?php
session_start();
include 'sessionclass.php';
include 'clconclass.php';
include 'xxxfunctions.php';
$obj = new session;
$seadminguide = $obj->seadminguide();
$obj1 = new clcon;
?>
<?php
$xxx = "Darla";
$xxx = $obj1->encode($xxx);
echo "Encoded: $xxx";
$yyy="_075xfZZXI4icnPVd9bV_SI6duxAise_aV71KeY28Jw";
$xxx = $obj1->decode($yyy);
echo "<br>Decoded: $xxx";
?>

									