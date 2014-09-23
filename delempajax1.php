<?php
    include 'delempclass.php';
	$obj = new delemp;
	
	if (isset($_GET['clid'])){
		
		$clid = $_GET['clid'];
		
		$obj->printcurloclist($clid);
	}
?>