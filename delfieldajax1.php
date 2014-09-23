<?php
    include 'delfieldclass.php';
	$obj = new delfield;
	
	if (isset($_GET['constypeid']) && isset($_GET['topicid'])){
		
		$constypeid = $_GET['constypeid'];
		$topicid = $_GET['topicid'];
		
		$obj->printsubtopiclist($constypeid, $topicid);
	}
?>