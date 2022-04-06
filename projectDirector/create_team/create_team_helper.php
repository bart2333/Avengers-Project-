<?php
require_once('../../inc/db_connect.php');
 
$project_id = filter_input(INPUT_POST, 'project_id', FILTER_VALIDATE_INT);
$team_name = filter_input(INPUT_POST, 'team_name');
$team_description = filter_input(INPUT_POST, 'team_description');
// this query inserts the new info into the teams table
$query = 'INSERT INTO team
                 (project_id, team_name, team_description)
              VALUES
                 (:project_id, :team_name, :team_description)';
    $statement = $db->prepare($query);
    $statement->bindValue(':project_id', $project_id);
    $statement->bindValue(':team_name', $team_name );  
	$statement->bindValue(':team_description', $team_description);
    $statement->execute();
    $statement->closeCursor();
	
	
header('Location: create_team.php') ;	
?>