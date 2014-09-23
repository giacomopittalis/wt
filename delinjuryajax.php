<?php
    include 'delinjuryclass.php';
	$obj = new delinjury;
	
	if (isset($_GET['bpid'])){
		
		$bpid = $_GET['bpid'];
		
		$obj->printijlist($bpid);
	}
?>