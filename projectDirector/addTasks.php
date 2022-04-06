<?php
require_once('../inc/db_connect.php');
require_once('../login/check_credentials.php');

$task_name = filter_input(INPUT_POST, 'task_name');
$task_category = filter_input(INPUT_POST, 'task_category');

add_tasks($task_name, $task_category);

include('../projectDirector/create_tasks.php');
