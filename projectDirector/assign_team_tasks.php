<?php
	/* 
		CIS 492
		Assign Team Page 
		Date: 04/01/22 
		Filename: assign_team_tasks.php 
	*/ 

require_once('../inc/db_connect.php');
include('director/dir_name.php');
include('webpage/header.php');

$project_id = filter_input(INPUT_POST, 'project_id', FILTER_VALIDATE_INT);
$task_id = filter_input(INPUT_POST, 'task_id', FILTER_VALIDATE_INT);
$team_id = filter_input(INPUT_POST, 'team_id', FILTER_VALIDATE_INT);

// sets variable values into SESSION for storage to use in query below 
if($project_id != NULL && $project_id != FALSE) {
	$_SESSION['c']['project_id'] = $project_id;	
}
if($task_id != NULL && $task_id != FALSE) {
	$_SESSION['c']['task_id'] = $task_id;	
}
if($team_id != NULL && $team_id != FALSE) {
	$_SESSION['c']['team_id'] = $team_id;	
}
//validation for invalid 1st <select> choice
if(array_key_exists('project',$_POST)) {
	if($project_id == FALSE){
	$error = "Please make a selection for each menu prior to continuing";	
}
}
//validation for invalid 2nd <select> choice
if(array_key_exists('task',$_POST)) {
	if($task_id == FALSE){
	$error = "Please make a selection for each menu prior to continuing";	
}
}	

// this query populates the 1ST drop down menu of projects for selection
$query = 'SELECT *
          FROM project
          ORDER BY project_id';
$statement = $db->prepare($query);
$statement->execute();
$projects = $statement->fetchAll();
$statement->closeCursor();

// this query populates the 2ND drop down menu of tasks for selection
$query = 'SELECT *
          FROM task_list
		  WHERE project_id = :project_id
          ORDER BY task_id';
$statement = $db->prepare($query);
$statement->bindValue(':project_id', $project_id);
$statement->execute();
$tasks = $statement->fetchAll();
$statement->closeCursor();

// this query populates the 3RD drop down menu of teams for selection
if(array_key_exists('task_id',$_POST)) { 
if(!empty($_SESSION['c'])) {
$query = 'SELECT *
          FROM task_list
		  INNER JOIN team
		  ON task_list.project_id = team.project_id
		  WHERE task_list.project_id = :project_id
		  AND task_list.task_id = :task_id
          ORDER BY team.team_id';
$statement = $db->prepare($query);
$statement->bindValue(':project_id', $_SESSION['c']['project_id']);
$statement->bindValue(':project_id', $_SESSION['c']['project_id']);
$statement->bindValue(':task_id', $task_id);
$statement->execute();
$teams = $statement->fetchAll();
$statement->closeCursor();
}else {
	$error = "Please make a selection for each menu prior to continuing";	
}
}

if(array_key_exists('chooseTeam',$_POST)) {
if(!empty($_SESSION['c'])) {
if($_SESSION['c']['project_id'] != NULL && $_SESSION['c']['project_id'] != FALSE) {
$project_id = $_SESSION['c']['project_id'];
}
if($_SESSION['c']['task_id'] != NULL && $_SESSION['c']['task_id'] != FALSE) {
$task_id = $_SESSION['c']['task_id'];	
}
if ($team_id != FALSE) {	
$query = 'SELECT *
          FROM team
		  WHERE team_id = :team_id
          ORDER BY team_id';
$statement = $db->prepare($query);
$statement->bindValue(':team_id', $team_id);
$statement->execute();
$teams1 = $statement->fetch();
$team_name = $teams1['team_name'];
$statement->closeCursor();
}else {$error = "Please make a selection for each menu prior to continuing";	
}
if($task_id != FALSE && $team_id != FALSE) {
	
$query = 'SELECT *
          FROM tasks
		  WHERE task_id = :task_id
          ORDER BY task_id';
$statement = $db->prepare($query);
$statement->bindValue(':task_id', $task_id);
$statement->execute();
$tasks1 = $statement->fetch();
$task_name = $tasks1['task_name'];
$statement->closeCursor();
}
}else {
	$error = "Please make a selection for each menu prior to continuing";	
}
}
// populates a SESSION of tasks to show to user and add to task_list once user is finished
if(array_key_exists('chooseTeam',$_POST)) {
	
	if((!empty($_SESSION['c']['project_id'])) && (!empty($_SESSION['c']['task_id'])) && ($task_id != FALSE) && ($team_id != FALSE)) {
	$_SESSION['tasks'][] = 
	array(
	'project_id' => $project_id,
	'task_id' => $task_id,
	'team_id' => $team_id,
	'task_name' => $task_name,
	'team_name' => $team_name

	);
    
}else {
	$error = "Please make a selection for each menu prior to continuing";	
}   
}
if(array_key_exists('enter',$_POST)) { 
// confirms SESSION is set 
if(!empty($_SESSION['tasks'])) {
// updates the team_id in task_list 
foreach ($_SESSION['tasks'] as $id => $b) :
$query = 'UPDATE task_list
			SET team_id = :team_id                
			WHERE project_id = :project_id
			AND task_id = :task_id';
    $statement = $db->prepare($query);
	$statement->bindValue(':project_id', $b['project_id']);
	$statement->bindValue(':task_id', $b['task_id']);
	$statement->bindValue(':team_id', $b['team_id']);
    $statement->execute();
    $statement->closeCursor();
endforeach;
	// only deletes this session :)
	unset($_SESSION['c']);
unset($_SESSION['tasks']);
$test = 0;	
}else {
	$error = "Please make a selection for each menu prior to continuing";	
}
}
if(array_key_exists('reset',$_POST)) { 
unset($_SESSION['tasks']);
unset($_SESSION['c']);
header("Refresh:0");

}
?>

<?php if(isset ($error)) { ?>
<br>
<h3 style="font-size: 20px;" ><?php echo $error;?></h3>
<br>

<?php }?>


<form action="" method="POST" >
<fieldset style="color: green;">
	<h1 style="font-size: 32px; color: white;">Assign Tasks to Team</h1>
	<hr> </hr>
</fieldset>	
<fieldset >

		
		<h3>Please choose a project to begin</h3>
			<select name="project_id" style="width:300px;">
				<option> ID# -- Project Name </option>
				<?php foreach ($projects as $project) : ?>
                <option value="<?php echo $project['project_id']; ?>" <?php if (isset ($_POST['project_id']) && ($_POST['project_id'] == $project['project_id'])) { ?> selected = "selected" <?php } ?>>
                    <?php echo $project['project_id']; ?>
					<?php echo $project['project_name']; ?>				
					 
                </option>
				<?php endforeach; ?>
			</select>
		<input type="submit" value="Choose Project" name = "project" /> 

</fieldset>

<fieldset >

		<h3>Please choose a task to assign: </h3>		
			<select name="task_id" style="width:300px;">
				<option> ID# -- Task Name </option>
				<?php foreach ($tasks as $task) : ?>
                <option value="<?php echo $task['task_id']; ?>" <?php if(isset($_POST['task_id']) && ($_POST['task_id'] == $task['task_id'])) { ?> selected = "selected" <?php } ?>>
                    <?php echo $task['task_id']; ?> -
					<?php echo $task['task_name']; ?> 
					
                </option>
				<?php endforeach; ?>
			</select>	
			<input type="submit" value="Select Task" name="task" /> 
</fieldset>
<fieldset style="float:left; margin-right: 30px;">
		<h3>Please choose a team: </h3>		
			<select name="team_id" style="width:300px;">
				<option> ID# -- Team Name </option>
				<?php foreach ($teams as $team) : ?>
                <option value="<?php echo $team['team_id']; ?>" <?php if(isset($_POST['team_id']) && ($_POST['team_id'] == $team['team_id'])) { ?> selected = "selected" <?php } ?>>
                    <?php echo $team['team_id']; ?> -
					<?php echo $team['team_name']; ?> 
					
                </option>
				<?php endforeach; ?>
			</select>	
		<input type="submit" value="Choose Team" name="chooseTeam" /> 

</fieldset>

</form>
<?php if(!empty($_SESSION['tasks'])) {?>
<fieldset style="width: 400px; float:left; margin-left: 8%; ">
<table class="blackBox">
<?php if(isset($_SESSION['tasks'])) { ?> 
<?php foreach ($_SESSION['tasks'] as $id => $b) : ?>
<tr>
<td>Project # <?php echo $b['project_id'];?> - Task: <?php echo $b['task_id'];?> <?php echo $b['task_name'];?> - Team: <?php echo $b['team_name'];?></td>

</tr>
<?php endforeach; ?>
</table>
</fieldset>
<?php } ?>
<?php } ?>



<fieldset style="clear: left;">
<form action="assign_team_tasks.php" method="POST">
	<input type="submit" value="Assign Task(s) to Team" name="enter" class="std_button"/> 
	<input type = "button" value = "Assign Team Page" class="std_button" onclick="window.location.href='assign_team.php'" />  
	<input type = "button" value = "Create Project Page" class="std_button" onclick="window.location.href='create_project_tab/create_project.php'" />  
	<input type = "submit" value = "Reset Page"  name = "reset" class="std_button" />
	
</form>	
</fieldset>
<br>
<br>
</body>
<footer><p>Capstone Project: Team Avengers 2022</p></footer>
</html>	