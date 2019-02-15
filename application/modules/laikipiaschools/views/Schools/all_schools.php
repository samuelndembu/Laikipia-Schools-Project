<div class="card shadow mb-4">
	<div class="card-header py-3">
		<button type="button" class="btn btn-success" data-toggle="modal" data-target="#createDonation">Add School</button>

		<div class="modal fade" id="createDonation" tabindex="-1" role="dialog" aria-labelledby="createDonationLabel"
		 aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="createDonationLabel">Enter New School</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<?php echo form_open($this->uri->uri_string()); ?>

						<div class="form-group row">
							<div class="col-sm-12 col-md-12">
								<input type="text" class="form-control" id="school_name" name="school_name" placeholder="School Name" required>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-12 col-md-12">
								<input type="text" class="form-control" id="school_write_up" name="school_write_up" placeholder="School Write up" required>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-12 col-md-12">
								<input type="number" class="form-control" id="school_boys_number" name="school_boys_number" placeholder="School Write up" required>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-12 col-md-12">
								<input type="number" class="form-control" id="school_girls_number" name="school_girls_number" placeholder="Number Of Girls" required>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-12 col-md-12">
								<input type="text" class="form-control" id="school_location_name" name="school_location_name" placeholder="Locaion Name" required>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-12 col-md-12">
								<input type="text" class="form-control" id="school_latitude" name="school_latitude" placeholder="Latitude" required>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-12 col-md-12">
								<input type="text" class="form-control" id="school_longitude" name="school_longitude" placeholder="Longitude" required>
							</div>
						</div>
						 <fieldset class="form-group">
								<div class="row">
								<legend class="col-form-label col-sm-2 pt-0">Status</legend>
								<br>
								<div class="col-sm-10">
									<div class="form-check">
									<input class="form-check-input" type="radio" name="school_status" id="school_status" value="1" checked>
									<label class="form-check-label" for="gridRadios1">
										Active
									</label>
									</div>
									<div class="form-check">
									<input class="form-check-input" type="radio" name="school_status" id="school_status" value="0">
									<label class="form-check-label" for="gridRadios2">
										Inactive
									</label>
									</div>
								</div>
								</div>
							</fieldset>
							<input class="form-check-input" type="hidden" name="school_status" id="school_status" value="0">
							</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">Save</button>
						</div>
						<?php form_close();?>
					</div>
				</div>
				</div>
			</div>
		</div>

	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-darkborderless" id="dataTable" width="100%" cellspacing="0">
				<thead class="thead-dark">
					<tr>
						<th>#</th>
						<th>School Name</th>
						<th>School Writeup</th>
						<th>Number of Boys</th>
						<th>Number of Girls</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tfoot class="thead-light">
					<tr>
						<th>#</th>
						<th>School Name</th>
						<th>School Writeup</th>
						<th>Number of Boys</th>
						<th>Number of Girls</th>
						<th>Actions</th>

					</tr>
				</tfoot>
				<tbody>

				<?php

if ($all_schools->num_rows() > 0) {
    $count = 0;

    foreach ($all_schools->result() as $row) {
        $id = $row->school_id;

        $count++;
        ?>
				<tr>
						<td>
							<?php echo $count ?>
						</td>
						<td>
							<?php echo $row->school_name; ?>
						</td>
						<td><?php echo $row->school_write_up; ?></td>
						<td><?php echo $row->school_boys_number; ?></td>
						<td><?php echo $row->school_girls_number; ?></td>
						<td>
						<!-- <td class="col-2"> <?php echo anchor("laikipiaschools/schools/singleschool/" . $id, "View", ['class' => 'btn btn-info']); ?></td> -->
						<?php echo anchor("laikipiaschools/update-school/" . $id, "Edit", ['class' => 'btn btn-warning']); ?>
						<?php echo anchor("laikipiaschools/delete-school/" . $id, "Delete", ['class' => 'btn btn-danger']); ?>
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
			<?php echo $links; ?>
		</p>
	</div>

