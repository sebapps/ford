<?php

session_start();
unset($_SESSION['username_database']);
header("location:begin.php");

?>