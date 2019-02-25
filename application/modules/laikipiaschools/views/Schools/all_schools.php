<?php

$validation_errors = validation_errors();
if (!empty($validation_errors)) {
    echo $validation_errors;
}
?>
<!--
<div class="container"> -->
<div class="shadow-lg p-3 mb-5 bg-white rounded">

    <div class="card-body">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                    data-target="#createDonation">Add
                    School</button>
                <a href="<?php echo site_url() . "administration/export-schools" ?>" target="_blank"
                    class="btn btn-default pull-right"><i class="fas fa-file-import"></i> Import</a>

                <a href="<?php echo site_url() . "administration/export-schools" ?>" target="_blank"
                    class="btn btn-default pull-right"><i class="fas fa-file-export"></i> Export</a>
                <div class="modal fade" id="createDonation" tabindex="-1" role="dialog"
                    aria-labelledby="createDonationLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createDonationLabel">Enter New School</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>




                            </div>
                            <div class="modal-body">
                                <?php echo form_open_multipart($this->uri->uri_string()); ?>
                                <div class="row">
                                </div>

                                <div class="form-group">
                                    <label for="school_name">Zones</label>
                                    <select id="inputState" class="form-control" name="school_zone">
                                        <option selected>Choose your zone...</option>
                                        <option value="Daiga">Daiga </option>
                                        <option value="Gituamba"> Gituamba </option>
                                        <option value="Igwamiti"> Igwamiti </option>
                                        <option value="Kinamba"> Kinamba </option>
                                        <option value="Marmanet"> Marmanet </option>
                                        <option value="Muhotetu"> Muhotetu </option>
                                        <option value="Mukogodo East "> Mukogodo East </option>
                                        <option value="Mutara"> Mutara </option>
                                        <option value="Nanyuki North "> Nanyuki North </option>
                                        <option value="Nanyuki South "> Nanyuki South </option>
                                        <option value="Ngobit"> Ngobit </option>
                                        <option value="Nyahururu "> Nyahururu </option>
                                        <option value="Ol Moran"> Ol Moran </option>’
                                        <option value="Rumuruti "> Rumuruti </option>
                                        <option value="Salama"> Salama </option>
                                        <option value="Sipili"> Sipili </option>
                                        <option value="Sirima"> Sirima </option>
                                        <option value="Tigithi"> Tigithi </option>
                                    </select>




                                    <!--
                                        <?php if ($zones->num_rows() > 0) {
    foreach ($zones->result() as $row) {?>
                                        <option value="<?php echo $row->school_zone ?>">
                                            <?php echo $row->school_zone ?></option>
                                        <?php
}
}?>
                                        '
                                    </select> -->
                                    <small id="emailHelp" class="form-text text-muted"></small>
                                </div>
                                <div class="form-group">
                                    <label for="school_name">School Name</label>
                                    <input type="text" class="form-control" id="school_name"
                                        aria-describedby="emailHelp" name="school_boys_number"
                                        placeholder="School Name">
                                    <small id="emailHelp" class="form-text text-muted"></small>
                                </div>
                                <div class="form-group">
                                    <label for="school_boys_number">Number of boys</label>
                                    <input type="number" class="form-control" id="school_boys_number"
                                        aria-describedby="emailHelp" name="school_boys_number"
                                        placeholder="Number of Boys">
                                    <!-- <small id="emailHelp" class="form-text text-muted"></small> -->
                                </div>
                                <div class="form-group">
                                    <label for="school_girls_number">Number of Girls</label>
                                    <input type="number" class="form-control" id="school_girls_number"
                                        aria-describedby="emailHelp" name="school_girls_number"
                                        placeholder="Number of Girls">
                                    <small id="emailHelp" class="form-text text-muted"></small>
                                </div>

                                <div class="form-group">
                                    <label for="school_status">Status</label>
                                    <div class="col-sm-10 row">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="school_status"
                                                id="school_status" value="1" checked>
                                            <Legend class="form-check-label" for="gridRadios1">
                                                Active
                                            </Legend>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="school_status"
                                                id="school_status" value="0">
                                            <Legend class="form-check-label" for="gridRadios2">
                                                Inactive
                                            </Legend>
                                        </div>
                                    </div>
                                    <small id="emailHelp" class="form-text text-muted"></small>
                                </div>

                                <div class="form-group">
                                    <label for="school_location_name">Location Description</label>
                                    <input type="text" class="form-control" id="school_location_name"
                                        aria-describedby="emailHelp" name="school_location_name"
                                        placeholder="Location Description">
                                    <small id="emailHelp" class="form-text text-muted"></small>
                                </div>

                                <div class="form-group">
                                    <label for="school_latitude">Latitude</label>
                                    <input type="number" class="form-control" id="school_latitude"
                                        aria-describedby="emailHelp" name="school_latitude" placeholder="Latitude">
                                    <small id="emailHelp" class="form-text text-muted"></small>
                                </div>
                                <div class="form-group">
                                    <label for="school_longitude">Longitude</label>
                                    <input type="number" class="form-control" id="school_longitude"
                                        aria-describedby="emailHelp" name="school_longitude" placeholder="Longitude">
                                    <small id="emailHelp" class="form-text text-muted"></small>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 col-md-12">
                                        <label for="school_image">Profile
                                            Image</label>
                                        <input type="file" id="school_image" name="school_image">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="school_write_up">School Write Up</label>
                                    <script>
                                    $(function() {
                                        $('textarea').froalaEditor()
                                    });
                                    </script>

                                    <textarea id="froala-editor" name="school_write_up" class="form-control"
                                        placeholder="School Write up"></textarea>
                                    <small id="emailHelp" class="form-text text-muted"></small>
                                </div>
                                <!-- <div class="form-group">
                                    <div class="col-sm-12 col-md-12">
                                        <label for="school_write_up" name="school_write_up"
                                            class="col-form-label"></label>
                                        <textarea name="school_write_up" class="form-control" id="school_write_up"
                                            placeholder="School Write up"></textarea>
                                    </div>
                                </div> -->

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
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
                    <th> School Picture</th>
                    <th>School Name</th>
                    <th>Number of Boys</th>
                    <th>Number of Girls</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>School Picture</th>
                    <th>School Name</th>
                    <th>Number of Boys</th>
                    <th>Number of Girls</th>
                    <th>Actions</th>

                </tr>
            </tfoot>
            <tbody>
                <?php
if ($query->num_rows() > 0) {
    $count = 0;

    foreach ($query->result() as $row) {
        $id = $row->school_id;

        $count++;
        ?>
                <tr>
                    <td>
                        <?php echo $count ?>
                    </td>
                    <td>
                        <img src="<?php echo base_url() . 'assets/uploads/' . $row->school_thumb_name; ?>" width="70px"
                            height="70px">
                    </td>
                    <td>
                        <?php echo $row->school_name; ?>
                    </td>

                    <td><?php echo $row->school_boys_number; ?></td>
                    <td><?php echo $row->school_girls_number; ?></td>

                    <td>
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                            data-target="#modalQuickView<?php echo $row->school_id; ?>"><i
                                class="fas fa-eye"></i></button>
                        <!-- Modal: modalQuickView -->
                        <div class="modal fade" id="modalQuickView<?php echo $row->school_id; ?>" tabindex="-1"
                            role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <h2 class="h2-responsive product-name">
                                                    <div class="modal-header row">
                                                        <div class="img-responsive center-block row">
                                                            <img src="<?php echo base_url() . 'assets/uploads/' . $row->school_thumb_name; ?>"
                                                                alt="avatar" class="img-responsive center-block"
                                                                width="70px" height="70px">
                                                        </div>
                                                    </div>
                                                    <strong>
                                                        <h1 class="text-center">
                                                            <?php echo $row->school_name; ?>
                                                        </h1>
                                                    </strong>

                                                    <!--Accordion wrapper-->
                                                    <div class="accordion md-accordion" id="accordionEx" role="tablist"
                                                        aria-multiselectable="true">
                                                    </div>

                                                    <div class="card">
                                                        <p>Location:<?php echo $row->school_location_name; ?>
                                                        </p>
                                                    </div>

                                                    <div class="card">
                                                        <p>Number Of
                                                            Girls:<?php echo $row->school_girls_number; ?>
                                                        </p>
                                                    </div>

                                                    <div class="card">
                                                        <p>Number Of
                                                            Boys:<?php echo $row->school_boys_number; ?>
                                                        </p>
                                                    </div>

                                                    <div class="card">
                                                        <p>School Write
                                                            Up:<?php echo $row->school_write_up; ?></p>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="text-center">
                                                <?php echo anchor('laikipiaschools/schools', 'back', ['class' => 'btn btn-primary']); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- <?php echo anchor("administration/edit-school/" . $row->school_id, "<i class='fas fa-edit'></i>", "class='btn btn-warning btn-sm'"); ?> -->


                        <!-- Button trigger modal -->
                        <!-- <button type="button" class="class='btn btn-warning btn-sm" data-toggle="modal" data-target="#exampleModal<?php echo $row->post_id; ?>">
            <i class='fas fa-edit'></i>
        </button> -->
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                            data-target="#exampleModal<?php echo $row->school_id; ?>"><i
                                class="fas fa-edit"></i></button>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal<?php echo $row->school_id; ?>" tabindex="-1"
                            role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Update School
                                            Details</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">Enter school Details to update</h5>

                                        <?php echo
        form_open($this->uri->uri_string()); ?>
                                        <div class="form-group row">
                                            <label for="school_name" class="col-sm-2 col-form-label">School
                                                Name</label>

                                            <div class="col-md-10">
                                                <?php echo form_input(['name' => 'school_name', 'placeholder' => 'School Name', 'class' => 'form-control', 'value' => set_value('school_name', $row->school_name)]) ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="school_write_up" class="col-sm-2 col-form-label">School
                                                Write up</label>
                                            <div class="col-md-10">
                                                <?php echo form_textarea(['name' => 'school_write_up', 'placeholder' => 'Describe your school briefly', 'class' => 'form-control', 'value' => set_value('firstname', $row->school_write_up)]) ?>
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










                                        <a href="<?php echo site_url() . "administration/export-schools" ?>"
                                            target="_blank" class="btn btn-default pull-right"><i
                                                class="fas fa-file-import"></i> Import</a>

                                        <a href="<?php echo site_url() . "administration/export-schools" ?>"
                                            target="_blank" class="btn btn-default pull-right"><i
                                                class="fas fa-file-export"></i> Export</a>




                                        <div class="form-group row">
                                            <label for="school_latitude"
                                                class="col-sm-2 col-form-label">Latitude</label>
                                            <div class="col-md-10">
                                                <?php echo form_input(['name' => 'school_latitude', 'placeholder' => 'Enter Latitude', 'class' => 'form-control', 'value' => set_value('school_latitude', $row->school_latitude)]) ?>
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label for="school_longitude"
                                                class="col-sm-2 col-form-label">Longitude</label>
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
                                            <legend class="col-form-label col-sm-2 pt-0">School Status
                                            </legend>
                                            <div class="form-group">
                                                <input type="radio" name="status" value="1"
                                                    <?php echo ($row->school_status == 'Active') ? 'checked' : '' ?>>Active
                                                <input type="radio" name="status" value="0"
                                                    <?php echo ($row->school_status == 'Inactive') ? 'checked' : '' ?> ">Inactive
                            </div>
                        </div>


                        <div class="
                                                    form-group row">
                                                <div class="col-sm-10">
                                                    <button type="submit" class="btn btn-primary">Save
                                                        School</button>
                                                    <div class="modal-footer">
                                                        <?php echo anchor('laikipiaschools/schools', 'Cancel', ['class' => 'btn btn-primary']); ?>
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
            </tbody>
        </table>
    </div>

    <?php echo $links; ?>
    </p>
    <script>
    $(function() {
        $('textarea').froalaEditor()
    });
    </script>
    <script>
    $(function() {
        $('textarea#froala-editor').froalaEditor()
    });
    </script>
</div>