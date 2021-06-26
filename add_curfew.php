<?php

include("functions.php");

$status = $_POST['status'];
$radius = $_POST['radius'];
$days = $_POST['days'];
$primary = $_POST['primary'];
$primary_phone = $_POST['primary_phone'];
$primary_email = $_POST['primary_email'];
$secondary = $_POST['secondary'];
$secondary_phone = $_POST['secondary_phone'];
$secondary_message = $_POST['secondary_message'];
$secondary_email = $_POST['secondary_email'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];

$json = add_curfew($status, $radius, $days, $primary, $primary_phone, $primary_email, $secondary, $secondary_phone, $secondary_message, $secondary_email, $start_time, $end_time);

echo $json;
?>