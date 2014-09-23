<?php
    include 'mlconrepclass.php';
	$obj = new mlconrep;
	
	if (isset($_GET['clid'])){
		
		$clid = $_GET['clid'];
		
		$obj->printcurloclist($clid);
	}
?>