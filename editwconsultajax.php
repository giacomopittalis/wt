<?php
    include 'editwconsultclass.php';
	$obj = new editwconsult;
	
	if (isset($_GET['clid'])){
		
		$clid = $_GET['clid'];
		
		$obj->printcurloclist($clid);
	}
?>