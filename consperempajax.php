<?php
    include 'consperempclass.php';
	$obj = new consperemp;
	
	if (isset($_GET['clid'])){
		
		$clid = $_GET['clid'];
		
		$obj->printcurloclist($clid);
	}
?>