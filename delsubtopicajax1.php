<?php
    include 'delsubtopicclass.php';
	$obj = new delsubtopic;
	
	if (isset($_GET['constypeid']) && isset($_GET['topicid'])){
		
		$constypeid = $_GET['constypeid'];
		$topicid = $_GET['topicid'];
		
		$obj->printsubtopiclist($constypeid, $topicid);
	}
?>