<?php
    include 'editiconsultclass.php';
	$obj = new editiconsult;
	
	if (isset($_GET['clid']) && isset($_GET['locid'])){
		
		$clid = $_GET['clid'];
		$locid = $_GET['locid'];
		
		$obj->printcuriclist($clid, $locid);
	}
?>