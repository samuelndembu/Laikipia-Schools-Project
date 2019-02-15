<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Merchant</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> -->
    <link rel="stylesheet" href="<?php echo base_url();?>/css/login.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
    <div class="row">
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
                            <a class="dropdown-item" href="../mpesa/logout">Logout</a>
                        </div>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Commission <badge class="btn-success" style="padding:10px;">Kes. 0</badge></a>
                    </li>
                </ul>
            </div>
        </nav>
        <br>
        <br>
    </div>
    <div class="row">
    <div class="container">
        <div class="row">
            <?php if($this->session->flashdata("error")) : ?>
                <label class="alert alert-danger d-flex justify-content-center" style="font-size:15px;"><?php echo $this->session->flashdata("error");?></label>
            <?php elseif($this->session->flashdata("success")) : ?>
                <label class="alert alert-success d-flex justify-content-center" style="font-size:15px;"><?php echo $this->session->flashdata("success");?></label>
            <?php endif; ?>  
        </div>

        <div class="row">
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
                        <form method="POST" action="<?php echo base_url();?>mpesa/save-client">
                            <div class="col form-group">
                                <input type="text" name="firstName" class="form-control" value="<?php echo $firstName;?>" hidden>
                            </div>
                            <div class="col form-group">
                                <input type="text" name="merchantId" class="form-control" value="<?php echo $merchantId;?>" hidden>
                            </div>
                            <div class="col form-group">
                                <input type="text" name="cell" class="form-control" value="<?php echo $cell;?>" hidden>
                            </div>
                            <div class="col form-group">
                                <input type="tel" class="form-control" name="phoneNumber" placeholder="Enter customer phone number" required>
                            </div>
                            <div class="col form-group">
                                <input type="text" class="form-control" id="location" name="location" value="" placeholder="Enter customer location" required>
                            </div>
                            <!-- <div class="form-group">
                                <input type="text" class="form-control" id="location" placeholder="Location">
                            </div> -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            </div>
        </div>
        <br>
        <div class="col-md-10 col-xl-12 col-md-offset-1" >
            <div class="panel panel-default panel-table">
                <div class="panel-heading">
                    <div class="row">
                    <div class="col col-xs-6">
                        <h6 class="panel-title">Customers Registered</h6>
                    </div>
                    <div class="col col-xs-6 text-right" style="margin-bottom:5px;">
                        <button type="button" class="btn btn-sm btn-warning btn-create" data-toggle="modal" data-target="#exampleModal">Create New Customer</button>
                    </div>
                    </div>
                </div>
                <div class="panel-body table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="hidden-xs">#</th>
                                <th>Name</th>
                                <th>Phone Number</th>
                                <!-- <th>Location</th> -->
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
    </script>
    
</body>
</html>