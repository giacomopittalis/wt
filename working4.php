<?php
    include 'mconrepclass.php';
	
	$obj = new mconrep;
	
	//$res = $obj->getlocarr();
	//var_dump($res);
	//$obj->checkdbf();
	$ret = array();
	$dbhandle = $obj->dbhandle();
	if ($dbhandle){
		$dbfound = $obj->dbfound();
		if ($dbfound){
			$tablename = "contact";
			$tex = $obj->tex($tablename);
			if ($tex){
				$sql1 = "SELECT `$tablename`.`id` FROM `$obj->db`.`$tablename`";
				$result1 = mysql_query($sql1, $dbhandle);
				if ($result1){
					if (mysql_num_rows($result1) > 0){
						while ($resarr1 = mysql_fetch_assoc($result1)){
							$conid = $resarr1['id'];
							$sql2 = "SELECT `$tablename`.`dat` FROM `$obj->db`.`$tablename` WHERE `$tablename`.`id` = '$conid'";
							$result2 = mysql_query($sql2, $dbhandle);
							if ($result2){
								if (mysql_num_rows($result2) > 0){
									$resarr2 = mysql_fetch_assoc($result2);
									$odat = $obj->decode($resarr2['dat']);
									//print $odat."<br />";
									$datarr = explode("/", $odat);
									$ndat = $datarr[1]."/".$datarr[0]."/".$datarr[2];
									//print $ndat."<br />";
									$ndat = $obj->encode($ndat);
									$sql3 = "UPDATE `$obj->db`.`$tablename` SET `$tablename`.`dat` = '$ndat' WHERE `$tablename`.`id` = '$conid'";
									$result3 = mysql_query($sql3, $dbhandle);
									if ($result3){
										print "done"."<br />";
									}
								}
							}
						}
					}
				}
			}
		}
	}
?>