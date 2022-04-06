<?php 
	/*    
		CIS 492
		Assign Tasks to Project Page
		Author: Team Avengers
		Date: 03/30/22
		Filename: assign_tasks_project.php
	*/ 

require_once('../inc/db_connect.php');
include('director/dir_name.php');
include('webpage/header.php');

$project_id = filter_input(INPUT_POST, 'project_id', FILTER_VALIDATE_INT);
$task_id = filter_input(INPUT_POST, 'task_id', FILTER_VALIDATE_INT);


// this query populates the drop down menu of projects for selection  
$query = 'SELECT *
          FROM project
          ORDER BY project_id';
$statement = $db->prepare($query);
$statement->execute();
$projects = $statement->fetchAll();
$statement->closeCursor();

// this query populates the drop down menu of tasks for selection

$query = 'SELECT *
          FROM tasks
          ORDER BY task_id';
$statement = $db->prepare($query);
$statement->execute();
$tasks = $statement->fetchAll();
$statement->closeCursor();
 

if(isset($project_id)) {
	$_SESSION['task']['project_id'] = $project_id;
}

if(isset($task_id)) {
	$_SESSION['task']['task_id'] = $task_id;
	$project_id = $_SESSION['task']['project_id'];
}
if(array_key_exists('project',$_POST)) {
	if($project_id == FALSE) {
	$error = "Please make a selection for each menu prior to continuing";
	}	
}
// this checks the task_id selected and sees if it is already in task_list
if(array_key_exists('task_id',$_POST)) { 
///////////////////////////////////////////////////
//////////////////////////////////////////////////
$query = 'SELECT *
          FROM task_list
          WHERE project_id = :project_id
		  AND task_id = :task_id';
$statement1 = $db->prepare($query);
$statement1->bindValue(':project_id',$project_id); 
$statement1->bindValue(':task_id',$task_id); 
$statement1->execute();
$myTasks = $statement1->fetchAll();
$statement1->closeCursor();

}

//populates the output at the end of the page 
if(array_key_exists('selectTask',$_POST)) {
if ($task_id != NULL || $task_id != FALSE) {
$query = 'SELECT *
          FROM project
          WHERE project_id = :project_id';
$statement = $db->prepare($query);
$statement->bindValue(':project_id',$_SESSION['task']['project_id']); 
$statement->execute();
$project_view = $statement->fetch();
$id = $project_view['project_id'];
$name = $project_view['project_name'];
$statement->closeCursor();


//populates the output at the end of the page 

$query = 'SELECT *
          FROM tasks
          WHERE task_id = :task_id';
$statement = $db->prepare($query);
$statement->bindValue(':task_id',$_SESSION['task']['task_id']); 
$statement->execute();
$task_view = $statement->fetch();
$task_id1 = $task_view['task_id'];
$task_name1 = $task_view['task_name']; 
$_SESSION['task']['task_name'] = $task_name1;
$_SESSION['task']['task_id1'] = $task_id1;
$statement->closeCursor();
}else { 
 $error = "Please make a selection for each menu prior to continuing";
 
}
}
if(array_key_exists('selectTask',$_POST)) { 
$query = 'SELECT *
          FROM task_list
		  INNER JOIN tasks
		  ON task_list.task_id = tasks.task_id
          WHERE project_id = :project_id
		  ORDER BY task_list.task_id';
$statement = $db->prepare($query);
$statement->bindValue(':project_id',$_SESSION['task']['project_id']); 
$statement->execute();
$objects = $statement->fetchAll();
$statement->closeCursor();

$query = 'SELECT *
          FROM tasks
          WHERE task_id = :task_id';
$statement = $db->prepare($query);
$statement->bindValue(':task_id',$_SESSION['task']['task_id']); 
$statement->execute();
$tasks = $statement->fetchAll();
$statement->closeCursor();
}
// inserts final data into task_list table 
if(array_key_exists('select_task',$_POST)) {
	if(!empty($_SESSION['task']['project_id']) && !empty($_SESSION['task']['task_name']) && !empty($_SESSION['task']['task_id'])) {
		$query = 'INSERT INTO task_list
						 (task_name, project_id, task_id, is_complete)
					  VALUES
						 (:task_name, :project_id, :task_id, :is_complete)';
			$statement = $db->prepare($query);
			$statement->bindValue(':task_name', $_SESSION['task']['task_name']);
			$statement->bindValue(':project_id',$_SESSION['task']['project_id']); 
			$statement->bindValue(':task_id',$_SESSION['task']['task_id1']); 
			$statement->bindValue(':is_complete','N'); 
			$statement->execute();
			$statement->closeCursor();	
			unset($error);
			unset($_SESSION['task']);
	}else { 
 $error = "Please make a selection for each menu prior to continuing";
 
}
}	

//clears the pesky SESSION 
if(array_key_exists('reset',$_POST)) { 

unset($_SESSION['task']);
}
?>
<?php if(isset ($error)) { ?>
<br>
<h3 style="font-size: 20px;" ><?php echo $error;?></h3>
<br>

<?php }?>




<?php if(!empty($myTasks) ) {?>
	<h3 style="font-size: 20px;"> This Task is Already Assigned</h3>
	<?php unset($_SESSION['task']);?>
	<br>
	<form action="assign_tasks_project.php" method="POST">
	<input type = "button" value = "Go Back" class="std_button" onclick="window.location.href='assign_tasks_project.php'" /> 
	<br>
	
	</form>	
<?php } ?>

<?php if(empty($myTasks)) {?>
<h1>Assign Tasks</h1>
<hr></hr>
<br>
<div>		
<fieldset>
<form action="" method="post">
	<h3>Please choose a project to add tasks: </h3>
			<select name="project_id">
				<option>ID -- name </option>
				<?php foreach ($projects as $project) : ?>
                <option value="<?php echo $project['project_id']; ?>" <?php if (isset ($project_id) && ($project_id == $project['project_id'])) { ?> selected = "selected" <?php } ?>>
                    <?php echo $project['project_id']; ?>
					<?php echo $project['project_name']; ?>
					
                </option>
            <?php endforeach; ?>
			</select>
	
		<input type="submit" value="Select Project" name="project" /> 
</form>
</fieldset>
<?php if((isset($project_id) || isset($task_id)) && ($task_id !== FALSE && $project_id !== FALSE)) {?>
<fieldset>
	<form action="" method="POST" >
	<h3>Please choose a task to add: </h3>
	
				<select name="task_id" style="width:300px;">
				<option> id -- category -- name </option>
				<?php foreach ($tasks as $task) : ?>
                <option value="<?php echo $task['task_id']; ?>" <?php if (isset($task_id) && ($task_id == $task['task_id'])) { ?> selected = "selected" <?php } ?>>
					<?php echo $task['task_id']; ?> - 
					<?php echo $task['task_category']; ?> -  
                    <?php echo $task['task_name']; ?> 

                </option>
            <?php endforeach; ?>
				</select>
		
		<input type="submit" value="Select Task" name="selectTask" /> 
			
</div>
<?php } ?>
<br>
<br>
<br>

</fieldset>
</form>
<?php if(isset($task_id) && $task_id != FALSE) {?>

<fieldset class="grayBox">
<h3  style="font-size:22px ; color: black;">Review Prior to Submission</h3>
<hr width="100%" >

		
		<h3 style = "color: black;" > Selected Project: <br><br><?php if ($task_id != NULL || $task_id != FALSE) {echo $id. "-" . $name; }?></h3>
		<h3 style = "color: black;"> Task to Add: <br><br><?php if ($task_id != NULL || $task_id != FALSE) { echo $task_id1. "-" . $task_name1;} ?> </h3><br>
		<h3 style = "color: black;">Tasks Already Added:</h3>
		<?php foreach ($objects as $object) : ?>
		<h3 style = "color: black;"><?php echo $object['task_id'];?> -  
		<?php echo $object['task_category'];?> - 
		<?php echo $object['task_name'];?></h3>
		<?php endforeach; ?>
		


</fieldset>
<?php } ?>
<fieldset style="clear: left;">
	<form action="assign_tasks_project.php" method="POST">
	<input type = "submit" value = "Add Selected Task" name="select_task" class="std_button" /> 
	<input type = "button" value = "Add Costs" class="std_button" onclick="window.location.href='create_project_tab/cost_page/cost_calculator_page.php'"/>   
	<input type = "button" value = "Add Team" class="std_button" onclick="window.location.href='assign_team.php'"/>  
	<input type = "button" value = "Create Project Page" class="std_button" onclick="window.location.href='create_project_tab/create_project.php'" />
	<input type = "submit" value = "Reset Page"  name = "reset" class="std_button" "/>
	</form>
</fieldset>
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
</html><?php } ?>
	