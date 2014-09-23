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
//header('Content-type: application/vnd.ms-excel');
//    header("Content-Disposition: attachment; filename=download.xls");
//    header("Pragma: no-cache");
//    header("Expires: 0"); 
?>
  

<?php 
$query="SELECT * from topic";

            $connection = mysqli_connect($host, $user, $pw, $db);
  
            
            $result = mysqli_query($connection, $query);  
            $row_cnt = $result->num_rows;
       
            

        $table='<table>';               
     $table.="";      
            while($row = mysqli_fetch_array($result))   {
                
                $id=$row['id'];
                $constypeid=$row['constypeid'];                
                $topic=$row['topic'];        
                
                $ttype=$row['ttype'];     ; 
                
                $tname=$row['tname'];              
                //$tname_d=$obj1->decode($tname);  
                
                $tid=$row['tid'];  
                //$tid=$obj1->decode($tid);
                
                           
                
   
               $table.="<tr><td>$id</td><td>$constypeid</td><td>$topic</td><td>$ttype</td><td>$tname</td><td>$tid</td></tr>";
    }
     $table.="</table>";      
           
                
        echo $table;
?>