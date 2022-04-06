<?php
session_start();  

$dir_id = $_SESSION['directorID'];   

// populates the projects tab to select a project to update
require_once('../../../inc/db_connect.php');
$query = 'SELECT *
          FROM project
          ORDER BY project_id';
$statement = $db->prepare($query);
$statement->execute();
$projects = $statement->fetchAll();
$statement->closeCursor();


include('php_cost_calculations.php');
// throws a pop up alert if TAFP is greater than 400 
if ($tafp > 400) {
	echo '<script>alert("Please be advised total adjusted function point is greater than 400.")</script>';
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<!--
		CIS 492
		Cost Calculator Page 
		Last Worked: 04/01/22
		Filename: cost_calculator_page.php
	-->
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<title>CalU - Project Tracker</title>	
	<link rel="stylesheet" href="main_for_cost.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<header>
	<nav>
		<div class="navbar">
			<ul>
				<li><a href="../../project_director_home.php">Home</a>
				<li><a href="#Projects">Projects</a>
					<ul>
						<li><a href="../create_project.php">Create Project</a></li>
						<li><a href="../../manage_a_project/manage_project.php">Manage Project</a></li> <!--JS fixed this so the link would work. -->
						<li><a href="../../create_team/create_team.php">Create Team</a></li>
						<li><a href="../../assign_team_tasks.php">Assign Project Tasks to Team</a></li> <!-- JS added this code to match with home page-->
						<li><a href="../../assign_team.php">Assign Team Members to Team</a></li> <!-- JS added this code to match with home page-->
						<li><a href="../../delete_team/delete_team.php">Delete Team</a></li> <!-- JS added this. Was missing-->
						<li><a href="../../delete_project/delete_project.php">Delete Project</a></li>
						<li><a href="../../archive_project.php">Archive Project</a></li> <!--JS fixed this so the link would work-->
						<li><a href="../../view_archived_project.php">View Archived Projects</a></li> <!-- JS added this code to match with home page-->
						<li><a href="cost_calculator_page.php">Update Costs</a></li>
					</ul>
				</li>
				<li><a href="#teamMembers">Team Members</a>
					<ul>
						<li><a href="../../addStudent.php">Add Team Members</a></li> <!-- Changed code here to reflect Team members and not students-->
						<li><a href="../../addPD.php">Add Project Director</a></li>
						<li><a href="../../create_team/create_team.php">Create Team</a></li>
						<li><a href="../../edit_student/editStudent.php">Edit Team Members</a></li>
						<li><a href="../../edit_PD/editPD.php">Edit Project Director</a></li>
						<li><a href="../../deleteStudent.php">Delete Team Members</a></li>
						<li><a href="../../deletePD.php">Delete Project Director</a></li>
					</ul>				
				</li>
				<li><a href="#messages">Messages</a>
				<ul>
						<li><a href="pd_email.php">Send Email</a></li> <!-- JS added this code to match with home page-->
					</ul>	
				</li>
				<li><a href="../../run_reports.php">Reports</a></li> <!-- JS fixed this code to match with home page-->
				<li><a href="../../create_tasks.php">Create Tasks</a></li>
			</ul>
		<div class="logout">
			<div class="logout2">
				<ul>
					<li><a href="../../clear.php">LOGOUT</a><li>
				</ul>
			</div>
		</div>
	</nav>
	<div class="header">
		<div class="header2">
			<img src="caluBanner.jpg" alt="California University of Pennsylvania">		
			<div class="greeting">
				<h3><b>Welcome Professor <?php echo $_SESSION['dir_fname']. " ". $_SESSION['dir_lname']; ?> </b></h3>
			</div>
		</div>
	</div>	
</header>	
<article>
        	
	   <h3> Weight Factors for Complexities</h3>
	    <table id = "weightFactors">
			<tr>
				<th>Parameter</th>
				<th>Low</th>
				<th>Medium</th>
				<th>High</th>
			</tr>
			<tr>
				<td>External Inputs</td>
				<td>3</td>
				<td>4</td>
				<td>6</td>
			</tr>
			<tr>
				<td>External Outputs</td>
				<td>4</td>
				<td>5</td>
				<td>7</td>
			</tr>
			<tr>
				<td>External Inquiries</td>
				<td>3</td>
				<td>4</td>
				<td>6</td>
			</tr>
			<tr>
			    <td>External Interfaces</td>
				<td>5</td>
				<td>7</td>
				<td>10</td>
			</tr>
			<tr>
				<td>Files Interacted</td>
				<td>7</td>
				<td>10</td>
				<td>15</td>
			</tr>
		</table>
    </article>
	<hr><br>
	<form action="" method="GET">
	<article>	
	<aside>
		
		<fieldset>
			<h3>Please choose a Project to Update: </h3>
			<select name="project_id">
				<?php foreach ($projects as $project) : ?>
                <option value="<?php echo $project['project_id']; ?>"<?php if (isset ($project_id) && ($project_id == $project['project_id'])) { ?> selected = "selected" <?php } ?>>
                    <?php echo $project['project_id']; ?>
					<?php echo $project['project_name']; ?>
					
                </option>
            <?php endforeach; ?>
			</select>
			
		</fieldset>
		<fieldset>
			<h3>Please Choose a Language Function Point Value to Proceed:</h3>
	
			<select id="LOC" name ="LOC" required="required" > 
				<option value="75">Java --- 75</option>
				<option value="50">Visual Basic --- 50</option>
				<option value="70">COBOL --- 70</option>
				<option value="70">HTML/CSS/JS/PHP --- 70</option>
			</select>
			<script type="text/javascript">
				document.getElementById('LOC').value = "<?php echo $_GET['LOC'];?>";
			</script>
		</fieldset>	
		<fieldset>
            <h3>Please provide the hourly rate (default value is 250.00): </h3>
            <input type="number" id="hourlyRate" name = "hourlyRate" <?php if(!isset($rate)) { echo "value = '250.00'";} ?> <?php if(isset($rate)) { ?>  value ="<?php echo $rate; } ?>"/> 
        </fieldset>
		<fieldset>
			<h3>Justification for Values Provided:</h3>
			<textarea rows="10" cols="80" font="16px" name = "reason" style="color:black;" > <?php echo $_SESSION['reason'];?> </textarea>
		<hr width="90%" >
		<h3>Total Adjusted Function Point: <?php echo $tafp;?></h3>		
		<h3>Total Lines of Code: <?php echo $tlc;?></h3>		
		<h3>Person-Months: <?php echo $PM;?></h3>		
		<h3>Months: <?php echo $months;?></h3>		
		<h3>Persons: <?php echo $persons;?></h3>
		<h3>Personnel Cost: <?php echo $personCost;?></h3> 
		
		</fieldset>

	</article>	
	<article>
	<h3>Please Enter The Total for Each Complexity</h3>
	<article>
	
	<table>
		<tr>
			<th>Parameter</th>
			<th>Low</th>
			<th>Medium</th>
			<th>High</th>
		</tr>
		<tr>
			<td>Total Inputs</td>
			<td><input size="3" type="number" min="0" max="100" id="P0" name="P0" value = "<?php echo $_GET['P0'] ?? 0;?>" required=""></td>
			<td><input size="3" type="number" min="0" max="100" id="P1" name="P1"  value= "<?php echo $_GET['P1'] ?? 0;?>"required=""></td>
			<td><input size="3" type="number" min="0" max="100" id="P2" name="P2" value = "<?php echo $_GET['P2'] ?? 0;?>"required=""></td>
		</tr>
		<tr>
			<td>Total Outputs</td>
			<td><input size="3" type="number" min="0" max="100" id="P3" name="P3" value = "<?php echo $_GET['P3'] ?? 0;?>"required=""></td>
			<td><input size="3" type="number" min="0" max="100" id="P4" name="P4" value = "<?php echo $_GET['P4'] ?? 0;?>"required=""></td>
			<td><input size="3" type="number" min="0" max="100" id="P5" name="P5" value = "<?php echo $_GET['P5'] ?? 0;?>"required=""></td>
		</tr>
		<tr>
			<td >Total Inquiries</td>
			<td><input size="3" type="number" min="0" max="100" id="P6" name="P6" value = "<?php echo $_GET['P6'] ?? 0;?>"required=""></td>
			<td><input size="3" type="number" min="0" max="100" id="P7" name="P7" value = "<?php echo $_GET['P7'] ?? 0;?>"required=""></td>
			<td><input size="3" type="number" min="0" max="100" id="P8" name="P8" value = "<?php echo $_GET['P8'] ?? 0;?>"required=""></td>
		</tr>
		<tr>
			<td>Total Interfaces</td>
			<td><input size="3" type="number" min="0" max="100" id="P9" name="P9"value = "<?php echo $_GET['P9'] ?? 0;?>"required=""></td>
			<td><input size="3" type="number" min="0" max="100" id="P10" name="P10"value = "<?php echo $_GET['P10'] ?? 0;?>"required=""></td>
			<td><input size="3" type="number" min="0" max="100" id="P11" name="P11"value = "<?php echo $_GET['P11'] ?? 0;?>"required=""></td>
		</tr>
		<tr>
			<td>Total Files</td>
			<td><input size="3" type="number" min="0" max="100" id="P12" name="P12"value = "<?php echo $_GET['P12'] ?? 0;?>"required=""></td>
			<td><input size="3" type="number" min="0" max="100" id="P13" name="P13"value = "<?php echo $_GET['P13'] ?? 0;?>"required=""></td>
			<td><input size="3" type="number" min="0" max="100" id="P14" name="P14"value = "<?php echo $_GET['P14'] ?? 0;?>" required=""></td>
		</tr>
	</table>
	</article>
	
	<h3>Please Rate the Value of Importance for the Following 14 Factors :</h3>
		<table>
			<tr>
				<th>Factors</th> 
				<th>Rate from 0 to 5</th>
			</tr>	
			<tr>
				<td>Importance of reliable backup and recovery?</td>
				<td><input size="8" type="number" min="0" max="5" id="Q1" name="Q1" value = "<?php echo $_GET['Q1'] ?? 1;?>"></td>
			</tr>
			<tr>
				<td>Will data communication required?</td>
				<td><input size="8" type="number" min="0" max="5" id="Q2" name="Q2"value = "<?php echo $_GET['Q2'] ?? 0;?>"></td>
			</tr>
			<tr>
				<td>Will there be distributed processing functions?</td>
				<td><input size="8" type="number" min="0" max="5" id="Q3" name="Q3" value = "<?php echo $_GET['Q3'] ?? 0;?>"></td>
			</tr>
			<tr>
			<td>Do you consider performance critical?</td>
			<td><input size="8" type="number" min="0" max="5" id="Q4" name="Q4"value = "<?php echo $_GET['Q4'] ?? 0;?>"></td>
			</tr>
			<tr>
			<td>Will this system run in an already existing heavily utilized operational environment?</td>
			<td><input size="8" type="number" min="0" max="5" id="Q5" name="Q5"value = "<?php echo $_GET['Q5'] ?? 0;?>"></td>
			</tr>
			<tr>
			<td>Will you require online data entry?</td>
			<td><input size="8" type="number" min="0" max="5" id="Q6" name="Q6"value = "<?php echo $_GET['Q6'] ?? 0;?>"></td>
			</tr>
			<tr>
			<td>Will the online data entry require that the input tranaction be entered on multiple screens or operations?</td>
			<td><input size="8" type="number" min="0" max="5" id="Q7" name="Q7"value = "<?php echo $_GET['Q7'] ?? 0;?>"></td>
			</tr>
			<tr>
			<td>Will the master files be updated online?</td>
			<td><input size="8" type="number" min="0" max="5" id="Q8" name="Q8"value = "<?php echo $_GET['Q8'] ?? 0;?>"></td>
			</tr>
			<tr>
			<td>Do you consider the inputs, outputs, inquiries, files as being complex?  </td>
			<td><input size="8" type="number" min="0" max="5" id="Q9" name="Q9"value = "<?php echo $_GET['Q9'] ?? 0;?>"></td>
			</tr>
			<tr>
			<td>Do you consider the internal processing complex?</td>
			<td><input size="8" type="number" min="0" max="5" id="Q10" name="Q10"value = "<?php echo $_GET['Q10'] ?? 0;?>"></td>
			</tr>
			<tr>
			<td>Is the code designed to be reusable?</td>
			<td><input size="8" type="number" min="0" max="5" id="Q11" name="Q11"value = "<?php echo $_GET['Q11'] ?? 0;?>"></td>
			</tr>
			<tr>
			<td>Will the conversion and installation be included in the design?</td>
			<td><input size="8" type="number" min="0" max="5" id="Q12" name="Q12"value = "<?php echo $_GET['Q12'] ?? 0;?>"></td>
			</tr>
			<tr>
			<td>Will the system be designed for multiple installations in different organizations?</td>
			<td><input size="8" type="number" min="0" max="5" id="Q13" name="Q13"value = "<?php echo $_GET['Q13'] ?? 0;?>"></td>
			</tr>
			<tr>
			<td>Will the application be designed to facilitate change and ease of use by the user?</td>
			<td><input size="8" type="number" min="0" max="5" id="Q14" name="Q14"value = "<?php echo $_GET['Q14'] ?? 0;?>"></td>
			</tr>
		</table>
	
		    <input type="submit" value="Calculate" id="calculate" class="std_button" /> 
			<input type = "button" value = "Create Project Page" class="std_button" onclick="window.location.href='../create_project.php'" /> 
			<input type = "button" value = "Add Tasks" class="std_button" onclick="window.location.href='../../assign_tasks_project.php'"/> 
			<input type = "button" value = "Reset" id="reset1" class="std_button" onclick="window.location.href='cost_calculator_page.php'"/> 
	</form>	 
	</aside>
	<aside>
	<form action="cost_update.php" method="GET"> 
	 
		<input type="submit" value="Save & Exit" id="update"  class="std_button"/>
	</form>
	</aside>
	
	
	
	
                           
	
	
	
		
</article>	
	
	</br>
	 </br>
	 </br>
	 </br></br>
	 </br>
	
	<footer>
	<p>put something here maybe, perhaps</p>
	</footer>


</body>
</html>