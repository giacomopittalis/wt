<?php
    session_start();
	include 'logoutclass.php';
	$obj = new logout;
	$euname = $_SESSION['uname'];
	$logout = $obj->logout($euname);
	session_unset(TRUE);
	session_destroy();
	header("Location: login.php");
?>