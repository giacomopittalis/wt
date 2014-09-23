<?php
    include 'crsubtopicclass.php';
	$obj = new crsubtopic;
	
	if (isset($_GET['constypeid'])){
		
		$constypeid = $_GET['constypeid'];
		
		$obj->printtopiclist($constypeid);
	}
?>