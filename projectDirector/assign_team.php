<?php
	/* 
		CIS 492
		Assign Team Page  
		Date: 03/30/22
		Filename: assign_team.php 
	*/ 

require_once('../inc/db_connect.php');
include('director/dir_name.php');
include('webpage/header.php');

$team_id = filter_input(INPUT_POST, 'team_id', FILTER_VALIDATE_INT);
$mem_id = filter_input(INPUT_POST, 'mem_id', FILTER_VALIDATE_INT);
$is_lead = filter_input(INPUT_POST, 'is_lead');

// this query populates the drop down menu of teams for selection

$query = 'SELECT *
          FROM team
          ORDER BY team_id';
$statement = $db->prepare($query);
$statement->execute();
$teams = $statement->fetchAll();
$statement->closeCursor();

// this query populates the drop down menu of team members for selection

$query = 'SELECT *
          FROM team_members
          ORDER BY mem_id';
$statement = $db->prepare($query);
$statement->execute();
$team_members = $statement->fetchAll();
$statement->closeCursor();
// this gets the current selected members first and last name 
if(isset($mem_id)) {
$query = 'SELECT *
          FROM team_members
          WHERE mem_id = :mem_id';
$statement = $db->prepare($query);
$statement->bindValue(':mem_id', $mem_id);
$statement->execute();
$team_mem = $statement->fetch();
$mem_fname = $team_mem['mem_fname'];
$mem_lname = $team_mem['mem_lname'];
$statement->closeCursor();

}
// this checks the mem_id selected and sees if it is already in teams_list
if(array_key_exists('mem_id',$_POST)) { 
$query1 = 'SELECT *
          FROM teams_list
          WHERE mem_id = :mem_id';
$statement1 = $db->prepare($query1);
$statement1->bindValue(':mem_id',$mem_id); 
$statement1->execute();
$members = $statement1->fetch();
if ($members !== FALSE) {
$memID = $members['mem_id'];
}
$statement1->closeCursor();
}

// this session holds the selected team members until final submission 
if(isset($team_id) && (!isset($memID))) {
	$_SESSION['teams'][] = 
	array(
	'team_id' => $team_id,
	'mem_id' => $mem_id,
	'is_lead' => $is_lead,
	'mem_fname' => $mem_fname,
	'mem_lname' => $mem_lname
	);	
}



if(array_key_exists('enter',$_POST)) { 
// inserts the final data when Add Member to Team is clicked
if(!empty($_SESSION['teams'])) {
foreach ($_SESSION['teams'] as $id => $b) :
$query = 'INSERT INTO teams_list
                 (mem_id, team_id, is_lead)
              VALUES
                 (:mem_id, :team_id, :is_lead)';
    $statement = $db->prepare($query);
    $statement->bindValue(':mem_id', $b['mem_id']);
    $statement->bindValue(':team_id',$b['team_id']); 
	$statement->bindValue(':is_lead',$b['is_lead']); 
    $statement->execute();
    $statement->closeCursor();

	unset($_SESSION['teams']); // only deletes this session :)



endforeach;
}else { 
 $error = "Please select at least one member prior to continuing";
 
}
}
//clears the SESSION 
if(array_key_exists('reset',$_POST)) { 
unset($_SESSION['teams']);
}

?>

<?php if(isset ($error)) { ?>
<br>
<h3 style="font-size: 20px;" ><?php echo $error;?></h3>
<br>

<?php }?>


<?php if(isset($memID)) {?>
	<h3 style="font-size: 20px;"> Team Member Already Assigned</h3>
	<?php unset($_SESSION['a']);?>
	<br>
	<form action="assign_team.php" method="POST">
	<input type = "button" value = "Go Back" class="std_button" onclick="window.location.href='assign_team.php'" /> 
	<br>
	
	</form>	
<?php } ?>

<?php if(!isset($memID)) {?>
<form action="" method="POST" >
<fieldset>
	<h1 style="font-size: 32px; color: white;">Assign Team Members</h1>
	<hr> </hr>
</fieldset>	
<fieldset>

		<p></p>
		<h3>Please choose a team to begin</h3>
			<select name="team_id" style="width:300px;">
				<?php foreach ($teams as $team) : ?>
                <option value="<?php echo $team['team_id']; ?>" <?php if(isset($_POST['team_id']) && ($_POST['team_id'] == $team['team_id'])) { ?> selected = "selected" <?php } ?>>
                    <?php echo $team['team_id']; ?>
					<?php echo $team['team_name']; ?>				
					
                </option>
				<?php endforeach; ?>
			</select>

		<h3>Please choose a team member: </h3>		
			<select name="mem_id" style="width:300px;">
				<?php foreach ($team_members as $team_member) : ?>
                <option value="<?php echo $team_member['mem_id']; ?>" <?php if(isset($_POST['mem_id']) && ($_POST['mem_id'] == $team_member['mem_id'])) { ?> selected = "selected" <?php } ?>>
                    <?php echo $team_member['mem_fname']; ?>
					<?php echo $team_member['mem_lname']; ?> -
					<?php echo $team_member['skills']; ?>
                </option>
				<?php endforeach; ?>
			</select>	


		<h3>Team Lead? (Y or N): </h3>
		
			<select name="is_lead" style="width:300px;">
			<option value="Y">Y</option>
			<option value="N">N</option>
			</select>
		
		
		
</fieldset>
<input type="submit" value="Select Member" name="selectMember" class="std_button" /> 
</form>
<br>
<?php if(isset($mem_id) ) {?>
<fieldset>
<table class="blackBox">

<?php foreach ($_SESSION['teams'] as $id => $b) : ?>
<tr>
<td>Member: <?php echo $b['mem_fname'];?> <?php echo $b['mem_lname'];?></td>
<td>Team: <?php echo $b['team_id']; ?> </td>
<td>Lead: <?php echo $b['is_lead']; ?> </td>
</tr>
<?php endforeach; ?>
</table>
</fieldset>
<?php } ?>
	

<fieldset style="clear: left;">
<form action="assign_team.php" method="POST">
	<input type="submit" value="Add Member(s) to Team" name="enter" class="std_button"/> 
	<input type = "button" value = "Assign Team Tasks" class="std_button" onclick="window.location.href='assign_team_tasks.php'" />  
	<input type = "button" value = "Create Project Page" class="std_button" onclick="window.location.href='create_project_tab/create_project.php'" />  
	<input type = "submit" value = "Reset Page"  name = "reset" class="std_button" />
	
</form>	
</fieldset>
<br>
<br>
<br>
<br>
<br>
<br>
</body>
<footer><p>Capstone Project: Team Avengers 2022</p></footer>
</html>	<?php } ?>