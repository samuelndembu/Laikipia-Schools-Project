
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
    <?php echo form_open($this->uri->uri_string());?>
          <div class="form-group">
            <label for="partner_type">Partner Type</label>
            <!-- <input type="name" class="form-control" name="partner_type" id="partner_type" naria-describedby="emailHelp" placeholder="Select Partner Name"> -->
            <select id="inputState" class="form-control" name="partner_type">
              <?php if($partner_types->num_rows() > 0)
              {
                foreach($partner_types->result() as $row)
                
                {?>
                  <option value="<?php echo $row->partner_type_id ?>" <?php echo $partner_type_id == $row->partner_type_id ? "selected" : "";?>><?php echo $row->partner_type_name; ?></option>
                  <?php
                }
              } ?>
          </select>
          </div>
          <div class="form-group">
            <label for="partner_name">Partner Name</label>
            <input type="name" class="form-control" name="partner_name" id="partner_name" naria-describedby="emailHelp" placeholder="Enter Partner Name" value=" <?php echo $partner_name;?>">
          </div>
          <div class="form-group">
            <label for="partner_email">Email address</label>
            <input type="email" class="form-control" id="partner_email" aria-describedby="emailHelp" placeholder="Enter email" name="partner_email" value=" <?php echo $partner_email; ?>">
          </div>
          
          <button type="submit" class="btn btn-primary">Update</button>

   <?php echo form_close() ?>
    </div>



