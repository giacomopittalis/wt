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
header('Content-type: application/vnd.ms-excel');
    header("Content-Disposition: attachment; filename=download.xls");
    header("Pragma: no-cache");
    header("Expires: 0"); 
?>
  

<?php 
$query=$_GET['query'];

            $connection = mysqli_connect($host, $user, $pw, $db);
  
            
            $result = mysqli_query($connection, $query);  
            $row_cnt = $result->num_rows;
       
            

          $table="<table>";               
     $table.="<tr><td>CONTACT DATE</td><td>EMPLOYER NAME</td><td>EMPLOYER LAST NAME</td></tr>";      
            while($row = mysqli_fetch_array($result))   {
                $contact_date=$row['dat'];
                $employer_name=$row['fname'];              
                $employer_name=$obj1->decode($employer_name);
                $employer_lname=$row['lname'];  
                $employer_lname=$obj1->decode($employer_lname);
               $table.="<tr><td>$contact_date</td><td>$employer_name</td><td>$employer_lname</td></tr>";
    }
     $table.="</table>";      
                
        echo $table;
?>