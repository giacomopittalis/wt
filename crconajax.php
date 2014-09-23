<?php
    include 'crconclass.php';
	$obj = new crcon;
	
	if (isset($_GET['clid'])){
		
		$clid = $_GET['clid'];
		
		$obj->printcurloclist($clid);
	}
?>