<?php


$project_name = $_SESSION['project_name'];
$dir_id = $_SESSION['directorID'];
$personnel_cost = filter_input(INPUT_GET, 'personnel_cost'); //
$account_id = $_SESSION['account_id'];
$pro_start_date = $_SESSION['pro_start_date'];
$pro_end_date = $_SESSION['pro_end_date'];
$project_description = $_SESSION['project_description'];
$_SESSION['personnel_cost'] = $personnel_cost;
require_once('../../../inc/db_connect.php');
$query = 'INSERT INTO project
                 (project_name, dir_id, personnel_cost, account_id, pro_start_date, pro_end_date, project_description)
              VALUES
                 (:project_name, :dir_id, :personnel_cost, :account_id, :pro_start_date, :pro_end_date, :project_description)';
    $statement = $db->prepare($query);
    $statement->bindValue(':project_name', $project_name);
    $statement->bindValue(':dir_id', $dir_id );  
    $statement->bindValue(':personnel_cost', $personnel_cost );  //$personnel_cost
    $statement->bindValue(':account_id', $account_id );  //$account_id
	$statement->bindValue(':pro_start_date', $pro_start_date);
	$statement->bindValue(':pro_end_date', $pro_end_date);
	$statement->bindValue(':project_description', $project_description);
    $statement->execute();
    $statement->closeCursor();

header('Location: ../../project_director_home.php') ;	
?>