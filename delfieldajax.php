<?php
    include 'delfieldclass.php';
	$obj = new delfield;
	
	if (isset($_GET['constypeid'])){
		
		$constypeid = $_GET['constypeid'];
		
		$obj->printtopiclist($constypeid);
	}
?>