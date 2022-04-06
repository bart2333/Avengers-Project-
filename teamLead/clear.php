<?php
session_start();
$_SESSION = array();
session_destroy();

$login_message = 'You have been logged out.';
header('Location:../login/main_login.php');
?>