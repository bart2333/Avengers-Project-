<?php
	$queryDirectors = "SELECT * FROM project_director";
	
	$stmt = $db->prepare($queryDirectors);
	$stmt->execute();
	$directors = $stmt->fetchAll();
	$stmt->closeCursor();