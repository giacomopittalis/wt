<?php
    include 'editwconsultclass.php';
	$obj = new editwconsult;
	
	if (isset($_GET['clid']) && isset($_GET['locid'])){
		
		$clid = $_GET['clid'];
		$locid = $_GET['locid'];
		
		$obj->printcurwclist($clid, $locid);
	}
?>