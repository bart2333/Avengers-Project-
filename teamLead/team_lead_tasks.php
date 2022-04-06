<?php
/*  
		CIS 492
		team lead tasks 
		Date: 03/30/22
		Filename: team_lead_tasks.php
		**** Updated with new stuff 3-14 the team_id
*/

require_once('../inc/db_connect.php');
include('lead/lead_name.php');
include('webpage/header.php');
$task_list_id = filter_input(INPUT_POST, 'task_list1', FILTER_VALIDATE_INT);
$mem_id = filter_input(INPUT_POST, 'mem_id', FILTER_VALIDATE_INT);
$due_date = filter_input(INPUT_POST, 'due_date');date("Y-m-d H:i:s");
$mem_id1 = $_SESSION['mem_id'];
$error = '';

if(isset($task_list_id)) {
	$_SESSION['teamTasks']['task_list_id'] = $task_list_id;
}

// This gives us the team_id
$query = 'SELECT team_id 
			FROM teams_list
				WHERE mem_id = :mem_id';		
					
$statement = $db->prepare($query);
$statement->bindValue(':mem_id',$mem_id1); 
$statement->execute();
$variable1 = $statement->fetch(); 
$team_id = $variable1['team_id'];
$statement->closeCursor();

//This will give us all the projects for that team_id ***
$query = 'SELECT *

		FROM teams_list
		INNER JOIN team
		ON teams_list.team_id = team.team_id
		INNER JOIN project
		ON team.project_id = project.project_id
		WHERE teams_list.team_id = :team_id';		
					
$statement = $db->prepare($query);
$statement->bindValue(':team_id',$team_id); 
$statement->execute();
$variable1 = $statement->fetch(); 
$project_id = $variable1['project_id'];
$name = $variable1['project_name'];
$start = $variable1['pro_start_date'];
$end = $variable1['pro_end_date'];
$desc = $variable1['project_description'];
$statement->closeCursor();


// this grabs all the tasks 
$query = 'SELECT *
          FROM task_list
		  INNER JOIN tasks
		  ON task_list.task_id = tasks.task_id
		  WHERE task_list.project_id = :project_id
		  AND task_list.team_id = :team_id';	
$statement = $db->prepare($query);
$statement->bindValue(':project_id',$project_id); 
$statement->bindValue(':team_id',$team_id); 
$statement->execute();
$task_lists = $statement->fetchAll();
$statement->closeCursor();

if(array_key_exists('selectTask',$_POST)) { 

$query = 'SELECT * 
			FROM teams_list
			INNER JOIN team_members
		  ON teams_list.mem_id = team_members.mem_id
				WHERE team_id = :team_id	
				ORDER BY teams_list.mem_id';	
$statement = $db->prepare($query);
$statement->bindValue(':team_id',$team_id); 
$statement->execute();
$teams_lists = $statement->fetchALL(); 
$statement->closeCursor();

}

if(array_key_exists('chooseMember',$_POST)) { 

$query = 'UPDATE task_list
            SET mem_id = :mem_id, due_date = :due_date
			   WHERE task_list_id = :task_list_id';
    $statement = $db->prepare($query);
	$statement->bindValue(':task_list_id',$_SESSION['teamTasks']['task_list_id']);
    $statement->bindValue(':mem_id', $mem_id);
    $statement->bindValue(':due_date',$due_date);
    $statement->execute();
    $statement->closeCursor();

	unset($_SESSION['teamTasks']); 
	unset($_SESSION['mem_id']);
	header('location:team_lead_tasks.php?success=1');
}
if(isset($_GET['success'])) {
	$error = 'The task has been assigned successfully!';
}
?>

<html>
<body>	
	
	<h1 style="font-size: 30px"> Assign Members Tasks </h1>
	<hr></hr>
	<br>
	
	<table>
		<tr>
			<th>Project ID</th>
			<th>Project Name</th>
			<th>Project Start Date</th>
			<th>Project End Date</th>
			<th>Project Description</th>
		</tr>
		<tr>
			<td><?php echo $project_id; ?></td>
			<td><?php echo $name; ?></td>
			<td><?php echo $start; ?></td>
			<td><?php echo $end; ?></td>
			<td><?php echo $desc; ?></td>
			
		</tr>
	</table>
<br>
		
<fieldset>
<form action="" method="post">
	<h3 style="font-size: 30px" >Please choose a task to assign: </h3>
	<select name="task_list1" style="width:300px;">
		<option>ID -- name </option>
			<?php foreach ($task_lists as $task_list) : ?>
                <option value="<?php echo $task_list['task_list_id']; ?>" <?php if (isset ($task_list_id) && ($task_list_id == $task_list['task_list_id'])) { ?> selected = "selected" <?php } ?>>
                    <?php echo $task_list['task_id']; ?>
					<?php echo $task_list['task_name']; ?>					
                </option>
            <?php endforeach; ?>
	</select>
	
		<input type="submit" value="Select Task" name="selectTask" /> 
</form>
</fieldset>	
<?php if(isset($task_list_id)) {?>
<fieldset>
<form action="team_lead_tasks.php" method="post">
	<h3 style="font-size: 30px" >Please choose a team member: </h3>
	<select name="mem_id" style="width:300px;">
		<option>ID -- name </option>
			<?php foreach ($teams_lists as $teams_list) : ?>
                <option value="<?php echo $teams_list['mem_id']; ?>">
                    <?php echo $teams_list['mem_id']; ?>
					<?php echo $teams_list['mem_fname']; ?>
					<?php echo $teams_list['mem_lname']; ?>	
								
                </option>
            <?php endforeach; ?>
			<?php echo $teams_list['mem_lname']; ?>
	</select>
	<h3 style="font-size: 30px; ">Assigned due date: </h3>
			<input style="width:200px; " type="date" name="due_date"  /> <br><br><br>
			<input type="submit" value="Choose Member" name="chooseMember" class="std_button"/> 
</form>
<br>
<br>
<br>
<br>

</fieldset>
<?php } ?>	
<footer>
	<p>Capstone Project: Team Avengers 2022</p>
</footer>
</html>

</body>
</html>