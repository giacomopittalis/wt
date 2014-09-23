<?php
    include 'delegrclass.php';
	$obj = new delegr;
	
	if (isset($_GET['clid'])){
		
		$clid = $_GET['clid'];
		
		$obj->printlinkedguidelist($clid);
	}
?>