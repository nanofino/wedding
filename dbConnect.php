<?php

	if($_SERVER['HTTP_HOST'] === 'localhost:8888') {// LOCAL
		
		$dbuser = "root";
		$dbpass = "root";
		$database = "nanodolo";
		//$server = "127.0.0.1";
		$server = "localhost";

		ini_set('display_startup_errors',1);
		ini_set('display_errors',1);
		error_reporting(-1);
		
	} else { // SERVER
		$dbuser = "";
		$dbpass = "";
		$database = "";
		$server = "";
	}
	$link = mysqli_connect($server,$dbuser,$dbpass);
	mysqli_select_db($link, $database);	
?>