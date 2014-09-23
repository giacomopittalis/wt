<?php
    include 'edithconsultclass.php';
	$obj = new edithconsult;
	
	if (isset($_GET['clid']) && isset($_GET['locid'])){
		
		$clid = $_GET['clid'];
		$locid = $_GET['locid'];
		
		$obj->printcurhclist($clid, $locid);
	}
?>