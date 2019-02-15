<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>New Partner</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="<?php echo base_url() ?>assets/jquery-3.3.1.min.js"></script>
    <link href="<?php echo base_url() ?>assets/themes/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>assets/themes/bootstrap/js/bootstrap.min.js" rel="stylesheet" />
    <link href="<?php echo base_url() ?>assets/custom/partner.css" rel="stylesheet"/>
</head>

<body>
    <div class = "container">
                    <?php

            $validation_errors = validation_errors();
            if (!empty($validation_errors)) {
                echo $validation_errors;
            }
            ?>
                <h1>Added <?php echo $partner_name; ?></h1>
            <ol>
                <li>Partner Type:<?php echo $partner_type; ?></li>
                <li>Partner Name:<?php echo $partner_name; ?></li>
                <li>Partner Email:<?php echo $partner_email; ?></li>
                <li>Partner Logo:<?php echo $partner_logo; ?></li>
            </ol>
    </div>

</body>
</html>