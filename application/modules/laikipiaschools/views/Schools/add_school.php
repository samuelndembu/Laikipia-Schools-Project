
<?php echo
form_open($this->uri->uri_string()); ?>
  <div class="form-group row">
    <label for="school_name" class="col-sm-2 col-form-label">School Name</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="school_name" placeholder="SCHOOL NAME">
    </div>
  </div>
  
    <div class="form-group row">
    <label for="school_boys_number" class="col-sm-2 col-form-label">Number of Boys</label>
    <div class="col-sm-10">
      <input type="numeric" class="form-control" id="school_boys_number" placeholder="Number of boys, eg. 10">
    </div>

  <div class="form-group row">
    <label for="school_girls_number" class="col-sm-2 col-form-label">Number of Girls</label>
    <div class="col-sm-10">
      <input type="numeric" class="form-control" id="school_girls_number" placeholder="Number of Girls, eg. 10">
    </div>
    <div class="form-group row">
    <label for="school_latitude" class="col-sm-2 col-form-label">Latitude</label>
    <div class="col-sm-10">
      <input type="Latitude" class="form-control" id="school_latitude" placeholder="Number of boys, eg. 0.10">
    </div>
     <div class="form-group row">
    <label for="school_longitude" class="col-sm-2 col-form-label">Longitude</label>
    <div class="col-sm-10">
      <input type="numeric" class="form-control" id="school_Longitude" placeholder="Longitude">
    </div>
    <div class="form-group row">
    <label for="school_location_name" class="col-sm-2 col-form-label">Location Name</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="school_location_name" placeholder="Location Name">
    </div>
    <div class="form-group row">
    <label for="school_write_up" class="col-sm-2 col-form-label">School Write up</label>
    <div class="col-sm-10">
      <input type="text-area" class="form-control" id="school_write_up" placeholder="Write a brief description about the school">
    </div>

  <fieldset class="form-group">
    <div class="row">
      <legend class="col-form-label col-sm-2 pt-0">School Status</legend>
      <div class="col-sm-10">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="1" checked>
          <label class="form-check-label" for="gridRadios1">
            Active
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="0">
          <label class="form-check-label" for="gridRadios2">
            Inactive
          </label>
        </div>
      </div>
    </div>
  </fieldset>

  </div>
  <div class="form-group row">
    <div class="col-sm-10">
      <button type="submit" class="btn btn-primary">Save School</button>
    </div>
  </div>
<?php
form_close();
?>


