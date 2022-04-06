<?php
	$queryProjects = "SELECT project.project_name, project.pro_start_date, project.pro_end_date, 
		project.project_description, team.team_name FROM project
		JOIN team ON project.project_id = team.project_id
		JOIN teams_list ON team.team_id = teams_list.team_id
		WHERE mem_id = :mem_id
		ORDER by project.project_name";
		
	$stmt = $db->prepare($queryProjects);
	$stmt->bindValue(':mem_id', $_SESSION['leadID']);
	$stmt->execute();
	$projects = $stmt->fetchAll();
	$stmt->closeCursor();
