
      <!-- <div class="container"> -->
      <div class = "container">
          <?php
        
          $validation_errors = validation_errors();
          if(!empty($validation_errors)){
              echo $validation_errors;
          }
          ?>
          </div>
          <!-- dynamically generating a form in brackets where to submit data to-->
          <div class="container">

          <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Launch demo modal
  </button>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <?php echo form_open_multipart($this->uri->uri_string());?>
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
              <!-- <input type="file" name="userfile" size="20" /> -->

<br /><br />
            </div>
            
          
        </div>
        <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
        </div>
  <?php echo form_close() ?>
        
      </div>
    </div>
  </div>
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
 



