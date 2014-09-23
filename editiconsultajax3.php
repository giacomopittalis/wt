<?php
    include 'editiconsultclass.php';
	$obj = new editiconsult;
	
	if (isset($_GET['icid'])){
		
		$icid = $_GET['icid'];
		
		$res = $obj->geticdump($icid);
		
		$jsonarr = json_encode($res, 1);
		
		echo $jsonarr;
	}
?>