<?php
	$queryProjects = "SELECT project.project_name, project.pro_start_date, project.pro_end_date, project.project_description, 
						project.personnel_cost, team.team_name, team_members.mem_fname, team_members.mem_lname FROM project 
						JOIN team ON project.project_id = team.project_id
						JOIN teams_list ON team.team_id = teams_list.team_id
						JOIN team_members ON teams_list.mem_id = team_members.mem_id
						WHERE dir_id = :dir_id
						ORDER by project.project_name";
						
	$stmt = $db->prepare($queryProjects);
	$stmt->bindValue(':dir_id', $_SESSION['directorID']);
	$stmt->execute();
	$projects = $stmt->fetchAll();
	$stmt->closeCursor();