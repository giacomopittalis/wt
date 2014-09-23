<?php
    include 'editwconsultclass.php';
	$obj = new editwconsult;
	
	if (isset($_GET['wcid'])){
		
		$ocid = $_GET['wcid'];
		
		$res = $obj->getwcdump($wcid);
		
		$jsonarr = json_encode($res, 1);
		
		echo $jsonarr;
	}
?>