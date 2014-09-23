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
       
            

        $table='<table>';               
     $table.="<tr><td>NAME</td><td>MIDDLE NAME</td><td>LAST NAME</td><td>DATE OF BIRTH</td><td>GENDER</td><td>DEPARTMENT</td><td>POSITION</td><td>DESG</td><td>TYPE</td><td>HIRING YEAR</td><td>PHOTO</td><td>H PLAN</td><td>STATUS</td></tr>";      
            while($row = mysqli_fetch_array($result))   {
                $employer_id=$row['id'];                   
                $employer_name=$row['fname'];              
                $employer_name=$obj1->decode($employer_name);
                $employer_mname=$row['mname'];              
                $employer_mname=$obj1->decode($employer_mname);                
                $employer_lname=$row['lname'];  
                $employer_lname=$obj1->decode($employer_lname);
                $employer_dob=$row['dob'];
                $employer_gender=$row['gender'];  
                $employer_gender=$obj1->decode($employer_gender); 
                $employer_dept=$row['dept'];  
                $employer_dept=$obj1->decode($employer_dept);     
                $employer_pos=$row['pos'];  
                $employer_pos=$obj1->decode($employer_pos); 
                $employer_desg=$row['desg'];  
                $employer_desg=$obj1->decode($employer_desg); 
                $employer_type=$row['type'];  
                $employer_type=$obj1->decode($employer_type);  
                $employer_hyear=$row['hyear'];  
                $employer_hyear=$obj1->decode($employer_hyear);  
                $employer_imgpath=$row['imgpath'];  
                $employer_imgpath=$obj1->decode($employer_imgpath);
                $employer_hplan=$row['hplan'];  
                $employer_hplan=$obj1->decode($employer_hplan);  
                $employer_status=$row['status'];  
                $employer_status=$obj1->decode($employer_status);     
               $table.="<tr><td>$employer_name</td><td>$employer_mname</td><td>$employer_lname</td><td>$employer_dob</td><td>$employer_gender</td><td>$employer_dept</td><td>$employer_pos</td><td>$employer_desg</td><td>$employer_type</td><td>$employer_hyear</td><td>$employer_imgpath</td><td>$employer_hplan</td><td>$employer_status</td></tr>";
    }
     $table.="</table>";      
           
                
        echo $table;
?>