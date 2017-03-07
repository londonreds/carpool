<?php
// this is here to display the offer form on its own page for mobile
require_once 'header.php';
?>

  <div class="container white-bg">
    <div class="row">
      <div class="col-md-12">
        <h2><img src="/car-red.png"> &nbsp;Offer a ride</h2><br />
        <form method="post" action="/add" id="add-form">
          <?php require_once 'offer-form.php'; ?>
        </form>
      </div>
    </div>
  </div>

</body>
</html>
