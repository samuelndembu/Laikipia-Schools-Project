<?php
if ($query->num_rows() > 0) {
    $count = 0;
    foreach ($query->result() as $row) {
        $id = $row->school_id;
        $count++;
        $image = $row->school_image_name;
        // $image = 'school_default.jpeg';
        ?>
				<tr>
					<td>
						<?php echo $count ?>
					</td>
					<td>
						<img src="<?php echo base_url() . 'assets/uploads/' . $row->school_thumb_name; ?>" width="70px" height="70px">
					</td>
					<td>
						<?php echo $row->school_name; ?>
					</td>

					<td>
						<?php echo $row->school_boys_number; ?>
					</td>
					<td>
						<?php echo $row->school_girls_number; ?>
					</td>

					<td>
						<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalQuickView<?php echo $row->school_id; ?>"><i
							 class="fas fa-eye"></i></button>
						<!-- Modal: modalQuickView -->
						<div class="modal fade" id="modalQuickView<?php echo $row->school_id; ?>" tabindex="-1" role="dialog"
						 aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title">
											<?php echo $row->school_name; ?>
										</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<div class="container">
											<div class="row">
												<div class="col-md-5 col-sm-12">
													<img style="max-width:100%;" src="<?php echo base_url() . 'assets/uploads/' . $image;?>" class="d-block w-100"
													 alt="No Image" />
												</div>
												<div class="col-md-7 col-sm-12 " style="border:0px solid gray">
													<div class="form-group">
														<h6 class="title-price"><small>School</small></h6>
														<label><b>
																<?php echo $row->school_name; ?></b></label>

														<h6 class="title-price"><small>Zone</small></h6>
														<label><b>
																<?php echo $row->school_zone; ?></b></label>

														<h6 class="title-price"><small>Number Of Boys</small></h6>
														<label><b>
																<?php echo $row->school_boys_number; ?></b></label>

														<h6 class="title-price"><small>Number Of Girls</small></h6>
														<label><b>
																<?php echo $row->school_girls_number; ?></b></label>
													</div>

												</div>
											</div>

											<div class="col-md-12 col-sm-12">
												<h6 class="title-price mt-4"><small>Write Up</small></h6>
												<div style="width:100%;border-top:1px solid silver">
													<p class="mt-3">
														<small>
															<?php echo $row->school_write_up; ?>
														</small>
													</p>
												</div>
											</div>

										</div>
									</div>
									<?php echo '<script type="text/javascript">
										function initialize() {
											var position = new google.maps.LatLng('.$row->school_latitude.','.$row->school_longitude.');
											var myOptions = {
											zoom: 15,
											center: position,
											mapTypeId: google.maps.MapTypeId.ROADMAP
											};
											var map = new google.maps.Map(
												document.getElementById("map_canvas'.$row->school_id.'"),
												myOptions);
										
											var marker = new google.maps.Marker({
												position: position,
												map: map,
												title:"This is the place."
                                            });  
                                            var infowincontent = document.createElement("div");
                                            var strong = document.createElement("strong");
                                            strong.textContent = "'.$row->school_name.'"
                                            infowincontent.appendChild(strong);
                                            infowincontent.appendChild(document.createElement("br"));
                              
                                            var text = document.createElement("text");
                                            text.textContent = "'.$row->school_location_name.'"
                                            infowincontent.appendChild(text);
                                            
											var infowindow = new google.maps.InfoWindow({
												content: infowincontent
                                            });
                                            infowindow.open(map,marker);
										
										}
										google.maps.event.addDomListener(window, "load", initialize);
										</script>';?>
									<div id="map_canvas<?php echo $row->school_id;?>" style="width:100%; height:500px"></div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									</div>
								</div>
							</div>
						</div>

	</div>
	<button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal<?php echo $row->school_id; ?>"><i
		 class="fas fa-edit"></i></button>
	<!-- Modal -->
	<div class="modal fade" id="editModal<?php echo $row->school_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	 aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">
						Update School
						Details</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="card-body">
					<h5 class="card-title">Enter school Details to
						update</h5>

					<?php echo form_open(base_url() . 'administration/edit-school/' . $row->school_id); ?>
					<div class="form-group row">
						<label for="school_name" class="col-sm-2 col-form-label">School
							Name</label>

						<div class="col-md-10">
							<?php echo form_input(['name' => 'school_name', 'placeholder' => 'School Name', 'class' => 'form-control', 'value' => set_value('school_name', $row->school_name)]) ?>
						</div>
					</div>
					<div class="form-group row">
						<label for="school_zone" class="col-sm-2 col-form-label">School
							Zone</label>

						<div class="col-md-10">
							<?php echo form_input(['name' => 'school_zone', 'placeholder' => 'School    Zone', 'class' => 'form-control', 'value' => set_value('school_zone', $row->school_zone)]) ?>
						</div>
					</div>

					<div class="form-group row">
						<label for="school_boys_number" class="col-sm-2 col-form-label">Number
							of
							Boys</label>
						<div class="col-md-10">
							<?php echo form_input(['name' => 'school_boys_number', 'placeholder' => 'Number of boys, eg. 10', 'class' => 'form-control', 'value' => set_value('school_boys_number', $row->school_boys_number)]) ?>
						</div>
					</div>
					<div class="form-group row">
						<label for="school_girls_number" class="col-sm-2 col-form-label">Number
							of
							Girls</label>
						<div class="col-md-10">
							<?php echo form_input(['name' => 'school_girls_number', 'placeholder' => 'Enter First Name', 'class' => 'form-control', 'value' => set_value('firstname', $row->school_girls_number)]) ?>
						</div>
					</div>
					<div class="form-group row">
						<label for="school_latitude" class="col-sm-2 col-form-label">Latitude</label>
						<div class="col-md-10">
							<?php echo form_input(['name' => 'school_latitude', 'placeholder' => 'Enter Latitude', 'class' => 'form-control', 'value' => set_value('school_latitude', $row->school_latitude)]) ?>
						</div>
					</div>
					<div class="form-group row">
						<label for="school_longitude" class="col-sm-2 col-form-label">Longitude</label>
						<div class="col-md-10">
							<?php echo form_input(['name' => 'school_longitude', 'placeholder' => 'Longitude', 'class' => 'form-control', 'value' => set_value('school_longitude', $row->school_longitude)]) ?>
						</div>
					</div>
					<div class="form-group row">
						<label for="school_location_name" class="col-sm-2 col-form-label">Location
							Name</label>
						<div class="col-md-10">
							<?php echo form_input(['name' => 'school_location_name', 'placeholder' => 'Location Name', 'class' => 'form-control', 'value' => set_value('school_location_name', $row->school_location_name)]) ?>
						</div>
					</div>

					<div class="row">
						<legend class="col-form-label col-sm-2 pt-0">
							School Status
						</legend>
						<div class="form-group">
							<input type="radio" name="status" value="1" <?php echo ($row->school_status == 'Active') ? 'checked' : ''
							?>>Active
							<input type="radio" name="status" value="0" <?php echo ($row->school_status == 'Inactive') ? 'checked' : '' ?>
							">Inactive
						</div>
					</div>

					<div class="form-group">
						<label for="school_write_up">School Write Up</label>
						<?php echo form_textarea(array('name' => 'school_write_up', 'id' => 'ckeditor', 'class' => "ckeditor", 'value' => set_value('school_write_up', $row->school_write_up))); ?>
						<small id="emailHelp" class="form-text text-muted"></small>
					</div>
					<div class="form-group row">
						<div class="col-sm-10">
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i>Close</button>
								<button type="submit" class="btn btn-primary"><i class="fas fa-check"></i>Save
									School</button>
							</div>
						</div>
					</div>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>
<?php if ($row->school_status == 1) {
            echo anchor("administration/deactivate-school/" . $row->school_id . "/" . $row->school_status, "<i class='far fa-thumbs-down'></i>", array("class" => "btn btn-default btn-sm", "onclick" => "return confirm('Are you sure you want to deactivate?')"));
        } else {
            echo anchor("administration/deactivate-school/" . $row->school_id . "/" . $row->school_status, "<i class='far fa-thumbs-up'></i>", array("class" => "btn btn-info btn-sm", "onclick" => "return confirm('Are you sure you want to activate?')"));
        }?>

<?php echo anchor("administration/delete-school/" . $row->school_id, '<i class="fas fa-trash-alt"></i>', array("class" => "btn btn-danger btn-sm", "onclick" => "return confirm('Are you sure you want to Delete?')")); ?>


</td>
</tr>
<?php
}
}
?>