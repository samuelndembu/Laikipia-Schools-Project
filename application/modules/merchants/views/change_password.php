
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Login</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="<?php echo $this->site_model->get_resources_location();?>bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<script src="<?php echo $this->site_model->get_resources_location();?>bootstrap/js/bootstrap.min.js"></script>
		<script src="<?php echo $this->site_model->get_resources_location();?>jquery-3.3.1.min.js"></script>
		<link rel="stylesheet" href="<?php echo $this->site_model->get_resources_location();?>custom/css/login.css">
		<!-- Font Awesome -->
		<link href="<?php echo $this->site_model->get_resources_location();?>fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
	</head>

	<body>
		<div class="container">
			<div class="d-flex justify-content-center login-container h-100">
				<div class="user_card">
					<div class="d-flex justify-content-center center">
						<div>
							<img src="<?php echo base_url();?>img/mawingu.png" style="width:50%;display:block;margin-left:auto;margin-right:auto;margin-top:10%;" alt="">
							<label for="" class="d-flex justify-content-center center" style="margin-bottom:5%;"><?php echo $title;?></label>
						</div>
					</div>
					<div>
						<?php echo form_open($this->uri->uri_string(), array("class" => "form-horizontal"))?>
							<?php if($this->session->flashdata("error")) : ?>
								<label class="alert alert-danger d-flex justify-content-center" style="font-size:15px;"><?php echo $this->session->flashdata("error");?></label>
							<?php endif; ?>

							<div style="margin-bottom:20px;">
								<div class="input-group input-group-lg">
									<div class="input-group-append">
										<span class="input-group-text"><i class="fa fa-lock"></i></span>
									</div>
									<input type="password" name="current_password" class="form-control input_user" placeholder="Current password" style="padding:10px;font-size:17px;" required>
								</div>
							</div>

                            <div style="margin-bottom:20px;">
                                <div class="input-group input-group-lg">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                    </div>
                                    <input type="password" name="new_password" class="form-control input_user" placeholder="New password" style="padding:10px;font-size:17px;" required>
                                </div>
                            </div>

                            <div>
                                <div class="input-group input-group-lg">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                    </div>
                                    <input type="password" name="confirm_password" class="form-control input_user" placeholder="Confirm password" style="padding:10px;font-size:17px;" required>
                                </div>
                            </div>
							
							<div>
								<button type="submit" class="btn login_btn" style="margin-top:18px;padding:10px;margin-bottom:5px;font-size:20px;">Change Password</button>
							</div>
						</form>
					</div>
					
				</div>
			</div>
		</div>
	</body>
</html>
