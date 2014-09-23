<?php
    include 'crhconsultclass.php';
	$obj = new crhconsult;
	
	if (isset($_GET['clid'])){
		
		$clid = $_GET['clid'];
		
		$obj->printcurloclist($clid);
	}
?>