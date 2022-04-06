<?php   
// edit_PD_helper.php
// UPDATES team_members table on click from editStudent.php
// Last Update: 03/05/22
$dir_id = filter_input(INPUT_POST, 'project_directors', FILTER_VALIDATE_INT);
$dir_fname = filter_input(INPUT_POST, 'dir_fname1');
$dir_lname = filter_input(INPUT_POST, 'dir_lname1');
$username = filter_input(INPUT_POST, 'username1');
$password = filter_input(INPUT_POST, 'password1');
session_start();  
$dir_id = $_SESSION['dir_id']; 






require_once('../../inc/db_connect.php');
$hash = password_hash($password, PASSWORD_DEFAULT);
$query = 'UPDATE project_director
                 SET dir_fname = :dir_fname, dir_lname = :dir_lname, username = :username, password = :password		 
				 WHERE dir_id =:dir_id';
				 
    $statement = $db->prepare($query);
	$statement->bindValue(':dir_id', $dir_id);
	$statement->bindValue(':dir_fname', $dir_fname);
    $statement->bindValue(':dir_lname', $dir_lname);
	$statement->bindValue(':username', $username);
	$statement->bindValue(':password', $hash);
    $statement->execute();
    $statement->closeCursor();


header('Location: editPD.php') ;
?>