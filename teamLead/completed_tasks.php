<?php 
/* 
		CIS 492
		completed tasks page  
		Date: 03/23/22
		Filename: completed_tasks.php
*/


require_once('../inc/db_connect.php');
include('lead/lead_name.php');
include('webpage/header.php');



//gets task_list_id for the final update
$task_list_id = filter_input(INPUT_POST, 'task_list_id', FILTER_VALIDATE_INT);	
//gets the mem_id to get the team id
$mem_id1 = $_SESSION['mem_id'];

//refreshes the page so the value of is_complete is current and not lagging
if(isset($task_list_id)) {
	header("Refresh:0");
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
		  INNER JOIN team_members
		  ON task_list.mem_id = team_members.mem_id
		  WHERE task_list.project_id = :project_id
		  AND task_list.team_id = :team_id';	
$statement = $db->prepare($query);
$statement->bindValue(':project_id',$project_id); 
$statement->bindValue(':team_id',$team_id); 
$statement->execute();
$task_lists = $statement->fetchAll();
$statement->closeCursor();


if(array_key_exists('completed',$_POST)) { 


// gets the value of is_complete for the selected task_list_id... 
$query = 'SELECT *
			FROM task_list 
				WHERE task_list_id = :task_list_id';		
					
$statement = $db->prepare($query);
$statement->bindValue(':task_list_id',$task_list_id); 
$statement->execute();
$change = $statement->fetch(); 
$is_complete = $change['is_complete'];
$statement->closeCursor();

// updates the is_complete value for the selected task
$query = 'UPDATE task_list
                 SET is_complete = :is_complete
				 WHERE task_list_id =:task_list_id'; 
				 
    $statement = $db->prepare($query);
	$statement->bindValue(':task_list_id', $task_list_id);
	if($is_complete == 'N') {	
		$statement->bindValue(':is_complete', 'Y');
		
	} else {
		$statement->bindValue(':is_complete', 'N');
		
	}
    $statement->execute();
    $statement->closeCursor();

}


?>


<html>
<body>

	<h1 style="font-size: 30px"> Task Status </h1>
	<hr></hr>
<br>
<br>

<fieldset>
<form action="" method="post">
	<table>
		<tr>
			<th>Task Name</th>
			<th>Due Date</th>
			<th>Assigned to</th>
			<th>Complete?</th>
			<th>Status</th>
		</tr>
		<?php foreach ($task_lists as $task_list) : ?>
		<tr>
			<td><?php echo $task_list['task_name']; ?></td>
			<td><?php echo $task_list['due_date']; ?></td>
			<td><?php echo $task_list['mem_fname']; ?> <?php echo $task_list['mem_lname']; ?></td>
			<td><?php echo $task_list['is_complete']; ?></td>
			<td> 
				<form action="" method="post">
				<input type = "hidden" name = "task_list_id" value = "<?php echo $task_list['task_list_id'];?>">
				<input type = "submit" name="completed" value ="<?php if($task_list['is_complete'] == 'N'){ ?><?php echo "mark complete";}?> <?php if($task_list['is_complete'] == 'Y') { ?> <?php echo "mark not complete"; }?> ">
			</form>	 
			</td>	 
		</tr>
		<?php endforeach; ?>

</fieldset>

</body>
</html>


<footer>
	<p>Capstone Project: Team Avengers 2022</p>
</footer>
</html>














































