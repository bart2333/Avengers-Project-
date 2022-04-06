<?php
	/*
		CIS 492
		Main Login Page
		Date: 12/18/21
		Filename: team_lead_messages.html
	*/

require_once('../inc/db_connect.php');
include('lead/lead_name.php');
include('webpage/header.php');
$memID = $_SESSION['mem_id'];

/* $queryDirInfo = "SELECT project_director.dir_fname, project_director.dir_lname, project_director.dir_id, 
					project.project_id, team.team_id FROM project
					JOIN team.project_id ON project.project_id
					JOIN project_director.dir_id on project.dir_id
					WHERE project.mem_id = $memID";
	$statement = $db->prepare($queryDirInfo);
	$statement->execute();
	$datas = $statement->fetchAll();
	$statement->closeCursor(); */

$queryDirector = "SELECT * FROM project_director ORDER BY dir_lname";
$queryStudent = "SELECT * FROM team_members ORDER BY mem_lname";
$stmt = $db->prepare($queryDirector);
$stmt2 = $db->prepare($queryStudent);
$stmt->execute();
$stmt2->execute();
$emailsPD = $stmt->fetchAll();
$emailsST = $stmt2->fetchAll();
$stmt->closeCursor();
$stmt2->closeCursor();
?>
<body><br>
<main>
	<div class="pdForm3">
			<h1>Email Messenger</h1>
			<p>Select the individuals you would like to send a message to.</p>
			<div class="entryForm2">
				<table align="center">
					<tr>
						<th>Last Name</th>
						<th>First Name</th>
						<th colspan="2">Email Address</th>
					</tr>
					<?php foreach($emailsPD as $emailPD): ?>
					<tr>
						<td><?php echo $emailPD['dir_lname'] ++; ?> </td>
						<td><?php echo $emailPD['dir_fname'] ++; ?> </td>
						<td><?php echo '<a  style="color:white" href="mailto:' . $emailPD['username'] ++ . '">' . $emailPD['username'] . '</a>';?></td>
					</tr>
					<?php endforeach; ?>
					<?php foreach($emailsST as $emailST): ?>
					<tr>
						<td><?php echo $emailST['mem_lname']; ?> </td>
						<td><?php echo $emailST['mem_fname']; ?> </td>
						<td><?php echo '<a style="color:white" href="mailto:' . $emailST['username'] . '">'. $emailST['username'] . '</a>';?></td>	
					</tr>
					<?php endforeach; ?>
				</table><br>
				<!--<input type="submit" name="compose" value="Compose" style="font-size: medium" data-email=>-->
			</div>
	</div><br><br>
</main>
</body>
<footer><p>Capstone Project: Team Avengers 2022</p></footer>
</html>