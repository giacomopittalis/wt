<?php
    include 'mcconrepclass.php';
	
	$obj = new mcconrep;
	
	//$res = $obj->getlocarr();
	//var_dump($res);
	//$obj->checkdbf();
	//$dat = $obj->decode("xS-BshFPNeP9r4z_sQwsGxJJG-bmJT2VwLEUTYefqLA");
	//print $dat."<br />";
	//$datarr = explode("/", $dat);
	//var_dump($datarr);
	$clid = array(2, 4);
	$locid = 0;
	$sex = "0";
	$arl = "0";
	$arh = "0";
	$year = "0";
	$month = "0";
	$x = "4";
	//$res1 = $obj->getmconrep($x, $locid, $sex, $arl, $arh, $year, $month);
	//print $res1;
	//$res = $obj->getmcconrep($clid, $locid, $sex, $arl, $arh, $year, $month);
	//$conid = 5;
	//$cl = $obj->getclid($conid);
	//print $cl;
	//var_dump($res);
	$con = $obj->getallcon();
	var_dump($con);
	$can = $obj->filterclid($con, $x);
	var_dump($can);
?>