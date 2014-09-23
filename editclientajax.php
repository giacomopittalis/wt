<?php
    include 'editclientclass.php';
	$obj = new editclient;
	
	if (isset($_GET['clid'])){
		
		$clid = $_GET['clid'];
		
		$res = $obj->getjsonarr($clid);
		
		$jsonarr = json_encode($res, 1);
		
		echo $jsonarr;
	}
?>