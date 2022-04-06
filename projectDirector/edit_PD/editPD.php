<?php  
	/* 
		CIS 492
		Edit Project Director Page
		Author: Team Avengers
		Date: 03/30/22
		Filename: editPD.php
	*/
	
$dir_id = filter_input(INPUT_POST, 'project_directors', FILTER_VALIDATE_INT);
$dir_fname1 = filter_input(INPUT_POST, 'dir_fname1');
$dir_lname1 = filter_input(INPUT_POST, 'dir_lname1');
$username1 = filter_input(INPUT_POST, 'username1');
// populates the drop down menu choices for editing 
require_once('../../inc/db_connect.php');
include('director/dir_name.php');
include('../webpage/sub_header.php');

$query = 'SELECT *
          FROM project_director
          ORDER BY dir_id';
$statement = $db->prepare($query);
$statement->execute();
$directors = $statement->fetchAll();
$statement->closeCursor();


// populates all the project_directors info for review by the user
if(array_key_exists('selectDirector',$_POST)) {   
$query = 'SELECT *
          FROM project_director
          WHERE dir_id = :dir_id';
$statement = $db->prepare($query);
$statement->bindValue(':dir_id', $dir_id);
$statement->execute();
$project_directors = $statement->fetch();
$dir_fname = $project_directors['dir_fname'];
$dir_lname = $project_directors['dir_lname'];
$usernameA = $project_directors['username'];
$statement->closeCursor();

}else {

$dir_fname = "";
$dir_lname = "";
$usernameA = "";
}

$_SESSION['dir_id'] = $dir_id;

?>

<h1> Edit Project Director Page</h1>
<hr></hr>
<br>		
<form action="" method="post">
<fieldset class="grayBox" style="width:550px;">
			<h3 style = "color: black;">Please choose a director account to edit: </h3>
			<select name="project_directors" style="width:300px;">
				<?php foreach ($directors as $director) : ?>
                <option value="<?php echo $director['dir_id']; ?>" <?php if (isset ($dir_id) && ($dir_id == $director['dir_id'])) { ?> selected = "selected" <?php } ?>>
                    <?php echo $director['dir_id']; ?>
					<?php echo $director['dir_fname']; ?>
					<?php echo $director['dir_lname']; ?>
                </option>
            <?php endforeach; ?>
			</select>
			<input type="submit" value="Select" name="selectDirector" /> 

	
</form>
<form action="edit_PD_helper.php" method="post">


<h3 style = "color: black;">Director first name: <input style="width:150px;" type="text"  name = "dir_fname1" value="<?php echo $dir_fname ?>"/> </h3> 
            
<h3 style = "color: black;">Director last name: <input style="width:150px;" type="text"  name = "dir_lname1" value="<?php echo $dir_lname ?>"/></h3>
            
<h3 style = "color: black;">Director username: <input style="width:150px;" type="text"  name = "username1" value="<?php echo $usernameA ?>"/></h3>

<h3 style = "color: black;">Director password: <input style="width:150px;" type="password"  name = "password1" /></h3>   <!-- change the type of the input to password to offer better security -->
<br>
<br> 
<input type="submit" value="Update Director" id="updateDirector"  />
</fieldset>
</form>


</body>
<footer><p>Capstone Project: Team Avengers 2022</p></footer>
</html>