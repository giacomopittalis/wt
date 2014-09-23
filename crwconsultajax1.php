<?php
    include 'crwconsultclass.php';
	$obj = new crwconsult;
	
	if (isset($_GET['clid']) && isset($_GET['locid'])){
		
		$clid = $_GET['clid'];
		$locid = $_GET['locid'];
		
		$obj->printcurconlist($clid, $locid);
	}
?>