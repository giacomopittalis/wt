<?php
    include 'workclass.php';
	$obj = new work;
		
		$res = $obj->getdump();
		
		$jsonarr = json_encode($res, 1);
		
		echo $jsonarr;
?>