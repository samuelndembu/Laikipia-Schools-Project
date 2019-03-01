<div class="container">
    <div class="card-header">
        <h1> Update School Details</h1>
    </div>
    <div class="card-body">
        <h5 class="card-title">Enter school Details to update</h5>

        <?php echo
form_open($this->uri->uri_string()); ?>
        <div class="form-group row">
            <label for="school_name" class="col-sm-2 col-form-label">School Name</label>

            <div class="col-md-10">
                <?php echo form_input(['name' => 'school_name', 'placeholder' => 'School Name', 'class' => 'form-control', 'value' => set_value('school_name', $school_name)]) ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="school_write_up" class="col-sm-2 col-form-label">School Write up</label>
            <div class="col-md-10">
                <?php echo form_textarea(['name' => 'school_write_up', 'placeholder' => 'Describe your school briefly', 'class' => 'form-control', 'value' => set_value('firstname', $school_write_up)]) ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="school_boys_number" class="col-sm-2 col-form-label">Number of Boys</label>
            <div class="col-md-10">
                <?php echo form_input(['name' => 'school_boys_number', 'placeholder' => 'Number of boys, eg. 10', 'class' => 'form-control', 'value' => set_value('school_boys_number', $school_boys_number)]) ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="school_girls_number" class="col-sm-2 col-form-label">Number of Girls</label>
            <div class="col-md-10">
                <?php echo form_input(['name' => 'school_girls_number', 'placeholder' => 'Enter First Name', 'class' => 'form-control', 'value' => set_value('firstname', $school_girls_number)]) ?>
            </div>

        </div>
        <div class="form-group row">
            <label for="school_latitude" class="col-sm-2 col-form-label">Latitude</label>
            <div class="col-md-10">
                <?php echo form_input(['name' => 'school_latitude', 'placeholder' => 'Enter Latitude', 'class' => 'form-control', 'value' => set_value('school_latitude', $school_latitude)]) ?>
            </div>
        </div>


        <div class="form-group row">
            <label for="school_longitude" class="col-sm-2 col-form-label">Longitude</label>
            <div class="col-md-10">
                <?php echo form_input(['name' => 'school_longitude', 'placeholder' => 'Longitude', 'class' => 'form-control', 'value' => set_value('school_longitude', $school_longitude)]) ?>
            </div>

        </div>

        <div class="form-group row">
            <label for="school_location_name" class="col-sm-2 col-form-label">Location Name</label>
            <div class="col-md-10">
                <?php echo form_input(['name' => 'school_location_name', 'placeholder' => 'Location Name', 'class' => 'form-control', 'value' => set_value('school_location_name', $school_location_name)]) ?>
            </div>
        </div>
        <div class="row">
            <legend class="col-form-label col-sm-2 pt-0">School Status</legend>
            <div class="form-group">
                <input type="radio" name="status" value="1" <?php echo ($school_status == 'Active') ? 'checked' : '' ?>
                    size="17">Active
                <input type="radio" name="status" value="0"
                    <?php echo ($school_status == 'Inactive') ? 'checked' : '' ?> size="17">Inactive
            </div>
        </div>
        <div class="row">
            <div class="col-sm-10">
                <div class="modal-footer">
                    <?php echo anchor('laikipiaschools/schools', 'Cancel', ['class' => 'btn btn-primary']); ?>
                    <button type="submit" class="btn btn-primary">Save School</button>
                </div>
            </div>
        </div>

    </div>
    <?php
form_close();
?>


</div>
</div>