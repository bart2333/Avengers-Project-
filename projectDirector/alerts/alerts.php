<?php
// This shows all projects now - add WHERE dir_id = :dir_id to change that 

$query = 'SELECT *
          FROM project
		  
          ORDER BY project_id';
		  
$statement = $db->prepare($query); 
$statement->execute();
$projects = $statement->fetchAll();
$statement->closeCursor();

$query = 'SELECT *
          FROM task_list
		  INNER JOIN project
		  ON project.project_id = task_list.project_id
		  WHERE is_complete = "Y"
          ORDER BY task_list_id';
		  
$statement = $db->prepare($query); 
$statement->execute();
$task_lists = $statement->fetchAll();
$statement->closeCursor();

// these assist in doing the date calculations for the "due in" under Project Alerts 
$myDate = strtotime(date('Y-m-d H:i:s'));
$nextDate = strtotime(date("02/20/22"));
$currentDate = ($myDate-$nextDate) /86400;

?>