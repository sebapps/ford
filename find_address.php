<?php

include("functions.php");
$address = $_POST['address'];
$city = $_POST['city'];
$state = $_POST['state'];

$key = "AIzaSyCDFMYxkMKHwdhEu5EE3JCSnpRCKSHffOs";
$full_address = trim(urlencode($address." ".$city.",".$state));

$json = '{"status" : "<<STATUS>>", "latitude" : "<<LATITUDE>>", "longitude" : " <<LONGITUDE>>"}';

$url = "https://maps.googleapis.com/maps/api/geocode/json?address={$full_address}&key={$key}";

$response = file_get_contents($url);
$response_json = json_decode($response);

if($response_json->results[0]->geometry->location) {
    $json = str_replace("<<STATUS>>", "SUCCESS", str_replace("<<LATITUDE>>", $response_json->results[0]->geometry->location->lat, str_replace("<<LONGITUDE>>", $response_json->results[0]->geometry->location->lng, $json)));
}
else {
    $json = str_replace("<<STATUS>>", "error", str_replace("<<LATITUDE>>", "0.00", str_replace("<<LONGITUDE>>", "0.00", $json)));
}

echo $json;

?>