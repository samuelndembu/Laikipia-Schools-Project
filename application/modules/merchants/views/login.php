
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Login</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<link rel="stylesheet" href="<?php echo base_url();?>/css/login.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
	</head>

	<body>
		<div class="container h-100">
			<div class="d-flex justify-content-center h-100">
				<div class="user_card">
					<div class="d-flex justify-content-center center">
						<div>
							<img src="<?php echo base_url();?>img/mawingu.png" style="width:50%;display:block;margin-left:auto;margin-right:auto;margin-top:10%;" alt="">
							<label for="" class="d-flex justify-content-center center" style="margin-bottom:5%;">Merchant Login</label>
						</div>
					</div>
					<div class=" form_container">
						<form method="POST" action="<?php echo site_url();?>mpesa/merchant">
							<?php if($this->session->flashdata("error")) : ?>
								<label class="alert alert-danger d-flex justify-content-center" style="font-size:15px;"><?php echo $this->session->flashdata("error");?></label>
							<?php endif; ?>
							<div style="margin-bottom:20px;">
								<div class="input-group input-group-lg">
									<div class="input-group-append">
										<span class="input-group-text"><i class="fas fa-phone"></i></span>
									</div>
									<input type="tel" name="phone" id="phone" class="form-control input_user" placeholder="Enter your phone number" style="padding:10px;font-size:17px;" required>
								</div>
							</div>

							<div>
								<div class="input-group input-group-lg">
									<div class="input-group-append">
										<span class="input-group-text"><i class="fas fa-lock"></i></span>
									</div>
									<input type="password" name="password" id="password" class="form-control input_user" placeholder="Enter your password" style="padding:10px;font-size:17px;" required>
								</div>
							</div>
							
							<div>
								<button type="submit" class="btn login_btn" style="margin-top:18px;padding:10px;margin-bottom:5px;font-size:20px;">Login</button>
							</div>
						</form>
					</div>
					
				</div>
			</div>
		</div>
	</body>
</html>
