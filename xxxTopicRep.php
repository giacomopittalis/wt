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
$query="SELECT * from hcdump where name='nmmxIF' and value='nMQmcLU9hvGdFiaQdsr_mcCJqSt4ndrSfR3aPpurN94'";

            $connection = mysqli_connect($host, $user, $pw, $db);
  
            
            $result = mysqli_query($connection, $query);  
            $row_cnt = $result->num_rows;
       
            
echo $row_cnt;
                      
   ?>  