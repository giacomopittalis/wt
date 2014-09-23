<?php
    include 'editiconsultclass.php';
	$obj = new editiconsult;
	
	if (isset($_GET['bpid'])){
		
		$bpid = $_GET['bpid'];
		
		$obj->printijlist($bpid);
	}
?>