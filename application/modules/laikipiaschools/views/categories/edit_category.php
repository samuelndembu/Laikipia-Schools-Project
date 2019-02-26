
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
    <label for="category_parent">Parent</label>
    <select id="inputState" class="form-control" name="category_parent">
    
    </select>
    </div>
    <div class="form-group">
    <label for="category_name">Name</label>
    <input type="category_name" class="form-control" name="name" id="name" naria-describedby="emailHelp" placeholder="Enter Name" value=" <?php echo $category_name; ?>">
    </div>
    
    <button type="submit" class="btn btn-primary">Update</button>

    <?php echo form_close() ?>
    </div>



