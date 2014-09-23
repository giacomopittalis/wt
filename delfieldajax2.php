<?php
    include 'delfieldclass.php';
	$obj = new delfield;
	
	if (isset($_GET['constypeid']) && isset($_GET['topicid']) && isset($_GET['subtopicid'])){
		
		$constypeid = $_GET['constypeid'];
		$topicid = $_GET['topicid'];
		$subtopicid = $_GET['subtopicid'];
		
		$obj->printfieldlist($constypeid, $topicid, $subtopicid);
	}
?>