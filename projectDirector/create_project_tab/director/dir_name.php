<?php

session_start();
$username = $_SESSION['username'];

$query = 'SELECT * FROM project_director
					WHERE username = :username';		
					
$statement = $db->prepare($query);
$statement->bindValue(':username',$username); 
$statement->execute();
$variable1 = $statement->fetch(); 
$directorID = $variable1['dir_id'];
$first = $variable1['dir_fname'];
$last = $variable1['dir_lname'];
$statement->closeCursor();

$_SESSION['directorID'] = $directorID;
$_SESSION['dir_fname'] = $first;
$_SESSION['dir_lname'] = $last;