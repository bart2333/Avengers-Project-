<?php
/*
	CIS 492
	add Project Director page 
	Date: 02/17/22
	Filename: addPD.php	
*/	

require_once('../inc/db_connect.php');
include('director/dir_name.php');
require_once('../login/check_credentials.php');
include('webpage/header.php');

$dir_fname = filter_input(INPUT_POST, 'dir_fname');
$dir_lname = filter_input(INPUT_POST, 'dir_lname');
$username1 = filter_input(INPUT_POST, 'username1');
$password1 = filter_input(INPUT_POST, 'password1');				  
				  
if(array_key_exists('register',$_POST)) {  
	add_project_director($dir_fname, $dir_lname, $username1, $password1);
}	
		  		  
?>

<main>
	<div class="pdForm">
		<h1>Register a New Project Director</h1>
		<p>Adding a new director will allow them the ability to create and register projects for the CIS Department.</p>
		<p>Please fill out all fields within this form.</p>
		<div class="entryForm">
			<form action="addPD.php" method="POST">			
				<label>First Name:</label>
				<input type="text" name="dir_fname" placeholder="John"><br>
				
				<label>Last Name:</label>
				<input type="text" name="dir_lname" placeholder="Doe"><br>
				
				<label>School Email:</label>
				<input type="text" name="username1" placeholder="doe123@calu.edu"><br>
				
				<label>Password:</label>
				<input type="password" name="password1" placeholder="**********"><br>
				
				<input type="submit" name="register" value="Register">
				
			</form>
		</div>
	</div>
</main>
</body>
<footer><p>Capstone Project: Team Avengers 2022</p></footer>
</html>