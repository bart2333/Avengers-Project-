<?php
	/*
		CIS 492
		create project page 
		Date: 04/05/22
		Filename: create_project.php
	*/

require_once('../../inc/db_connect.php');
include('director/dir_name.php');
include('../webpage/sub_header.php');
////////////////////// We may want to add something to prevent this from re-inserting the same info if the BACK button is hit 

// this populates the account drop down menu 
$query = 'SELECT *
          FROM accounting
          ORDER BY account_id';
$statement = $db->prepare($query);
$statement->execute();
$accounts = $statement->fetchAll();
$statement->closeCursor();

$dir_id = $_SESSION['directorID']; // this grabs the session from home page 


$personnel_cost = filter_input(INPUT_POST, 'personnel_cost');
$account_id = filter_input(INPUT_POST, 'account_id');
$pro_start_date = filter_input(INPUT_POST, 'pro_start_date');date("Y-m-d H:i:s");
$pro_end_date = filter_input(INPUT_POST, 'pro_end_date');date("Y-m-d H:i:s");
$project_description = filter_input(INPUT_POST, 'project_description');


?>

<h3 style="font-size: 36px"> Create Project </h3>
<hr></hr>
<br>
<form action="create_project_helper.php" method="post" id="create">
		<fieldset>
            <h3>Project Name:</h3> 
			<input type="text" name="project_name" required="required" class="create_project"/> 
		
            <h3>Estimated Start Date: </h3>
			<input type="date" name="pro_start_date" class="create_project" /> 
		
			<h3>Estimated End Date:   </h3> 
			<input type="date" name="pro_end_date" class="create_project" />
			
			<h3>Please choose account: </h3>
			<select name="account_id">
				<?php foreach ($accounts as $account) : ?>
                <option value="<?php echo $account['account_id']; ?>">
                    <?php echo $account['acc_name']; ?>
                </option>
            <?php endforeach; ?>
            </select>
			
			<h3>Description: </h3>  
			<textarea rows="10" cols="80" font="16px" name="project_description"></textarea>
			
		</fieldset> 
	

<div id="buttonContainer1">
	<input type="submit" value="Create Project " class="std_button" /> 
	<input type = "button" value = "Add Costs" class="std_button" onclick="window.location.href='cost_page/cost_calculator_page.php'"/>  
	<input type = "button" value = "Add Tasks" class="std_button" onclick="window.location.href='../assign_tasks_project.php'"/>  
	<input type = "button" value = "Create Team" class="std_button" onclick="window.location.href='../assign_team.php'"/>  
	<input type = "reset" value = "Reset" class="std_button" />  
</div>
</form>


</body>
<br>
<br>
<br>
<br>
<footer>
	<p>put something here maybe, perhaps</p>
</footer>
</html>