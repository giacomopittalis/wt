<?php
    include 'edithconsultclass.php';
	$obj = new edithconsult;
	
	if (isset($_GET['hcid'])){
		
		$hcid = $_GET['hcid'];
		
		$res = $obj->gethcdump($hcid);
		
		$jsonarr = json_encode($res, 1);
		
		echo $jsonarr;
	}
?>