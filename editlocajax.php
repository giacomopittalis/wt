<?php
    include 'editlocclass.php';
	$obj = new editloc;
	
	if (isset($_GET['clid'])){
		
		$clid = $_GET['clid'];
		
		$obj->printcurloclist($clid);
	}
?>