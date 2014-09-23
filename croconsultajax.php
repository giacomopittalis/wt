<?php
    include 'croconsultclass.php';
	$obj = new croconsult;
	
	if (isset($_GET['clid'])){
		
		$clid = $_GET['clid'];
		
		$obj->printcurloclist($clid);
	}
?>