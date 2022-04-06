<?php 
	/*
		CIS 492
		Create Team Page 
		Last Worked: 03/09/22
		Filename: create_team.php
	*/
	
// this page creates a new team 			
require_once('../../inc/db_connect.php');
include('director/dir_name.php');
include('../webpage/sub_header.php');

// this query populates the drop down menu of projects for selection
$query = 'SELECT *
          FROM project
          ORDER BY project_id';
$statement = $db->prepare($query);
$statement->execute();
$projects = $statement->fetchAll();
$statement->closeCursor();

?>

<h1> Create Team </h1>
<hr></hr>
<br>
<form action="create_team_helper.php" method="post" id="">
<select name="project_id">
				<?php foreach ($projects as $project) : ?>
                <option value="<?php echo $project['project_id']; ?>">
                    <?php echo $project['project_id']; ?>
					<?php echo $project['project_name']; ?>
					
                </option>
            <?php endforeach; ?>
</select>			
		<fieldset>
            <h3>Team Name:</h3> 
			<input type="text" name="team_name" required="required" class="create_project"/> 
		           		
			<h3>Team Description: </h3>  
			<textarea rows="10" cols="80" font="16px" name="team_description"></textarea>
			
		</fieldset> 

	<input style="text-align:center" type="submit" value="Create Team" id="createTeam" class="std_button" /> 
	<input type = "button" value = "Assign Team Members" class="std_button" onclick="window.location.href='../assign_team.php'"/>  
	<input type = "button" value = "Director Home" class="std_button" onclick="window.location.href='../project_director_home.php'"/>  
	<input type = "reset" value = "Reset" id="reset1" class="std_button" />  
</form>

</body>
<br>
<br>
<br>
<br>
<footer><p>Capstone Project: Team Avengers 2022</p></footer>
</html>










