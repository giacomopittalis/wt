<?php
    include 'crpconsultclass.php';
	$obj = new crpconsult;
	
	if (isset($_GET['clid'])){
		
		$clid = $_GET['clid'];
		
		$obj->printcurloclist($clid);
	}
?>