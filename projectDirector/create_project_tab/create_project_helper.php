<?php
$project_name= filter_input(INPUT_POST, 'project_name');
$personnel_cost = filter_input(INPUT_POST, 'personnel_cost');
$account_id = filter_input(INPUT_POST, 'account_id');
$pro_start_date = filter_input(INPUT_POST, 'pro_start_date');date("Y-m-d H:i:s");
$pro_end_date = filter_input(INPUT_POST, 'pro_end_date');date("Y-m-d H:i:s");
$project_description = filter_input(INPUT_POST, 'project_description');

session_start();
$dir_id = $_SESSION['directorID']; // this grabs the session from home page 


require_once('../../inc/db_connect.php');
$query = 'INSERT INTO project
                 (project_name, dir_id, personnel_cost, account_id, pro_start_date, pro_end_date, project_description)
              VALUES
                 (:project_name, :dir_id, :personnel_cost, :account_id, :pro_start_date, :pro_end_date, :project_description)';
    $statement = $db->prepare($query);
    $statement->bindValue(':project_name', $project_name);
    $statement->bindValue(':dir_id', $dir_id );  
    $statement->bindValue(':personnel_cost', $personnel_cost );  //$personnel_cost
    $statement->bindValue(':account_id', $account_id );  //$account_id
	$statement->bindValue(':pro_start_date', $pro_start_date);date("Y-m-d H:i:s");
	$statement->bindValue(':pro_end_date', $pro_end_date);date("Y-m-d H:i:s");
	$statement->bindValue(':project_description', $project_description);
    $statement->execute();
    $statement->closeCursor();

header('Location: create_project.php') ;
?>