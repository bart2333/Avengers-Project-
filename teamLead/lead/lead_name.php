<?php

session_start();
$username = $_SESSION['username'];

$query = 'SELECT * FROM team_members
					WHERE username = :username';		
					
$statement = $db->prepare($query);
$statement->bindValue(':username',$username); 
$statement->execute();
$variable1 = $statement->fetch(); 
$leadID = $variable1['mem_id'];
$first = $variable1['mem_fname'];
$last = $variable1['mem_lname'];
$mem_id = $variable1['mem_id'];
$statement->closeCursor();

$_SESSION['leadID'] = $leadID;
$_SESSION['mem_fname'] = $first;
$_SESSION['mem_lname'] = $last;
$_SESSION['mem_id'] = $mem_id;

?>