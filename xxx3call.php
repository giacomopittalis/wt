<?php
$connection = mysqli_connect("localhost", "root", "", "welltrail");
 
$selectvalue = mysqli_real_escape_string($connection, $_GET['svalue']);
 
mysqli_select_db($connection, "db-name");
$result = mysqli_query($connection, "SELECT clname FROM client");
 
echo '<option value="">Please select...</option>';
while($row = mysqli_fetch_array($result))
  {
    echo '<option value="'.$row['drink_name'].'">' . $row['clname'] . "</option>";
    //echo $row['drink_type'] ."<br/>";
  }
 
mysqli_free_result($result);
mysqli_close($connection);
 ?>