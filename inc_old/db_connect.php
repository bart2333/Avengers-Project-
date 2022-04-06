<?php
	$dsn = 'mysql:host=localhost;dbname=CIS_Scheduling_Tracking';
	$username = 'root';
	$password = 'pa55word';
	
	/*connect to the database*/
	$db = new PDO($dsn, $username, $password);
	
	if($db === false) {
		die("Error: Connection Failed!".mysqli_connect_error());
	}
?>