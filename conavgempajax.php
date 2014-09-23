<?php
    include 'conavgempclass.php';
	$obj = new conavgemp;
	
	if (isset($_GET['clid'])){
		
		$clid = $_GET['clid'];
		
		$obj->printcurloclist($clid);
	}
?>