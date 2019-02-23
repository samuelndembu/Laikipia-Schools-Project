<div class="container">
    <div class="shadow-lg p-3 mb-5 bg-white rounded"">



    <div class=" card-body">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                    data-target="#createDonation">Add Post</button>
                <div class="modal fade" id="createDonation" tabindex="-1" role="dialog"
                    aria-labelledby="createDonationLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createDonationLabel">Enter New Post</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <?php echo form_open_multipart($this->uri->uri_string()); ?>
                                <div class="form-group row">
                                    <div class="col-sm-12 col-md-12">
                                        <label for="post_image_name">Post Title</label>
                                        <input type="text" class="form-control" id="post_title" name="post_title"
                                            placeholder="Post Name" required>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <div class="col-sm-12 col-md-12">
                                        <label for="post_image_name">Category</label>
                                        <input type="text" class="form-control" id="post_category" name="post_category"
                                            placeholder="Category" required>
                                    </div>
                                </div>







                                <div class="form-group row">
                                    <div class="col-sm-12 col-md-12">
                                        <label for="post_image_name">Post
                                            Image</label>
                                        <input type="file" id="post_image_name" name="post_image_name">
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <div class="col-sm-12 col-md-12">
                                        <label for="post_image_name">Post Image</label>
                                        <input type="Numeric" class="form-control" id="post_views" name="post_views"
                                            placeholder="Views" required>
                                    </div>
                                </div>


                                <fieldset class="form-group row">
                                    <div class="col-sm-12 col-md-12">
                                        <label for="post_image_name">Status</label>
                                        <br>
                                        <div class="col-sm-10">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="post_status"
                                                    id="post_status" value="1" checked>
                                                <label class="form-check-label" for="gridRadios1">
                                                    Active
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="post_status"
                                                    id="post_status" value="0">
                                                <label class="form-check-label" for="gridRadios2">
                                                    Inactive
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <!-- <input class="form-check-input" type="hidden" name="post_status" id="post_status"
                                    value="0"> -->
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12 col-md-12">
                                    <label for="post_image_name">Post Description</label>
                                    <textarea class="form-control" id="message-text" placeholder="Post Description"
                                        name="post_descriptioon"></textarea>
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
    </div>



    <div class=" table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>#</th>
                    <th> Post Image</th>
                    <th>Post Title</th>
                    <th>Post Description</th>
                    <th>Post Views</th>
                    <th>Post Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Post Image</th>
                    <th>Post Title</th>
                    <th>Description</th>
                    <th>Views</th>
                    <th>Post Status</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
            <tbody>
                <?php
if ($query->num_rows() > 0) {
    $count = 0;

    foreach ($query->result() as $row) {
        $id = $row->post_id;

        $count++;
        ?>
                <tr>
                    <td>
                        <?php echo $count ?>
                    </td>
                    <td>
                        <img src="<?php echo base_url() . 'assets/uploads/' . $row->post_thumb_name; ?>">
                    </td>
                    <td>
                        <?php echo $row->post_title; ?>
                    </td>

                    <td><?php echo $row->post_description; ?></td>
                    <td><?php echo $row->post_views; ?></td>
                    <td><?php echo $row->post_status; ?></td>

                    <td>
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                            data-target="#modalQuickView<?php echo $row->post_id; ?>"><i
                                class="fas fa-eye"></i></button>
                        <!-- Modal: modalQuickView -->
                        <div class="modal fade" id="modalQuickView<?php echo $row->post_id; ?>" tabindex="-1"
                            role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <h2 class="h2-responsive product-name">
                                                    <div class="modal-header row">
                                                        <div class="img-responsive center-block row">
                                                            <img src="<?php echo base_url() . 'assets/uploads/' . $row->post_thumb_name; ?>"
                                                                alt="avatar" class="img-responsive center-block">
                                                        </div>
                                                    </div>
                                                    <strong>
                                                        <h1 class="text-center"><?php echo $row->post_title; ?>
                                                        </h1>
                                                    </strong>

                                                    <!--Accordion wrapper-->
                                                    <div class="accordion md-accordion" id="accordionEx" role="tablist"
                                                        aria-multiselectable="true">
                                                    </div>

                                                    <div class="card">
                                                        <p>Category:<?php echo $row->category; ?>
                                                        </p>
                                                    </div>

                                                    <div class="card">
                                                        <p>Post Description:<?php echo $row->post_description; ?>
                                                        </p>
                                                    </div>

                                                    <div class="card">
                                                        <p>Views:<?php echo $row->post_views; ?>
                                                        </p>
                                                    </div>

                                                    <div class="card">
                                                        <p>Post Status:<?php echo $row->post_status; ?>
                                                        </p>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="text-center">
                                                <?php echo anchor('administration/posts', 'back', ['class' => 'btn btn-primary']); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php echo anchor("administration/edit/" . $row->post_id, "<i class='fas fa-edit'></i>", "class='btn btn-warning btn-sm'"); ?>
                        <?php if ($row->post_status == 1) {
            echo anchor("administration/deactivate-post/" . $row->post_id . "/" . $row->post_status, "<i class='far fa-thumbs-down'></i>", array("class" => "btn btn-default btn-sm", "onclick" => "return confirm('Are you sure you want to deactivate?')"));
        } else {
            echo anchor("administration/deactivate-post/" . $row->post_id . "/" . $row->post_status, "<i class='far fa-thumbs-up'></i>", array("class" => "btn btn-info btn-sm", "onclick" => "return confirm('Are you sure you want to activate?')"));
        }?>

                        <?php echo anchor("administration/delete-post/" . $row->post_id, '<i class="fas fa-trash-alt"></i>', array("class" => "btn btn-danger btn-sm", "onclick" => "return confirm('Are you sure you want to Delete?')")); ?>


                    </td>
                </tr>
                <?php
}
}
?>
            </tbody>
        </table>
    </div>

    <?php echo $links; ?>
    </p>
</div>