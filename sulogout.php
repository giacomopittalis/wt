<?php
    session_start();
	session_unset(TRUE);
	session_destroy();
	header("Location: sulogin.php");
?>