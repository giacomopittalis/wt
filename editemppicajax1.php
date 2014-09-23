<?php
    include 'editemppicclass.php';
	$obj = new editemppic;
	
	if (isset($_GET['clid'])){
		
		$clid = $_GET['clid'];
		
		$obj->printcurloclist($clid);
	}
?>