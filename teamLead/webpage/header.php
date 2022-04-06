<!DOCTYPE html>
<html lang="en">
<head>
	
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<title>CalU - Project Tracker</title>	
	<link rel="stylesheet" href="webpage/main.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
</head>
<body>
<header>
	<nav>
		<div class="navbar">
			<ul>
				<li><a href="team_lead_home.php">HOME</a></li>
				<li><a href="#Manage Projects">Projects</a>
				 <ul>
					<li><a href="team_lead_tasks.php">Assign Tasks</a></li>
				 </ul>
				<li><a href="team_lead_messages.php">SEND MESSAGES</a></li>
				<li><a href="team_lead_reports.php">REPORTS</a></li>
				<li><a href="#Manage Tasks">Manage Tasks</a>
				<ul>
					<li><a href="completed_tasks.php">Task Status</a></li>
				 </ul>
			</ul>
		<div class="logout">
			<div class="logout2">
				<ul>
					<li><a href="clear.php">LOGOUT</a></li>
				</ul>
			</div>
		</div>
	</nav>
	<div class="header">
		<div class="header2">
			<img src="caluBanner.jpg" alt="California University of Pennsylvania">		
			<div class="greeting">
				<h3><b>Welcome <?php echo $variable1['mem_fname']. " ". $variable1['mem_lname']; ?></b>&nbsp;</h3>
		</div>		
		</div>
	</div>	
</header>