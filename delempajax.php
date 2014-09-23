<?php
    include 'delempclass.php';
	$obj = new delemp;
	
	if (isset($_GET['clid']) && isset($_GET['locid'])){
		
		$clid = $_GET['clid'];
		$locid = $_GET['locid'];
		
		$obj->printcuremplist($clid, $locid);
	}
?>