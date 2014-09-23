<?php
session_start();
include 'sessionclass.php';
include 'clconclass.php';
$obj = new session;
$seadminguide = $obj->seadminguide();
$obj1 = new clcon;

$connection = mysqli_connect($dbserver, $dbusername, $dbpass, $db);
 
$selectvalue = mysqli_real_escape_string($connection, $_GET['svalue']);
 
$result = mysqli_query($connection, "SELECT * FROM subtopic where topicid='$selectvalue'");
 
echo '<option value="">Please select...</option>';
while($row = mysqli_fetch_array($result))   {
$locid=$row['subtopic'];
//$locid = $obj1->decode($locid);

    echo '<option value="'.$row['id'].'">' . $locid . "</option>";
    //echo $row['drink_type'] ."<br/>";
  }
 
mysqli_free_result($result);
mysqli_close($connection);
 ?>