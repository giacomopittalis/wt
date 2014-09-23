<?php
    include 'crempclass.php';
	$obj = new cremp;
	
	if (isset($_GET['month']) && isset($_GET['year'])){
		
		$month = $_GET['month'];
		$year = $_GET['year'];
		
		$obj->printdays($year, $month);
	}
?>