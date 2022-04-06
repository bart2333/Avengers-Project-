<?php

/* 
		CIS 492
		team lead page  
		Date: 03/19/22
		Filename: team_lead_home.php
*/

require_once('../inc/db_connect.php');
include('lead/lead_name.php');
include('alerts/alerts.php');
include('webpage/header.php');
//var_dump($_SESSION['username']);
?>
	

	<div class="container">
		<div class="side1" align = "center">
		<h4 align = "center">Unassigned Task Alerts:</h4>
		<ul type="A"  name = "dueDate1">
		<?php foreach ($unassignedTasks as $unassignedTask) : ?>
		<?php if($unassignedTask['mem_id'] === NULL) { ?>
                <li style="margin-right: 11%; list-style-type: none; font-weight: bold;" id="1">
				
				<?php echo "Task # ".$unassignedTask['task_id']. " ". $unassignedTask['task_name']. " is unassigned.";?> </li>
				<br>
		<?php } ?>
        <?php endforeach; ?>
		</ul>
		
		</div>
		<div class="side2">
		<h4 align = "center">Task Alerts:</h4>
		<ul type="A"  name = "dueDate2">
		<?php foreach ($task_lists as $task_list) : ?>

                <li style="margin-right: 11%; list-style-type: none; font-weight: bold;" id="1"><?php $nextDate = strtotime(($task_list['due_date']));?>
				<?php $currentDate = round((($nextDate-$myDate) /86400), 2);?>
				<?php echo "Task # ".$task_list['task_id']. " ". $task_list['task_name']. " assigned to ". $task_list['mem_fname']. " ". $task_list['mem_lname']. " is due in ".$currentDate.   " days.";?> </li>
				<br>
        <?php endforeach; ?>
		</ul>
		</div>		
	</div>
	<br>
</body>
</html>
<footer>
	<p>Capstone Project: Team Avengers 2022</p>
</footer>
</html>