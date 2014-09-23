<?php
    include 'conperempclass.php';
	$obj = new conperemp;
	
	if (isset($_GET['clid'])){
		
		$clid = $_GET['clid'];
		
		$obj->printcurloclist($clid);
	}
?>