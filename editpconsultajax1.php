<?php
    include 'editpconsultclass.php';
	$obj = new editpconsult;
	
	if (isset($_GET['clid']) && isset($_GET['locid'])){
		
		$clid = $_GET['clid'];
		$locid = $_GET['locid'];
		
		$obj->printcurpclist($clid, $locid);
	}
?>