<?php
	/*
		CIS 492
		Manage project page  
		Date: 03/31/22  
		Filename: manage_project.php
	*/

 
require_once('../../inc/db_connect.php');
include('../director/dir_name.php');
include('../webpage/sub_header.php');
$dir_id = $_SESSION['directorID'];
$project_id = filter_input(INPUT_POST, 'project_id1', FILTER_VALIDATE_INT);
$project_name = filter_input(INPUT_POST, 'project_name');
$account_id = filter_input(INPUT_POST, 'account_id');
$pro_start_date = filter_input(INPUT_POST, 'pro_start_date');date("Y-m-d H:i:s");
$pro_end_date = filter_input(INPUT_POST, 'pro_end_date');date("Y-m-d H:i:s");
$project_description = filter_input(INPUT_POST, 'project_description');
$dir_id1 = filter_input(INPUT_POST, 'dir_id1', FILTER_VALIDATE_INT);

                                              //****  taken out to see all projects can add back in 
// this populates the project drop down menu     ***** WHERE dir_id = :dir_id  $statement->bindValue(':dir_id',$dir_id);
$query = 'SELECT *
          FROM project
		  
          ORDER BY project_id';
$statement = $db->prepare($query);
 
$statement->execute();
$projects = $statement->fetchAll();
$statement->closeCursor();

// this populates the account drop down menu 
$query = 'SELECT *
          FROM accounting
          ORDER BY account_id';
$statement = $db->prepare($query);
$statement->execute();
$accounts = $statement->fetchAll();
$statement->closeCursor();

// this populates the director id drop down menu 
$query = 'SELECT *
          FROM project_director
          ORDER BY dir_id';
$statement = $db->prepare($query);
$statement->execute();
$directors = $statement->fetchAll();
$statement->closeCursor();

//populates the input fields with chosen project_id data  
if(array_key_exists('project_id1',$_POST)) { 
if($project_id != FALSE) {
$query = 'SELECT *
          FROM project
          WHERE project_id = :project_id';
$statement = $db->prepare($query);
$statement->bindValue(':project_id',$project_id); 
$statement->execute();
$project_chosen = $statement->fetch();
$project_name = $project_chosen['project_name'];
$project_start = $project_chosen['pro_start_date'];
$project_end = $project_chosen['pro_end_date'];
$project_description = $project_chosen['project_description'];
$dir_id2 = $project_chosen['dir_id'];
$statement->closeCursor();

}else { 
 $error = "Please select a project prior to continuing";
 
}
}
if(isset($project_id)) {
	$_SESSION['manage']['project_id'] = $project_id;
}

if(array_key_exists('submit1',$_POST)) { 
if($_SESSION['manage']['project_id'] != NULL || $_SESSION['manage']['project_id'] != FALSE){
$query = 'UPDATE project
                 SET project_name = :project_name, dir_id = :dir_id, account_id = :account_id,
					pro_start_date = :pro_start_date, pro_end_date = :pro_end_date, project_description = :project_description
				 WHERE project_id =:project_id'; 
				 
    $statement = $db->prepare($query);
	$statement->bindValue(':project_id', $_SESSION['manage']['project_id']);
	$statement->bindValue(':project_name', $project_name);
    $statement->bindValue(':dir_id', $dir_id1);
	$statement->bindValue(':account_id', $account_id);
    $statement->bindValue(':pro_start_date', $pro_start_date );
	$statement->bindValue(':pro_end_date', $pro_end_date);
    $statement->bindValue(':project_description', $project_description);
    $statement->execute();
    $statement->closeCursor();
	header("Refresh:0");
	unset($_SESSION['manage']);
}else { 
 $error = "Please select a project prior to continuing";
 
}
}

?>

<?php if(isset ($error)) { ?>
<br>
<h3 style="font-size: 20px;" ><?php echo $error;?></h3>
<br>

<?php }?>


<h1 style="font-size: 30px"> Manage Project </h1>
<hr></hr>

<fieldset>

	<h3>Please choose a project to edit</h3>
	
	<form action="" method="POST" >
		<select name="project_id1" style="width:300px; background-color: #d4d4d4">
		<option> ID# -- Project Name </option>
		<?php foreach ($projects as $project) : ?>
           <option value="<?php echo $project['project_id']; ?>" <?php if (isset ($project_id) && ($project_id == $project['project_id'])) { ?> selected = "selected" <?php } ?>>
		  
           <?php echo $project['project_id']; ?>
		   <?php echo $project['project_name']; ?>
	
           </option>
        <?php endforeach; ?>
		</select>
			
		<input type="submit" value="Edit Project" id="" /> 
	</form>
</fieldset >
	<?php if(isset($project_id)) {?>

	<fieldset style="float:left; margin-right: 30px;">
	<form action="manage_project.php" method="post" id="">
		
            <h3>Project Name:</h3> 
			<input style="width:300px;" type="text" name="project_name" required="required" value ="<?php echo $project_name; ?>" class="create_project"/> 
			
			<h3>Director ID:</h3> 
			<select name="dir_id1" style="width:300px; font-weight: bold; background-color: #d4d4d4">
				<?php foreach ($directors as $director) : ?>
                <option value="<?php echo $director['dir_id']; ?>"<?php if($project_id != FALSE) { ?><?php echo $director['dir_id'] === $dir_id2 ? ' selected = "selected"' : '' ?><?php } ?>>
                    <?php echo $director['dir_id']; ?>
					<?php echo $director['dir_fname']; ?> <?php echo $director['dir_lname']; ?>
                </option>
            <?php endforeach; ?>
            </select>
			
			 
            <h3>Estimated Start Date: </h3>
			<input style="width:300px;"type="date" name="pro_start_date" value ="<?php echo $project_start; ?>" class="create_project" /> 
		
			<h3>Estimated End Date:   </h3> 
			<input style="width:300px;" value ="<?php echo $project_end; ?>" type="date" name="pro_end_date"  class="create_project" />
			
			<h3>Please choose account: </h3>
			<select name="account_id" style="width:300px; background-color: #d4d4d4">
				<?php foreach ($accounts as $account) : ?>
                <option value="<?php echo $account['account_id']; ?>">
                    <?php echo $account['acc_name']; ?>
                </option>
            <?php endforeach; ?>
            </select>
			
			<h3>Description: </h3>  
			<textarea rows="10" cols="60" font="16px" name="project_description"><?php echo $project_description; ?></textarea>
			
			<br>
			<input type="submit" value="Edit Project " class="std_button" name="submit1"/> 
			
			
	</form>	
	 
</fieldset> 
<?php if($project_id != FALSE) { ?>
<fieldset style="width: 400px; border: thick solid; float:left; background: #C0C0C0; margin-left: 8%; ">
<h1 style="font-size: 22px; color: black;" > Current Project Data:</h1>
<hr width="100%" >
<h3 style = "color: black;">Project Name: <?php echo $project_name;?>  </h3> 	
<h3 style = "color: black;">Project Start Date: <?php echo $project_start;?>  </h3> 	
<h3 style = "color: black;">Project End Date: <?php echo $project_end;?>  </h3> 
<h3 style = "color: black;">Project Description: <?php echo $project_description;?>  </h3> 
</fieldset>	
<?php } ?>
<?php } ?>	

<fieldset style="clear: left;">	
	<input type = "button" value = "Edit Costs" class="std_button" onclick="window.location.href='../create_project_tab/cost_page/cost_calculator_page.php'"/>  
	<input type = "button" value = "Edit Tasks" class="std_button" onclick="window.location.href='edit_project_tasks.php'"/>  
	<input type = "button" value = "Edit Team" class="std_button" onclick="window.location.href='edit_team.php'"/>  
	
</fieldset>



</body>
<br>
<br>
<br>
<br>
<footer>
	<p>Capstone Project: Team Avengers 2022</p>
</footer>
</html>