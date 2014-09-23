<?php
    include 'crwconsultclass.php';
	$obj = new crwconsult;
	
	if (isset($_GET['clid'])){
		
		$clid = $_GET['clid'];
		
		$obj->printcurloclist($clid);
	}
?>