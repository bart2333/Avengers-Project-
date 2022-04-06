<?php
	$queryTeamMembers = 'SELECT * FROM team_members';
	
	$stmt = $db->prepare($queryTeamMembers);
	$stmt->execute();
	$teamMembers = $stmt->fetchAll();
	$stmt->closeCursor();