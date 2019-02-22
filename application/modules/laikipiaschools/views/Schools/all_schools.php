<!--

				Button trigger modal
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
				    <i class="fas fa-search"></i>Search School
				</button>

				<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Search School</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="btn-group">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        Select Search Criteria
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <button name="school_name" value="school_name" class="dropdown-item" type="button">School
                            Name</button>
                        <button name="school_boys_number" value="school_boys_number" class="dropdown-item"
                            type="button">Number of Girls</button>
                        <button name="school_girls_number" value="school_girls_number" class="dropdown-item"
                            type="button">Number of Girls</button>
                        <button name="school_location_name" value="school_location_name" class="dropdown-item"
                            type="button">Location Name</button>
                        <button name="school_status" value="school_status" class="dropdown-item" type="button">School
                            Status</button>
                    </div>
                </div>

                <br></br>
                <br></br>
                <br></br>
                <!-- Search form -->
                <form class="form-inline">
                    <i class="fas fa-search" aria-hidden="true"></i>
                    <input class="form-control form-control-sm ml-3 w-75" type="text" placeholder="Search"
                        aria-label="Search">
                </form>


            </div>
            <br></br>
            <br></br>
            <br></br>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>






<div class="container">
    <div class="shadow-lg p-3 mb-5 bg-white rounded"">



<div class=" card-body">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                    data-target="#createDonation">Add
                    School</button>
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
                                <div class="form-group row">
                                    <div class="col-sm-12 col-md-12">
                                        <input type="text" class="form-control" id="school_name" name="school_name"
                                            placeholder="School Name" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 col-md-12">
                                        <input type="number" class="form-control" id="school_boys_number"
                                            name="school_boys_number" placeholder="Number of Boys" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 col-md-12">
                                        <input type="number" class="form-control" id="school_girls_number"
                                            name="school_girls_number" placeholder="Number Of Girls" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-12 col-md-12">
                                        <input type="text" class="form-control" id="school_location_name"
                                            name="school_location_name" placeholder="Location Description" required>
                                    </div>
                                    <div class="form-group row">
                                        <div class="panel-body">
                                            <label class="title">Zone: </label>
                                            <?php echo form_dropdown('school_location_name', $zones, '', 'class="form-control"'); ?>
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12 col-md-12">
                                            <input type="text" class="form-control" id="school_latitude"
                                                name="school_latitude" placeholder="Latitude" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12 col-md-12">
                                            <input type="text" class="form-control" id="school_longitude"
                                                name="school_longitude" placeholder="Longitude" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12 col-md-12">
                                            <label for="school_image">Profile
                                                Image</label>
                                            <input type="file" id="school_image" name="school_image">
                                        </div>
                                    </div>
                                    <fieldset class="form-group">
                                        <div class="row">
                                            <legend class="col-form-label col-sm-2 pt-0">Status</legend>
                                            <br>
                                            <div class="col-sm-10">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="school_status"
                                                        id="school_status" value="1" checked>
                                                    <label class="form-check-label" for="gridRadios1">
                                                        Active
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="school_status"
                                                        id="school_status" value="0">
                                                    <label class="form-check-label" for="gridRadios2">
                                                        Inactive
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <input class="form-check-input" type="hidden" name="school_status"
                                        id="school_status" value="0">
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12 col-md-12">
                                        <label for="school_write_up" class="col-form-label"></label>
                                        <textarea class="form-control" id="message-text"
                                            placeholder="School Write up"></textarea>
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
                        <th> School Picture</th>
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
                            <img src="<?php echo base_url() . 'assets/uploads/' . $row->school_thumb_name; ?>">
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
                                                                    alt="avatar" class="img-responsive center-block">
                                                            </div>
                                                        </div>
                                                        <strong>
                                                            <h1 class="text-center"><?php echo $row->school_name; ?>
                                                            </h1>
                                                        </strong>

                                                        <!--Accordion wrapper-->
                                                        <div class="accordion md-accordion" id="accordionEx"
                                                            role="tablist" aria-multiselectable="true">
                                                        </div>

                                                        <div class="card">
                                                            <p>Location:<?php echo $row->school_location_name; ?></p>
                                                        </div>

                                                        <div class="card">
                                                            <p>Number Of Girls:<?php echo $row->school_girls_number; ?>
                                                            </p>
                                                        </div>

                                                        <div class="card">
                                                            <p>Number Of Boys:<?php echo $row->school_boys_number; ?>
                                                            </p>
                                                        </div>

                                                        <div class="card">
                                                            <p>School Write Up:<?php echo $row->school_write_up; ?></p>
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

                            <?php echo anchor("administration/edit/" . $row->school_id, "<i class='fas fa-edit'></i>", "class='btn btn-warning btn-sm'"); ?>
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
    </div>