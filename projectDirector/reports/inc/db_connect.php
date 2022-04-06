<?php
  $dsn1 = 'mysql:host=localhost;dbname=project_tracking';   // changed this 2/3/22 
    $username1 = 'root';    //I changed these as well can be changed back 
    $password1 = '';
   	
    try {
        $db = new PDO($dsn1, $username1, $password1);
		//echo '<p> You are connected to the database.</p>';
    } 
	catch (PDOException $e) {
        $error_message = $e->getMessage();
        echo  'Connection error.:$error_message';
    }
	
?>