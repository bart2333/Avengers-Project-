<?php
	/*
		CIS 492
		Add Student Page 
		Date: 03/18/22 
		Filename: addStudent.php
	*/	

require_once('../inc/db_connect.php');
include('director/dir_name.php');
require_once('../login/check_credentials.php');
include('webpage/header.php');

$mem_fname = filter_input(INPUT_POST, 'mem_fname');
$mem_lname = filter_input(INPUT_POST, 'mem_lname');
$username = filter_input(INPUT_POST, 'username');
$password = filter_input(INPUT_POST, 'password');
$skills = filter_input(INPUT_POST, 'skills');
if(array_key_exists('register',$_POST)) {  
	 add_team_member($mem_fname, $mem_lname, $username, $password, $skills);
}
  
?>

<main>
	<div class="pdForm">
		<h1>Register a Team Member</h1>
		<p>Adding a new team member will allow them to participate in various projects hosted by the CIS Department.</p>
		<p>Please fill out all fields within this form.</p>
		<div class="entryForm">
			<form action="addStudent.php" method="POST" >
				<label>First Name:</label>
				<input type="text" name="mem_fname" required="required" placeholder="John"><br>
				
				<label>Last Name:</label>
				<input type="text" name="mem_lname" required="required" placeholder="Doe"><br>
				
				<label>School Email:</label>
				<input type="text" name="username" required="required" placeholder="doe123@calu.edu"><br>
				
				<label>Password:</label>
				<input type="password" name="password" placeholder="**********"><br>
				
				<label>Skills:</label>
				<textarea type="text" name = "skills"></textarea><br>
				
				<input type="submit" name="register" value="Register">

			</form>
		</div>
	</div>
</main>
</body>
<footer><p>Capstone Project: Team Avengers 2022</p></footer>
</html>