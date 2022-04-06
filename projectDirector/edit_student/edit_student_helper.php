<?php  
// edit_student_helper.php
// UPDATES team_members table on click from editStudent.php
// Last Update: 3/12/22
// added username and password
$mem_id = filter_input(INPUT_POST, 'team_members', FILTER_VALIDATE_INT);
$mem_fname = filter_input(INPUT_POST, 'mem_fname1');
$mem_lname = filter_input(INPUT_POST, 'mem_lname1');
$username = filter_input(INPUT_POST, 'username1');
$password = filter_input(INPUT_POST, 'password1');
session_start();  
$mem_id = $_SESSION['mem_id']; 


if($mem_id== FALSE){
$error = "Please select a project prior to continuing";
 
}




require_once('../../inc/db_connect.php');
$hash = password_hash($password, PASSWORD_DEFAULT);
$query = 'UPDATE team_members
                 SET mem_fname = :mem_fname, mem_lname = :mem_lname, username = :username, password = :password 		 
				 WHERE mem_id =:mem_id';
				 
    $statement = $db->prepare($query);
	$statement->bindValue(':mem_id', $mem_id);
	$statement->bindValue(':mem_fname', $mem_fname);
    $statement->bindValue(':mem_lname', $mem_lname);
	$statement->bindValue(':username', $username);
	$statement->bindValue(':password', $hash);
    $statement->execute();
    $statement->closeCursor();


header('Location: editStudent.php') ;
?>