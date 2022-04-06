<?php
	/*  
		CIS 492
		Edit Student Page
		Author: Team Avengers
		Date: 03/30/22
		Filename: editStudent.php
	*/
	
$mem_id = filter_input(INPUT_POST, 'team_members', FILTER_VALIDATE_INT);
$mem_fname1 = filter_input(INPUT_POST, 'mem_fname1');
$mem_lname1 = filter_input(INPUT_POST, 'mem_lname1');
$username1 = filter_input(INPUT_POST, 'username1');
// populates the drop down menu choices for editing 
require_once('../../inc/db_connect.php');
include('director/dir_name.php');
include('../webpage/sub_header.php');

$query = 'SELECT *
          FROM team_members
          ORDER BY mem_id';
$statement = $db->prepare($query);
$statement->execute();
$teams = $statement->fetchAll();
$statement->closeCursor();


// populates all the team member info for review by the user 
 
if(array_key_exists('selectStudent',$_POST)) { 	 
$query = 'SELECT *
          FROM team_members
          WHERE mem_id = :mem_id';
$statement = $db->prepare($query);
$statement->bindValue(':mem_id', $mem_id);
$statement->execute();
$team_members = $statement->fetch();
$mem_fname = $team_members['mem_fname'];
$mem_lname = $team_members['mem_lname'];
$usernameA = $team_members['username'];
$statement->closeCursor();
}else {

$mem_fname = "";
$mem_lname = "";
$usernameA = "";
}


$_SESSION['mem_id'] = $mem_id;



?>

<h1> Edit Team Member Page</h1>
<hr></hr>
<br>		
<form action="" method="post">
<fieldset class="grayBox" style="width:550px;">
			<h3 style = "color: black;">Please choose a team tember account to edit: </h3>
			<select name="team_members" style="width:300px;">
				<?php foreach ($teams as $team) : ?>
                <option value="<?php echo $team['mem_id']; ?>" <?php if (isset ($mem_id) && ($mem_id == $team['mem_id'])) { ?> selected = "selected" <?php } ?>>
                    <?php echo $team['mem_id']; ?>
					<?php echo $team['mem_fname']; ?>
					<?php echo $team['mem_lname']; ?>
                </option>
            <?php endforeach; ?>
			</select>
			<input type="submit" value="Select" name="selectStudent" /> 
		
	
</form>
<form action="edit_student_helper.php" method="post">


<h3 style = "color: black;">Team Member first name: <input style="width:150px;" type="text"  name = "mem_fname1" value="<?php echo $mem_fname?>"/> </h3> 
            
<h3 style = "color: black;">Team Member last name: <input  style="width:150px;" type="text"  name = "mem_lname1" value="<?php echo $mem_lname?>"/></h3>
            
<h3 style = "color: black;">Team Member username: <input style="width:150px;" type="text"  name = "username1" value="<?php echo $usernameA ?>"/></h3>
            	
<h3 style = "color: black;">Team Member password: <input style="width:150px;" type="password"  name = "password1" /></h3> <!-- change the type of the input to password to offer better security -->        	
 
<br>
	 
		<input type="submit" value="Update Team Member" name="updateStudent"/>
</fieldset>
</form>


</body>
<footer><p>Capstone Project: Team Avengers 2022</p></footer>
</html>