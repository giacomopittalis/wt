<?php
    include 'editpconsultclass.php';
	$obj = new editpconsult;
	
	if (isset($_GET['pcid'])){
		
		$pcid = $_GET['pcid'];
		
		$res = $obj->getpcdump($pcid);
		
		$jsonarr = json_encode($res, 1);
		
		echo $jsonarr;
	}
?>