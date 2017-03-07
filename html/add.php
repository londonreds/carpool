<?php

  require_once 'connect.php';
  require_once 'functions.php';
  require_once 'config.php';

  // go and retrieve lat and lng for postcode
  $url = "https://maps.googleapis.com/maps/api/geocode/json?key=" . GOOGLE_MAPS_GEOCODE_KEY . "&address=" . urlencode($_POST['postcode']) . ",UK&sensor=false";  // bugfix - added ,UK to avoid getting geolocated in China etc
  $result = file_get_contents($url);
  $resultArray = json_decode($result, true);
  $lat = $resultArray['results'][0]['geometry']['location']['lat'];
  $lng = $resultArray['results'][0]['geometry']['location']['lng'];

  $time = time();
  $time_readable = date("r", $time);
  $ip_address = $_SERVER['REMOTE_ADDR'];
  $contact_url = create_code();

  if ($_POST['destination'] == DESTINATION1_NAME) $colour = DESTINATION1_COLOUR;
  if ($_POST['destination'] == DESTINATION2_NAME) $colour = DESTINATION2_COLOUR;

  $moderation = 'pending';

  $stmt = DB::conn()->prepare("INSERT INTO rides (destination, name, towncity, postcode, email, mobile, spaces, dateleaving, timeleaving, datereturning, timereturning, alsopickup, extrainfo, lat, lng, `time`, time_readable, ip_address, contact_url, colour, moderation) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
  $stmt->bind_param("sssssssssssssssssssss",
    html_safe($_POST['destination']),
    html_safe($_POST['name']),
    html_safe($_POST['towncity']),
    html_safe($_POST['postcode']),
    html_safe($_POST['email']),
    html_safe($_POST['mobile']),
    html_safe($_POST['spaces']),
    html_safe($_POST['dateleaving']),
    html_safe($_POST['timeleaving']),
    html_safe($_POST['datereturning']),
    html_safe($_POST['timereturning']),
    html_safe($_POST['alsopickup']),
    html_safe($_POST['extrainfo']),
    $lat,
    $lng,
    $time,
    $time_readable,
    $ip_address,
    $contact_url,
    $colour,
    $moderation
  );

  $stmt->execute(); $stmt->close();

?>
