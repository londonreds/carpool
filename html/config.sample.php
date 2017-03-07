<?php

  // database
  const MYSQL_HOST = 'localhost';
  const MYSQL_USER = 'carpool';
  const MYSQL_PASS = 'password here';
  const MYSQL_DB = 'carpool';

  // to send emails from interested people to drivers
  // see README.md for installation of Mailgun dependencies
  const MAILGUN_API_KEY = 'key-xxxx';
  const MAILGUN_DOMAIN = '';

  // for map and postcode geocoder
  // https://developers.google.com/maps/documentation/javascript/
  // https://developers.google.com/maps/documentation/geocoding/
  const GOOGLE_MAPS_API_KEY = '';
  const GOOGLE_MAPS_GEOCODE_KEY = '';

  // contact email will be displayed publicly at some points
  const SITE_TITLE = 'Momentum Carpool';
  const CONTACT_EMAIL = '';
  const FROM_EMAIL = '';

  // text for the front page (html allowed)
  const INTRO_TEXT = 'Heading to Copeland or Stoke to campaign for Labour in the upcoming byelections? Enter your postcode below to find a ride! Or if you can drive, enter where you\'re heading from to offer a lift to other activists.<br /><a href="http://www.peoplesmomentum.com/by_elections" target="_blank">More info on the byelections &raquo;</a>';

  // this password lets you log in to /admin - don't leave it blank
  const ADMIN_PANEL_PASSWORD = "password here";

  // it's possible to have more (or fewer) destinations but you'll need to
  // find where these constants are used and adapt the code there
  const DESTINATION1_NAME = 'Stoke';
  const DESTINATION1_COLOUR = 'red';
  const DESTINATION1_LAT = 53.0027;
  const DESTINATION1_LNG = -2.1794;
  const DESTINATION2_NAME = 'Copeland';
  const DESTINATION2_COLOUR = 'turq';
  const DESTINATION2_LAT = 54.5497;
  const DESTINATION2_LNG = -3.5892;
