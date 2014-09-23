<?php
    include 'editempclass.php';
	$obj = new editemp;
	
	if (isset($_GET['clid'])){
		
		$clid = $_GET['clid'];
		
		$obj->printcurloclist($clid);
	}
?>