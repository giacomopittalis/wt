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

            
            $connection = mysqli_connect($host, $user, $pw, $db);
            $result = mysqli_query($connection, "SELECT * from icdump where icid='1'");  
            $row_cnt = $result->num_rows;

           while($row = mysqli_fetch_array($result))   {            
            $name=$row['name'];
            $value=$row['value'];
            $value=$obj1->decode($value);
            
echo "Name= $name Value= $value";
            
            echo "<br>";
           }
       
?>