<?php

include("functions.php");
$vehicle_lat = $_POST['vehicle_lat'];
$vehicle_lon = $_POST['vehicle_lon'];

$json = get_vehicle_distance($vehicle_lat, $vehicle_lon);
echo $json;

?>