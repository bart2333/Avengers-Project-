<?php
	$queryArchive = "SELECT archive_project.project_name, archive_project.pro_start_date, archive_project.pro_end_date, archive_project.project_description
						FROM archive_project 
						ORDER by archive_project.project_name";
						
	$stmt = $db->prepare($queryArchive);
	$stmt->execute();
	$projects = $stmt->fetchAll();
	$stmt->closeCursor();