<?php 
	/* 
		CIS 492
		Delete Project Page 
		Last Worked: 03/12/22
		Filename: delete_project.php
	*/

// 03/04 - now will delete only on the button click 

$project_id = filter_input(INPUT_POST, 'project_id', FILTER_VALIDATE_INT);
require('../../inc/db_connect.php');
include('director/dir_name.php');
include('../webpage/sub_header.php');

// this refreshes the page if the "ID# -- Project Name" is selected which would give and error 
if ($project_id === FALSE){
	
header("Refresh:0");
}
//This saves the project ID in a SESSION for further use 
if(isset($project_id)) {
	$_SESSION['c']['project_id'] = $project_id;
}

// populates the projects drop down to select a project to delete
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
$dir_id = $project['dir_id'];
$account_id = $project['account_id'];
$pro_start_date = $project['pro_start_date'];
$pro_end_date = $project['pro_end_date'];
$project_description = $project['project_description'];
$tafp1 = $project['tafp1'];
$code = $project['code'];
$personMonths = $project['personMonths'];
$months = $project['months'];
$persons = $project['persons'];
$personnel_cost = $project['personnel_cost'];
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

if(array_key_exists('deleteProject',$_POST)) {
// this will search archive_project and see if this project is archived 
//FALSE means it is not archived
$query = 'SELECT *
          FROM archive_project
		  WHERE project_id = :project_id';
$statement = $db->prepare($query);
$statement->bindValue(':project_id', $_SESSION['c']['project_id']);
$statement->execute();
$checkArchives = $statement->fetch();
$statement->closeCursor();
if($checkArchives == TRUE) {
// deletes the selected project 
$query = 'DELETE FROM project
             WHERE project_id = :project_id';    
			 
    $statement = $db->prepare($query);
    $statement->bindValue(':project_id', $_SESSION['c']['project_id']);
    $statement->execute();
    $statement->closeCursor();
	
	unset($_SESSION['c']);
	header("Refresh:0");
	
}else {
	header('Location: delete_project_helper.php') ;
}
}
//clears the SESSION 
if(array_key_exists('reset',$_POST)) { 
unset($_SESSION['c']);
header("Refresh:0");
}
?>


<h1 style="font-size: 32px"> Delete Project Page</h1>
<hr></hr>
<br>	
<form action="" method="post">
<fieldset>
			<h3>Please choose a Project to Update: </h3>
			<select required name="project_id" style="width:250px">
				<option> ID# -- Project Name </option>
				<?php foreach ($projects as $project) : ?>
                <option value="<?php echo $project['project_id']; ?>">
                    <?php echo $project['project_id']; ?> -
					<?php echo $project['project_name']; ?>
					
                </option>
            <?php endforeach; ?>
			</select>
	
		<input type="submit" value="Select Project" id="selectProject"  />
</fieldset>

<br>
	<fieldset class="grayBox">
			
		<h3 style = "color: black;">Project Name: <?php echo $project_name;?></h3>
		<h3 style = "color: black;">Director ID: <?php echo $dir_id;?></h3>
		<h3 style = "color: black;">Account ID: <?php echo $account_id;?></h3>
		<h3 style = "color: black;">Project Start Date: <?php echo $pro_start_date;?></h3>
		<h3 style = "color: black;">Project End Date: <?php echo $pro_end_date;?></h3>		
		<h3 style = "color: black;">Project Description: <?php echo $project_description;?></h3>		
		<?php if($tafp1 != "") {?>
		<h3 style = "color: black;">Total Adjusted Function Point: <?php echo $tafp1;?></h3>		
		<h3 style = "color: black;">Lines of Code: <?php echo $code;?></h3>
		<h3 style = "color: black;" >Person Months: <?php echo $personMonths;?></h3> 
		<h3 style = "color: black;">Months: <?php echo $months;?></h3> 
		<h3 style = "color: black;">Person: <?php echo $persons;?></h3> 
		<h3 style = "color: black;">Personnel Cost: $<?php echo $personnel_cost;?></h3>
		<?php } ?>	
    </fieldset>
</form>
<fieldset style="clear: left;">
<form action="delete_project.php" method="post">
<input type="submit" value="Delete Project" name="deleteProject" class="std_button"/>
<input type = "button" value = "Archive Project" class="std_button" onclick="window.location.href='../archive_project.php'"/>
<input type = "button" value = "Director Home" class="std_button" onclick="window.location.href='../project_director_home.php'"/>  
<input type = "submit" value = "Reset" name="reset" class="std_button" />  
</form>
</fieldset>
<br>
<br>
<br>
</body>
<footer><p>Capstone Project: Team Avengers 2022</p></footer>
</html>
