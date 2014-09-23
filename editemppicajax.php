<?php
    include 'editemppicclass.php';
	$obj = new editemppic;
	
	if (isset($_GET['clid']) && isset($_GET['locid'])){
		
		$clid = $_GET['clid'];
		$locid = $_GET['locid'];
		
		$obj->printcuremplist($clid, $locid);
	}
?>