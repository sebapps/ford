<?php

include dirname( __FILE__ )."/db.php";
include dirname( __FILE__ )."/functions.php";
require dirname( __FILE__ )."/Twilio/autoload.php";
use Twilio\Rest\Client;

$account_sid = '{account_dis}';
$auth_token = '{auth_token}';
$twilio_number = "+{twilio_number}";
$client = new Client($account_sid, $auth_token);

// Hard-code the timezone for EST
date_default_timezone_set("America/New_York");

// Get today's day of the week (0 = Sunday, 6 = Saturday)
$dayofweek = date("w");

// The time right now
$currentdate = date("Y-m-d H:i");

// Go through all the active curfews
$query = "SELECT * FROM curfews WHERE curfew_status = 'on'";
$result = mysqli_query($mysql, $query);
$num_rows = mysqli_num_rows($result);

if($num_rows > 0) {
    while($row = mysqli_fetch_array($result)) {
        
        // Does today fall on a possible curfew?
        $possible_curfew = false;
        
        switch($dayofweek) {
            case 0:
                if($row['sunday'] == "y") {
                    $start_time = date("Y-m-d H:i",strtotime($row['start_time']));
                    $end_time = date("Y-m-d H:i",strtotime($row['end_time']));
                    if($row['start_time'] > $row['end_time'])
                        $end_time = date("Y-m-d H:i", strtotime($end_time." +1 day"));
                }
                elseif($row['saturday'] == "y" && $row['start_time'] > $row['end_time']) {
                    $start_time = date("Y-m-d H:i",strtotime($row['start_time']." -1 day"));
                    $end_time = date("Y-m-d H:i",strtotime($row['end_time']));
                }
                $possible_curfew = true;
                break;
                
            case 1:
                if($row['monday'] == "y") {
                    $start_time = date("Y-m-d H:i",strtotime($row['start_time']));
                    $end_time = date("Y-m-d H:i",strtotime($row['end_time']));
                    if($row['start_time'] > $row['end_time'])
                        $end_time = date("Y-m-d H:i", strtotime($end_time." +1 day"));
                }
                elseif($row['sunday'] == "y" && $row['start_time'] > $row['end_time']) {
                    $start_time = date("Y-m-d H:i",strtotime($row['start_time']." -1 day"));
                    $end_time = date("Y-m-d H:i",strtotime($row['end_time']));
                }
                $possible_curfew = true;
                break;
                
            case 2:
                if($row['tuesday'] == "y") {
                    $start_time = date("Y-m-d H:i",strtotime($row['start_time']));
                    $end_time = date("Y-m-d H:i",strtotime($row['end_time']));
                    if($row['start_time'] > $row['end_time'])
                        $end_time = date("Y-m-d H:i", strtotime($end_time." +1 day"));
                }
                elseif($row['monday'] == "y" && $row['start_time'] > $row['end_time']) {
                    $start_time = date("Y-m-d H:i",strtotime($row['start_time']." -1 day"));
                    $end_time = date("Y-m-d H:i",strtotime($row['end_time']));
                }
                $possible_curfew = true;
                break;
                
            case 3:
                if($row['wednesday'] == "y") {
                    $start_time = date("Y-m-d H:i",strtotime($row['start_time']));
                    $end_time = date("Y-m-d H:i",strtotime($row['end_time']));
                    if($row['start_time'] > $row['end_time'])
                        $end_time = date("Y-m-d H:i", strtotime($end_time." +1 day"));
                }
                elseif($row['tuesday'] == "y" && $row['start_time'] > $row['end_time']) {
                    $start_time = date("Y-m-d H:i",strtotime($row['start_time']." -1 day"));
                    $end_time = date("Y-m-d H:i",strtotime($row['end_time']));
                }
                $possible_curfew = true;
                break;
                
            case 4:
                if($row['thursday'] == "y") {
                    $start_time = date("Y-m-d H:i",strtotime($row['start_time']));
                    $end_time = date("Y-m-d H:i",strtotime($row['end_time']));
                    if($row['start_time'] > $row['end_time'])
                        $end_time = date("Y-m-d H:i", strtotime($end_time." +1 day"));
                }
                elseif($row['wednesday'] == "y" && $row['start_time'] > $row['end_time']) {
                    $start_time = date("Y-m-d H:i",strtotime($row['start_time']." -1 day"));
                    $end_time = date("Y-m-d H:i",strtotime($row['end_time']));
                }
                $possible_curfew = true;
                break;
                
            case 5:
                if($row['friday'] == "y") {
                    $start_time = date("Y-m-d H:i",strtotime($row['start_time']));
                    $end_time = date("Y-m-d H:i",strtotime($row['end_time']));
                    if($row['start_time'] > $row['end_time'])
                        $end_time = date("Y-m-d H:i",strtotime($end_time." +1 day"));
                }
                elseif($row['thursday'] == "y" && $row['start_time'] > $row['end_time']) {
                    $start_time = date("Y-m-d H:i",strtotime($row['start_time']." -1 day"));
                    $end_time = date("Y-m-d H:i",strtotime($row['end_time']));
                }
                $possible_curfew = true;
                break;
                
            case 6:
                if($row['saturday'] == "y") {
                    $start_time = date("Y-m-d H:i",strtotime($row['start_time']));
                    $end_time = date("Y-m-d H:i",strtotime($row['end_time']));
                    if($row['start_time'] > $row['end_time'])
                        $end_time = date("Y-m-d H:i",strtotime($end_time." +1 day"));
                }
                elseif($row['friday'] == "y" && $row['start_time'] > $row['end_time']) {
                    $start_time = date("Y-m-d H:i",strtotime($row['start_time']." -1 day"));
                    $end_time = date("Y-m-d H:i",strtotime($row['end_time']));
                }
                $possible_curfew = true;
                break;
        }
        
        if($possible_curfew) {
            if(strtotime($currentdate) >= strtotime($start_time) && strtotime($currentdate) <= strtotime($end_time)) {
                
                // We are in an active curfew window - check the distance against the allowed radius
                $allowed_radius = $row['radius'];
                
                // Get the current home location
                $query = "SELECT home_latitude, home_longitude FROM homes WHERE username = '".$row['username']."'";
                $result_home = mysqli_query($mysql, $query);
                $num_rows_home = mysqli_num_rows($result);
                
                if($num_rows_home > 0) {
                    $row_home = mysqli_fetch_array($result_home);
                    $home_latitude = $row_home['home_latitude'];
                    $home_longitude = $row_home['home_longitude'];
                    
                    // Get the distance from the vehicle to the home
                    $json = json_decode(refresh_location());
                    
                    if($json->status == "SUCCESS") {
                        $vehicle_latitude = $json->vehicleLocation->latitude;
                        $vehicle_longitude = $json->vehicleLocation->longitude;
                        $distance = distance($home_latitude, $home_longitude, $vehicle_latitude, $vehicle_longitude, "M");
                        
                        // If the distance is larger than the allowed radius, alert
                        if($distance > $allowed_radius) {
                            
                            // Set the alert status as 'y' (ON)
                            $query = "UPDATE curfews SET alarm_status = 'y' WHERE curfew_id = '".$row['curfew_id']."'";
                            mysqli_query($mysql, $query);
                            
                            // Send out the various alerts
                            if($row['primary_choice'] == "both" || $row['primary_choice'] == "email") {
                                
                                $to = $row['primary_email'];
                                $subject = "Ford CurPhew Alert - Vehicle not in designated area";
                                $body = "Your vehicle is ".(number_format($distance, 2))." miles away from its designated area. Please verify.";
                                mail($to, $subject, $body);
                            }
                            if($row['primary_choice'] == "both" || $row['primary_choice'] == "phone") {
                                
                                $phone = $row['primary_phone'];
                                $body = "Your vehicle is ".(number_format($distance, 2))." miles away from its designated area. Please verify.";
                                
                                $client->messages->create(
                                    $phone,
                                    array(
                                        'from' => $twilio_number,
                                        'body' => $body
                                    )
                                );
                            }
                            if($row['secondary_choice'] == "both" || $row['secondary_choice'] == "email") {
                                
                                $to = $row['secondary_email'];
                                $subject = "Ford CurPhew Alert - Vehicle not in designated area";
                                if($row['secondary_message'] == "") {
                                    $body = "Your vehicle is ".(number_format($distance, 2))." miles away from its designated area. Please verify.";
                                }
                                else {
                                    $body = str_replace("!start!", $start_time, str_replace("!distance!", number_format($distance, 2)." miles", $row['secondary_message']));
                                }
                                mail($to, $subject, $body);
                            }
                            if($row['secondary_choice'] == "both" || $row['secondary_choice'] == "phone") {
                                
                                $phone = $row['secondary_phone'];
                                if($row['secondary_message'] == "") {
                                    $body = "Your vehicle is ".(number_format($distance, 2))." miles away from its designated area. Please verify.";
                                }
                                else {
                                    $body = str_replace("!start!", $start_time, str_replace("!distance!", number_format($distance, 2)." miles", $row['secondary_message']));
                                }
                                
                                $client->messages->create(
                                    $phone,
                                    array(
                                        'from' => $twilio_number,
                                        'body' => $body
                                    )
                                );
                            }
                        }
                    }
                }
            }
        }
    }
}

?>