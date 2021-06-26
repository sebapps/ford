<?php

include("functions.php");
$lat = $_POST['lat'];
$lon = $_POST['lon'];

set_home_location($lat, $lon);
echo "SUCCESS";

?>