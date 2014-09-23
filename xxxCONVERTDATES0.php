<?php
//session_start();
//include 'sessionclass.php';
//include 'clconclass.php';
//include 'xxxfunctions.php';
//$obj = new session;
//$seadminguide = $obj->seadminguide();
//$obj1 = new clcon;
//
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

?>
  

<?php 
// yyyy-mm-dd
$connection = mysqli_connect($host, $user, $pw, $db);
$result = mysqli_query($connection, "SELECT * from contact order by id");  
$row_cnt = $result->num_rows;

echo "<br>Total employee dob: $row_cnt<br>";
while($row = mysqli_fetch_array($result))   {
$dob=$row['dat'];
$id=$row['id'];
$dob_d = $obj1->decode($dob);
echo "$id) $dob - ";

echo $dob_d."<br>";

$result2 = mysqli_query($connection, "UPDATE contact SET dat='$dob_d' WHERE id='$id'");  
}           
echo "<br><br><br>";       
?>