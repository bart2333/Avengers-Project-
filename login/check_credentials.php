<?php 
  
/* *filename: check_credentials.php
   *checks to see if username/password are in team_members, project_director tables  
   *adds new users to those tables 
*/

function add_team_member($mem_fname, $mem_lname, $username, $password, $skills) {  // this adds a new team member 
	global $db;
	$hash = password_hash($password, PASSWORD_DEFAULT);
	$query = 'INSERT INTO team_members(mem_fname, mem_lname, username, password, skills)
				VALUES (:mem_fname, :mem_lname, :username, :password, :skills)';
	$statement = $db->prepare($query);
	$statement->bindValue(':mem_fname', $mem_fname);
	$statement->bindValue(':mem_lname', $mem_lname);
	$statement->bindValue(':username', $username);
	$statement->bindValue(':password', $hash);
	$statement->bindValue(':skills', $skills);
	$statement->execute();
	$statement->closeCursor();
}
function add_project_director($dir_fname, $dir_lname, $username, $password) {// this adds a new project director  
	global $db;                        
	$hash = password_hash($password, PASSWORD_DEFAULT);
	$query1 = 'INSERT INTO project_director(dir_fname, dir_lname, username, password)
				VALUES (:dir_fname, :dir_lname, :username, :password)';
	
	$statement1 = $db->prepare($query1);
	$statement1->bindValue(':dir_fname', $dir_fname);
	$statement1->bindValue(':dir_lname', $dir_lname);
	$statement1->bindValue(':username', $username);
	$statement1->bindValue(':password', $hash);
	$statement1->execute();
	$statement1->closeCursor();
}


function valid_team_member($username, $password) { 
	global $db;                             // checks to see if provided username and password are in team_member table  
	 
	$query = 'SELECT password FROM team_members
			  WHERE username = :username';

	$statement2 = $db->prepare($query);
	$statement2->bindValue(':username', $username);
	$statement2->execute();
	$row = $statement2->fetch();
	$statement2->closeCursor();
	if (!empty($row)) {
	$hash = $row['password'];
	return password_verify($password, $hash);
	}
}

function valid_project_director($username, $password) { // checks to see if provided username and password are in project_director table
	global $db;       
	
	$query = 'SELECT password FROM project_director
			  WHERE username = :username';
	
	$statement3 = $db->prepare($query);
	$statement3->bindValue(':username', $username);
	$statement3->execute();
	$row = $statement3->fetch();
	$statement3->closeCursor();
	if (!empty($row)) {
	$hash = $row['password'];
	return password_verify($password, $hash);
	}
}

function add_tasks ($task_name, $task_category) {
	global $db;
	$query2 = 'INSERT INTO tasks(task_name, task_category)
				VALUES (:task_name, :task_category)';
				
	$statement4 = $db->prepare($query2);
	$statement4->bindValue(':task_name', $task_name);
	$statement4->bindValue(':task_category', $task_category);
	$statement4->execute();
	$statement4->closeCursor();
}

/*
if(array_key_exists('register',$_POST)) {  
	add_project_director($dir_fname, $dir_lname, $username1, $password1);
}*/ 
?>

