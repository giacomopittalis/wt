<?php
    include 'delsubtopicclass.php';
	$obj = new delsubtopic;
	
	if (isset($_GET['constypeid'])){
		
		$constypeid = $_GET['constypeid'];
		
		$obj->printtopiclist($constypeid);
	}
?>