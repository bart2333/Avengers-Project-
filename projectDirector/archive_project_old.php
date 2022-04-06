<?php 
	/*
		CIS 492
		Archive Project Page 
		Last Worked: 03/18/22
		Filename: archive_project.php
	*/ 
	
	 
$project_id = filter_input(INPUT_POST, 'project_id', FILTER_VALIDATE_INT);
require('../inc/db_connect.php');
include('director/dir_name.php');
include('webpage/header.php');

// this refreshes the page if the "ID# -- Project Name" is selected which would give and error 
if ($project_id === FALSE){
	
header("Refresh:0");
}
if(isset($project_id)) {
	$_SESSION['b']['project_id'] = $project_id;
}
// populates the projects tab to select a project to archive
$query = 'SELECT *
          FROM project
          ORDER BY project_id';
$statement = $db->prepare($query);
$statement->execute();
$projects = $statement->fetchAll();
$statement->closeCursor();

// populates all the project info for review by the user 
if(array_key_exists('project_id',$_POST)) {  
	
$query = 'SELECT *
          FROM project
          WHERE project_id = :project_id';
$statement = $db->prepare($query);
$statement->bindValue(':project_id', $project_id);
$statement->execute();
$project = $statement->fetch();
$project_name = $project['project_name'];
$_SESSION['b']['project_name'] = $project_name;
$dir_id = $project['dir_id'];
$_SESSION['b']['dir_id'] = $dir_id;
$account_id = $project['account_id'];
$_SESSION['b']['account_id'] = $account_id;
$pro_start_date = $project['pro_start_date'];
$_SESSION['b']['pro_start_date'] = $pro_start_date;
$pro_end_date = $project['pro_end_date'];
$_SESSION['b']['pro_end_date'] = $pro_end_date;
$project_description = $project['project_description'];
$_SESSION['b']['project_description'] = $project_description;
$tafp1 = $project['tafp1'];
$_SESSION['b']['tafp1'] = $tafp1;
$code = $project['code'];
$_SESSION['b']['code'] = $code;
$personMonths = $project['personMonths'];
$_SESSION['b']['personMonths'] = $personMonths;
$months = $project['months'];
$_SESSION['b']['months'] = $months;
$persons = $project['persons'];
$_SESSION['b']['persons'] = $persons;
$personnel_cost = $project['personnel_cost'];
$_SESSION['b']['personnel_cost'] = $personnel_cost;
$statement->closeCursor();
} else {
$project_name = "";
$dir_id = "";
$account_id = "";
$pro_start_date = "";
$pro_end_date = "";
$project_description = "";
$tafp1 = "";
$code = "";
$personMonths = "";
$months = "";
$persons = "";
$personnel_cost = "";
}

if(array_key_exists('archiveProject',$_POST)) {
$query = 'INSERT INTO archive_project
             (project_id, project_name, dir_id, account_id, pro_start_date, pro_end_date, project_description, 
			 tafp1, code, personMonths, months, persons, personnel_cost)
              VALUES
             (:project_id, :project_name, :dir_id, :account_id, :pro_start_date, :pro_end_date, :project_description, 
			 :tafp1, :code, :personMonths, :months, :persons, :personnel_cost)';
			 
    $statement = $db->prepare($query);
    $statement->bindValue(':project_id', $_SESSION['b']['project_id']);
    $statement->bindValue(':project_name', $_SESSION['b']['project_name'] );
	$statement->bindValue(':dir_id', $_SESSION['b']['dir_id'] );  	
    $statement->bindValue(':account_id', $_SESSION['b']['account_id'] ); 
	$statement->bindValue(':pro_start_date', $_SESSION['b']['pro_start_date']);date("Y-m-d H:i:s");
	$statement->bindValue(':pro_end_date', $_SESSION['b']['pro_end_date']);date("Y-m-d H:i:s");
	$statement->bindValue(':project_description', $_SESSION['b']['project_description']);
	$statement->bindValue(':tafp1', $_SESSION['b']['tafp1']);
	$statement->bindValue(':code', $_SESSION['b']['code']);
	$statement->bindValue(':personMonths', $_SESSION['b']['personMonths']);
	$statement->bindValue(':months', $_SESSION['b']['months']);
	$statement->bindValue(':persons', $_SESSION['b']['persons']);
	$statement->bindValue(':personnel_cost', $_SESSION['b']['personnel_cost']);
    $statement->execute();
    $statement->closeCursor();
	
}
//clears the SESSION 
if(array_key_exists('reset',$_POST)) { 
unset($_SESSION['b']);
header("Refresh:0");
}
?>

<h1 style="font-size: 32px"> Archive Project Page</h1>
<hr></hr>
<br>	
<form action="archive_project.php" method="post">

<fieldset>
			<h3>Please choose a Project to Archive: </h3>
			<select name="project_id" style="width:250px">
				<option> ID# -- Project Name </option>
				<?php foreach ($projects as $project) : ?>
                <option value="<?php echo $project['project_id']; ?>" <?php if (isset ($_POST['project_id']) && ($_POST['project_id'] == $project['project_id'])) { ?> selected = "selected" <?php } ?>>
                    <?php echo $project['project_id']; ?> -
					<?php echo $project['project_name']; ?>
					
                </option>
            <?php endforeach; ?>
			</select>
	
		<input type="submit" value="Select Project" id="selectProject"  />
</form>
</fieldset>


<br>
	<fieldset class="grayBox">
			
		<h3 style = "color: black;">Project Name: <?php echo $project_name;?></h3>
		<input type="hidden" value = "<?php echo $project_name;?>" name="project_name"/>
		<h3 style = "color: black;">Director ID: <?php echo $dir_id;?></h3>
		<input type="hidden" value = "<?php echo $dir_id;?>" name="dir_id"/>
		<h3 style = "color: black;">Account ID: <?php echo $account_id;?></h3>
		<input type="hidden" value = "<?php echo $account_id;?>" name="account_id"/>
		<h3 style = "color: black;">Project Start Date: <?php echo $pro_start_date;?></h3>
		<input type="hidden" value = "<?php echo $pro_start_date;?>" name="pro_start_date"/>
		<h3 style = "color: black;">Project End Date: <?php echo $pro_end_date;?></h3>	
		<input type="hidden" value = "<?php echo $pro_end_date;?>" name="pro_end_date"/>
		<h3 style = "color: black;">Project Description: <?php echo $project_description;?></h3>
		<input type="hidden" value = "<?php echo $project_description;?>" name="project_description"/>
		<?php if($tafp1 != "") {?>
		<h3 style = "color: black;">Total Adjusted Function Point: <?php echo $tafp1;?></h3>		
		<h3 style = "color: black;">Lines of Code: <?php echo $code;?></h3>
		<h3 style = "color: black;" >Person Months: <?php echo $personMonths;?></h3> 
		<h3 style = "color: black;">Months: <?php echo $months;?></h3> 
		<h3 style = "color: black;">Person: <?php echo $persons;?></h3> 
		<h3 style = "color: black;">Personnel Cost: $<?php echo $personnel_cost;?></h3>
		<?php } ?>	
    </fieldset>

<fieldset style="clear: left;">
<form action="archive_project.php" method="post">
<input type="submit" value="Archive Project" name="archiveProject" class="std_button"/>
<input type = "button" value = "Delete Project" class="std_button" onclick="window.location.href='delete_project/delete_project.php'"/> 
<input type = "button" value = "View Archives" class="std_button" onclick="window.location.href='view_archived_project.php'"/>  
<input type = "submit" value = "Reset" name="reset" class="std_button" />  
</form>
</fieldset>
<br>
<br>
<br>
</body>
<footer><p>Capstone Project: Team Avengers 2022</p></footer>
</html>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
