<?php

/* 
		CIS 492
		Date: 03/30/22 
		Filename: edit_project_tasks.php 
*/ 

require_once('../../inc/db_connect.php');
 
include('../director/dir_name.php');
include('../webpage/sub_header.php');

$project_id = filter_input(INPUT_POST, 'project_id', FILTER_VALIDATE_INT);
$task_list_id = filter_input(INPUT_POST, 'task_list_id', FILTER_VALIDATE_INT);

if(isset($project_id)) {
	$_SESSION['b']['project_id'] = $project_id;
}

// this query populates the 1st drop down menu of projects for selection  
$query = 'SELECT *
          FROM project
          ORDER BY project_id';
$statement = $db->prepare($query);
$statement->execute();
$projects = $statement->fetchAll();
$statement->closeCursor();

// inner join to populate 2nd drop down 
if(array_key_exists('project_id',$_POST)) { 
if ($project_id != FALSE) {
$query = 'SELECT *
          FROM task_list
			INNER JOIN tasks
			ON task_list.task_id = tasks.task_id
          WHERE project_id = :project_id
		  ORDER BY task_list.task_id';
$statement = $db->prepare($query);
$statement->bindValue(':project_id',$project_id); 
$statement->execute();
$task_lists = $statement->fetchALL();
$statement->closeCursor();
}else {
	$error = "Please make a selection prior to continuing";		
}
}
// this query populates the drop down menu of tasks for selection

if(array_key_exists('task_list_id',$_POST)) {
if ($task_list_id != FALSE) {
$query = 'DELETE FROM task_list
             WHERE task_list_id = :task_list_id';    
			 
    $statement = $db->prepare($query);
    $statement->bindValue(':task_list_id', $task_list_id);
    $statement->execute();
    $statement->closeCursor();
	unset($_SESSION['b']);
}else {
	$error = "Please make a selection prior to continuing";		
}
}	
	

?>

<?php if(isset ($error)) { ?>
<br>
<h3 style="font-size: 20px;" ><?php echo $error;?></h3>
<br>

<?php }?>

<h1 style="font-size: 40px">Edit Tasks</h1>
<hr></hr>
<br>
		
<fieldset>
<form action="" method="post">
	<h3>Please choose a project to edit tasks: </h3>
			<select name="project_id">
				<option>ID -- name </option>
				<?php foreach ($projects as $project) : ?>
                <option value="<?php echo $project['project_id']; ?>" <?php if (isset ($project_id) && ($project_id == $project['project_id'])) { ?> selected = "selected" <?php } ?>>
                    <?php echo $project['project_id']; ?>
					<?php echo $project['project_name']; ?>
					
                </option>
            <?php endforeach; ?>
			</select>
	
		<input type="submit" value="Select Project" id="" /> 
</form>
</fieldset>

<?php if(isset($project_id) && ($project_id != FALSE)) {?>
<fieldset>
	<form action="" method="POST" >
	<h3>Please choose a task to delete: </h3>
	
				<select name="task_list_id" style="width:300px;">
				<option>  ID -- category -- name </option>
				<?php foreach ($task_lists as $task_list) : ?>
                <option value="<?php echo $task_list['task_list_id']; ?>">
					<?php echo $task_list['task_id']; ?> - 
					<?php echo $task_list['task_category']; ?> - 
                    <?php echo $task_list['task_name']; ?> 
					
                </option>
            <?php endforeach; ?>
				</select>
		
		<input type="submit" value="Delete Task" name="delete_task" /> 		
</form>
</fieldset>
<?php } ?>







<input type = "button" value = "Edit Costs" class="std_button" onclick="window.location.href='../create_project_tab/cost_page/cost_calculator_page.php'"/>   
	<input type = "button" value = "Edit Team" class="std_button" onclick="window.location.href='edit_team.php'"/>  
	<input type = "button" value = "Director Home" class="std_button" onclick="window.location.href='../project_director_home.php'" />  
	<input type = "button" value = "Manage Project" class="std_button" onclick="window.location.href='manage_project.php'" /> 
<br>
<br>
<br>
<br>
<br>
</body>
<footer><p>Capstone Project: Team Avengers 2022</p></footer>
<br>
<br>
<br>
</html>