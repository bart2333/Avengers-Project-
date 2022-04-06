<?php

function add_project($project_name, $dir_id, $personnel_cost, $account_id, $pro_start_date, $pro_end_date){ 
global $db;
$query = 'INSERT INTO project
                 (project_name, dir_id, personnel_cost, account_id, pro_start_date, pro_end_date)
              VALUES
                 (:project_name, :dir_id, :personnel_cost, :account_id :pro_start_date, :pro_end_date)';
    $statement = $db->prepare($query);
    $statement->bindValue(':project_name', $project_name);
    $statement->bindValue(':dir_id', $directorID );  
    $statement->bindValue(':personnel_cost', $personnel_cost );  //$personnel_cost
    $statement->bindValue(':account_id', $account_id );  //$account_id
	$statement->bindValue(':pro_start_date', $pro_start_date);
	$statement->bindValue(':pro_end_date', $pro_end_date);
    $statement->execute();
    $statement->closeCursor();
}

