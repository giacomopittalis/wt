<?php
    include 'editempclass.php';
	$obj = new editemp;
	
	if (isset($_GET['clid']) && isset($_GET['locid'])){
		
		$clid = $_GET['clid'];
		$locid = $_GET['locid'];
		
		$obj->printcuremplist($clid, $locid);
	}
?>