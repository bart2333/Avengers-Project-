<?php
	/*
		CIS 492
		Project Director Reports Page 
		Date: 2/26/22
		Filename: directorProjects.php
	*/

require_once('../../inc/db_connect.php');
include('director/dir_name.php');
include('report_data2.php');
include('webpage/header.php');
?>
<main>
<aside>
	<div class="reportType">
		<ul class="reportNames">
			<h3><b>REPORT OPTIONS:</b></h3>		
			<li><a href='../run_reports.php' style="color: white">Display All Projects</a></li><br>			
			<li><a href='allProjects.php' style="color: white">Display All Projects with TEAMS</a></li><br>
			<li><a href='directorProjects.php' style="color: white">Display Director's Projects</a></li><br>
			<li><a href='archiveProjects.php' style="color: white">Display Archived Projects</a></li><br>
			<li><a href='allDirectors.php' style="color: white">Display all Directors</a></li><br>
			<li><a href='allTeamMembers.php' style="color: white">Display All Team Members</a></li><br>
			<li><a href='allTeams.php' style="color: white">Display All Teams</a></li><br>
		</ul>
	</div>
</aside>
	<div class="report">
		<h1>CALU Project Tracking and Scheduling Reports Page</h1>
			<div class="export">
				<button style="float:right" type="button" id="export_btn"> <img src="webpage/excel.jpg" height ="18"/></button>
			</div> 		
			<div class="reportForm" id="excel_data">
			<h3>List of all Projects created by <?php echo $variable1['dir_fname']. " ". $variable1['dir_lname']; ?></b>&nbsp;</h3>
			<table id="table_content" align="center">
				<tr>
					<th>Project Name</th>
					<th>Project Start Date</th>
					<th>Project End Date</th>
					<th>Description</th>
					<th>Personnel Costs</th>
					<th>Team Name</th>
				</tr>
				<?php foreach($projects as $project): ?>
				<tr>
					<td><?php echo $project["project_name"]; ?></td>
					<td><?php echo $project["pro_start_date"]; ?></td>
					<td><?php echo $project["pro_end_date"]; ?></td>
					<td><?php echo $project["project_description"]; ?></td>
					<td><?php echo "$". $project["personnel_cost"]; ?></td>
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

<script>
	function html_table_to_excel(type) {
		var data = document.getElementById('table_content');
		var file = XLSX.utils.table_to_book(data, {sheet: "sheet1"});
		
		XLSX.write(file, { bookType: type, bookSST: true, type: 'base64' });
		XLSX.writeFile(file, 'file.' + type);
	}
	
	const export_btn = document.getElementById('export_btn');
	export_btn.addEventListener('click', () => {
		html_table_to_excel('xlsx');
	});
</script>