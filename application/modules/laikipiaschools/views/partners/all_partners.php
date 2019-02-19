

          <?php
        
          $validation_errors = validation_errors();
          if(!empty($validation_errors)){
              echo $validation_errors;
          }
          ?>


<div class="card shadow mb-4">
	<div class="card-header py-3">

    <!-- <button type="button" class="btn btn-success">Add Partner</button> -->
	
	<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
    Add Partner
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
	  <?php echo form_open(base_url() . 'administration/partners/add-partners')?>
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
            
          
        </div>
        <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
        
  <?php echo form_close() ?>
      </div>
      
    </div>
  </div>
</div>

	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>#</th>
						<th>PartnerType</th>
						<th>PartnerName</th> 
						<th>PartnerEmail</th>
                        <th>PartnerLogo</th>
                        <th>Actions</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
                    <th>#</th>
						<th>PartnerType</th>
						<th>PartnerName</th> 
						<th>PartnerEmail</th>
                        <th>PartnerLogo</th>
                        <th>Actions</th>
					</tr>
				</tfoot>
				<tbody>
					<?php 
                    if($query->num_rows() > 0)
                    {
                        $count = 0;
                        foreach($query->result() as $row)
                        {
							$count++;
                            ?>
					<tr>
						<td>
							<?php echo $count?>
						</td>
						<td>
							<?php echo $row->partner_type_name;?>
						</td>
						<td>
							<?php echo $row->partner_name;?>
                        </td>
                        <td>
							<?php echo $row->partner_email;?>
                        </td>
                        <td>
							<?php echo $row->partner_logo;?>
						</td>
						<td>
						 <?php echo anchor("administration/addpartner","View","class='btn btn-dark btn-sm'");?> 
						<?php echo anchor("administration/edit/". $row->partner_id,"Edit","class='btn btn-warning btn-sm'");?>
						<?php echo anchor("administration/deactivate-partner/". $row->partner_id,"Deactivate","class='btn btn-primary btn-sm'");?>
            <?php echo anchor("administration/delete-partner/". $row->partner_id,"Delete","class='btn btn-danger btn-sm'");?>

							
						</td>
					</tr>
					<?php
                        }
                    }
                    ?>
				</tbody>
			</table>
		</div>

		<p>
		
		</p>
	</div>
</div>


