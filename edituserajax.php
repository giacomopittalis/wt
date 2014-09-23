<?php
    include 'edituserclass.php';
	$obj = new edituser;
	
	if (isset($_GET['uname'])){
		
		$uname = $_GET['uname'];
		
		$res = $obj->getjsonarr($uname);
		
		$jsonarr = json_encode($res, 1);
		
		echo $jsonarr;
	}
?>