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
     $table.="<tr><td>CONTACT DATE</td><td>EMPLOYER NAME</td><td>EMPLOYER LAST NAME</td><td>CONTACT TYPE</td><td>U NAME</td><td>HC FOR THIS CONTACT</td><td>IC FOR THIS CONTACT</td><td>OC FOR THIS CONTACT</td><td>PC FOR THIS CONTACT</td></tr>";      
            while($row = mysqli_fetch_array($result))   {
                $contact_id=$row['contactID'];
                $contact_date=$row['dat'];
                $employer_name=$row['fname'];  
                $employer_name=$obj1->decode($employer_name);
                $employer_lname=$row['lname'];  
                $employer_lname=$obj1->decode($employer_lname);
                $employer_contype=$row['contype'];  
                $employer_contype=$obj1->decode($employer_contype); 
                $employer_uname=$row['uname'];  
                $employer_uname=$obj1->decode($employer_uname);
                
       
            
            $resultHC = mysqli_query($connection, "SELECT * from hcmain where conid='$contact_id'");  
            $row_cntHC = $resultHC->num_rows;     
            
            $resultIC = mysqli_query($connection, "SELECT * from icmain where conid='$contact_id'");  
            $row_cntIC = $resultIC->num_rows;               
                
            $resultOC = mysqli_query($connection, "SELECT * from ocmain where conid='$contact_id'");  
            $row_cntOC = $resultOC->num_rows;                
 
             $resultPC = mysqli_query($connection, "SELECT * from pcmain where conid='$contact_id'");  
            $row_cntPC = $resultPC->num_rows;                          
                
               $table.="<tr><td>$contact_date</td><td>$employer_name</td><td>$employer_lname</td><td>$employer_contype</td><td>$employer_uname</td><td>$row_cntHC</td><td>$row_cntIC</td><td>$row_cntOC</td><td>$row_cntPC</td></tr>";
    }
     $table.="</table>";      
                
        echo $table;
?>