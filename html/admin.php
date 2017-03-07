<?php

  require_once 'header.php';
  require_once 'connect.php';
  require_once 'config.php';

  if (!$_POST) {
    echo '<form method="post" action="/admin"><div class="container"><div class="row"><div class="col-md-6 col-md-offset-3" style="margin-top: 5em;"><input type="password" name="pw" placeholder="Password" class="form-control" /><br /><input type="submit" value="Log in" class="btn btn-default pull-right"></div></div></div></form>';
  }

  if (!isset($_POST['pw'])) exit();
  if ($_POST['pw'] != ADMIN_PANEL_PASSWORD) exit('wrong password');

  if (isset($_POST['id'])) {
    // update the record
    $stmt = DB::conn()->prepare("UPDATE rides SET moderation = ? WHERE id = ?");
    if ($_POST['submit'] == 'Approve') $moderation = 'approved';
    if ($_POST['submit'] == 'Booked') $moderation = 'booked';
    $stmt->bind_param('si', $moderation, $_POST['id']);
  	$stmt->execute();
    $stmt->close();
  }

  require_once 'functions.php';
	$stmt = DB::conn()->prepare("SELECT * FROM rides ORDER BY id DESC");
	$stmt->execute();
	$result = $stmt->get_result();
	while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
      array_walk ( $row, 'html_safe' );
			$events[] = (object) $row;
	}

?>

  <style> body { background-color: initial; } </style>
  
  <div class="container-fluid white-bg">

    <div class="row">

      <div class="col-md-6">
        <h2>Check and approve</h2>
      </div>

      <div class="col-md-6">
        <form method="post" action="/admin">
          <input type="hidden" name="pw" value="<?php echo ADMIN_PANEL_PASSWORD; ?>" />
          <br /><input type="submit" value="Refresh" class="btn btn-default pull-right" />
        </form>
      </div>

    </div>

    <div class="row">

      <div class="col-md-12">

        <table class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Destination</th>
              <th>Name</th>
              <th>Leaving from</th>
              <th>Postcode</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Spaces</th>
              <th>Leaving</th>
              <th>Returning</th>
              <th>Also pickup</th>
              <th>Extra info</th>
              <th></th>
            </tr>
          </thead>
          <tbody>

          <?php foreach($events as $event): ?>
            <form method="post" action="/admin">
              <input type="hidden" name="pw" value="<?php echo ADMIN_PANEL_PASSWORD; ?>" />
              <input type="hidden" name="id" value="<?= $event->id ?>" />
              <tr<?php if ($event->moderation == 'pending') { echo ' class="warning"'; } ?>>
                <td><?= $event->id ?></td>
                <td><?= $event->destination ?></td>
                <td><?= $event->name ?></td>
                <td><?= $event->towncity ?></td>
                <td><?= $event->postcode ?></td>
                <td><?= $event->email ?></td>
                <td><?= $event->mobile ?></td>
                <td><?= $event->spaces ?></td>
                <td><?= $event->dateleaving ?> <?= $event->timeleaving ?></td>
                <td><?= $event->datereturning ?> <?= $event->timereturning ?></td>
                <td><?= $event->alsopickup ?></td>
                <td><?= $event->extrainfo ?></td>
                <td>
                  <?= ucwords($event->moderation) ?><br />
                  <?php if ($event->moderation == 'pending') { ?><input type="submit" class="btn btn-primary" name="submit" value="Approve" /><?php } ?><br />
                  <?php if ($event->moderation == 'approved') { ?><input type="submit" class="btn btn-primary" name="submit" value="Booked" /><?php } ?>
                </td>
              </tr>
            </form>
          <?php endforeach; ?>

          </tbody>
        </table>


      </div>

    </div>

  </div>


  </body>
</html>
