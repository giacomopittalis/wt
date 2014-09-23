<?php
    include 'toprepclass.php';
	$obj = new toprep;
	
	if (isset($_GET['clid'])){
		
		$clid = $_GET['clid'];
		
		$obj->printcurloclist($clid);
	}
?>