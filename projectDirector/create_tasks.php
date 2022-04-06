<?php
	/*
		CIS 492
		Create Tasks Page
		Author: Team Avengers
		Date: 02/13/22
		Filename: create_tasks.php
	*/

require_once('../inc/db_connect.php');
include('director/dir_name.php');
include('webpage/header.php');
include('../login/check_credentials.php');

$queryTasks = "SELECT * FROM tasks ORDER BY task_category";
$stmt = $db->prepare($queryTasks);
$stmt->execute();
$tasks = $stmt->fetchAll();
$stmt->closeCursor();

$error = '';

if(isset($_POST['register'])) {
	$task_name = filter_input(INPUT_POST, 'task_name');
	$task_category = filter_input(INPUT_POST, 'task_category');

//check for unique values in the task name
$queryCheckName = 'SELECT COUNT(*) FROM tasks WHERE task_name =:task_name';
$stmt1 = $db->prepare($queryCheckName);
$stmt1->bindValue(':task_name', $task_name);
$stmt1->execute();
$countName = $stmt1->fetchColumn();	
	
// check to see if the input fields are NOT empty - if they are not empty, it will check to see if the task exists and
// if so you will be redirected to the create tasks page with the correct message and if it does not exist then it will add the task to the system	
	if(!empty($task_name) && !empty($task_category)) {		
		if($countName>0) {
			header('location:create_tasks.php?already=1');
		} else {
			add_tasks($task_name, $task_category);
			header('location:create_tasks.php?inserted=1');
		}
	} else {
		header('location:create_tasks.php?required=1');
	}
}

// these are the different redirect options that will be completed based on which function was completed
if(isset($_GET["inserted"])) {
	$error = "The task has been added to the database.";
}

if(isset($_GET["already"])) {
	$error = "The task you are attempting to create already exists in the database.";
}

if(isset($_GET["required"])) {
	$error = "Please enter in a name and category to be submitted.";
}

// function to delete a specific task via a button - the button is placed within the table
if(isset($_POST['deleteTask'])) {
	$id = $_POST['task_id'];
	
	$queryDeleteTask = 'DELETE FROM tasks WHERE task_id =' .$id;
	$stmt3 = $db->prepare($queryDeleteTask);
	$stmt3->execute();
	
	header('location:create_tasks.php?deleted=1');
}

// this will provide the specific message to display to the project director letting them know the project was deleted
if(isset($_GET['deleted'])) {
	$error = "The task has been deleted from the system.";
}
?>

<main>
	<div class="pdForm3">
		<h1>Create Tasks for various Projects</h1>
		<p>Please refer to the table below to ensure your task does not already exist.</p>
		<p>Please complete all fields within this form.</p>
		<div class="entryForm2">
			<form method="POST">
				<span style="color: yellow"><b><?php if($error != '') { echo $error; } ?></b></span><br>			
				<br><label>Task Name:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="text" name="task_name" placeholder="Create Project"><br>
				
				<label>Task Category:</label>
				<input type="text" name="task_category" placeholder="Planning Phase"><br>
				<br>
				<input type="submit" name="register" value="Register" style = "font-size: medium">	<br>			
			</form><br>
				<table align="center">
					<tr>
						<th>Task Name</th>
						<th>Task Category</th>
						<th>Drop Task</th>
					</tr>
					<?php foreach($tasks as $task): ?>
					<tr>
						<td><?php echo $task["task_name"]; ?> </td>
						<td><?php echo $task["task_category"]; ?> </td>
						<td>
							<form method="POST">
								<input type="hidden" name="task_id" value="<?php echo $task['task_id']; ?>"> <!-- used to delete a task from the system -->
								<input type="submit" name="deleteTask" value="Delete">
							</form>
						</td>
					</tr>
					<?php endforeach; ?>
				</table>
		</div><br><br>
	</div>
</main>
</body><br>
<footer><p>Capstone Project: Team Avengers 2022</p></footer>
</html>