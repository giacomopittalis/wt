<?php
    include 'toprepclass.php';
	$obj = new toprep;
	
	if (isset($_GET['constypeid'])){
		
		$constypeid = $_GET['constypeid'];
		
		$obj->printtopiclist($constypeid);
	}
?>