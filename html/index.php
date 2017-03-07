<?php

	error_reporting(E_ERROR | E_PARSE);		// no warnings or notices in prod

	global $req;
	$req = explode("/", $_SERVER['REQUEST_URI']);

	if ($req[1] == 'add') {
		if (!$_POST) {
			header('Location: /');
			exit();
		}
		require_once('add.php');
		$added = true;
		// exit();
	}

	if ($req[1] == 'contact') {
		require_once('contact.php');
		exit();
	}

	if ($req[1] == 'admin') {
		require_once('admin.php');
		exit();
	}

	if ($req[1] == 'offer') {
		require_once('offer.php');
		exit();
	}

	require_once 'connect.php';
	require_once 'functions.php';

	$stmt = DB::conn()->prepare("SELECT * FROM rides WHERE moderation = 'approved' AND STR_TO_DATE(dateleaving, '%d %M %Y') > NOW() ORDER BY STR_TO_DATE(dateleaving, '%d %M %Y') ASC");
	// the date filter is so we don't show cars leaving in the past.
	// the 'order by' is so the soonest cars are on top where there are two in the same place
	$stmt->execute();
	$result = $stmt->get_result();
	while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			array_walk ( $row, 'html_safe' );
			$events[] = (object) $row;
	}

	require_once 'header.php';

?>

  <div id="events_map" class="gmaps"></div>

	<div class="mobile-panel">
		<div class="container">
			<div class="row" style="margin-top: 10px;">
				<form method="post" action="/search">
					<div class="col-xs-6" style="padding-right: 10px;">
						<div class="input-group">
							<input id="addressmob" type="text" name="address" placeholder="Postcode" class="form-control" />
							<span class="input-group-btn"><input id="submitmob" type="button" value="Go" class="btn btn-default" /></span>
						</div>
					</div>
					<div class="col-xs-6" style="padding-left: 10px;">
						<a class="btn btn-default form-control" style="font-size: 16px;" href="/offer"><img src="/car-red.png"> &nbsp;Offer a ride</a>
					</div>
				</form>
			</div>
		</div>
	</div>

	<?php if ( isset($added) ): ?>
		<div class="mobile-panel" style="top: 0; z-index: 99;">
			<div class="alert alert-success"><button type="button" class="close" onclick="$(this).parent().parent().hide();">&times;</button>Thanks for adding your offer of a ride! It will be checked over and appear on the map soon.</div>
		</div>
	<?php endif; ?>

	<div class="container">

    <div class="row" style="margin-top: 1.5em;">

      <div class="col-md-3">
        <img src="/carpool.png" style="max-width: 300px;" />
      </div>

      <div class="col-md-4 col-md-offset-5 info-panel" style="background-color: white; padding: 1em; max-height: 90vh; overflow-y: scroll; overflow-x: hidden;">

				<?php if ( isset($added) ): ?>
					<div class="alert alert-success">Thanks for adding your offer of a ride! It will be checked over and appear on the map soon.</div>
				<?php endif; ?>

        <p><?= INTRO_TEXT ?></p>
				Key: &nbsp; <img src="/car-<?= DESTINATION1_COLOUR ?>.png" /> Going to <?= DESTINATION1_NAME ?> &nbsp; <img src="/car-<?= DESTINATION2_COLOUR ?>.png" /> Going to <?= DESTINATION2_NAME ?>
        <hr />

        <h4><img src="/car-red.png"> &nbsp;Find a ride</h4>
        <form method="post" action="/search">
          <input id="address" type="text" name="address" placeholder="Postcode" class="form-control" />
					<input id="submit" type="button" value="Search" class="btn btn-default" style="margin-top: 0.5em;" />
					<br />
        </form>

        <hr />
        <a class="btn btn-default" style="font-size: 18px;" onclick="$('#add-form').toggle();"><img src="/car-red.png"> &nbsp;Can you offer a ride?</a>

        <br />
        <form method="post" action="/add" id="add-form" style="display: none;">
					<?php require_once 'offer-form.php'; ?>
        </form>

      </div>

    </div>


		<script>

		  initMap = function(){
		   map = new google.maps.Map(document.getElementById('events_map'), {
		      zoom: 6,
			    center: {lat: 53.8, lng: -1.55}
		    });
				geocoder = new google.maps.Geocoder();
			  document.getElementById('submit').addEventListener('click', function() {
			    geocodeAddress(geocoder, map);
			  });
				document.getElementById('submitmob').addEventListener('click', function() {
			    geocodeAddress(geocoder, map);
			  });

		    // var bounds = new google.maps.LatLngBounds();
		    var openWindow = null;

				var marker = new google.maps.Marker({
						position: { lat: <?= DESTINATION1_LAT ?>, lng: <?= DESTINATION1_LNG ?> },
						map: map,
						title: '<?= DESTINATION1_NAME ?>',
						icon: '/star-<?= DESTINATION1_COLOUR ?>.png'
				});
				var marker = new google.maps.Marker({
						position: { lat: <?= DESTINATION2_LAT ?>, lng: <?= DESTINATION2_LNG ?> },
						map: map,
						title: '<?= DESTINATION2_NAME ?>',
						icon: '/star-<?= DESTINATION2_COLOUR ?>.png'
				});

		    $('.m-event').each(function(){

					var lat = $(this).data('lat'),
		          lng = $(this).data('lng'),
		          title = $(this).data('towncity'),
              colour = $(this).data('colour');

		      if (lat && lng){
		          var marker = new google.maps.Marker({
		              position: { lat: lat, lng: lng },
		              map: map,
		              title: title,
                  icon: '/car-' + colour + '.png'
		          });
		          var infoWindow = new google.maps.InfoWindow({
		              content:
									'<div style="max-width: 200px;">'
										+ '<h4>To '
										+ $(this).data('destination')
										+ ' &nbsp;<img src="/car-'
										+ $(this).data('colour')
										+ '.png"></h4><h5>Leaving from '
										+ $(this).data('towncity')
										+ '<br />'
										+ $(this).data('leaving')
										+ '<br />'
										+ $(this).data('spaces')
										+ ' spaces</h5>'
										+ '<p>Returning '
										+ $(this).data('returning')
										+ '<br />'
										+ $(this).data('alsopickup')
										+ '<br />'
										+ $(this).data('extrainfo')
										+ '</p>'
										+ '<p><a class="btn btn-primary" href="/contact/'
										+ $(this).data('contact_url')
										+ '">Contact</a></p>'
									+ '</div>'
		          });

		          marker.addListener('click', function(){
		            if (openWindow){
		              openWindow.close();

		              if (openWindow != infoWindow){
		                openWindow = infoWindow;
		                infoWindow.open(map, marker);
		              } else {
		                openWindow = null;
		              }
		            } else {
		              openWindow = infoWindow;
		              infoWindow.open(map, marker);
		            }
		          });
		      }
		    });

		  };

		function geocodeAddress(geocoder, resultsMap) {
		  var address = document.getElementById('address').value;
			if (!address) {
				address = document.getElementById('addressmob').value;
			}
			var request = {
			    address: address,
			    componentRestrictions: {
			        country: 'UK'
			    }
			}
		  geocoder.geocode(request, function(results, status) {
		    if (status === 'OK') {
		      resultsMap.setCenter(results[0].geometry.location);
					resultsMap.setZoom(9);
		    } else {
		      alert("Sorry, we couldn't find that place");
		    }
		  });
		}

		$(document).on("keypress", 'form', function (e) {
		    var code = e.keyCode || e.which;
		    if (code == 13) {
		        e.preventDefault();
						geocodeAddress(geocoder, map);
		        return false;
		    }
		});

		</script>

    <?php foreach ($events as $event): ?>
	    <div
	    class="m-event"
	    data-lat="<?= $event->lat ?>"
	    data-lng="<?= $event->lng ?>"
	    data-destination="<?= $event->destination ?>"
			data-towncity="<?= ucwords($event->towncity) ?>"
			data-leaving="<?= $event->dateleaving ?> <?= $event->timeleaving ?>"
			data-returning="<?= $event->datereturning ?> <?= $event->timereturning ?>"
			data-spaces="<?= $event->spaces ?>"
			data-alsopickup="<?php if ($event->alsopickup) echo 'Can also pick up from ' . $event->alsopickup; ?>"
			data-extrainfo="<?= $event->extrainfo ?>"
			data-colour="<?= $event->colour ?>"
			data-contact_url="<?= $event->contact_url ?>"
	    ></div>
    <?php endforeach; ?>

		<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?= GOOGLE_MAPS_API_KEY ?>&callback=initMap" type="text/javascript"></script>


	</div>

</body>

</html>
