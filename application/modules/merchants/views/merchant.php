<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Merchant</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?php echo $this->site_model->get_resources_location();?>bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="<?php echo $this->site_model->get_resources_location();?>jquery-3.3.1.min.js"></script>
    <script src="<?php echo $this->site_model->get_resources_location();?>bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo $this->site_model->get_resources_location();?>custom/css/login.css">
    <!-- Font Awesome -->
    <link href="<?php echo $this->site_model->get_resources_location();?>fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <a class="navbar-brand" href="#">My Profile</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo $firstName;?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#"><?php echo $cell;?></a>
                        <a class="dropdown-item" href="<?php echo site_url();?>merchant/change-password">Update Password</a>
                        <a class="dropdown-item" href="<?php echo site_url();?>mpesa/logout">Logout</a>
                    </div>
                </li>
                <!-- <li class="nav-item active">
                    <a class="nav-link" href="#">Commission <badge class="btn-success" style="padding:10px;">Kes. 0</badge></a>
                </li> -->
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Register Customers</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="<?php echo site_url();?>mpesa/save-client">
                            <input type="hidden" name="firstName" class="form-control" value="<?php echo $firstName;?>">
                            <input type="hidden" name="merchantId" class="form-control" value="<?php echo $merchantId;?>">
                            <input type="hidden" name="cell" class="form-control" value="<?php echo $cell;?>">
                            <div class="col form-group">
                                <input type="tel" class="form-control" name="phoneNumber" placeholder="Enter customer phone number" required autocomplete="off">
                            </div>
                            <div class="col form-group">
                                <input type="text" class="form-control" id="location" name="location" value="" placeholder="Enter customer location" required>
                            </div>
                            <!-- <div class="form-group">
                                <input type="text" class="form-control" id="location" placeholder="Location">
                            </div> -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12 col-md-offset-12">
                <?php if($this->session->flashdata("error")) : ?>
                    <div class="alert alert-danger" align="center" role="alert"><?php echo $this->session->flashdata("error");?></div>
                <?php elseif($this->session->flashdata("success")) : ?>
                    <div class="alert alert-success" align="center" role="alert"><?php echo $this->session->flashdata("success");?></div>
                <?php endif; ?> 
            </div>
        </div>
           
        <div class="card panel-default panel-table">
            <div class="card-header">
                <div class="row">
                <div class="col col-xs-6">
                    <h6 class="panel-title">Customers Registered</h6>
                </div>
                <div class="col col-xs-6 text-right" style="margin-bottom:5px;">
                    <button type="button" class="btn btn-sm btn-warning btn-create" data-toggle="modal" data-target="#exampleModal">Create New Customer</button>
                </div>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered table-sm" style="font-size:0.8rem;">
                    <thead>
                        <tr>
                            <th class="hidden-xs">#</th>
                            <th>Name</th>
                            <th>Phone Number</th>
                            <th>Created</th>
                        </tr> 
                    </thead>
                    <tbody>
                        <?php
                        $count = 1;
                        foreach($customers as $customer):
                            $date=date_create($customer->created_at);?>
                            <tr>
                                <td><?php echo $count++; ?></td>
                                <td><?php echo $customer->full_name; ?></td>
                                <td><?php echo $customer->phone_number; ?></td>
                                <td><?php echo date_format($date,"dS-M-Y H:i"); ?></td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script>
        var locationInput = document.getElementById("location");
        (function(){
            var location = "";
            var geoError = function(error) {
                console.log('Error occurred. Error code: ' + error.code);
                // error.code can be:
                //   0: unknown error
                //   1: permission denied
                //   2: position unavailable (error response from location provider)
                //   3: timed out
            };
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    let url = "https://maps.googleapis.com/maps/api/geocode/json?latlng="+position.coords.latitude+","+position.coords.longitude+"&key=AIzaSyBqpe5MxT-z7CHNWtJHCDm0cp9Mpiwuk3s";
                    var obj = new XMLHttpRequest;
                    obj.onreadystatechange = function(){
                        if((this.readyState ==4) && (this.status ==200)){
                            console.log(JSON.parse(this.responseText)["results"]);
                            let tempLocation = "";
                            tempLocation = JSON.parse(this.responseText);
                            if(tempLocation !== "" || tempLocation !== null){
                                let _customFormat = tempLocation["results"][0]["address_components"];
                                location = _customFormat[0]['short_name'] + ", " + _customFormat[1]['short_name'] + " KE";
                                if(location !== "" || location !== null || location !== undefined){
                                    locationInput.value = location;
                                }
                            }
                        }
                    };
                    obj.open("GET", url, true);
                    obj.send();
                }, geoError);
            } else { 
                location = "Geolocation is not supported.";
                document.getElementById("location").value = location;
            }
        })();

        /*
            Fade out alerts
        */
        $(".alert").fadeTo(5000, 1000).slideUp(1000, function(){
            $(".alert").slideUp(1000);
        });
    </script>
    
</body>
</html>