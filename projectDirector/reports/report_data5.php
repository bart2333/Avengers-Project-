<?php
	$queryTeams = 'SELECT * FROM team';
	
	$stmt = $db->prepare($queryTeams);
	$stmt->execute();
	$teams = $stmt->fetchAll();
	$stmt->closeCursor();