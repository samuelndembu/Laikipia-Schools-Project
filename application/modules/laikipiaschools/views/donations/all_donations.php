<div class="card shadow mb-4">
    <div class="card-header py-3">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createDonation">Add
            Donation</button>

        <div class="modal fade" id="createDonation" tabindex="-1" role="dialog" aria-labelledby="createDonationLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createDonationLabel">Add Donation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php echo form_open($this->uri->uri_string()); ?>

                        <div class="form-group row">

                            <div class="col-sm-12 col-md-12">
                                <input type="number" class="form-control" id="donation_amount" name="donation_amount"
                                    placeholder="Donation Amount" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 col-md-12">
                                <select class="custom-select my-1 mr-sm-2" name="partner_id" required>
                                    <option selected>Choose Parner...</option>
                                    <?php
if ($partners->num_rows() > 0) {
    foreach ($partners->result() as $row) {?>
                                    <option value="<?php echo $row->partner_id; ?>">
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
                            <div class="col-sm-12 col-md-12">
                                <select class="custom-select my-1 mr-sm-2" name="school_id" required>
                                    <option selected>Choose School...</option>
                                    <?php
if ($schools->num_rows() > 0) {
    foreach ($schools->result() as $row) {?>
                                    <option value="<?php echo $row->school_id; ?>">
                                        <?php echo $row->school_name; ?>
                                    </option>
                                    <?php
}
}
?>
                                </select>
                            </div>

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
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Partner</th>
                        <th>School</th>
                        <th>Amount</th>
                        <!-- <th>GroupType</th> -->
                        <th>Donation Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Partner</th>
                        <th>School</th>
                        <th>Amount</th>
                        <!-- <th>GroupType</th> -->
                        <th>Donation Date</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
if ($query->num_rows() > 0) {
    $count = 0;
    foreach ($query->result() as $row) {
        $count++;
        ?>
                    <tr>
                        <td>
                            <?php echo $count ?>
                        </td>
                        <td>
                            <?php echo $row->partner_name; ?>
                        </td>
                        <td>
                            <?php echo $row->school_name; ?>
                        </td>
                        <td>
                            <?php echo number_format($row->donation_amount); ?>
                        </td>
                        <td>
                            <?php echo date('jS M Y', strtotime($row->created_on)); ?>
                        </td>
                        <td>
                            <?php echo anchor("laikipiaschools/edit-donation/" . $row->donation_id, "Edit", "class='btn btn-warning'"); ?>
                            <?php echo anchor("laikipiaschools/delete-donation/" . $row->donation_id, "Delete", array("onclick" => "return confirm('Are sure you want to delete!!!')", "class" => "btn btn-danger")); ?>
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
</div>