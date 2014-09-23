<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "welltrail.cg1maemtimf4.us-west-2.rds.amazonaws.com";
$user = "welltrail";
$pw = "w3lltra1l";
$db = "welltrail";

$connection = mysqli_connect($host, $user, $pw, $db);
$result = mysqli_query($connection, "SELECT * from contact order by id");  
$row_cnt = $result->num_rows;
echo $row_cnt;









function safe_b64decode($string) {
        	$data = str_replace(array('-','_'),array('+','/'),$string);
        	$mod4 = strlen($data) % 4;
        	if ($mod4) {
            	$data .= substr('====', $mod4);
        	}
        	return base64_decode($data);
    	}


 $skey 	= "PuRnIma1953";
	$crypttext = safe_b64decode("PJI7vrj9OZ7r5qbW3VbdYPN0XqnqH9OIqfm9ZsNsMig"); 
        	$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        	$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        	$decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $skey, $crypttext, MCRYPT_MODE_ECB, $iv);
        	echo trim($decrypttext);
?>

									