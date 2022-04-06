<?php
 	/* 
		CIS 492
		Delete Student Page 
		Last Worked: 03/09/22
		Filename: deleteStudent.php
	*/  
	
$mem_id = filter_input(INPUT_POST, 'mem_id', FILTER_VALIDATE_INT);

require('../../inc/db_connect.php');
include('director/dir_name.php');
include('../webpage/sub_header.php');

if(isset($mem_id)) {
	$_SESSION['mem_id'] = $mem_id;
}

$query = 'SELECT *
          FROM team_members
          ORDER BY mem_id';
$statement = $db->prepare($query);
$statement->execute();
$team_members = $statement->fetchAll();
$statement->closeCursor();
///////////////////////////////////////////////////////////////

if(array_key_exists('mem_id',$_POST)) {  
	
$query = 'SELECT *
          FROM team_members
          WHERE mem_id = :mem_id';
$statement = $db->prepare($query);
$statement->bindValue(':mem_id', $mem_id);
$statement->execute();
$team_member = $statement->fetch();
$mem_fname = $team_member['mem_fname'];
$mem_lname = $team_member['mem_lname'];

$statement->closeCursor();
} else {
$mem_id = "";
$mem_fname = "";
$mem_lname = "";
}
/////////////////////////////////////////////////////////////////

if(array_key_exists('deleteStudent',$_POST)) {
$query = 'DELETE FROM team_members
             WHERE mem_id = :mem_id';    
			 
    $statement = $db->prepare($query);
    $statement->bindValue(':mem_id', $_SESSION['mem_id']);
    $statement->execute();
    $statement->closeCursor();

$query2 = 'UPDATE task_list
    SET mem_id = null
	WHERE mem_id = :mem_id';
	
$statement2 = $db->prepare($query2);
$statement2->bindValue(':mem_id', $_SESSION['mem_id']);
$statement2->execute();
$statement2->closeCursor();

unset($_SESSION['mem_id']);
header("Refresh:0");
}

//clears the pesky SESSION 
if(array_key_exists('reset',$_POST)) { 
unset($_SESSION['mem_id']);
}
?>

<h1> Delete Team Member Page</h1>
<hr></hr>
<br>	

<fieldset>
<form action="" method="POST">
			<h3>Please choose a Team Member Account to Delete: </h3>
			<select name="mem_id" style="width:250px">
				<?php foreach ($team_members as $team_member) : ?>
                <option value="<?php echo $team_member['mem_id']; ?>">
                    <?php echo $team_member['mem_fname']; ?>
					<?php echo $team_member['mem_lname']; ?>
					
                </option>
            <?php endforeach; ?>
			</select>
			<input type="submit" value="Select Team Member" name="selectStudent"  />

</form>
</fieldset>
<br>
<br>

<fieldset class="grayBox">
			
	<h3 style = "color: black;">Team Member ID #: <?php echo $mem_id;?></h3>
	<h3 style = "color: black;">Team Member First Name: <?php echo $mem_fname;?></h3>
	<h3 style = "color: black;">Team Member Last Name: <?php echo $mem_lname;?></h3>
		
</fieldset>
<fieldset style="clear: left;">
<form action="deleteStudent.php" method="post">
<input type="submit" value="Delete Team Member" class="std_button" name="deleteStudent" />
<input type = "button" value = "Director Home" class="std_button" onclick="window.location.href='../project_director_home.php'"/>  
<input type = "submit" value = "Reset Page"  name = "reset" class="std_button" /> 

</form>
</fieldset>


	
</body>
<footer><p>Capstone Project: Team Avengers 2022</p></footer>
</html>
























