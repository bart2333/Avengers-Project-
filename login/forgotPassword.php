<?php
require_once('../inc/db_connect.php');
$username = filter_input(INPUT_POST, 'username');
?>
<!DOCTYPE html>  
<html lang="en">
<head>
	<!--	
		CIS 492
		Main Login Page
		Date: 02/04/2022
		Filename: forgotPassword.php
	-->
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<title>CalU - Project Tracker</title>	
	<link rel="stylesheet" href="main.css">	
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
	<header>
		<div class="header2">
			<img src="caluBanner.jpg" alt="California University of Pennsylvania">	
				<br><br><br><br><br><br><br><br><br><br>	
		</div>
		<nav>
			<div class="navbar">
				<ul>
					<li><a href="main_login.php">Login</a></li>
				</ul>
			</div>
		</nav>
	</header>
	<br>
	<main>
		<form action = "index.php" class = "entryForm" autocomplete = "off" method="post"><!-- this was added as well 2/3/22-->
			<h3>Cal U Project Scheduling and Tracking System</h3>
			<p>Please enter in a valid email address:</p>
				<div class="floating-lable">
					<span class="material-icons md-35">&#9993;</span>
						&nbsp;<!--I changed this to "username" to match the tables in database instead of "email"-->
						<input placeholder = "username" type = "email" name = "username" id = "username" autocomplete = "off" required>
				</div> <br>
				<input type="submit" name="reset" value = "Reset"></h4>
        </form>
	</main>	
</body>
<footer><p>Capstone Project: Team Avengers 2022</p></footer>
</html>