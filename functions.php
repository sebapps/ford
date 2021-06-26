<?php

include("db.php");

// Hard-code the timezone for EST
date_default_timezone_set("America/New_York");

// Returns the access token used to make calls to the API
function get_access_token() {
    
    global $mysql;
    global $username;
    
    // Do we have an access token?
    $code = "";
    $access_token = "";
    $access_token_expire = "";
    $refresh_token = "";
    $refresh_token_expire = "";
    $rightnow = date("Y-m-d H:i:s", strtotime("now"));
    
    $query = "SELECT code, access_token, access_token_expire, refresh_token, refresh_token_expire FROM users WHERE username = '$username'";
    $result = mysqli_query($mysql, $query);
    
    $num_rows = mysqli_num_rows($result);
    if($num_rows > 0) {
        $row = mysqli_fetch_array($result);
        $code = $row['code'];
        $access_token = $row['access_token'];
        $access_token_expire = $row['access_token_expire'];
        $refresh_token = $row['refresh_token'];
        $refresh_token_expire = $row['refresh_token_expire'];
    }
    
    // If we do NOT have an access token, OR the refresh token expired, get both tokens
    if($access_token == "" || ($refresh_token_expire != "" && $rightnow > $refresh_token_expire)) {
        
        // Access tokens expire in 20 minutes - set it to 16 minutes in future
        $access_token_expire = date("Y-m-d H:i:s", strtotime("+16 minutes"));
        
        // Refresh tokens expire in 90 days - set it to 85 days
        $refresh_token_expire = date("Y-m-d H:i:s", strtotime("+85 days"));
        
        $command = 'curl -d "grant_type=authorization_code&client_id=30990062-9618-40e1-a27b-7c6bcb23658a&client_secret=T_Wk41dx2U9v22R5sQD4Z_E1u-l2B-jXHE&code='.$code.'" -H "Content-Type: application/x-www-form-urlencoded" -X POST https://dah2vb2cprod.b2clogin.com/914d88b1-3523-4bf6-9be4-1b96b4f6f919/oauth2/v2.0/token?p=B2C_1A_signup_signin_common';

        $response = shell_exec($command);
        $json = json_decode($response);

        if(isset($json->access_token))
            $access_token = $json->access_token;
        
        if(isset($json->refresh_token))
            $refresh_token = $json->refresh_token;
            
        $query = "UPDATE users SET access_token = '$access_token', access_token_expire = '$access_token_expire', refresh_token = '$refresh_token', refresh_token_expire = '$refresh_token_expire' WHERE username = '$username'";

        $result = mysqli_query($mysql, $query);
    }
    else {
        // If we have an access token, but it expired, get a refresh token
        if($access_token_expire != "" && $rightnow > $access_token_expire) {
        
            // Access tokens expire in 20 minutes - set it to 16 minutes in future
            $access_token_expire = date("Y-m-d H:i:s", strtotime("+16 minutes"));
        
            $command = 'curl -d "grant_type=refresh_token&refresh_token='.$refresh_token.'&client_id=30990062-9618-40e1-a27b-7c6bcb23658a&client_secret=T_Wk41dx2U9v22R5sQD4Z_E1u-l2B-jXHE" -H "Content-Type: application/x-www-form-urlencoded" -X POST https://dah2vb2cprod.b2clogin.com/914d88b1-3523-4bf6-9be4-1b96b4f6f919/oauth2/v2.0/token?p=B2C_1A_signup_signin_common';
        
            $response = shell_exec($command);
            $json = json_decode($response);
        
            if(isset($json->access_token))
                $access_token = $json->access_token;
            
            $query = "UPDATE users SET access_token = '$access_token', access_token_expire = '$access_token_expire' WHERE username = '$username'";
            $result = mysqli_query($mysql, $query);
        }
    }
    return $access_token;
}

// Returns the vehicle ID belonging to the user
function get_vehicle_id() {
    
    global $mysql;
    global $username;
    global $username_db;
    
    $vehicle_id = "";
    $vehicle_image = "";
    $query = "SELECT ford_vehicle_id, vehicle_image FROM vehicles WHERE username = '$username_db'";
    $result = mysqli_query($mysql, $query);
    $num_rows = mysqli_num_rows($result);
    
    if($num_rows > 0) {
        $row = mysqli_fetch_array($result);
        $vehicle_id = $row['ford_vehicle_id'];
        $vehicle_image = $row['vehicle_image'];
    }
    
    // If there are no vehicles, look up the first one and add it
    if($vehicle_id == "") {
        
        $access_token = get_access_token();
        $command = 'curl -H "Accept: application/json" -H "Content-Type: application/json" -H "api-version: 2020-06-01" -H "Application-Id: afdc085b-377a-4351-b23e-5e1d35fb3700" -H "Authorization: Bearer '.$access_token.'" https://api.mps.ford.com/api/fordconnect/vehicles/v1';

        $response = shell_exec($command);
        $json = json_decode($response);

        if(isset($json->vehicles)) {
            $vehicles = array();
            foreach($json->vehicles as $vehicle)
                $vehicles[] = $vehicle->vehicleId;
                
            // For testing purposes, use the first one
            $vehicle_id = $vehicles[0];
            
            $query = "INSERT INTO vehicles (username, ford_vehicle_id, vehicle_image) VALUES ('$username_db', '$vehicle_id', 'https://mkpuertorico.com/ford/images/ford_thumb.png')";
            $result = mysqli_query($mysql, $query);
        }
    }
    /*if($vehicle_image == "") {
        $access_token = get_access_token();
        $command = 'curl -H "Accept: application/json" -H "Content-Type: application/json" -H "api-version: 2020-06-01" -H "Application-Id: afdc085b-377a-4351-b23e-5e1d35fb3700" -H "Authorization: Bearer '.$access_token.'" https://api.mps.ford.com/api/fordconnect/vehicles/v1/'.$vehicle_id.'/images/thumbnail?make=Ford&model=&year=2019';

        $response = shell_exec($command);
        echo $response; exit;
        $json = json_decode($response);
        print_r($json); exit;

        if(isset($json->vehicles)) {
            $vehicles = array();
            foreach($json->vehicles as $vehicle)
                $vehicles[] = $vehicle->vehicleId;
                
            // For testing purposes, use the first one
            $vehicle_id = $vehicles[0];
            
            $query = "INSERT INTO vehicles (username, ford_vehicle_id) VALUES ('$username_db', '$vehicle_id')";
            $result = mysqli_query($mysql, $query);
        }
    }*/
    return $vehicle_id;
}

// Returns the vehicle image
function get_vehicle_image() {
    global $mysql;
    global $username;
    global $username_db;
    
    $vehicle_image = "";
    $query = "SELECT vehicle_image FROM vehicles WHERE username = '$username_db'";
    $result = mysqli_query($mysql, $query);
    $num_rows = mysqli_num_rows($result);
    
    if($num_rows > 0) {
        $row = mysqli_fetch_array($result);
        $vehicle_image = $row['vehicle_image'];
    }
    return $vehicle_image;
}

// Returns the vehicle status JSON object
function get_status() {
    
    // Get the vehicle ID
    $vehicle_id = get_vehicle_id();
    
    // Get the access token
    $access_token = get_access_token();
    
    $command = 'curl -H "Application-Id: afdc085b-377a-4351-b23e-5e1d35fb3700" -H "api-version: 2020-06-01" -H "Authorization: Bearer '.$access_token.'" https://api.mps.ford.com/api/fordconnect/vehicles/v1/'.$vehicle_id;
    
    $response = shell_exec($command);
    //$json = json_decode($response);
    
    return $response;
    
}

// Returns the vehicle location JSON object
function get_location() {
    
    // Get the vehicle ID
    $vehicle_id = get_vehicle_id();
    
    // Get the access token
    $access_token = get_access_token();
    
    $command = 'curl -H "Application-Id: afdc085b-377a-4351-b23e-5e1d35fb3700" -H "api-version: 2020-06-01" -H "Authorization: Bearer '.$access_token.'" https://api.mps.ford.com/api/fordconnect/vehicles/v1/'.$vehicle_id.'/location';
    
    $response = shell_exec($command);
    //$json = json_decode($response);
    
    return $response;
}

// Updates the vehicle location cache and then returns its location's JSON object
function refresh_location() {
    
    // Get the vehicle ID
    $vehicle_id = get_vehicle_id();
    
    // Get the access token
    $access_token = get_access_token();
    
    $command = 'curl -H "Application-Id: afdc085b-377a-4351-b23e-5e1d35fb3700" -H "api-version: 2020-06-01" -H "Authorization: Bearer '.$access_token.'" -X POST https://api.mps.ford.com/api/fordconnect/vehicles/v1/'.$vehicle_id.'/location';
    
    $response = shell_exec($command);
    $json = json_decode($response);
    
    // Now that we POSTED the call, we can get the updated status
    $json = get_location();
    return $json;
}

// Returns the user home location GPS coordinates
function get_home_location() {
    global $mysql;
    global $username;
    global $username_db;
    
    $json = '{"status": "<<STATUS>>", "longitude": "<<LONGITUDE>>", "latitude": "<<LATITUDE>>"}';
    
    $query = "SELECT home_latitude, home_longitude FROM homes WHERE username = '$username_db'";
    $result = mysqli_query($mysql, $query);
    $num_rows = mysqli_num_rows($result);
    
    if($num_rows > 0) {
        $row = mysqli_fetch_array($result);
        $json = str_replace("<<STATUS>>", "SUCCESS", str_replace("<<LONGITUDE>>", $row['home_longitude'], str_replace("<<LATITUDE>>", $row['home_latitude'], $json)));
    }
    else {
        $json = str_replace("<<STATUS>>", "NONE", str_replace("<<LONGITUDE>>", "0.00", str_replace("<<LATITUDE>>", "0.00", $json)));
    }
    return $json;
}

// Sets the home location
function set_home_location($lat, $lon) {
    global $mysql;
    global $username;
    global $username_db;
    
    $query = "SELECT home_latitude, home_longitude FROM homes WHERE username = '$username_db'";
    $result = mysqli_query($mysql, $query);
    $num_rows = mysqli_num_rows($result);
    
    if($num_rows == 0) {
        $query = "INSERT INTO homes (username, home_latitude, home_longitude) VALUES ('$username_db', '$lat', '$lon')";
        mysqli_query($mysql, $query);
    }
    else {
       $query = "UPDATE homes SET home_latitude = '$lat', home_longitude = '$lon' WHERE username = '$username_db'";
        mysqli_query($mysql, $query);
    }
    return "SUCCESS";
}

// Returns the distance from the vehicle to the user's home
function get_vehicle_distance($vlat, $vlon) {
    global $mysql;
    global $username;
    global $username_db;
    
    $json = '{"status" : "<<STATUS>>", "distance" : "<<DISTANCE>>", "curfew" : "<<CURFEW>>", "radius" : "<<RADIUS>>"}';
    $json_home = json_decode(get_home_location());
    $distance = number_format(distance($vlat, $vlon, $json_home->latitude, $json_home->longitude, "M"), 2);
    
    $query = "SELECT curfew_status, radius FROM curfews WHERE username = '$username_db'";
    $result = mysqli_query($mysql, $query);
    $num_rows = mysqli_num_rows($result);
    if($num_rows == 0) {
        $json = str_replace("<<STATUS>>", "SUCCESS", str_replace("<<DISTANCE>>", $distance, str_replace("<<CURFEW>>", "Not Set", str_replace("<<RADIUS>>", "0.00", $json))));
    }
    else {
        $row = mysqli_fetch_array($result);
        if($row['curfew_status'] == "off")
            $json = str_replace("<<STATUS>>", "SUCCESS", str_replace("<<DISTANCE>>", $distance, str_replace("<<CURFEW>>", "Inactive", str_replace("<<RADIUS>>", $row['radius'], $json))));
        else
            $json = str_replace("<<STATUS>>", "SUCCESS", str_replace("<<DISTANCE>>", $distance, str_replace("<<CURFEW>>", "Active", str_replace("<<RADIUS>>", $row['radius'], $json))));
    }
    return $json;
}

// Helper function for distance
function distance($lat1, $lon1, $lat2, $lon2, $unit) {
  if (($lat1 == $lat2) && ($lon1 == $lon2)) {
    return 0;
  }
  else {
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
      return ($miles * 1.609344);
    } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else {
      return $miles;
    }
  }
}

// Resets the user home (erases it)
function reset_home_location() {
    global $mysql;
    global $username;
    global $username_db;
    
    $query = "DELETE FROM homes WHERE username = '$username_db'";
    $result = mysqli_query($mysql, $query);
    
    return "SUCCESS";
}

// Adds or updates the curfew
function add_curfew($status, $radius, $days, $primary, $primary_phone, $primary_email, $secondary, $secondary_phone, $secondary_message, $secondary_email, $start_time, $end_time) {
    global $mysql;
    global $username;
    global $username_db;
    
    $query = "SELECT * FROM curfews WHERE username = '$username_db'";
    $result = mysqli_query($mysql, $query);
    $num_rows = mysqli_num_rows($result);
    
    if($num_rows == 0) {
        $days_query = " '<<SUN>>', '<<MON>>', '<<TUE>>', '<<WED>>', '<<THU>>', '<<FRI>>', '<<SAT>>' ";
        
        if(strpos($days, 'sunday') !== FALSE)
            $days_query = str_replace('<<SUN>>', 'y', $days_query);
        else
            $days_query = str_replace('<<SUN>>', 'n', $days_query);
        
        if(strpos($days, 'monday') !== FALSE)
            $days_query = str_replace('<<MON>>', 'y', $days_query);
        else
            $days_query = str_replace('<<MON>>', 'n', $days_query);
            
        if(strpos($days, 'tuesday') !== FALSE)
            $days_query = str_replace('<<TUE>>', 'y', $days_query);
        else
            $days_query = str_replace('<<TUE>>', 'n', $days_query);
            
        if(strpos($days, 'wednesday') !== FALSE)
            $days_query = str_replace('<<WED>>', 'y', $days_query);
        else
            $days_query = str_replace('<<WED>>', 'n', $days_query);
            
        if(strpos($days, 'thursday') !== FALSE)
            $days_query = str_replace('<<THU>>', 'y', $days_query);
        else
            $days_query = str_replace('<<THU>>', 'n', $days_query);
            
        if(strpos($days, 'friday') !== FALSE)
            $days_query = str_replace('<<FRI>>', 'y', $days_query);
        else
            $days_query = str_replace('<<FRI>>', 'n', $days_query);
            
        if(strpos($days, 'saturday') !== FALSE)
            $days_query = str_replace('<<SAT>>', 'y', $days_query);
        else
            $days_query = str_replace('<<SAT>>', 'n', $days_query);   
        
        $query = "INSERT INTO curfews (username, curfew_status, radius, sunday, monday, tuesday, wednesday, thursday, friday, saturday, primary_choice, primary_phone, primary_email, secondary_choice, secondary_phone, secondary_email, secondary_message, start_time, end_time) VALUES ('$username_db', '$status', '$radius', ".$days_query.", '$primary', '$primary_phone', '$primary_email', '$secondary', '$secondary_phone', '$secondary_email', '".urlencode($secondary_message)."', '$start_time', '$end_time')";
        $result = mysqli_query($mysql, $query);
    }
    else {
        $days_query = " sunday = '<<SUN>>', monday = '<<MON>>', tuesday = '<<TUE>>', wednesday = '<<WED>>', thursday = '<<THU>>', friday = '<<FRI>>', saturday = '<<SAT>>' ";
    
        if(strpos($days, 'sunday') !== FALSE)
            $days_query = str_replace('<<SUN>>', 'y', $days_query);
        else
            $days_query = str_replace('<<SUN>>', 'n', $days_query);
        
        if(strpos($days, 'monday') !== FALSE)
            $days_query = str_replace('<<MON>>', 'y', $days_query);
        else
            $days_query = str_replace('<<MON>>', 'n', $days_query);
            
        if(strpos($days, 'tuesday') !== FALSE)
            $days_query = str_replace('<<TUE>>', 'y', $days_query);
        else
            $days_query = str_replace('<<TUE>>', 'n', $days_query);
            
        if(strpos($days, 'wednesday') !== FALSE)
            $days_query = str_replace('<<WED>>', 'y', $days_query);
        else
            $days_query = str_replace('<<WED>>', 'n', $days_query);
            
        if(strpos($days, 'thursday') !== FALSE)
            $days_query = str_replace('<<THU>>', 'y', $days_query);
        else
            $days_query = str_replace('<<THU>>', 'n', $days_query);
            
        if(strpos($days, 'friday') !== FALSE)
            $days_query = str_replace('<<FRI>>', 'y', $days_query);
        else
            $days_query = str_replace('<<FRI>>', 'n', $days_query);
            
        if(strpos($days, 'saturday') !== FALSE)
            $days_query = str_replace('<<SAT>>', 'y', $days_query);
        else
            $days_query = str_replace('<<SAT>>', 'n', $days_query);    
    
        $query = "UPDATE curfews SET curfew_status = '$status', radius = '$radius', ".$days_query.", primary_choice = '$primary', primary_phone = '$primary_phone', primary_email = '$primary_email', secondary_choice = '$secondary', secondary_phone = '$secondary_phone', secondary_email = '$secondary_email', secondary_message = '$secondary_message', start_time = '$start_time', end_time = '$end_time' WHERE username = '$username_db'";
        $result = mysqli_query($mysql, $query);
    }
    echo "SUCCESS";
}

// Returns the user's curfew
function get_curfew() {
    global $mysql;
    global $username;
    global $username_db;
    
    $json = '{"curfew_status" : "NOT_FOUND"}';
    
    $query = "SELECT json_object('curfew_status', curfew_status, 'radius', radius, 'sunday', sunday, 'monday', monday, 'tuesday', tuesday, 'wednesday', wednesday, 'thursday', thursday, 'friday', friday, 'saturday', saturday, 'primary_choice', primary_choice, 'primary_phone', primary_phone, 'primary_email', primary_email, 'secondary_choice', secondary_choice, 'secondary_phone', secondary_phone, 'secondary_email', secondary_email, 'secondary_message', secondary_message, 'start_time', start_time, 'end_time', end_time) AS result FROM curfews WHERE username = '$username_db'";
    $result = mysqli_query($mysql, $query);
    $num_rows = mysqli_num_rows($result);

    if($num_rows > 0) {
        $row = mysqli_fetch_array($result);
        $json = $row['result'];
    }
    return $json;
}
?>