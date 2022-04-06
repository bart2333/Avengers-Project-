<?php
	/*
		CIS 492
		Assign Team Page 
		Date: 03/09/22
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
// this query populates the drop down menu of team members for selection

$query = 'SELECT *
          FROM team_members
          ORDER BY mem_id';
$statement = $db->prepare($query);
$statement->execute();
$team_members = $statement->fetchAll();
$statement->closeCursor();

// these sessions keep the value of the variables inbetween forms for the final submission 
if(isset($team_id)) {
	$_SESSION['a']['team_id'] = $team_id;
	
}
if(isset($mem_id) ) {
$_SESSION['a']['mem_id'] = $mem_id;
}

if(isset($mem_fname)) {
	$_SESSION['a']['mem_fname'] = $mem_fname;	
}
if(isset($mem_lname)) {
	$_SESSION['a']['mem_lname'] = $mem_lname;	
}
if(isset($is_lead)) {
	$_SESSION['a']['is_lead'] = $is_lead;	
}

	

//populates the output at the end of the page 
if(array_key_exists('is_lead',$_POST)) { 
$query = 'SELECT *
          FROM team
          WHERE team_id = :team_id';
$statement = $db->prepare($query);
$statement->bindValue(':team_id',$_SESSION['a']['team_id']); 
$statement->execute();
$team_view = $statement->fetch();
$id = $team_view['team_id'];
$name = $team_view['team_name'];
$_SESSION['a']['team_name'] = $name;
$statement->closeCursor();

$query = 'SELECT *
          FROM teams_list
		  INNER JOIN team
		  ON teams_list.team_id = team.team_id
		  INNER JOIN team_members
		  ON teams_list.mem_id = team_members.mem_id
		  WHERE teams_list.team_id = :team_id
          ORDER BY teams_list.mem_id';
$statement = $db->prepare($query);
$statement->bindValue(':team_id',$_SESSION['a']['team_id']); 
$statement->execute();
$members = $statement->fetchAll();
$statement->closeCursor();
}
//populates the output at the end of the page 
if(array_key_exists('is_lead',$_POST)) { 
$query = 'SELECT *
          FROM team_members
          WHERE mem_id = :mem_id';
$statement = $db->prepare($query);
$statement->bindValue(':mem_id',$_SESSION['a']['mem_id']); 
$statement->execute();
$member = $statement->fetch();
$mem_fname = $member['mem_fname'];
$mem_lname = $member['mem_lname'];
$statement->closeCursor();
}
if(array_key_exists('enter',$_POST)) { 

	
// inserts the final data when Add Member to Team is clicked


$query = 'INSERT INTO teams_list
                 (mem_id, team_id, is_lead)
              VALUES
                 (:mem_id, :team_id, :is_lead)';
    $statement = $db->prepare($query);
    $statement->bindValue(':mem_id', $_SESSION['a']['mem_id']);
    $statement->bindValue(':team_id',$_SESSION['a']['team_id']); 
	$statement->bindValue(':is_lead',$_SESSION['a']['is_lead']); 
    $statement->execute();
    $statement->closeCursor();

	unset($_SESSION['a']); // only deletes this session :)


}

//clears the pesky SESSION 
if(array_key_exists('reset',$_POST)) { 
unset($_SESSION['a']);
}

?>
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
<fieldset>
		<h1>Assign Team Members</h1>
		<p></p>
		<h3>Please choose a team to begin</h3>
	
			<form action="" method="POST" >
				<select name="team_id" style="width:300px;">
				<?php foreach ($teams as $team) : ?>
                <option value="<?php echo $team['team_id']; ?>">
                    <?php echo $team['team_id']; ?>
					<?php echo $team['team_name']; ?>				
					
                </option>
            <?php endforeach; ?>
				</select>
			
			<input type="submit" value="Select Team" id="" /> 
			</form>
		</fieldset>
		
		<?php if(isset($_SESSION['a']['team_id'])) {?>
		
		<fieldset>
			<h3>Please choose a team member: </h3>
			<form action="" method="POST" >
				<select name="mem_id" style="width:300px;">
				<?php foreach ($team_members as $team_member) : ?>
                <option value="<?php echo $team_member['mem_id']; ?>">
					
                    <?php echo $team_member['mem_fname']; ?>
					<?php echo $team_member['mem_lname']; ?> -
					<?php echo $team_member['skills']; ?>
                </option>
            <?php endforeach; ?>
				</select>	
						
			<input type="submit" value="Select Team Member" id="" /> 
			</form>
		</fieldset>
		
		<?php if(isset ($_SESSION['a']['mem_id'])) {?>
		<fieldset>
		<h3>Team Lead? (Y or N): </h3>
		<form action="" method="POST" >
			<select name="is_lead" style="width:300px;">
			<option value="Y">Y</option>
			<option value="N">N</option>
			</select>
		
		<input type="submit" value="Select Lead" name="ccc" /> 
		</form>
		</fieldset>
	
		<?php } ?> <?php } ?>

   		
		
<?php if(isset ($is_lead))  {?>
<form action="assign_team.php" method="POST">

<h1>Review Prior to Submission</h1>
<hr width="100%" >
<fieldset class="grayBox">
	
		<h3 style = "color: black;"> Team: <?php echo $id. "-" . $name; ?></h3>
		<h3 style = "color: black;"> Team Member: <?php echo $mem_fname;?> <?php echo $mem_lname;?> </h3>
		<h3 style = "color: black;"> Team Lead: <?php echo $_SESSION['a']['is_lead']; ?></h3>
		
		<input type="submit" value="Add Member to Team" name="enter" /> 
		
</fieldset>

</form>

<fieldset class="grayBox">
		
<h3 style="font-size: 22px; color: black;"> Team: <?php echo $_SESSION['a']['team_name'];?> includes members: </h3>
<?php foreach ($members as $member) : ?>
					<h3 style = "color: black;"> Name: <?php echo $member['mem_fname'];?> <?php echo $member['mem_lname']; ?></h3>
					<h3 style = "color: black;"> Skills: <?php echo $member['skills']; ?></h3>
					<h3 style = "color: black;">Lead: <?php echo $member['is_lead']; ?></h3>
					<br>

<?php endforeach; ?>
</fieldset>
<?php } ?>
<br>
<br>
<br>

<fieldset style="clear: left;">
<form action="assign_team.php" method="POST">
	<input type = "button" value = "Add Costs" class="std_button" onclick="window.location.href='create_project_tab/cost_page/cost_calculator_page.php'"/>   
	<input type = "button" value = "Add Tasks" class="std_button" onclick="window.location.href='assign_tasks_project.php'"/>  
	<input type = "button" value = "Create Project Page" class="std_button" onclick="window.location.href='create_project_tab/create_project.php'" /> 
	<input type = "button" value = "Director Home" class="std_button" onclick="window.location.href='project_director_home.php'" /> 
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
</html><?php } ?>	