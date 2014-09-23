<?php
    include 'editoconsultclass.php';
	$obj = new editoconsult;
	
	if (isset($_GET['ocid'])){
		
		$ocid = $_GET['ocid'];
		
		$res = $obj->getocdump($ocid);
		
		$jsonarr = json_encode($res, 1);
		
		echo $jsonarr;
	}
?>