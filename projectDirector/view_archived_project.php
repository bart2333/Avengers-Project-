<?php
	/*
		CIS 492
		View Archived Project Page 
		Last Worked: 03/18/22
		Filename: view_archived_project.php
	*/
	
	 
$project_id = filter_input(INPUT_POST, 'project_id', FILTER_VALIDATE_INT);
require('../inc/db_connect.php');
include('director/dir_name.php');
include('webpage/header.php');
//var_dump($project_id);

// this refreshes the page if the "ID# -- Project Name" is selected which would give and error 
if ($project_id === FALSE){
	
header("Refresh:0");
}

// populates the projects tab 
$query = 'SELECT *
          FROM archive_project
          ORDER BY project_id';
$statement = $db->prepare($query);
$statement->execute();
$projects = $statement->fetchAll();
$statement->closeCursor();

// provides the values for the table based on selection
if(isset($project_id)) {
$query = 'SELECT *
          FROM archive_project
          WHERE project_id = :project_id';
$statement = $db->prepare($query);
$statement->bindValue(':project_id', $project_id);
$statement->execute();
$currentProject = $statement->fetch();
$project_name = $currentProject['project_name'];
$dir_id= $currentProject['dir_id']; 
$account_id = $currentProject['account_id']; 
$pro_start_date = $currentProject['pro_start_date']; 
$pro_end_date = $currentProject['pro_end_date']; 
$project_description = $currentProject['project_description']; 
$tafp1 = $currentProject['tafp1']; 
$statement->closeCursor();
}


//RESET
if(array_key_exists('reset',$_POST)) { 

header("window.location.href='view_archived_project.php'");
}
?>

<h1 style="font-size: 32px"> View Archived Project Page</h1>
<hr></hr>
<br>	
<form action="view_archived_project.php" method="post">

<fieldset>
			<h3>Please choose an Archive to View: </h3>
			<select name="project_id" style="width:250px">
			
				<option> ID# -- Project Name </option>
				<?php foreach ($projects as $project) : ?>
                <option value="<?php echo $project['project_id'];?>" <?php if (isset ($_POST['project_id']) && ($_POST['project_id'] == $project['project_id'])) { ?> selected = "selected" <?php } ?>>
                    <?php echo $project['project_id']; ?> -
					<?php echo $project['project_name']; ?>
			
                </option>
            <?php endforeach; ?>
				
			</select>
	
		<input type="submit" value="Select Archive" id="selectArchive"  />
</form>
</fieldset>
<?php if(isset($project_id)) { ?>
<table>
	<tr>
		<th>Project ID</th>
		<th>Project name</th>
		<th>Director ID</th>
		<th>Account</th>
		<th>Start Date</th>
		<th>End Date</th>
		<th>Description</th>
		<th>T.A.F.P.</th>
	</tr>
	<tr>
		<td><?php echo $project_id; ?></td>
		<td><?php echo $project_name; ?></td>
		<td><?php echo $dir_id; ?></td>
		<td><?php echo $account_id; ?></td>
		<td><?php echo $pro_start_date; ?></td>
		<td><?php echo $pro_end_date; ?></td>
		<td><?php echo $project_description; ?></td>
		<td><?php echo $tafp1; ?></td>
	</tr>
</table>		
<fieldset>
<?php } ?>
<form action="view_archived_project.php" method="post">
<input type = "button" value = "Archive Project" class="std_button" onclick="window.location.href='archive_project.php'"/>
<input type = "button" value = "Delete Project" class="std_button" onclick="window.location.href='delete_project/delete_project.php'"/> 
<input type = "button" value = "Director Home" class="std_button" onclick="window.location.href='project_director_home.php'"/>  
<input type = "submit" value = "Reset" name="reset" class="std_button" />  
</form>
</fieldset>
<br>
<br>
<br>
</body>
<footer><p>Capstone Project: Team Avengers 2022</p></footer>
</html>