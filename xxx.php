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
$yyy="2iHvJjviiP02tOgRjJ1llO1gGvUOlCWiTMpMqVVPwzs";
$xxx = $obj1->decode($yyy);
echo "<br>Decoded: $xxx";
?>

									