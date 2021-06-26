<?php
session_start();
if(!isset($_SESSION['username_database']))
    header("location: username.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>CurPhew | Ford Connect Hackathon</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
        <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />
        <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="css/themify-icons/themify-icons.css">
        <link rel="stylesheet" href="css/slick/slick.css">
        <link rel="stylesheet" href="css/slick/slick-theme.css">
        <link rel="stylesheet" href="css/fancybox/jquery.fancybox.min.css">
        <link rel="stylesheet" href="css/aos/aos.css">
        <link href="css/style.css?id=<?php echo date("YmdHis"); ?>" rel="stylesheet">
    </head>
    <body class="body-wrapper" data-spy="scroll" data-target=".privacy-nav">
      
        <nav class="navbar main-nav navbar-expand-lg px-2 px-sm-0 py-2 py-lg-0">
          <div class="container">
            <a class="navbar-brand" href="index.html"><img id="logo" src="images/logo.png" alt="logo"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
              aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="ti-menu"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav ml-auto">
                <li class="nav-item home">
                  <a class="nav-link" href="#" onclick="show_home_panel();">Home</a>
                </li>

                <li class="nav-item curfewst">
                  <a class="nav-link" href="#" onclick="show_curfew_panel();">Curfews</a>
                </li>
                
                <li class="nav-item curfewst">
                  <a class="nav-link" href="logout.php">LOGOUT</a>
                </li>
                
              </ul>
            </div>
          </div>
        </nav>
        
        <div id="curfew-holder">
           <strong>Curfew Settings</strong><br/>
           <table id="curfew-table">
               <tr>
                   <td>Curfew Status</td>
                   <td>
                        <select id="status">
                            <option value="off">Inactive</option>
                            <option value="on">Active</option>
                        </select>
                   </td>
               </tr>
               <tr>
                   <td>Radius</td>
                   <td>
                        <select id="radius">
                            <option value="0.25">0.25 miles</option>
                            <option value="0.30">0.30 miles</option>
                            <option value="0.35">0.35 miles</option>
                            <option value="0.40">0.40 miles</option>
                            <option value="0.45">0.45 miles</option>
                            <option value="0.50">0.50 miles</option>
                        </select>
                   </td>
               </tr>
               <tr>
                   <td>Curfew Days</td>
                   <td>
                       <span class="days" id="sunday">SUN</span>
                       <span class="days" id="monday">MON</span>
                       <span class="days" id="tuesday">TUE</span>
                       <span class="days" id="wednesday">WED</span>
                       <span class="days" id="thursday">THU</span>
                       <span class="days" id="friday">FRI</span>
                       <span class="days" id="saturday">SAT</span>
                   </td>
               </tr>
               <tr>
                    <td>Start Time</td>
                    <td>
                        <select id="start_time">
                            <option value="00:00">Midnight</option>
                            <option value="00:30">12:30 AM</option>
                            <option value="01:00">1:00 AM</option>
                            <option value="01:30">1:30 AM</option>
                            <option value="02:00">2:00 AM</option>
                            <option value="02:30">2:30 AM</option>
                            <option value="03:00">3:00 AM</option>
                            <option value="03:30">3:30 AM</option>
                            <option value="04:00">4:00 AM</option>
                            <option value="04:30">4:30 AM</option>
                            <option value="05:00">5:00 AM</option>
                            <option value="05:30">5:30 AM</option>
                            <option value="06:00">6:00 AM</option>
                            <option value="06:30">6:30 AM</option>
                            <option value="07:00">7:00 AM</option>
                            <option value="07:30">7:30 AM</option>
                            <option value="08:00">8:00 AM</option>
                            <option value="08:30">8:30 AM</option>
                            <option value="09:00">9:00 AM</option>
                            <option value="09:30">9:30 AM</option>
                            <option value="10:00">10:00 AM</option>
                            <option value="10:30">10:30 AM</option>
                            <option value="11:00">11:00 AM</option>
                            <option value="11:30">11:30 AM</option>
                            <option value="12:00">12:00 PM</option>
                            <option value="12:30">12:30 PM</option>
                            <option value="13:00">1:00 PM</option>
                            <option value="13:30">1:30 PM</option>
                            <option value="14:00">2:00 PM</option>
                            <option value="14:30">2:30 PM</option>
                            <option value="15:00">3:00 PM</option>
                            <option value="15:30">3:30 PM</option>
                            <option value="16:00">4:00 PM</option>
                            <option value="16:30">4:30 PM</option>
                            <option value="17:00">5:00 PM</option>
                            <option value="17:30">5:30 PM</option>
                            <option value="18:00">6:00 PM</option>
                            <option value="18:30">6:30 PM</option>
                            <option value="19:00">7:00 PM</option>
                            <option value="19:30">7:30 PM</option>
                            <option value="20:00">8:00 PM</option>
                            <option value="20:30">8:30 PM</option>
                            <option value="21:00">9:00 PM</option>
                            <option value="21:30">9:30 PM</option>
                            <option value="22:00">10:00 PM</option>
                            <option value="22:30">10:30 PM</option>
                            <option value="23:00">11:00 PM</option>
                            <option value="23:30">11:30 PM</option>
                        </select>
                   </td>
                   <tr>
                        <td>End Time</td>
                        <td>
                        <select id="end_time">
                            <option value="00:00">Midnight</option>
                            <option value="00:30">12:30 AM</option>
                            <option value="01:00">1:00 AM</option>
                            <option value="01:30">1:30 AM</option>
                            <option value="02:00">2:00 AM</option>
                            <option value="02:30">2:30 AM</option>
                            <option value="03:00">3:00 AM</option>
                            <option value="03:30">3:30 AM</option>
                            <option value="04:00">4:00 AM</option>
                            <option value="04:30">4:30 AM</option>
                            <option value="05:00">5:00 AM</option>
                            <option value="05:30">5:30 AM</option>
                            <option value="06:00">6:00 AM</option>
                            <option value="06:30">6:30 AM</option>
                            <option value="07:00">7:00 AM</option>
                            <option value="07:30">7:30 AM</option>
                            <option value="08:00">8:00 AM</option>
                            <option value="08:30">8:30 AM</option>
                            <option value="09:00">9:00 AM</option>
                            <option value="09:30">9:30 AM</option>
                            <option value="10:00">10:00 AM</option>
                            <option value="10:30">10:30 AM</option>
                            <option value="11:00">11:00 AM</option>
                            <option value="11:30">11:30 AM</option>
                            <option value="12:00">12:00 PM</option>
                            <option value="12:30">12:30 PM</option>
                            <option value="13:00">1:00 PM</option>
                            <option value="13:30">1:30 PM</option>
                            <option value="14:00">2:00 PM</option>
                            <option value="14:30">2:30 PM</option>
                            <option value="15:00">3:00 PM</option>
                            <option value="15:30">3:30 PM</option>
                            <option value="16:00">4:00 PM</option>
                            <option value="16:30">4:30 PM</option>
                            <option value="17:00">5:00 PM</option>
                            <option value="17:30">5:30 PM</option>
                            <option value="18:00">6:00 PM</option>
                            <option value="18:30">6:30 PM</option>
                            <option value="19:00">7:00 PM</option>
                            <option value="19:30">7:30 PM</option>
                            <option value="20:00">8:00 PM</option>
                            <option value="20:30">8:30 PM</option>
                            <option value="21:00">9:00 PM</option>
                            <option value="21:30">9:30 PM</option>
                            <option value="22:00">10:00 PM</option>
                            <option value="22:30">10:30 PM</option>
                            <option value="23:00">11:00 PM</option>
                            <option value="23:30">11:30 PM</option>
                        </select>
                   </td>
               </tr>
               <tr>
                   <td>Primary Notification</td>
                   <td>
                       <select id="primary_notification" onchange="toggle_primary();">
                           <option value="both">Phone and Email</option>
                           <option value="phone">Phone</option>
                           <option value="email">Email</option>
                       </select>
                   </td>
               </tr>
               <tr id="primary_phone_tr">
                   <td>Primary Phone</td>
                   <td><input type="text" id="primary_phone" value="" /></td>
               </tr>
               <tr id="primary_email_tr">
                   <td>Primary Email</td>
                   <td><input type="text" class="email" id="primary_email" value="" /></td>
               </tr>
               <tr>
                   <td>Secondary Notification</td>
                   <td>
                       <select id="secondary_notification" onchange="toggle_secondary();">
                           <option value="both">Phone and Email</option>
                           <option value="phone">Phone</option>
                           <option value="email">Email</option>
                           <option value="none">None</option>
                       </select>
                   </td>
               </tr>
               <tr id="secondary_phone_tr">
                   <td>Secondary Phone</td>
                   <td>
                       <input type="text" id="secondary_phone" value="" />
                       <br/>Optional custom text message.<br/>Enter !start! or !distance! to add those two values to the message.<br><textarea class="textarea" id="secondary_message"></textarea></start>
                   </td>
               </tr>
               <tr id="secondary_email_tr">
                   <td>Secondary Email</td>
                   <td><input type="text" class="email" id="secondary_email" value="" /></td>
               </tr>
           </table>
           <button class="settings-button" onclick="save_curfew();">Save</button><br/>
        </div>
        
        <div id="infobar">
            <div id="infobar-left">Distance from home: <span id="distance_from_home"></span> | Curfew Status: <span id="curfew_status"></span></div><div id="infobar-right"><span onclick="center_on_vehicle();" class="cursor">View Car</span> | <span onclick="center_on_home();" class="cursor">View Home</span> | <span onclick="verify_reset_home();" class="cursor">Reset Home</span></div>
        </div>
            
        <div id="map-holder">
            <!-- MAP -->
            <div id="map"></div>
            
            <!-- NOTIFICATION -->
            <div id="notification">
                <span class="notification_message" id="home-notification-none">Home location NOT SET.<br/>Would you like to set your current location as your home location?<br/><button class="settings-button" onclick="activate_geolocation();">YES</button><button class="settings-button" onclick="activate_manual_address();">NO</button>
                </span>
                
                <span class="notification_message" id="geolocation-activating"><br/>Please wait while geolocation is activated...<br/>Remember to allow GPS positioning if prompted.
                </span>
                
                <span class="notification_message" id="home-notification-confirm"><br/>Would you like to set this as your home location?<br/><button class="settings-button" onclick="confirm_home();">YES</button><button class="settings-button" onclick="activate_manual_address();">NO</button>
                </span>
                
                <span class="notification_message" id="home-address-prompt">Please enter your home address:<br/>
                <table id="address_table">
                    <tr>
                        <td><input class="text" type="text" id="address" /></td>
                        <td><input class="text" type="text" id="city" /></td>
                        <td><input class="small-text" type="text" id="state" /></td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td>City</td>
                        <td>State</td>
                    </tr>
                </table>
                <button class="settings-button" onclick="geolocate_manual_address();">Go!</button><button class="settings-button" onclick="cancel_manual_address()">Cancel</button>
                </span>
                
                <span class="notification_message" id="vehicle-location-in-progress"><br/>Please wait while the vehicle is located....
                </span>
                
                <span class="notification_message" id="home-notification-reset"><br/>Are you sure you want to reset your home location?<br/><button class="settings-button" onclick="reset_home();">YES</button><button class="settings-button" onclick="cancel_reset_home();">NO</button>
                </span>
                
                <span class="notification_message" id="manual-home-selection"><br/>Click anywhere on the map to set your home location.<br/><button class="settings-button" onclick="cancel_manual_home_notification()">OK</button></span>
                
                <span class="notification_message" id="curfew-in-progress"><br/>Please wait while the curfew information is loaded....
                </span>
                
            </div>
        </div>
        
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/slick.min.js"></script>
        <script src="js/jquery.fancybox.min.js"></script>
        <script src="js/jquery.syotimer.min.js"></script>
        <script src="js/aos.js"></script>
        <script src="js/script.js"></script>
        <script type="text/javascript">
        var radius = 0.00;
        var home_shown = true;
        var manual_home_selection = false;
        let map;
        let auto_marker;
        let home_marker;
        let home_radius;
        let auto_coords;
        let home_coords;
        var auto_image = "";
        $(document).ready(function(){
            // First step
            // Is the user home set?
            $.post("home_location.php").done(function(data){
                if(data != "") {
                    var json = JSON.parse(data);
                    // User has not yet set a home location
                    if(json.status == "NONE") {
                        $("#home-notification-none").show();
                        $("#notification").fadeIn(400);
                    }
                    else if(json.status == "SUCCESS") {
                        home_coords = new Object();
                        home_coords.latitude = json.latitude;
                        home_coords.longitude = json.longitude;
                        var center = new google.maps.LatLng(home_coords.latitude, home_coords.longitude);
                        map.panTo(center);
                        map.setZoom(15);
                        update_map(center);
                        geolocate_vehicle();
                    }
                }
            });
            // Allow the days to be toggled
            $(".days").click(function(){
                if($(this).hasClass("days-picked"))
                    $(this).removeClass("days-picked");
                else
                    $(this).addClass("days-picked");
            });
        });
        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                center: { lat: 37.090, lng: -95.712 },
                zoom: 2,
            });
            map.addListener('click', function(e) {
                if(manual_home_selection) {
                    manual_home_selection = false;
                    home_marker.setMap(null);
                    home_radius.setMap(null);
                    update_map(e.latLng);
                    
                    // Set this is the new home location
                    home_coords = new Object();
                    home_coords.latitude = e.latLng.lat();
                    home_coords.longitude = e.latLng.lng();
                        
                    $.post("confirm_home.php", {lat: home_coords.latitude, lon: home_coords.longitude}).done(function(data) {
                        geolocate_vehicle();
                    });
                }
            });
        }
        // Geolocation
        var geolocation_options = {
            enableHighAccuracy: true,
            timeout: 5000,
            maximumAge: 0
        };
        function geolocation_success(pos) {
            home_coords = pos.coords;
            $("#geolocation-activating").fadeOut(400, function() {
                var center = new google.maps.LatLng(home_coords.latitude, home_coords.longitude);
                map.panTo(center);
                map.setZoom(15);
                update_map(center)
                $("#notification").css("opacity", "0.6");
                $("#home-notification-confirm").fadeIn(400);
            });
        }
        function geolocation_error(err) {
            console.warn(`ERROR(${err.code}): ${err.message}`);
        }
        function activate_manual_address() {
            $(".notification_message").hide();
            $("#home-notification-none").fadeOut(400, function() {
                $("#home-address-prompt").fadeIn(400);
            });
        }
        function geolocate_manual_address() {
            var address = $("#address").val();
            var city = $("#city").val();
            var state = $("#state").val();
            
            if(address == "" || city == "" || state == "") {
                alert("Please complete the address information.");
                return;
            }
            
            $.post("find_address.php", {address: address, city: city, state: state}).done(function(data){
                if(data != "") {
                    var json = JSON.parse(data);
                    if(json.status == "SUCCESS") {
                        home_coords = new Object();
                        home_coords.latitude = json.latitude;
                        home_coords.longitude = json.longitude;
                        var center = new google.maps.LatLng(home_coords.latitude, home_coords.longitude);
                        map.panTo(center);
                        map.setZoom(15);
                        update_map(center);
                        $("#notification").css("opacity", "0.6");
                        $("#home-address-prompt").fadeOut(400, function(){
                             $("#home-notification-confirm").fadeIn(400); 
                        });
                    }
                }
            })
        }
        function activate_geolocation() {
            $("#home-notification-none").fadeOut(400, function() {
                 if(navigator.geolocation) {
                     $("#geolocation-activating").fadeIn(400);
                        navigator.geolocation.getCurrentPosition(geolocation_success, geolocation_error, geolocation_options);
                 }
                 else {
                     
                 }
            });
        }
        function confirm_home() {
             $("#home-notification-confirm").fadeOut(400, function(){
                 $.post("confirm_home.php", {lat: home_coords.latitude, lon: home_coords.longitude}).done(function(data) {
                     geolocate_vehicle();
                 })
             });
        }
        function geolocate_vehicle() {
            $(".notification_message").hide();
            $("#vehicle-location-in-progress").show();
            $("#notification").css("opacity", "0.6");
            $("#notification").fadeIn(400);
            
            if(auto_image == "") {
                $.post("vehicle_image.php").done(function(data) {
                    auto_image = data;
                    // Find the current GPS of the vehicle
                    $.post("status.php").done(function(data){
                        if(data != "") {
                            var json = JSON.parse(data);
                            if(json.status == "SUCCESS") {
                                auto_coords = new Object();
                                auto_coords.latitude = json.vehicle.vehicleLocation.latitude;
                                auto_coords.longitude = json.vehicle.vehicleLocation.longitude;
                                var center = new google.maps.LatLng(auto_coords.latitude, auto_coords.longitude);
                                map.panTo(center);
                                map.setZoom(15);
                                // Drop a pin
                                auto_marker = new google.maps.Marker({
                                    position: center,
                                    map,
                                    title: "Current Vehicle Location",
                                    icon: auto_image
                                });
                                $("#notification").fadeOut(400);
                                // Get the vehicle distance from home
                                get_vehicle_distance();
                            }
                        }
                    });
                });
            }
            else {
                // Find the current GPS of the vehicle
                $.post("status.php").done(function(data){
                    if(data != "") {
                        var json = JSON.parse(data);
                        if(json.status == "SUCCESS") {
                            auto_coords = new Object();
                            auto_coords.latitude = json.vehicle.vehicleLocation.latitude;
                            auto_coords.longitude = json.vehicle.vehicleLocation.longitude;
                            var center = new google.maps.LatLng(auto_coords.latitude, auto_coords.longitude);
                            map.panTo(center);
                            map.setZoom(15);
                            // Drop a pin
                            auto_marker = new google.maps.Marker({
                                position: center,
                                map,
                                title: "Current Vehicle Location",
                                icon: auto_image
                            });
                            $("#notification").fadeOut(400);
                            // Get the vehicle distance from home
                            get_vehicle_distance();
                        }
                    }
                });
            }
        }
        
        // Gets the vehicle distance from home
        function get_vehicle_distance() {
            $.post("distance.php", {vehicle_lat: auto_coords.latitude, vehicle_lon: auto_coords.longitude}).done(function(data){
                var json_dist = JSON.parse(data);
                if(json_dist.status == "SUCCESS") {
                    $("#distance_from_home").html(json_dist.distance+" miles");
                    $("#curfew_status").html(json_dist.curfew);
                    radius = json_dist.radius;
                    // Create the radius
                    if(radius > 0.00) {
                        if(home_radius)
                            home_radius.setMap(null);
                        var center = new google.maps.LatLng(home_coords.latitude, home_coords.longitude);
                        home_radius = new google.maps.Circle({
                            strokeColor: "#022253",
                            strokeOpacity: 0.8,
                            strokeWeight: 2,
                            fillColor: "#1e94cd",
                            fillOpacity: 0.35,
                            map,
                            center: center,
                            radius: (radius * 1609.344)
                        });
                    }
                    if(home_shown) {
                        if(!$("#infobar").is(":visible"))
                            $("#infobar").slideDown(400);
                    }
                }
            });
        }
        
        // Verify the user wants to reset the home
        function verify_reset_home() {
            center_on_home();
            $(".notification_message").hide();
            $("#home-notification-reset").show();
            $("#notification").css("opacity", "0.6");
            $("#notification").fadeIn(400);
        }
        
        // Remove the home location and reload the page
        function reset_home() {
            $("#home-notification-reset").fadeOut(400, function(){
                $.post("reset_home.php").done(function(data){
                    $("#manual-home-selection").fadeIn(400);
                    manual_home_selection = true;
                });
            })
        }
        
        // Cancel the reset
        function cancel_reset_home() {
            $("#notification").fadeOut(400);
        }
        
        // Cancels the manual address entry box
        function cancel_manual_address() {
            $("#home-address-prompt").fadeOut(400, function(){
                 $("#manual-home-selection").fadeIn(400);
                 manual_home_selection = true;
            });
        }
        
        // Cancels the manual home notification
        function cancel_manual_home_notification() {
            $("#manual-home-selection").fadeOut(400);
            $("#notification").fadeOut(400);
        }
        
        // Recenter the map on the vehicle 
        function center_on_vehicle() {
            var center = new google.maps.LatLng(auto_coords.latitude, auto_coords.longitude);
            map.panTo(center);
            map.setZoom(15);
        }
        
        // Recenter the map on the user home
        function center_on_home() {
            var center = new google.maps.LatLng(home_coords.latitude, home_coords.longitude);
            map.panTo(center);
            map.setZoom(15);
        }
        
        // Udate the map
        function update_map(center) {
            // Drop a pin
            home_marker = new google.maps.Marker({
                position: center,
                map,
                title: "Home"});
            // Create the radius
            if(radius > 0.00) {
                home_radius = new google.maps.Circle({
                    strokeColor: "#022253",
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: "#1e94cd",
                    fillOpacity: 0.35,
                    map,
                    center: center,
                    radius: (radius * 1609.344)
                });
            }
        }
        
        // Slide the home panel into view
        function show_home_panel() {
            if(!home_shown) {
                home_shown = true;
                $("#curfew-holder").animate({"left" : "-100%"}, function(){
                    $("#curfew-holder").hide();
                    $("#infobar").show();
                    $("#map-holder").show();
                    $("#infobar").animate({"left" : "0%"});
                    $("#map-holder").animate({"left" : "0%"}, function(){
                    });
                });
            }
        }
        
        // Slide the curfew panel into view
        function show_curfew_panel() {
            if(home_shown) {
                home_shown = false;
                $(".notification_message").hide();
                $("#curfew-in-progress").fadeIn(400);
                $("#notification").fadeIn(400, function(){
                    $.post("get_curfew.php").done(function(data){
                        var json = JSON.parse(data);
                        if(json.curfew_status != "NOT_FOUND") {
                            // Populate the fields
                            $("#status").val(json.curfew_status);
                            $("#radius").val(json.radius);
                            $(".days").removeClass("days-picked");
                            if(json.sunday == "y")
                                $("#sunday").addClass("days-picked");
                            if(json.monday == "y")
                                $("#monday").addClass("days-picked");
                            if(json.tuesday == "y")
                                $("#tuesday").addClass("days-picked");
                            if(json.wednesday == "y")
                                $("#wednesday").addClass("days-picked");
                            if(json.thursday == "y")
                                $("#thursday").addClass("days-picked");
                            if(json.friday == "y")
                                $("#friday").addClass("days-picked");
                            if(json.saturday == "y")
                                $("#saturday").addClass("days-picked");
                            $("#start_time").val(json.start_time);
                            $("#end_time").val(json.end_time);
                            
                            $("#primary_notification").val(json.primary_choice);
                            $("#primary_phone").val(json.primary_phone);
                            $("#primary_email").val(json.primary_email);
                            $("#secondary_notification").val(json.secondary_choice);
                            $("#secondary_phone").val(json.secondary_phone);
                            $("#secondary_email").val(json.secondary_email);
                            $("#secondary_message").val(json.secondary_message);
                        }
                        $("#infobar").animate({"left" : "-100%"});
                        $("#map-holder").animate({"left" : "-100%"}, function(){
                            $("#infobar").hide();
                            $("#map-holder").hide();
                            $("#notification").fadeOut(400);
                            $("#curfew-holder").show();
                            toggle_primary();
                            toggle_secondary();
                            $("#curfew-holder").animate({"left" : "0%"});
                        });
                    });
                });
            }
        }
        
        // Toggle the primary notification channel displays
        function toggle_primary() {
            var primary = $("#primary_notification").val();
            if(primary == "both") {
                if(!$("#primary_phone_tr").is(":visible"))
                    $("#primary_phone_tr").slideDown(400);
                if(!$("#primary_email_tr").is(":visible"))
                    $("#primary_email_tr").slideDown(400);
            }
            else if(primary == "phone") {
                if(!$("#primary_phone_tr").is(":visible"))
                    $("#primary_phone_tr").slideDown(400);
                if($("#primary_email_tr").is(":visible"))
                    $("#primary_email_tr").slideUp(400);
            }
            else if(primary == "email") {
                if($("#primary_phone_tr").is(":visible"))
                    $("#primary_phone_tr").slideUp(400);
                if(!$("#primary_email_tr").is(":visible"))
                    $("#primary_email_tr").slideDown(400);
            }
        }
        
        // Toggle the secondary notification channel displays
        function toggle_secondary() {
            var secondary = $("#secondary_notification").val();
            if(secondary == "both") {
                if(!$("#secondary_phone_tr").is(":visible"))
                    $("#secondary_phone_tr").slideDown(400);
                if(!$("#secondary_email_tr").is(":visible"))
                    $("#secondary_email_tr").slideDown(400);
            }
            else if(secondary == "phone") {
                if(!$("#secondary_phone_tr").is(":visible"))
                    $("#secondary_phone_tr").slideDown(400);
                if($("#secondary_email_tr").is(":visible"))
                    $("#secondary_email_tr").slideUp(400);
            }
            else if(secondary == "email") {
                if($("#secondary_phone_tr").is(":visible"))
                    $("#secondary_phone_tr").slideUp(400);
                if(!$("#secondary_email_tr").is(":visible"))
                    $("#secondary_email_tr").slideDown(400);
            }
            else if(secondary == "none") {
                if($("#secondary_phone_tr").is(":visible"))
                    $("#secondary_phone_tr").slideUp(400);
                if($("#secondary_email_tr").is(":visible"))
                    $("#secondary_email_tr").slideUp(400);
            }
        }
        
        // Saves the current curfew configuration
        function save_curfew() {
            // Verify the inputs
            var days = "";
            $(".days").each(function(i) {
                if($(this).hasClass("days-picked"))
                    days+= $(this).attr("id")+"|";
            });
            if(days == "") {
                alert("Please select at least one day for the curfew.");
                return;
            }
            var status = $("#status").val();
            var radius = $("#radius").val();
            var primary = $("#primary_notification").val();
            var primary_phone = $("#primary_phone").val();
            var primary_email = $("#primary_email").val();
            var secondary = $("#secondary_notification").val();
            var secondary_phone = $("#secondary_phone").val();
            var secondary_message = $("#secondary_message").val();
            var secondary_email = $("#secondary_email").val();
            var start_time = $("#start_time").val();
            var end_time = $("#end_time").val();
            if(primary == "both" || primary == "phone") {
                if(primary_phone.match(/\d/g).length!==10) {
                    alert("Please enter a valid primary 10-digit phone number.");
                    return;
                }
            }
            else if(primary == "both" || primary == "email") {
                if(!validate_email(primary_email)) {
                    alert("Please enter a valid primary email address phone number.");
                    return;
                }
            }
            if(secondary == "both" || secondary == "phone") {
                if(secondary_phone.match(/\d/g).length!==10) {
                    alert("Please enter a valid secondary 10-digit phone number.");
                    return;
                }
            }
            else if(secondary == "both" || secondary == "email") {
                if(!validate_email(secondary_email)) {
                    alert("Please enter a valid secondary email address phone number.");
                    return;
                }
            }
            $.post("add_curfew.php", {status: status, radius: radius, days: days, primary: primary, primary_phone: primary_phone, primary_email: primary_email, secondary: secondary, secondary_phone: secondary_phone, secondary_message: secondary_message, secondary_email: secondary_email, start_time: start_time, end_time: end_time}).done(function(data){
                alert("The curfew information was saved.");
                get_vehicle_distance();
            });
        }

        // Helper function for email validation
        function validate_email(email) {
            const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
             return re.test(String(email).toLowerCase());
        }
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key={API_KEY}&callback=initMap&libraries=&v=weekly" async></script>
    </body>
</html>
