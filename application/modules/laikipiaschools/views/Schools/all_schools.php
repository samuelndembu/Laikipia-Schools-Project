<?php

$validation_errors = validation_errors();
if (!empty($validation_errors)) {
    echo $validation_errors;
}
?>
<!--
<div class="container"> -->
<div class="shadow-lg p-3 mb-5 bg-white rounded" id="ads">
    <div class="card-body">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                    data-target="#createDonation">Add
                    School</button>
                <input type="file" class="btn btn-default pull-right" placeholder="Import" />

                <a href="<?php echo site_url() . " administration/export-schools" ?>" target="_blank"
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
                                <div class="form-group">
                                    <label for="school_name">School Name</label>
                                    <input type="text" class="form-control" id="school_name"
                                        aria-describedby="emailHelp" name="school_name" placeholder="School Name">
                                </div>
                                <div class="form-group">
                                    <label for="school_name">Zone</label>
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
                                    <small id="emailHelp" class="form-text text-muted"></small>
                                </div>
                                <!-- <div class="form-group">
                                    <label for="school_name">School Name</label>
                                    <!-- <input type="text" class="form-control" id="school_name"
                                        aria-describedby="emailHelp" name="school_boys_number"
                                        placeholder="School Name"> -->
                                <!-- <select id="inputState" class="form-control" name="school_name">
                                        <option selected>Choose your School.</option>
                                        <option value="Draja Academy">Draja Academy</option>
                                        <option value="G.G Kinamba Day sec school"> G.G Kinamba Day Secondary School
                                        </option>
                                        <option value="G.G Kinamba Pry school"> G.G Kinamba Primary School</option>
                                        <option value="Kiwanja day sec school">Kiwanja Day Secondary School</option>
                                        <option value="Kunderila Day Sec School"> Kunderila Day Secondary School
                                        </option>
                                        <option value="Shamanei day sec school">Shamanei Day Secondary School</option>
                                        <option value="Shamanei pry school">Shamanei Primary School</option>
                                        <option value="Tandare Day sec school">Tandare Day Secondary School</option>
                                    </select>
                                </div> -->

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
                                    <input type="numeric" class="form-control" id="school_latitude"
                                        aria-describedby="emailHelp" name="school_latitude" placeholder="Latitude">
                                    <small id="emailHelp" class="form-text text-muted"></small>
                                </div>
                                <div class="form-group">
                                    <label for="school_longitude">Longitude</label>
                                    <input type="numeric" class="form-control" id="school_longitude"
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
                                    <?php echo form_textarea(array('name' => 'school_write_up', 'id' => 'ckeditor', 'class' => "ckeditor")); ?>
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
                    <th> School Picture</th>
                    <th>School Name</th>
                    <th>Number of Boys</th>
                    <th>Number of Girls</th>
                    <th>Status</th>
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
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
            <tbody>
                <?php $this->load->view('view_edit_school');?>
            </tbody>
        </table>
    </div>
    <p>
        <?php echo $links; ?>
    </p>