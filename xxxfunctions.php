<?php
$host = "welltrail.cg1maemtimf4.us-west-2.rds.amazonaws.com";
$user= "welltrail";
$pw="w3lltra1l";
$db="welltrail";


function clientIdToName ($id) {
    global $host, $user, $pw, $db;
    $connection = mysqli_connect($host, $user, $pw, $db);
    $result = mysqli_query($connection, "SELECT clname from client where id='$id'");    
    while($row = mysqli_fetch_array($result))   {
    $clientname=$row['clname'];
    return $clientname;
    }
}

function locationIdToName ($id) {
    global $host, $user, $pw, $db;
    $connection = mysqli_connect($host, $user, $pw, $db);
    $result = mysqli_query($connection, "SELECT locid from clientloc where id='$id'");    
    while($row = mysqli_fetch_array($result))   {
    $locationname=$row['locid'];
    return $locationname;
    }
}

function getage($id) {
    global $host, $user, $pw, $db;
    $connection = mysqli_connect($host, $user, $pw, $db);
    $result = mysqli_query($connection, "SELECT dob from employee where id='$id'"); 
    while($row = mysqli_fetch_array($result))   {
    $dob=$row['dob'];
    }
    $dobarr = explode("/", $dob);
    $age = (date("md", date("U", mktime(0, 0, 0, $dobarr[0], $dobarr[1], $dobarr[2]))) > date("md") ? ((date("Y")-$dobarr[2])-1):(date("Y")-$dobarr[2]));
    return $age;
    }

?>
 