<?php  
// cost_update.php 
// UPDATES Project table costs values only from what is shown after hitting "calculate"
// Last Update: 04/01/22  

session_start();  // Session used to capture values from php_cost_calculations
$project_id = $_SESSION['project_id']; //filter_input(INPUT_GET, 'project_id');
$tafp1 = $_SESSION['tafp1'];
$code = $_SESSION['code'];
$personMonths = $_SESSION['personMonths'];
$months = $_SESSION['months'];
$persons = $_SESSION['persons'];
$personnel_cost = $_SESSION['personnel_cost'];
$reason = $_SESSION['reason'];


require_once('../../../inc/db_connect.php');// query uses the project value from the 'project_id' to update the chosen project 
$query = 'UPDATE project
                 SET tafp1 = :tafp1, code = :code, personMonths =:personMonths, 
				 months =:months, persons =:persons, personnel_cost =:personnel_cost, cost_justification =:cost_justification
				 WHERE project_id =:project_id';
				 
    $statement = $db->prepare($query);
	 $statement->bindValue(':project_id', $project_id);
    $statement->bindValue(':tafp1', $tafp1);
    $statement->bindValue(':code', $code);
    $statement->bindValue(':personMonths', $personMonths);
    $statement->bindValue(':months', $months);
	$statement->bindValue(':persons', $persons);
	$statement->bindValue(':personnel_cost', $personnel_cost);
	$statement->bindValue(':cost_justification', $reason);
    $statement->execute();
    $statement->closeCursor();

$_SESSION['project_id'] = "";
$_SESSION['tafp1'] = "";
$_SESSION['code'] = "";
$_SESSION['personMonths'] = "";
$_SESSION['months'] = "";
$_SESSION['persons'] = "";
$_SESSION['personnel_cost'] = "";

// directs to the PD home page after "Save & Exit" is clicked
header('Location: ../../project_director_home.php') ;
?>