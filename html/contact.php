<?php

  require '../vendor/autoload.php';
  use Mailgun\Mailgun;

  require_once 'functions.php';
  require_once 'config.php';

  require_once 'connect.php';
  $stmt = DB::conn()->prepare("SELECT * FROM rides WHERE contact_url = ? LIMIT 1");
  $stmt->bind_param('s', $req[2]);
  $stmt->execute();
  $result = $stmt->get_result();
  while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
      $event = (object) $row; // only save 1
  }

  if ($_POST) {

    // send email
    // from us, reply-to points to user

    # First, instantiate the SDK with your API credentials and define your domain.
    $mg = new Mailgun(MAILGUN_API_KEY);
    $domain = MAILGUN_DOMAIN;

    $message = "Someone is interested in your carpool to $event->destination!

Name: {$_POST['name']}
Email: {$_POST['email']}
Phone number: {$_POST['phone']}
Number of spaces requested: {$_POST['spaces']}
Message: {$_POST['message']}

Drop them an email to set up your car share!

If your car is full, email " . CONTACT_EMAIL . " and we'll remove it from the map.

Thanks for offering to help Labour win in $event->destination. Let's show what our people-powered movement can do!";

    try {
      // plain text email, no html
      $mg->sendMessage($domain,
        array('from'  => SITE_TITLE . ' <' . FROM_EMAIL . '>',
        'to'          => $event->email,
        'h:Reply-To'  => $_POST['email'],
        'subject'     => 'Someone is interested in your carpool',
        'text'        => $message)
      );
      $messagesent = true;
    } catch (Exception $e) {
      $messagesent = 'error';
    }


  }




  require_once 'header.php';

  if (!isset($event)) exit('Error');


?>

  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <br /><a href="/"><img src="/carpool.png" /></a>
      </div>
      <div class="col-md-8 white-bg">

        <?php if (isset($messagesent)): ?>
          <?php if ($messagesent === 'error'): ?>
            <br /><div class="alert alert-danger">Sorry, there was a problem sending your message. Please email <?php echo CONTACT_EMAIL; ?></div>
          <?php else: ?>
            <br /><div class="alert alert-success">Your details have been sent to the driver, they should be in touch soon to set up your lift!</div>
          <?php endif; ?>
        <?php endif; ?>

        <h2>Going from <?= $event->towncity ?> to <?= $event->destination ?></h2>
        <h4>Leaving <?= $event->dateleaving ?> <?= $event->timeleaving ?>, <?= $event->spaces ?> spaces. Returning <?= $event->datereturning ?> <?= $event->timereturning ?></h4>
        <p><?php if ($event->alsopickup) echo 'Can also pick up from ' . $event->alsopickup; ?></p>
        <p><?= $event->extrainfo ?></p>

        <form method="post" action="/contact/<?= html_safe($req[2]) ?>">

          <h3>Get in touch to set up the ride:</h3><br />

          <div class="row">
            <div class="col-md-6">
              <input type="text" name="name" placeholder="Your name" class="form-control "/>
            </div>
            <div class="col-md-6">
              <input type="text" name="email" placeholder="Your email" class="form-control "/>
            </div>
          </div><br />

          <div class="row">
            <div class="col-md-6">
              <input type="text" name="phone" placeholder="Your phone number" class="form-control "/>
            </div>
            <div class="col-md-6">
              <input type="text" name="spaces" placeholder="Number of spaces requested" class="form-control "/>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <br />
              <textarea name="message" style="height: 8em;" placeholder="A message to the person making the offer (optional)" class="form-control"></textarea>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <br /><input type="submit" value="Send" class="btn btn-primary btn-lg" />
            </div>
          </div>

        </form>

      </div>
    </div>
  </div>
