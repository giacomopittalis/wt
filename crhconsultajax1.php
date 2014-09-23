<?php
    include 'crhconsultclass.php';
	$obj = new crhconsult;
	
	if (isset($_GET['clid']) && isset($_GET['locid'])){
		
		$clid = $_GET['clid'];
		$locid = $_GET['locid'];
		
		$obj->printcurconlist($clid, $locid);
	}
?>