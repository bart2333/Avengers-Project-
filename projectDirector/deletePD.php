<?php
	/*
		CIS 492
		Delete PD Page 
		Last Worked: 03/09/22
		Filename: deletePD.php
	*/
 
$dir_id = filter_input(INPUT_POST, 'dir_id', FILTER_VALIDATE_INT);

require('../inc/db_connect.php');
include('director/dir_name.php');
include('webpage/header.php');

if(isset($dir_id)) {
	$_SESSION['dirID'] = $dir_id;
}

$query = 'SELECT *
          FROM project_director
          ORDER BY dir_id';
$statement = $db->prepare($query);
$statement->execute();
$project_directors = $statement->fetchAll();
$statement->closeCursor();
///////////////////////////////////////////////////////////////

if(array_key_exists('dir_id',$_POST)) {  
	
$query = 'SELECT *
          FROM project_director
          WHERE dir_id = :dir_id';
$statement = $db->prepare($query);
$statement->bindValue(':dir_id', $dir_id);
$statement->execute();
$project_director = $statement->fetch();
$dir_fname = $project_director['dir_fname'];
$dir_lname = $project_director['dir_lname'];

$statement->closeCursor();
} else {
$dir_id = "";
$dir_fname = "";
$dir_lname = "";

}
/////////////////////////////////////////////////////////////////

if(array_key_exists('deletePD',$_POST)) {
$query = 'DELETE FROM project_director
             WHERE dir_id = :dir_id';    
			 
    $statement = $db->prepare($query);
    $statement->bindValue(':dir_id', $_SESSION['dirID']);
    $statement->execute();
    $statement->closeCursor();
	
$query2 = 'UPDATE project
    SET dir_id = null
	WHERE dir_id = :dir_id';
	
$statement2 = $db->prepare($query2);
$statement2->bindValue(':dir_id', $_SESSION['dirID']);
$statement2->execute();
$statement2->closeCursor();

unset($_SESSION['dirID']);
header("Refresh:0");

}
//clears the pesky SESSION 
if(array_key_exists('reset',$_POST)) { 
unset($_SESSION['dirID']);
}

?>

<h1> Delete Project Director Page</h1>
<hr></hr>
<br>	
<fieldset>
	<form action="" method="post">

		<h3>Please choose a Project Director Account to Delete: </h3>
			<select name="dir_id" style="width:250px">
			<?php foreach ($project_directors as $project_director) : ?>
                <option value="<?php echo $project_director['dir_id']; ?>">
                    <?php echo $project_director['dir_fname']; ?>
					<?php echo $project_director['dir_lname']; ?>	
                </option>
				
            <?php endforeach; ?>
			</select>
			
		<input type="submit" value="Select PD" name="selectPD"   />
	</form>			
</fieldset>

<br>
<br>
<fieldset class="grayBox">
			
		<h3 style = "color: black;">Director #: <?php echo $dir_id;?></h3>
		<h3 style = "color: black;">Director First Name: <?php echo $dir_fname;?></h3>
		<h3 style = "color: black;">Director Last Name: <?php echo $dir_lname;?></h3>
		
   

</fieldset>
<fieldset style="clear: left;">
<form action="deletePD.php" method="post" id=""  >
<input type="submit" value="Delete PD" name="deletePD" class="std_button"/>
<input type = "button" value = "Director Home" class="std_button" onclick="window.location.href='../project_director_home.php'"/>  
<input type = "submit" value = "Reset Page"  name = "reset" class="std_button" /> 
</form>
</fieldset>


</body>
<footer><p>Capstone Project: Team Avengers 2022</p></footer>
</html>
























