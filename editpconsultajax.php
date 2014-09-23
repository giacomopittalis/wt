<?php
    include 'editpconsultclass.php';
	$obj = new editpconsult;
	
	if (isset($_GET['clid'])){
		
		$clid = $_GET['clid'];
		
		$obj->printcurloclist($clid);
	}
?>