<?php
	/*
		CIS 492
		Project Director Messenger
		Date: 2/16/22
		Filename: pd_messenger.php
	*/

require_once('../inc/db_connect.php');
include('director/dir_name.php');
include('webpage/header.php');

$queryDirector = "SELECT * FROM project_director ORDER BY dir_lname";
$queryStudent = "SELECT * FROM team_members ORDER BY mem_lname";
$stmt = $db->prepare($queryDirector);
$stmt2 = $db->prepare($queryStudent);
$stmt->execute();
$stmt2->execute();
$emailsPD = $stmt->fetchAll();
$emailsST = $stmt2->fetchAll();
$stmt->closeCursor();
$stmt->closeCursor();

?>
<body><br>
<main>
	<div class="pdForm3">
		<form action="compose_email.php" method="POST">
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
						<td><?php echo $emailPD['dir_lname']; ?> </td>
						<td><?php echo $emailPD['dir_fname']; ?> </td>
						<td><?php echo '<a  style="color:white" href="mailto:' . $emailPD['username'] . '">' . $emailPD['username'] . '</a>';?></td>
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
		</form>
	</div><br><br>
</main>
</body>
<footer><p>Capstone Project: Team Avengers 2022</p></footer>
</html>