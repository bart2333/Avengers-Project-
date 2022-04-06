<?php
 
// I made this separate file for the delete project form button action
require('../../inc/db_connect.php');
include('director/dir_name.php');
include('../webpage/sub_header.php');
/*new*/ 
if(isset($_SESSION['c']['project_id'])) {
$_SESSION['project_id'] = $_SESSION['c']['project_id'] ;
 
unset($_SESSION['c']); 
}
var_dump($_SESSION['project_id']);


if(array_key_exists('deleteProject2',$_POST)) {
$query = 'DELETE FROM project
             WHERE project_id = :project_id';    
			 
    $statement = $db->prepare($query);
    $statement->bindValue(':project_id', $_SESSION['project_id']);
    $statement->execute();
    $statement->closeCursor();
	
/*new*/	unset($_SESSION['project_id']);
/*new*/	unset($_SESSION['c']); 
	header('Location: delete_project.php') ;
	
}
	
?>



<h3>This project is not archived!!</h3>
<h3> Please select Delete Project to confirm delete or select Archive Project to archive this project </h3>
<fieldset>
<form action="" method="post">
<input type="submit" value="Delete Project" name="deleteProject2" class="std_button"/>
<input type = "button" value = "Archive Project" class="std_button" onclick="window.location.href='../archive_project.php'"/>
<input type = "button" value = "Back" class="std_button" onclick="window.location.href='delete_project.php'"/>  
<input type = "button" value = "Director Home" class="std_button" onclick="window.location.href='../project_director_home.php'"/>  

</form>
</fieldset>

<br>
<br>
<br>
</body>
<footer><p>Capstone Project: Team Avengers 2022</p></footer>
</html>