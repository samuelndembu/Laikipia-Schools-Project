<?php

$validation_errors = validation_errors();
if (!empty($validation_errors)) {
    echo $validation_errors;
}
?>


<div class="shadow-lg p-3 mb-5 bg-white rounded">
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
                                        <label for="post_title">Post Title</label>
                                        <input type="text" class="form-control" id="post_title" name="post_title"
                                            placeholder="Post Title" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-12 col-md-12">
                                        <label for="category_id">Categories</label>
                                        <select id="inputState" class="form-control" name="category_id">
                                            <option selected>Choose Category</option>

                                            <?php if ($categories->num_rows() > 0) {
    foreach ($categories->result() as $row) {?>
                                            <option value="<?php echo $row->category_id; ?>">
                                                <?php echo $row->category_name; ?></option>
                                            <?php
}
}?>
                                            '
                                        </select>
                                    </div>
                                </div>



                                <div class="form-group row">
                                    <div class="col-sm-12 col-md-12">
                                        <label for="post_image_name">Post
                                            Image</label>
                                        <input type="file" id="post_image_name" name="post_image_name">
                                    </div>
                                </div>

                                <!--
                                <div class="form-group row">
                                    <div class="col-sm-12 col-md-12">
                                        <label for="post_views">Post Views</label>
                                        <input type="Numeric" class="form-control" id="post_views" name="post_views"
                                            placeholder="Views" required>
                                    </div>
                                </div> -->

                                <div class="form-group row">
                                    <!-- <fieldset class="form-group"> -->
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
                                </div>

                                <div class="form-group">
                                    <label for="post_description">Post Description</label>
                                    <?php echo form_textarea(array('name' => 'post_description', 'placeholder' => 'Write s description of the post', 'id' => 'ckeditor', 'class' => "ckeditor")); ?>
                                    <small id="emailHelp" class="form-text text-muted"></small>
                                </div>


                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                            class="fas fa-times"></i>Close</button>
                                    <button type="submit" class="btn btn-primary"><i
                                            class="fas fa-check"></i>Save</button>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
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
                    <th>Post Image</th>
                    <th>Post Title</th>
                    <th>Post Category</th>
                    <th>Date Created</th>
                    <!-- <th>Post Status</th> -->
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Post Image</th>
                    <th>Post Title</th>

                    <th>Post Category</th>
                    <th>Date Created</th>
                    <!-- <th>Post Status</th> -->
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
                    <break>
                        <!-- <td>
                        <?php echo $row->category_name ?>
                    </td> -->
                        <td>
                            <?php foreach ($categories->result() as $category) {
            if ($category->category_id == $row->category_id) {
                echo $category->category_name;
            }
        }
        ?>
                        </td>
                        <td>
                            <?php echo $row->created_on; ?>
                        </td>

                        <td>
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#modalQuickView<?php echo $row->post_id; ?>"><i
                                    class="fas fa-eye"></i></button>
                            <!-- Modal: modalQuickView -->
                            <div class="modal fade" id="modalQuickView<?php echo $row->post_id; ?>" tabindex="-1"
                                role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content primary">
                                        <div class="modal-body primary">
                                            <strong>
                                                <h1 class="card text-center"><?php echo $row->post_title; ?>
                                                </h1>
                                            </strong>
                                            <div class="row">

                                                <div class="card-body col-md-6 col-sm-2">
                                                    <div class="img-responsive left-block row">
                                                        <img src="<?php echo base_url() . 'assets/uploads/' . $row->post_image_name; ?>"
                                                            alt="avatar" class="mx-auto d-block">
                                                    </div>
                                                </div>

                                                <div class="card-body col-md-6 col-sm-4">
                                                    <div class="accordion md-accordion" id="accordionEx" role="tablist"
                                                        aria-multiselectable="true">
                                                    </div>

                                                    <div>
                                                        <h5>Category: </h5>
                                                        <p> <?php foreach ($categories->result() as $category) {
            if ($category->category_id == $row->category_id) {
                echo $category->category_name;
            }
        }
        ?>
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <h5> Post
                                                            Description:</h5>
                                                        <p><?php echo $row->post_description; ?>
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <p class="card-text"><small class="text-muted">Date
                                                                Created:<?php echo $row->created_on; ?></small>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                                    class="fas fa-times"></i>Close</button>
                                        </div>
                                    </div>

                                </div>

                            </div>
    </div>




    <!-- <?php echo anchor("administration/edit-school/" . $row->post_id, "<i class='fas fa-edit'></i>", "class='btn btn-warning btn-sm'"); ?> -->


    <!-- Button trigger modal -->
    <button type="button" class="class='btn btn-warning btn-sm" data-toggle="modal"
        data-target="#exampleModal<?php echo $row->post_id; ?>">
        <i class='fas fa-edit'></i>
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal<?php echo $row->post_id; ?>" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel<?php echo $row->post_id; ?>">Update Post</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Enter Post Details to update</h5>

                    <?php echo
        form_open($this->uri->uri_string()); ?>
                    <div class="form-group row">
                        <label for="post_title" class="col-sm-2 col-form-label">Post
                            Title</label>
                        <div class="col-md-10">
                            <?php echo form_input(['name' => 'post_title', 'class' => 'form-control', 'value' => set_value('post_title', $row->post_title)]) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="post_description" class="col-sm-2 col-form-label">Post
                            Description</label>
                        <div class="col-md-10">
                            <?php echo form_textarea(['name' => 'post_description', 'id' => 'ckeditor', 'class' => 'ckeditor', 'value' => set_value('post_description', $row->post_description)]) ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="post_image_name" class="col-sm-2 col-form-label">Post
                            Image</label>
                        <div class="col-md-10">
                            <?php echo form_input(['name' => 'post_image_name', 'class' => 'form-control', 'value' => set_value('post_image_name', $row->post_image_name)]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-form-label col-sm-2 pt-0">Post Status</label>
                        <div class="form-group">
                            <input type="radio" name="status" value="1"
                                <?php echo ($row->post_status == 'Active') ? 'checked' : '' ?>>Active
                            <input type="radio" name="status" value="0"
                                <?php echo ($row->post_status == 'Inactive') ? 'checked' : '' ?>>Inactive
                        </div>
                    </div>
                    <div class="modal-footer row">

                        <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i>Save
                            Changes</button>

                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                class="fas fa-times"></i>Close</button>
                    </div>

                </div>

            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
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

<p>
    <?php echo $links; ?>
</p>
</div>