<?php
// I made this separate file for the delete team form button action
session_start();
require('../../inc/db_connect.php');
$team_id = $_SESSION['team_id'] ;

$query = 'DELETE FROM team
             WHERE team_id = :team_id';    
			 
    $statement = $db->prepare($query);
    $statement->bindValue(':team_id', $team_id);
    $statement->execute();
    $statement->closeCursor();
	
	
header('Location: delete_team.php') ;

?>	