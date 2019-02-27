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
                                <div class="form-group">
                                    <label for="school_name">School Name</label>
                                    <!-- <input type="text" class="form-control" id="school_name"
                                        aria-describedby="emailHelp" name="school_boys_number"
                                        placeholder="School Name"> -->
                                    <select id="inputState" class="form-control" name="school_name">
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
                                            <div class="col-md-12">
                                                <div class="container">
                                                    <div class="row justify-content-center">
                                                        <h3> <?php echo $row->school_name; ?></h3>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-5 col-sm-2">
                                                        <div class="img-responsive center-block row">
                                                            <img src="<?php echo base_url() . 'assets/uploads/' . $row->school_image_name; ?>"
                                                                alt="avatar" class="rounded float-left">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-7 col-sm-4">
                                                        <h5 class="card-title">Details</h5>
                                                        <div>
                                                            <h6>Zone:</h6>
                                                            <p><?php echo $row->school_zone; ?>
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <h6>Number Of Boys:</h6>
                                                            <p><?php echo $row->school_boys_number; ?>
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <h6>Number Of
                                                                Girls:</h6>
                                                            <p><?php echo $row->school_girls_number; ?>
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <h6>Status:</h6>
                                                            <p><?php echo $row->school_status; ?>
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <h6>School Write
                                                                Up: </h6>
                                                            <p><?php echo $row->school_write_up; ?>
                                                            </p>
                                                        </div>
                                                        <p class="card-text"><small class="text-muted">Date
                                                                Created:<?php echo $row->created_on; ?></small>
                                                        </p>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div>
                                                        <p>Location
                                                            Description:&nbsp; <?php echo $row->school_location_name; ?>
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <p>&nbsp;Latitude:&nbsp;
                                                            <?php echo $row->school_latitude; ?>
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <p> &nbsp;Longitude:&nbsp;
                                                            <?php echo $row->school_longitude; ?>
                                                        </p>
                                                    </div>
                                                    <div id="map">34</div>
                                                    <div>
                                                        <button class="btn btn-warning btn-sm"
                                                            onclick="loadLocation()">View on Map</button>

                                                        <?php echo "<script type='text/javascript'>

                                                        function loadLocation()
                                                        {
                                                            var myLatLng = {lat: -5.363, lng: 131.044};
                                                            var mapDiv = document.createElement('DIV');
                                                            var  map = new google.maps.Map(mapDiv, {
                                                                zoom: 16,
                                                                center: new google.maps.LatLng(-33.91722, 151.23064),
                                                                mapTypeId: 'roadmap'
                                                            });

                                                            var marker = new google.maps.Marker({
                                                                position: myLatLng,
                                                                map: map,
                                                                title: 'Hello World!'
                                                            });
                                                            console.log(mapDiv);
                                                             document.getElementById('ads').appendChild(mapDiv);
                                                        }
                                                        </script>"; ?>
                                                    </div>



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
    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
        data-target="#exampleModal<?php echo $row->school_id; ?>"><i class="fas fa-edit"></i></button>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal<?php echo $row->school_id; ?>" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <div class="row">
                        <legend class="col-form-label col-sm-2 pt-0">
                            School Status
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

                        <div class="form-group row">
                            <label for="school_write_up" class="ckeditor">School
                                Write up</label>
                            <div class="col-md-10">
                                <?php echo form_textarea(['name' => 'school_write_up', 'placeholder' => 'Describe your school briefly', 'class' => 'ckeditor', 'id' => 'ckeditor', 'value' => set_value('school_write_up', $row->school_write_up)]) ?>
                            </div>
                        </div>
                        <div class="
                                form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i>Save
                                    School</button>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                            class="fas fa-times"></i>Close</button>
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
<p>
    <?php echo $links; ?>
</p>