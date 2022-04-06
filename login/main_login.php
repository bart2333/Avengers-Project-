<?php
require_once('../inc/db_connect.php');
$username = filter_input(INPUT_POST, 'username');
$password = filter_input(INPUT_POST, 'password');
?>

<!DOCTYPE html>  
<html lang="en">
<head>
	<!--	
		CIS 492
		Main Login Page
		Date: 02/04/2022
		Filename: main_login.php
	-->
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<title>CalU - Project Tracker</title>	
	<link rel="stylesheet" href="login.css">	
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
	<header>
		<div class="header">
				<img src="img/tower-wordmark2.png" alt="California University of Pennsylvania">
				<br><br><br><br><br><br><br><br><br><br>	
		</div>
	</header>
	<br> 
	<main>
		<form action = "index.php" class = "log-in" autocomplete = "off" method="post"><!-- this was added as well 2/3/22-->
			<h3>Cal U Project Scheduling and Tracking System</h3>
			<p>Welcome! <br> Log into your account to view your projects:</p>
				<div class="floating-lable">
					<span class="material-icons md-35">&#9993;</span>
						&nbsp;<!--I changed this to "username" to match the tables in database instead of "email"-->
						<input placeholder = "username" type = "email" name = "username" id = "username" autocomplete = "off" required>
				</div> <br>
				<div class="floating-lable2">
					<i class="material-icons">lock</i>&nbsp;
						<input placeholder = "Password" type = "password" name = "password" id = "password" autocomplete = "off">
				</div>

				<h4><a href="forgotPassword.php" name="reset">Forgot Password</a> <!--student admin -->
				<input type="submit" name="log-in" value = "Login"></h4>
        </form>
	</main>
</body>
<footer><p>Capstone Project: Team Avengers 2022</p></footer>
</html>