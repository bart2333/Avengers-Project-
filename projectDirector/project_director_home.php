<?php  
	/*
		CIS 492
		Project Director 
		Date: 03/30/22
		Filename: project_director_home.php
	*/

// need all of this to grab the PD's username and stores in a SESSION
// we could add the password to in case two PD's had the same username 
require_once('../inc/db_connect.php');
include('director/dir_name.php');
include('alerts/alerts.php');
include('webpage/header.php');

?>
	<div class="container">
		<div class="side1" align = "center"> <!-- I created a Project Alerts in a <h4> added to main.css file -->
		<h4 style="font-size: 20px;">Project Alerts:</h4>
		<ul type="A"  class = "dueDates">
		<?php foreach ($projects as $project) : ?>

                <li style="margin-right: 11%;" id="1"><?php $nextDate = strtotime(($project['pro_end_date']));?>
				<?php $currentDate = round((($nextDate-$myDate) /86400), 2);?>
				<?php echo "Project # ". $project['project_id']. " - " . $project['project_name']. " is due in ".$currentDate.   " days.";?> </li>
				<br>
        <?php endforeach; ?>
		</ul>
		</div>
		<div class="side2" align = "center">
		<h4 style="font-size: 20px;" align = "center">Task Alerts:</h4>
		<ul type="A"  class = "dueDates">
		<?php foreach ($task_lists as $task_list) : ?>

                <li style="margin-right: 11%;" ?>
				<?php $nextDate = strtotime(($task_list['due_date'])); ?>
				<?php $currentDate = round((($nextDate-$myDate) /864000), 2); ?>
				<?php if ($currentDate > -30) { ?>
				<?php echo "Project: ". $task_list['project_name']. " - Task: " . $task_list['task_name']. " is complete";?> </li>
				<br>
				<?php } ?>
        <?php endforeach; ?>
		</ul>
		</div>	
			<!--<div class="side2">
		
		</div>-->
	</div>

</body>
<footer><p>Capstone Project: Team Avengers 2022</p></footer>
</html>