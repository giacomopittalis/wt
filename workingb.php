<?php
    include 'workclass.php';
	
	$obj = new work;
	
	//$res = $obj->getlocarr();
	//var_dump($res);
	//$obj->checkdbf();
	
	//$res = $obj->crbemp();
	//var_dump($res);
	
	$value = "PYnjOIXnlQVIcyA1dqd7lWl8GyDUrEyaEBtNtGYMJpM";
	
	print $obj->decode($value);
?>