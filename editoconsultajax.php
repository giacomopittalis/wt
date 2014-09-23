<?php
    include 'editoconsultclass.php';
	$obj = new editoconsult;
	
	if (isset($_GET['clid'])){
		
		$clid = $_GET['clid'];
		
		$obj->printcurloclist($clid);
	}
?>