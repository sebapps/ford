<?php

session_start();

$db_server = "{db_server}";
$db_username = "{db_username}";
$db_password = "{db_password}!";
$db_database = "{db_database}";

$mysql = mysqli_connect($db_server, $db_username, $db_password, $db_database);

$username = "{username}";
$username_db = "{username}";

if(isset($_SESSION['username_database']))
    $username_db = $_SESSION['username_database'];
    
?>