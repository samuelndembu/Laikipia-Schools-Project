<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <script src="<?php echo base_url() ?>assets/vendor/jquery/jquery-3.3.1.slim.min.js"></script> -->
    <link href="<?php echo base_url() ?>assets/themes/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>assets/themes/bootstrap/js/bootstrap.min.js" rel="stylesheet" />
    <link href="<?php echo base_url() ?>assets/themes/custom/partner.css" rel="stylesheet"/>
</head>
<body>
    <!-- <div class="container"> -->
    <div class = "container">
        <?php
       
        $validation_errors = validation_errors();
        if(!empty($validation_errors)){
            echo $validation_errors;
        }
        ?>
        <!-- dynamically generating a form in brackets where to submit data to-->
        <div class="container">
    <?php echo form_open ($this->uri->uri_string());?>
          <div class="form-group">
            <label for="partner_type">Partner Type</label>
            <!-- <input type="name" class="form-control" name="partner_type" id="partner_type" naria-describedby="emailHelp" placeholder="Select Partner Name"> -->
            <select id="inputState" class="form-control" name="partner_type">
              <option selected>Choose...</option>
              
              <?php if($partner_types->num_rows() > 0)
              {
                foreach($partner_types->result() as $row)
                
                {?>
                  <option value="<?php echo $row->partner_type_id ?>"><?php echo $row->partner_type_name ?></option>
                  <?php
                }
              } ?>
          </select>
          </div>
          <div class="form-group">
            <label for="partner_name">Partner Name</label>
            <input type="name" class="form-control" name="partner_name" id="partner_name" naria-describedby="emailHelp" placeholder="Enter Partner Name">
          </div>
          <div class="form-group">
            <label for="partner_email">Email address</label>
            <input type="email" class="form-control" id="partner_email" aria-describedby="emailHelp" placeholder="Enter email" name="partner_email">
          </div>
          <div class="form-group">
            <label for="partner_logo">Upload Partner Logo</label>
            <input type="file" class="form-control-file" id="partner_logo" name="partner_logo">
          </div>
          
          <button type="submit" class="btn btn-primary">Submit</button>

   <?php echo form_close() ?>
    </div>
</body>
</html>



