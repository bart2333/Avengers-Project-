<?php
	$queryProjects = "SELECT project.project_name, project.pro_start_date, project.pro_end_date, project.project_description
						FROM project 
						ORDER by project.project_name";
						
	$stmt = $db->prepare($queryProjects);
	$stmt->execute();
	$projects = $stmt->fetchAll();
	$stmt->closeCursor();
