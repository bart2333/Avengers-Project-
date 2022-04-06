<?php

/* 
		CIS 492
		Alerts
		Date: 04/03/22
		Filename: alerts.php
		**** Updated 4-3
*/


$query = 'SELECT *
          FROM team_members
		  WHERE username = :username';
		  
$statement = $db->prepare($query);
$statement->bindValue(':username',$_SESSION['username']);  
$statement->execute();
$variable = $statement->fetch();
$mem_id = $variable['mem_id'];
$statement->closeCursor();

$query = 'SELECT *
          FROM teams_list
		  WHERE mem_id = :mem_id';
		  
$statement = $db->prepare($query);
$statement->bindValue(':mem_id',$mem_id);  
$statement->execute();
$variable3 = $statement->fetch();
$team_id = $variable3['team_id'];
$statement->closeCursor();

$query = 'SELECT *
          FROM team
		  WHERE team_id = :team_id';
		  
$statement = $db->prepare($query);
$statement->bindValue(':team_id',$team_id);  
$statement->execute();
$variable2 = $statement->fetch();
$project_id = $variable2['project_id'];
$statement->closeCursor();


// this will show all the unassigned tasks where mem id is null or unassigned 
$query = 'SELECT DISTINCT *
          FROM task_list
		  INNER JOIN team
			ON task_list.project_id = team.project_id
		  WHERE task_list.project_id = :project_id
		  AND task_list.team_id = :team_id
		 GROUP BY task_id
          ORDER BY task_id';
		  
$statement = $db->prepare($query);
$statement->bindValue(':project_id',$project_id); 
$statement->bindValue(':team_id',$team_id);  
$statement->execute();
$unassignedTasks = $statement->fetchAll();
$statement->closeCursor();


// this only shows the assigned tasks now 
// remove the join on team members to show all tasks 
$query = 'SELECT *
          FROM task_list
		  INNER JOIN team
			ON task_list.project_id = team.project_id
		  INNER JOIN team_members
			ON task_list.mem_id = team_members.mem_id
		  WHERE task_list.project_id = :project_id
		  AND task_list.team_id = :team_id
		  AND task_list.is_complete = "N"
		  GROUP BY task_id
          ORDER BY task_id';
		  
$statement = $db->prepare($query);
$statement->bindValue(':project_id',$project_id); 
$statement->bindValue(':team_id',$team_id);  
$statement->execute();
$task_lists = $statement->fetchAll();
$statement->closeCursor();



// these assist in doing the date calculations for the "due in" under Project Alerts 
$myDate = strtotime(date('Y-m-d H:i:s'));
$nextDate = strtotime(date("02/20/22"));
$currentDate = ($myDate-$nextDate) /86400;

?>