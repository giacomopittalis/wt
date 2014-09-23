<?php
    include 'toprepclass.php';
	$obj = new toprep;
	
	if (isset($_GET['constypeid']) && isset($_GET['topicid'])){
		
		$constypeid = $_GET['constypeid'];
		$topicid = $_GET['topicid'];
		
		$obj->printsubtopiclist($constypeid, $topicid);
	}
?>