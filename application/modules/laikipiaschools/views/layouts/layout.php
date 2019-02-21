<!doctype html>
<html lang="en">

<head>
	<?php $this->load->view('laikipiaschools/layouts/includes/header');?>
</head>

<body>
	<?php echo $this->load->view('laikipiaschools/layouts/includes/navigation'); ?>

	<div class="container-fluid">
		<div class="row">
			<?php $this->load->view('laikipiaschools/layouts/includes/sidebar');?>

			<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 pt-5">
		<?php 
		$error = $this->session->flashdata('error');
		$success = $this->session->flashdata('success');
		if(!empty($error))
		{
			?>
			<div class="alert alert-danger">
				<?php echo $error;?>
			</div>
			<?php
		}

		if(!empty($success))
		{
			?>
			<div class="alert alert-success">
				<?php echo $success;?>
			</div>
			<?php
		}

		echo $content;?>
			</main>
		</div>
	</div>
	<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery-3.3.1.slim.min.js"></script>
	<script>
		window.jQuery || document.write('<script src=""<?php echo base_url(); ?>assets/vendor/jquery/jquery-3.3.1.slim.min.js"><\/script>')

	</script>
	<script src="<?php echo base_url(); ?>assets/vendor/js/bootstrap.bundle.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/icons/feather.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/dashboard.js"></script>
  <link href="<?php echo base_url(); ?>assets/fontawesome/css/all.css" rel="stylesheet">
<script defer src="<?php echo base_url(); ?>assets/fontawesome/js/all.js"></script>
  
</body>

</html>
