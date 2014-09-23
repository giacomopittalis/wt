<?php
    include 'editoconsultclass.php';
	$obj = new editoconsult;
	
	if (isset($_GET['clid']) && isset($_GET['locid'])){
		
		$clid = $_GET['clid'];
		$locid = $_GET['locid'];
		
		$obj->printcuroclist($clid, $locid);
	}
?>