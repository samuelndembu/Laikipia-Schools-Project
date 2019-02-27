
<?php echo form_open($this->uri->uri_string(), array("class" => "form-signin","style"=>"padding:20px;background-color:#DCDCDC;border-radius:5px;"));?>
	<img class="mb-4 rounded-circle" src="<?php echo base_url();?>assets/images/lock1.png" alt="" width="90" height="90">
	<h1 class="h3 mb-3 font-weight-normal"><?php echo  $title;?></h1>
	
	<label for="user_email" class="sr-only m">Email address</label>
	<input type="user_email" style="margin-bottom:40px;" id="user_email" name="user_email" class="form-control" placeholder="Email address" required autofocus>
	<label for="user_password" class="sr-only">Password</label>
	<input type="password" style="margin-bottom:40px;" id="user_password"  name="user_password" class="form-control" placeholder="Password" required>
	<button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
<?php echo form_close();