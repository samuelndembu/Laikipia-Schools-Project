<?php

$validation_errors = validation_errors();
if (!empty($validation_errors)) {
    echo $validation_errors;
}
?>
<div class="shadow-lg p-3 mb-5 bg-white rounded">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <!-- <button type="button" class="btn btn-success">Add Partner</button> -->
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                Add Partner
            </button>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Partner</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo form_open_multipart(base_url() . 'administration/partners/add-partners') ?>
                    <div class="form-group">
                        <label for="partner_type">Partner Type</label>
                        <!-- <input type="name" class="form-control" name="partner_type" id="partner_type" naria-describedby="emailHelp" placeholder="Select Partner Name"> -->
                        <select id="inputState" class="form-control" name="partner_type">
                            <option selected>Choose...</option>

                            <?php if ($partner_types->num_rows() > 0) {
    foreach ($partner_types->result() as $row) {?>
                            <option value="<?php echo $row->partner_type_id ?>">
                                <?php echo $row->partner_type_name ?></option>
                            <?php
}
}?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="partner_name">Partner Name</label>
                        <input type="name" class="form-control" name="partner_name" id="partner_name"
                            naria-describedby="emailHelp" placeholder="Enter Partner Name">
                    </div>
                    <div class="form-group">
                        <label for="partner_email">Email address</label>
                        <input type="email" class="form-control" id="partner_email" aria-describedby="emailHelp"
                            placeholder="Enter email" name="partner_email">
                    </div>
                    <div class="form-group">
                        <label for="partner_description">Partner Description</label>
                        <input type="text-area" class="form-control" id="partner_description"
                            aria-describedby="emailHelp" placeholder="Enter sho description" name="partner_description">
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
    <?php echo form_close() ?>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Partner Type</th>
                        <!-- <th>Partner Name</th> -->
                        <!-- <th><?php echo anchor("administration/partners/partner.partner_name/" . $order_method, "Partner Name"); ?></th> -->
                        <th><?php echo anchor("administration/partners/" . $order . "/" . $order_method, "Partner Name"); ?></th>
                        <th>Partner Email</th>
                        <th>Partner Logo</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Partner Type</th>
                        <th>Partner Name</th>
                        <th>Partner Email</th>
                        <th>Partner Logo</th>
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
                            <?php echo $row->partner_type_name; ?>
                        </td>
                        <td>
                            <?php echo $row->partner_name; ?>
                        </td>
                        <td>
                            <?php echo $row->partner_email; ?>
                        </td>
                        <td>
                            <img src="<?php echo base_url() . 'assets/uploads/' . $row->partner_thumb; ?>">
                        </td>
                        <td>

                            <?php if ($row->partner_status == 1) {?>
                            <a href="" class="btn btn-dark btn-sm" data-toggle="modal"
                                data-target="#modalLoginAvatar<?php echo $row->partner_id; ?>"><i
                                    class="fas fa-eye"></i></a>
                            <?php }?>

                            <!--Modal: Login with Avatar Form-->
                            <div class="modal fade" id="modalLoginAvatar<?php echo $row->partner_id; ?>" tabindex="-1"
                                role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog cascading-modal modal-avatar modal-md" role="document">
                                    <!--Content-->
                                    <div class="modal-content" style="margin-left:0px;">

                                        <!--Header-->
                                        <div class="modal-header">
                                            <img src="<?php echo base_url() . 'assets/uploads/' . $row->partner_thumb; ?>"
                                                alt="avatar" class="rounded-circle img-responsive"
                                                style="margin-left:40%;margin-right:50%">
                                        </div>
                                        <!--Body-->
                                        <div class="modal-body">

                                            <h5 class=" pb-3"><b>Retrieved:</b> <br /> <?php echo $row->partner_name; ?>
                                            </h5>

                                            <div class=" ml-1 pb-3" style="font-size:20px;list-style-type:none;">
                                                <li><b>Partner Type:</b> <br /> <?php echo $row->partner_type_name; ?>
                                                </li>
                                            </div>
                                            <div class=" ml-1 pb-3" style="font-size:20px;list-style-type:none;">
                                                <li><b>Partner Name: </b> <br /><?php echo $row->partner_name; ?></li>
                                            </div>
                                            <div class="ml-1 pb-3" style="font-size:20px;list-style-type:none;">
                                                <li><b>Partner Email: </b> <br /><?php echo $row->partner_email; ?></li>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary"
                                                    data-dismiss="modal">Close</button>

                                            </div>
                                        </div>

                                    </div>
                                    <!--/.Content-->
                                </div>
                            </div>
                            <!--Modal: Login with Avatar Form-->

                            <?php echo anchor("administration/edit_partner/" . $row->partner_id, "<i class='fas fa-edit'></i>", "class='btn btn-warning btn-sm p-left-10'", "style='padding-left:10px;'"); ?>
                            <?php if ($row->partner_status == 1) {
            echo anchor("administration/deactivate-partner/" . $row->partner_id . "/" . $row->partner_status, "<i class='far fa-thumbs-down'></i>", array("class" => "btn btn-info btn-sm p-left-10", "onclick" => "return confirm('Are you sure you want to deactivate?')"));
        } else {
            echo anchor("administration/deactivate-partner/" . $row->partner_id . "/" . $row->partner_status, "<i class='far fa-thumbs-up'></i>", array("class" => "btn btn-info btn-sm", "onclick" => "return confirm('Are you sure you want to activate?')"));
        }?>
                            <?php
echo anchor("administration/delete-partner/" . $row->partner_id, "<i class='fas fa-trash-alt'></i>", array("class" => "btn btn-danger btn-sm", "onclick" => "return confirm('Are you sure you want to Delete?')")); ?>


                        </td>
                    </tr>
                    <?php
}
}
?>
                </tbody>
            </table>
        </div>
    </div>
    <p>
        <?php echo $links; ?>
    </p>
</div>
</div>