<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow" style= "margin-bottom: 5px;" >
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Administration</a>
    
				<div class="dropdown mr-20">
					<a class="dropdown-toggle" href="<?php echo base_url(); ?>administration/logout" role="button" data-toggle="dropdown">
						<span class="user-name"><?php if($this->session->userdata('laikipia_admin')){
							echo ($this->session->userdata('laikipia_admin'))['other_name'];
						} 
						else{
							redirect('administration/login');
						}?>
						 </span>
					</a>
					<div class="dropdown-menu dropdown-menu-right">
						
						<a class="dropdown-item" href="<?php echo base_url(); ?>administration/logout"> Log Out</a>
					</div>
				</div>
	
</nav>