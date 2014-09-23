<?php
    include 'edithconsultclass.php';
	$obj = new edithconsult;
	
	if (isset($_GET['clid'])){
		
		$clid = $_GET['clid'];
		
		$obj->printcurloclist($clid);
	}
?>