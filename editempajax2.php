<?php
    include 'editempclass.php';
	$obj = new editemp;
	
	if (isset($_GET['empid'])){
		
		$empid = $_GET['empid'];
		
		$res = $obj->getjsonarr($empid);
		
		$jsonarr = json_encode($res, 1);
		
		echo $jsonarr;
	}
?>