<?php  

require_once('../inc/db_connect.php');
require_once('check_credentials.php');


$action = filter_input(INPUT_POST, 'action');
if($action == NULL) { 
  $action = filter_input(INPUT_GET, 'action');
	if($action == NULL) {
		$action = 'decide_landing_page';
	}
}

session_start();
if(!isset($_SESSION['test'])) {
   $action = 'login';
}

$username = filter_input(INPUT_POST, 'username');
$password = filter_input(INPUT_POST, 'password');

// a hashed username/password must be added to database they cannot be hardcoded. 
switch($action) {
	case 'login' :
	$username = filter_input(INPUT_POST, 'username');
	$password = filter_input(INPUT_POST, 'password');
	$_SESSION['username'] = $username;

	if (valid_team_member($username, $password)) {            // used to see if the credientals are in team_member table 
	   $_SESSION['test'] = 1;
	   header('Location: ../teamLead/team_lead_home.php') ;
	   
	}else if (valid_project_director($username, $password)) {   // used to see if the credientals are in project_director table      
	   $_SESSION['test'] = 2;	   
	   header('Location: ../projectDirector/project_director_home.php') ;
	   
	}else  {
		$login_message = 'Please enter a valid username and password.';
		echo $login_message;
		 include('main_login.php');
	}
	break;
	case 'decide_landing_page':
	if($_SESSION['test'] = 2) {
		header('Location: ../projectDirector/project_director_home.php') ;
	}
	else if($_SESSION['test'] = 1) {
		header('Location: ../teamLead/team_lead_home.php');
	}
	break;	
	}
