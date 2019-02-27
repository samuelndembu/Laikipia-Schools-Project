<!-- <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow" style= "margin-bottom: 5px;" >
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Administration</a>

				<div class="dropdown mr-20">
					<a class="dropdown-toggle" href="<?php echo base_url(); ?>administration/logout" role="button" data-toggle="dropdown">
						<span class="user-name"><?php if ($this->session->userdata('laikipia_admin')) {
    echo ($this->session->userdata('laikipia_admin'))['other_name'];
} else {
    redirect('administration/login');
}?>
						 </span>
					</a>
					<div class="dropdown-menu dropdown-menu-right">

						<a class="dropdown-item" href="<?php echo base_url(); ?>administration/logout"> Log Out</a>
					</div>
				</div>

</nav> -->

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03"
        aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">Administration</a>

    <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
        </ul>
        <?php echo form_open(base_url() . 'administration/search-'.$route, array("class" => "form-inline my-2 my-lg-0")) ?>
        <select class="custom-select2 form-control mr-sm-2" name="search_param">
            <option>Choose..</option>
            <?php foreach ($search_options as $search_option) {?>
            <option value="<?php echo $search_option['id']; ?>"><?php echo $search_option['name']; ?></option>
            <?php }?>

        </select>
        <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
        <?php echo form_close(); ?>
    </div>
    <div class="dropdown mr-20 btn btn-primary my-2 my-sm-0 m-5">
        <a class="dropdown-toggle" href="<?php echo base_url(); ?>administration/logout" role="button"
            data-toggle="dropdown">
            <span
                class="user-name"><?php if ($this->session->userdata('laikipia_admin')) {
    echo ($this->session->userdata('laikipia_admin'))['other_name'];
} else {
    redirect('administration/login');
}?>
            </span>
        </a>
        <div class="dropdown-menu ">

            <a class="dropdown-item" href="<?php echo base_url(); ?>administration/logout"> Log Out</a>
        </div>
    </div>
</nav>