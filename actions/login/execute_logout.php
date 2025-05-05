<?php 
include_once "../../common.php";


if (is_session_started() === FALSE) {
	session_start();
}

unset($_SESSION);
session_destroy();

header("Location: ../../login.php");
?>