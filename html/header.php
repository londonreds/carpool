<?php require_once 'config.php'; ?><!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

	<title><?= SITE_TITLE ?></title>

	<meta property="og:image" content="/fb.jpg" />

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

  <link href="https://fonts.googleapis.com/css?family=Viga" rel="stylesheet">

  <script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="/style.css?v=<?= time() ?>">

  <script>
	  $( function() {
	    $( "#datepicker" ).datepicker({ dateFormat: 'd MM yy' });
	    $( "#datepicker2" ).datepicker({ dateFormat: 'd MM yy' });
	  } );
  </script>

</head>

<body>
