<?php
    include 'mconrepclass.php';
	$obj = new mconrep;
	
	if (isset($_GET['clid'])){
		
		$clid = $_GET['clid'];
		
		$obj->printcurloclist($clid);
	}
?>