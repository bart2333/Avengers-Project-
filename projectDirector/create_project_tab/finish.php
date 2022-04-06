<?php
//session_start();
$personnel_cost = filter_input(INPUT_GET, 'personnel_cost');
var_dump($personnel_cost);

/*
require('../../inc/db_connect.php');
$query = 'SELECT *
          FROM project 
          ORDER BY account_id';
$statement = $db->prepare($query);
$statement->execute();
$accounts = $statement->fetchAll();
$statement->closeCursor();
*/


?>



<!DOCTYPE html>
<html lang="en">
<head>
	<!--
		CIS 492
		Project Director 
		Date: 2/4/22
		Filename: project_director_home.php
	-->
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<title>CalU - Project Tracker</title>	
	<link rel="stylesheet" href="main_for_create.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<header>
	<nav> 
		<div class="navbar">
			<ul>
				<li><a href="#home">Home</a>
				<li><a href="#Projects">Projects</a>
					<ul>
						<li><a href="create_project_tab/create_project.php">Create Project</a></li>
						<li><a href="manage_project.html">Manage Project</a></li>
						<li><a href="create_team.html">Create Team</a></li>
						<li><a href="delete_project.html">Delete Project</a></li>
						<li><a href="archive_project.html">Archive Project</a></li>
					</ul>
				</li>
				<li><a href="#teamMembers">Team Members</a>
					<ul>
						<li><a href="addStudent.php">Add Students</a></li>
						<li><a href="addPD.php">Add Project Director</a></li>
						<li><a href="create_team.html">Create Team</a></li>
						<li><a href="editStudent.html">Edit Student</a></li>
						<li><a href="editPD.html">Edit Project Director</a></li>						
						<li><a href="deleteStudent.html">Delete Student</a></li>
						<li><a href="deletePD.html">Delete Project Director</a></li>
					</ul>				
				</li>
				<li><a href="#messages">Send Messages</a></li>
				<li><a href="#reports">Reports</a></li>
				<li><a href="#tasks">Create Tasks</a></li>
			</ul>
		<div class="logout">
			<div class="logout2">
				<ul>
					<li><a href="clear.php">LOGOUT</a><li>
				</ul>
			</div>
		</div>
	</nav>
	

</body>
</html>