<?php
    include 'criconsultclass.php';
	$obj = new criconsult;
	
	if (isset($_GET['bpid'])){
		
		$bpid = $_GET['bpid'];
		
		$obj->printijlist($bpid);
	}
?>