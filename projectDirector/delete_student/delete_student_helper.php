<?php

// I made this separate file for the delete project form button action
session_start();
require('../../inc/db_connect.php');
$project_id = $_SESSION['project_id'] ;

$query = 'DELETE FROM project
             WHERE project_id = :project_id';    
			 
    $statement = $db->prepare($query);
    $statement->bindValue(':project_id', $project_id);
    $statement->execute();
    $statement->closeCursor();
	
	
header('Location: delete_project.php') ;	
?>