
<nav class="navbar navbar-expand-lg navbar-light border-bottom box-shadow bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03"
        aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">Administration</a>

    <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
        </ul>
        <?php if (isset($route)) {
             if ($this->session->userdata($route . '_search_title')){?>
             <div class="text-center p-3">
                 <label class="text-dark"><?php echo $this->session->userdata($route . '_search_title'); ?> </label>
               </div>
               <?php }
    echo form_open(base_url() . 'administration/search-' . $route, array("class" => "form-inline my-2 my-lg-0"))?>
                <select class="custom-select2 form-control mr-sm-2" name="search_param" required>
                    <option value="">Choose..</option>
                    <?php foreach ($search_options as $search_option) {
                        if($route == "schools"){?>
                            <option value="<?php echo $search_option['name']; ?>"><?php echo $search_option['name']; ?></option>
                        <?php } else{?>
                            <option value="<?php echo $search_option['id']; ?>"><?php echo $search_option['name']; ?></option>
                     <?php  }
                     }?>

                </select>
                <button class="btn btn-outline-primary my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
            <?php echo form_close();
    if ($this->session->userdata($route . "_search")) { ?>
            <a class="btn btn-outline-primary btn-sm m-2" href="<?php echo base_url() . 'administration/'.$route. '/close-search';?>">Close Search</a>
        <?php }}?>

    </div>
    <a class="p-2 text-dark" href="#">
    <span class="user-name"><?php if ($this->session->userdata('laikipia_admin')) {
    echo ($this->session->userdata('laikipia_admin'))['other_name'];} else {
    redirect('administration/login');}?>
    </span></a>
    <a class="btn btn-outline-danger btn-sm" href="<?php echo base_url(); ?>administration/logout"><i class="fas fa-sign-out-alt"></i>Log Out</a>
</nav>