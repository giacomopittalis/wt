<?php
    include 'crfieldclass.php';
	$obj = new crfield;
	
	if (isset($_GET['constypeid'])){
		
		$constypeid = $_GET['constypeid'];
		
		$obj->printtopiclist($constypeid);
	}
?>