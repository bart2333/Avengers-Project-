<?php
session_start();
$_SESSION = array();
session_destroy();
session_write_close();
$login_message = 'You have been logged out.';
header('Location:../login/main_login.php');
?>