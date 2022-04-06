<?php
	/*
		CIS 492 
		Date: 04/01/22
		Filename: delete_team.php
		Author: Team Avengers
	*/
	
require('../../inc/db_connect.php');
include('director/dir_name.php');
include('../webpage/sub_header.php');

// gets the team id to delete
$team_id = filter_input(INPUT_POST, 'team_id', FILTER_VALIDATE_INT);
$_SESSION['team_id'] = $team_id;
// populates the teams tab to select a team to delete

$query = 'SELECT *
          FROM team
          ORDER BY team_id';
$statement = $db->prepare($query);
$statement->execute();
$teams = $statement->fetchAll();
$statement->closeCursor();


if(array_key_exists('team_id',$_POST)) {  

// populates all the team info for review by the user 
$query = 'SELECT *
          FROM team
          WHERE team_id = :team_id';
$statement = $db->prepare($query);
$statement->bindValue(':team_id', $team_id);
$statement->execute();
$team = $statement->fetch();
$team_id = $team['team_id'];
$project_id = $team['project_id'];
$team_name = $team['team_name'];
$statement->closeCursor();
}else {
	$project_id = "";
	$team_name = "";
}

?>

<h1> Delete Team Page</h1>
<hr></hr>
<br>
<form action="" method="post" id="">

<fieldset>
			<h3>Please choose a Team to Delete: </h3>
			 <br>
			<select name="team_id">
			  
				<?php foreach ($teams as $team) : ?>
                <option value="<?php echo $team['team_id']; ?>">
                    <?php echo "Team # ".$team['team_id']; ?>
					<?php echo "Project # ".$team['project_id']; ?>
					<?php echo $team['team_name']; ?>
					
                </option>
				<?php endforeach; ?>
				
			</select>
		<input type="submit" value="Select Team" id="selectTeam"  />	
</fieldset>
	 <br>
<fieldset name = "delete_page_info">
<div>
			
		<h3 style="color:black">Project ID: <?php echo $project_id;?></h3>
		<h3 style="color:black">Team Name: <?php echo $team_name;?></h3>
		<h3 style="color:black">Team ID: <?php echo $team_id;?></h3>
		
    </div>
</fieldset>
</form>
<form action="delete_team_helper.php" method="post" >
<input type="submit" value="Delete Team" id="deleteTeam" class="std_button" />
</form>

</body>
<footer><p>Capstone Project: Team Avengers 2022</p></footer>
</html>