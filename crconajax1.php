<?php
    include 'crconclass.php';
	$obj = new crcon;
	
	if (isset($_GET['clid']) && isset($_GET['locid']) && isset($_GET['bulk'])){
		
		$clid = $_GET['clid'];
		$locid = $_GET['locid'];
		$bulk = $_GET['bulk'];
		
		$obj->printcuremplist($clid, $locid, $bulk);
	}
?>