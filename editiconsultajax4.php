<?php
    include 'editiconsultclass.php';
	$obj = new editiconsult;
	
	if (isset($_GET['icid'])){
		
		$icid = $_GET['icid'];
		$obj->injx($icid);
	}
?>