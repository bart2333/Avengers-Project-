<?php
/*      CIS 492
		Edit Project Teams Page
		Author: Team Avengers
		Date: 03/30/22
		Filename: edit_team.php  
*/
 
require_once('../../inc/db_connect.php');

include('../director/dir_name.php');
include('../webpage/sub_header.php');

$project_id = filter_input(INPUT_POST, 'project_id', FILTER_VALIDATE_INT);
$teams_list_id = filter_input(INPUT_POST, 'teams_list_id', FILTER_VALIDATE_INT);
$team_id = filter_input(INPUT_POST, 'team_id', FILTER_VALIDATE_INT);

// this query populates the 1st drop down menu of projects for selection  
$query = 'SELECT *
          FROM project
          ORDER BY project_id';
$statement = $db->prepare($query);
$statement->execute();
$projects = $statement->fetchAll();
$statement->closeCursor();

// inner join to populate 2nd drop down 
if(array_key_exists('project_id',$_POST)) {
if ($project_id != FALSE) {	
$query = 'SELECT *
          FROM teams_list
			INNER JOIN team
			ON teams_list.team_id = team.team_id
			INNER JOIN team_members
			ON teams_list.mem_id = team_members.mem_id
          WHERE project_id = :project_id
		  ORDER BY teams_list.team_id';
$statement = $db->prepare($query);
$statement->bindValue(':project_id',$project_id); 
$statement->execute();
$teams_lists = $statement->fetchALL();
$statement->closeCursor();
}else {
	$error = "Please make a selection prior to continuing";		
}
}
//deletes team member
if(array_key_exists('delete_member',$_POST)) { 
if ($teams_list_id != FALSE) {
$query = 'DELETE FROM teams_list
             WHERE teams_list_id = :teams_list_id';    
			 
    $statement = $db->prepare($query);
    $statement->bindValue(':teams_list_id', $teams_list_id);
    $statement->execute();
    $statement->closeCursor();	
}else {
	$error = "Please make a selection prior to continuing";		
}
}
// this query gets the team_id for the teams_list selection made for the following delete query
if(array_key_exists('delete_team',$_POST)) { 
if ($teams_list_id != FALSE) {
$query = 'SELECT *
          FROM teams_list
          WHERE teams_list_id = :teams_list_id';
$statement = $db->prepare($query);
$statement->bindValue(':teams_list_id',$teams_list_id); 
$statement->execute();
$team = $statement->fetch();
$team_id = $team['team_id'];
$statement->closeCursor();
}else {
	$error = "Please make a selection prior to continuing";		
}
}
// deletes entire team 
if(array_key_exists('delete_team',$_POST)) { 
$query = 'DELETE FROM team
             WHERE team_id = :team_id';    
			 
    $statement = $db->prepare($query);
    $statement->bindValue(':team_id', $team_id);
    $statement->execute();
    $statement->closeCursor();	
}	



?>

<?php if(isset ($error)) { ?>
<br>
<h3 style="font-size: 20px;" ><?php echo $error;?></h3>
<br>

<?php }?>



<h1 style="font-size: 40px">Edit Team</h1>
<hr></hr>
<br>
		
<fieldset>
<form action="" method="post">
	<h3>Please choose a project to view team/team members: </h3>
			<select name="project_id">
				<option>ID -- name </option>
				<?php foreach ($projects as $project) : ?>
                <option value="<?php echo $project['project_id']; ?>" <?php if (isset ($project_id) && ($project_id == $project['project_id'])) { ?> selected = "selected" <?php } ?>>
                    <?php echo $project['project_id']; ?>
					<?php echo $project['project_name']; ?>
					
                </option>
            <?php endforeach; ?>
			</select>
	
		<input type="submit" value="Select Project" id="" /> 
</form>
</fieldset>

<?php if(isset($project_id) && ($project_id != FALSE)) {?>
<fieldset>
	<form action="" method="POST" >
	<h3>Please choose a team member to delete: </h3>
	
				<select name="teams_list_id" style="width:300px;">
				
				<option>  Team ID -- team -- member </option>
				<?php foreach ($teams_lists as $teams_list) : ?>     
				<option value="<?php echo $teams_list['teams_list_id']; ?>">
					
					 # <?php echo $teams_list['team_id']; ?> - 
					   <?php echo $teams_list['team_name']; ?> -
					   <?php echo $teams_list['mem_fname'] ?> <?php echo $teams_list['mem_lname']; ?>
                </option>
            <?php endforeach; ?>
				</select>
		
		<input type="submit" value="Delete Member" name="delete_member" /> 
		<input type="submit" value="Delete Team" name="delete_team" /> 			
</form>
</fieldset>
<?php } ?>







<input type = "button" value = "Edit Costs" class="std_button" onclick="window.location.href='../create_project_tab/cost_page/cost_calculator_page.php'"/>   
	<input type = "button" value = "Edit Task" class="std_button" onclick="window.location.href='edit_project_tasks.php'"/>  
	<input type = "button" value = "Director Home" class="std_button" onclick="window.location.href='../project_director_home.php'" />  
	<input type = "button" value = "Manage Project" class="std_button" onclick="window.location.href='manage_project.php'" /> 
<br>
<br>
<br>
<br>
<br>
</body>
<footer><p>Capstone Project: Team Avengers 2022</p></footer>
<br>
<br>
<br>
</html>