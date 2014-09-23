<?php
session_start();
include 'sessionclass.php';
include 'clconclass.php';
include 'xxxfunctions.php';
$obj = new session;
$seadminguide = $obj->seadminguide();
$obj1 = new clcon;

error_reporting(E_ALL);
ini_set('display_errors', 1);

?>

  

<?php 
// hcmain: id 5070 conid 6665 è uguale al contactid 6665 che ha il clientid 10 e anche empid

$connection = mysqli_connect($host, $user, $pw, $db);

$queryc="SELECT * from contact";
$resultc = mysqli_query($connection, $queryc);  
$row_cntc = $resultc->num_rows;

$queryhc="SELECT * from hcmain";
$resulthc = mysqli_query($connection, $queryhc);  
$row_cnthc = $resulthc->num_rows;

$queryic="SELECT * from icmain";
$resultic = mysqli_query($connection, $queryic);  
$row_cntic = $resultic->num_rows;

$queryoc="SELECT * from ocmain";
$resultoc = mysqli_query($connection, $queryoc);  
$row_cntoc = $resultoc->num_rows;

$querypc="SELECT * from pcmain";
$resultpc = mysqli_query($connection, $querypc);  
$row_cntpc = $resultpc->num_rows;

echo "Total contacts: ";
echo $row_cntc;
echo "<br><br>Total consults: ";
echo $row_cnthc+$row_cntic+$row_cntoc+$row_cntpc;
echo "<br>";
echo "<br>Healt consults: $row_cnthc<br>";
echo "<br>Injuri consults: $row_cntic<br>";
echo "<br>Opportunity consults: $row_cntoc<br>";
echo "<br>Proactive consults: $row_cntpc<br>";
?>