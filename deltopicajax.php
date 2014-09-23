<?php
    include 'deltopicclass.php';
	$obj = new deltopic;
	
	if (isset($_GET['constypeid'])){
		
		$constypeid = $_GET['constypeid'];
		
		$obj->printtopiclist($constypeid);
	}
?>