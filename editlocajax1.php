<?php
    include 'editlocclass.php';
	$obj = new editloc;
	
	if (isset($_GET['locid1'])){
		
		$locid = $_GET['locid1'];
		
		$res = $obj->getjsonarr($locid);
		
		$jsonarr = json_encode($res, 1);
		
		echo $jsonarr;
	}
?>