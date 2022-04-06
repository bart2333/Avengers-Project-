<?php
	/*
		CIS 492
		Project Director Reports Page 
		Date: 2/26/22
		Filename: run_reports.php
	*/

require_once('../inc/db_connect.php');
include('director/dir_name.php');
include('reports/report_data.php');
include('webpage/header.php');
?>
<main>
	<div class="pdForm2">
	<h1>Project Detail Report</h1>
		<div class="reportForm">
			<table align="center">
				<tr>
					<th>Project Name</th>
					<th>Project Start Date</th>
					<th>Project End Date</th>
					<th>Description</th>
					<th>Personnel Costs</th>
					<th>Team Name</th>
					<th>Team Members</th>
				</tr>
				<?php foreach($projects as $project): ?>
				<tr>
					<td><?php echo $project["project_name"]; ?></td>
					<td><?php echo $project["pro_start_date"]; ?></td>
					<td><?php echo $project["pro_end_date"]; ?></td>
					<td><?php echo $project["project_description"]; ?></td>
					<td><?php echo $project["personnel_cost"]; ?></td>
					<td><?php echo $project["team_name"]; ?></td>
					<td><?php echo $project["mem_fname"]. " ". $project["mem_lname"]; ?></td>
				</tr>
				<?php endforeach; ?>
			</table>
		</div><br><br><br>
	</div>
</main>
</body>
<footer><p>Capstone Project: Team Avengers 2022</p></footer>
</html>