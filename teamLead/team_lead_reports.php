<?php
	/*
		CIS 492
		Team Lead Reports page
		Date: 3/2/22
		Filename: team_lead_reports.php
	*/

require_once('../inc/db_connect.php');	
include('lead/lead_name.php');
include('reports/report_data.php');
include('webpage/header.php');
?>
<main>
<aside class="detail">
	<!--<div class="reportType">
		<ul class="reportNames">
			<li><a href='team_lead_reports.php' style="color: white">Display Lead's Projects</a></li><br>
		</ul>
	</div> -->
</aside>
	<div class="report">
		<h1>CALU Project Tracking and Scheduling Reports Page</h1>	
			<div class="reportForm" id="excel_data">
			<h3>All Current Projects for the Team Member</h3>
			<table id="table_content" align="center">
				<tr>
					<th>Project Name</th>
					<th>Project Start Date</th>
					<th>Project End Date</th>
					<th>Description</th>
					<th>Team Name</th>
				</tr>
				<?php foreach($projects as $project): ?>
				<tr>
					<td><?php echo $project["project_name"]; ?></td>
					<td><?php echo $project["pro_start_date"]; ?></td>
					<td><?php echo $project["pro_end_date"]; ?></td>
					<td><?php echo $project["project_description"]; ?></td>
					<td><?php echo $project["team_name"]; ?></td>
				</tr>
				<?php endforeach; ?>
			</table>
		</div><br><br>
	</div><br><br>
</main>
</body>
<footer><p>Capstone Project: Team Avengers 2022</p></footer>
</html>
