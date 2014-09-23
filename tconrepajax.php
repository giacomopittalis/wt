<?php
    include 'tconrepclass.php';
	$obj = new tconrep;
	
	if (isset($_GET['clid'])){
		
		$clid = $_GET['clid'];
		
		$obj->printcurloclist($clid);
	}
?>