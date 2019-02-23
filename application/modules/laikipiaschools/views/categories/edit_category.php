
    <!-- <div class="container"> -->
    <div class = "container">
    <?php

$validation_errors = validation_errors();
if (!empty($validation_errors)) {
    echo $validation_errors;
}
?>
    <!-- dynamically generating a form in brackets where to submit data to-->
    <div class="container">
    <?php echo form_open($this->uri->uri_string()); ?>
    <div class="form-group">
    <label for="parent">Parent</label>
    <select id="inputState" class="form-control" name="parent">
    
    </select>
    </div>
    <div class="form-group">
    <label for="name">Name</label>
    <input type="name" class="form-control" name="name" id="name" naria-describedby="emailHelp" placeholder="Enter Name" value=" <?php echo $name; ?>">
    </div>
    
    <button type="submit" class="btn btn-primary">Update</button>

    <?php echo form_close() ?>
    </div>



