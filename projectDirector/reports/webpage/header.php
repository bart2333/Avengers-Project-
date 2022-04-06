<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<title>CalU - Project Tracker</title>	
	<link rel="stylesheet" href="webpage/main3.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
</head>
<body>
<header>
	<nav> 
		<div class="navbar">
			<ul>
				<li><a href="../project_director_home.php">Home</a>
				<li><a href="#Projects">Projects</a>
					<ul>
						<li><a href="../create_project_tab/create_project.php">Create Project</a></li>
						<li><a href="../manage_a_project/manage_project.php">Manage Project</a></li>
						<li><a href="../create_team/create_team.php">Create Team</a></li>
						<li><a href="../delete_team/delete_team.php">Delete Team</a></li>
						<li><a href="../delete_project/delete_project.php">Delete Project</a></li>
						<li><a href="../archive_project.php">Archive Project</a></li>
					</ul>
				</li>
				<li><a href="#teamMembers">Team Members</a>
					<ul>
						<li><a href="../addStudent.php">Add Team Members</a></li>
						<li><a href="../addPD.php">Add Project Director</a></li>
						<li><a href="../create_team/create_team.php">Create Team</a></li>
						<li><a href="../edit_student/editStudent.php">Edit Team Members</a></li>
						<li><a href="../edit_PD/editPD.php">Edit Project Director</a></li>						
						<li><a href="../delete_student/deleteStudent.php">Delete Team Members</a></li>
						<li><a href="../deletePD.php">Delete Project Director</a></li>
					</ul>				
				</li>
				<li><a href="#messages">Messages</a>
					<ul>
						<li><a href="../pd_email.php">Email</a></li>
					</ul>				
				</li>
				<li><a href="../run_reports.php">Reports</a></li>
				<li><a href="../create_tasks.php">Create Tasks</a></li>
			</ul>
		<div class="logout">
			<div class="logout2">
				<ul>
					<li><a href="../clear.php">LOGOUT</a><li>
				</ul>
			</div>
		</div>
	</nav>
	<div class="header">
		<div class="header2">
			<img src="webpage/caluBanner.jpg" alt="California University of Pennsylvania">		
			<div class="greeting">
				<h3><b>Welcome Professor <?php echo $variable1['dir_fname']. " ". $variable1['dir_lname']; ?></b>&nbsp;</h3>
			</div>
		</div>
	</div>	
</header>	