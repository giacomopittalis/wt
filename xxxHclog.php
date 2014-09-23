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
$query="SELECT * from hclog";

            $connection = mysqli_connect($host, $user, $pw, $db);
  
            
            $result = mysqli_query($connection, $query);  
            $row_cnt = $result->num_rows;
       
            

        $table='<table>';               
     $table.="<tr><td>UNAME</td><td>IPADD</td><td>DTS</td><td>action</td><td>conid</td></tr>";      
            while($row = mysqli_fetch_array($result))   {
                $id=$row['id'];
                
                $uname=$row['uname'];              
                $uname=$obj1->decode($uname);
                
                $ipadd=$row['ipadd'];              
                $ipadd=$obj1->decode($ipadd);  
                
                $dts=$row['dts'];  
                $dts=$obj1->decode($dts);
                
                $action=$row['action'];
                $action=$obj1->decode($action); 
                
                $conid=$row['hcid'];               
                
   
               $table.="<tr><td>$uname</td><td>$ipadd</td><td>$dts</td><td>$action</td><td>$conid</td></tr>";
    }
     $table.="</table>";      
           
                
        echo $table;
?>