<!doctype html>
<html lang="en">

<head>
    <?php $this->load->view('laikipiaschools/layouts/includes/header');?>
</head>

<body>
<<<<<<< HEAD
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
	<script defer src="<?php echo base_url(); ?>assets/custom/js/feather.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/dashboard.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/script.js"></script>
  <link href="<?php echo base_url(); ?>assets/fontawesome/css/all.css" rel="stylesheet">
<script defer src="<?php echo base_url(); ?>assets/fontawesome/js/all.js"></script>
  
=======
    <?php echo $this->load->view('laikipiaschools/layouts/includes/navigation'); ?>

    <div class="container-fluid">
        <div class="row">
            <?php $this->load->view('laikipiaschools/layouts/includes/sidebar');?>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 pt-5">
                <?php
$error = $this->session->flashdata('error');
$success = $this->session->flashdata('success');
if (!empty($error)) {
    ?>
                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div>
                <?php
}

if (!empty($success)) {
    ?>
                <div class="alert alert-success">
                    <?php echo $success; ?>
                </div>
                <?php
}

echo $content;?>
            </main>
        </div>
    </div>
    <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery-3.3.1.slim.min.js"></script>
    <script>
    window.jQuery || document.write(
        '<script src=""<?php echo base_url(); ?>assets/vendor/jquery/jquery-3.3.1.slim.min.js"><\/script>')
    </script>
    <script src="<?php echo base_url(); ?>assets/vendor/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/icons/feather.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/dashboard.js"></script>
    <link href="<?php echo base_url(); ?>assets/fontawesome/css/all.css" rel="stylesheet">
    <script defer src="<?php echo base_url(); ?>assets/fontawesome/js/all.js"></script>
    <link href='https://cdn.jsdelivr.net/npm/froala-editor@2.9.3/css/froala_editor.min.css' rel='stylesheet'
        type='text/css' />
    <link href='https://cdn.jsdelivr.net/npm/froala-editor@2.9.3/css/froala_style.min.css' rel='stylesheet'
        type='text/css' />

    <!-- Include JS file. -->
    <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/froala-editor@2.9.3/js/froala_editor.min.js'>
    </script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/editors/css/froala_editor.pkgd.min.css">
>>>>>>> d14311ebf6830f5a49bc33b5ce8a36e55116f894
</body>

</html>