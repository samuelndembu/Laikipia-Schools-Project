<div class="card shadow mb-4">
	<div class="card-header py-3">
        <h3 class="form-group row mt-5">Edit Donation</h3>
	</div>
	<?php echo form_open($this->uri->uri_string()); ?>
	<div class="card-body">
    <div class="form-group row mt-5">
	<?php if ($query->num_rows() > 0) {
    $donation = $query->row();?>
	<label for="donation_amount" class="col-sm-2 col-form-label">Donation Amount</label>
	<div class="col-sm-10">
		<input type="text" class="form-control" name="donation_amount" id="donation_amount" value="<?php echo $donation->donation_amount; ?>">
	</div>
</div>

    <div class="form-group row">
	<label for="donation_amount" class="col-sm-2 col-form-label">Partner</label>
	<div class="col-sm-10">
		<select class="custom-select my-1 mr-sm-2" name="partner_id">
			<option selected>Choose Parner...</option>
			<?php
if ($partners->num_rows() > 0) {
        foreach ($partners->result() as $row) {?>
			<option value="<?php echo $row->partner_id; ?>" <?php echo $row->partner_id == $donation->partner_id ? "selected" : ""; ?>>
				<?php echo $row->partner_name; ?>
			</option>
			<?php
}
    }
    ?>
		</select>
	</div>
</div>

<div class="form-group row">
	<label for="donation_amount" class="col-sm-2 col-form-label">School</label>
	<div class="col-sm-10">
		<select class="custom-select my-1 mr-sm-2" name="school_id">
			<option selected>Choose School...</option>
			<?php
if ($schools->num_rows() > 0) {
        foreach ($schools->result() as $row) {?>
			<option value="<?php echo $row->school_id; ?>" <?php echo $row->school_id == $donation->school_id ? "selected" : ""; ?>>
				<?php echo $row->school_name; ?>
			</option>
			<?php
}
    }
    ?>
		</select>
	</div>
</div>
<div class="col-auto">
	<button type="submit" class="btn btn-primary mb-2">Update</button>
</div>
<?php form_close();?>

	</div>
</div>
<?php
}?>