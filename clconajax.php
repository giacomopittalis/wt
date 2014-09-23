<?php
    include 'clconclass.php';
	$obj = new clcon;
	
	if (isset($_GET['clid'])){
		
		$clid = $_GET['clid'];
		
		$obj->printcurloclist($clid);
	}
?>