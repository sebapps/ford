<?php

session_start();

$username_database = $_POST['username'];
$_SESSION['username_database'] = $username_database;

header("location:index.php");

?>