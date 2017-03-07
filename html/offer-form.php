
  <?php require_once 'config.php'; ?>

    <select name="destination" class="form-control">
      <option value="<?= DESTINATION1_NAME ?>">Going to <?= DESTINATION1_NAME ?></option>
      <option value="<?= DESTINATION2_NAME ?>">Going to <?= DESTINATION2_NAME ?></option>
    </select>
    <input type="text" name="name" placeholder="Name" class="form-control" />
    <div class="row">
      <div class="col-sm-6">
        <input type="text" name="towncity" placeholder="Town/City" class="form-control" />
      </div>
      <div class="col-sm-6">
        <input type="text" name="postcode" placeholder="Postcode" class="form-control" />
      </div>
    </div>
    <input type="text" name="email" placeholder="Email address" class="form-control" />

    <div class="row">
      <div class="col-sm-6">
        <input type="text" name="mobile" placeholder="Mobile number" class="form-control" />
      </div>
      <div class="col-sm-6">
        <select name="spaces" class="form-control">
          <option value="">Number of spaces</option>
          <?php
            for ($i=1; $i < 10; $i++) {
              echo "<option value=\"$i\">$i</option>";
            }
          ?>
        </select>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-6">
        <input type="text" name="dateleaving" placeholder="Date leaving" class="form-control" id="datepicker" />
      </div>
      <div class="col-sm-6">
        <input type="text" name="timeleaving" placeholder="Time leaving" class="form-control" />
      </div>
    </div>

    <div class="row">
      <div class="col-sm-6">
        <input type="text" name="datereturning" placeholder="Date returning" class="form-control" id="datepicker2" />
      </div>
      <div class="col-sm-6">
        <input type="text" name="timereturning" placeholder="Time returning" class="form-control" />
      </div>
    </div>

    <input type="text" name="alsopickup" placeholder="Also willing to pick up from" class="form-control" />
    <input type="text" name="extrainfo" placeholder="Extra info about your car/journey" class="form-control" />

    <br /><input type="submit" value="Add your ride" class="btn btn-primary" /><br />
