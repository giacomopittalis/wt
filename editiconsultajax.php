<?php
    include 'editiconsultclass.php';
	$obj = new editiconsult;
	
	if (isset($_GET['clid'])){
		
		$clid = $_GET['clid'];
		
		$obj->printcurloclist($clid);
	   }
?>