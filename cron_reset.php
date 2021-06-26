<?php

include dirname( __FILE__ )."/db.php";
include dirname( __FILE__ )."/functions.php";
require dirname( __FILE__ )."/Twilio/autoload.php";
use Twilio\Rest\Client;

$account_sid = '{account_sid}';
$auth_token = '{auth_token}';
$twilio_number = "+{twilio_number}";
$client = new Client($account_sid, $auth_token);

// Hard-code the timezone for EST
date_default_timezone_set("America/New_York");

// Find all the alarms that are currently on
$query = "SELECT * FROM curfews WHERE alarm_status = 'y'";
$result = mysqli_query($mysql, $query);
$num_rows = mysqli_num_rows($result);

if($num_rows > 0) {
    while($row = mysqli_fetch_array($result)) {
        
        // Is the car still out of range?
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
                        
                // If the distance is less than the allowed radius, turn off alert
                if($distance <= $allowed_radius) {
                    // Set the alert status as 'n' (OFF)
                    $query = "UPDATE curfews SET alarm_status = 'n' WHERE curfew_id = '".$row['curfew_id']."'";
                    mysqli_query($mysql, $query);
                    
                    // Send out the alerts
                    if($row['primary_choice'] == "both" || $row['primary_choice'] == "email") {
                                
                        $to = $row['primary_email'];
                        $subject = "Ford CurPhew Alert - Vehicle IN designated area";
                        $body = "Your vehicle has returned to its designated area. Thank you.";
                        mail($to, $subject, $body);
                    }
                    if($row['primary_choice'] == "both" || $row['primary_choice'] == "phone") {
                                
                        $phone = $row['primary_phone'];
                        $body = "Your vehicle has returned to its designated area. Thank you.";
                                
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
                        $subject = "Ford CurPhew Alert - Vehicle IN designated area";
                        $body = "Your vehicle has returned to its designated area. Thank you.";
                        mail($to, $subject, $body);
                    }
                    if($row['secondary_choice'] == "both" || $row['secondary_choice'] == "phone") {
                                
                        $phone = $row['secondary_phone'];
                        $body = "Your vehicle has returned to its designated area. Thank you.";
                                
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

?>