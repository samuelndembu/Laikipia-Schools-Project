<?php
		
		$result = '';
		
		$tasks_search = $this->session->userdata('tasks_search');
		
		//if users exist display them
		if ($query->num_rows() > 0)
		{
			$count = $page;
			
			$result .= 
			'
			<table class="table table-bordered table-striped table-sm display pb-30">
				<thead>
					<tr>
						<th>#</th>
						<th><a href="'.site_url().'customers/tasks/customers.firstName/'.$order_method.'/'.$page.'">First Name</a></th>
						<th><a href="'.site_url().'customers/tasks/customers.lastName/'.$order_method.'/'.$page.'">Last Name</a></th>
						<th><a href="'.site_url().'customers/tasks/customers.username/'.$order_method.'/'.$page.'">Phone</a></th>
						<th><a href="'.site_url().'customers/tasks/task_status.task_status_name/'.$order_method.'/'.$page.'">Status</a></th>
						<th><a href="'.site_url().'customers/tasks/task.created/'.$order_method.'/'.$page.'">Created</a></th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
			';
			
			foreach ($query->result() as $row)
			{
				$task_id = $row->task_id;
				$customer_id = $row->customer_id;
				$firstName = $row->firstName;
				$lastName = $row->lastName;
				$username = $row->username;
				$created = $row->created;
				$task_status_name = $row->task_status_name;
                $created = date('jS M Y H:i a',strtotime($created));

                $customer_gender = $row->customer_gender;
                $customer_location = $row->customer_location;
                $customer_age = $row->customer_age;
				$customer_access_code = $this->tasks_model->get_completion_status($row->customer_access_code);
				$customer_splash_page = $this->tasks_model->get_completion_status($row->customer_splash_page);
				$customer_mpesa = $this->tasks_model->get_completion_status($row->customer_mpesa);
				$customer_autoplay = $this->tasks_model->get_completion_status($row->customer_autoplay);
				$customer_comments = $row->customer_comments;
				$customer_updated_by = $row->customer_updated_by;
                $customer_updated = $row->customer_updated;

                if($task_assignees->num_rows() > 0)
                {
                    foreach($task_assignees->result() as $row)
                    {
                        $personnel_id = $row->personnel_id;
                        $personnel_fname = $row->personnel_fname;
                        $personnel_onames = $row->personnel_onames;
                        $personnel_phone = $row->personnel_phone;
                        //Get task assignee
                        if($customer_updated_by == $personnel_id)
                        {
                            $customer_updated_by = $personnel_fname.' '.$personnel_onames;
                        }
                    }
                }
                
				if($created == "1st Jan 1970 03:00 am" || $created == "30th Nov -0001 00:00 am")
				{
					$created = "";
                }

                $actions = "";
                if($task_status_name == "Assigned")
                {
                    $task_status_name = '<span class="label label-primary">'.$task_status_name.'</span>';
                    $actions .= form_open("customers/update-status", array("onSubmit" => "return confirm('Are you sure you want to select ".$firstName." ".$lastName."?')")).
                    '<input type="hidden" name="task_id" value="'.$task_id.'"/>'.
                    '<input type="hidden" name="task_status_id" value="2"/>'.
                    '<button type="submit" class="btn btn-warning btn-sm">Select Customer</button>'.
                    form_close();
                }

                else if($task_status_name == "In Progress")
                {
                    $task_status_name = '<span class="label label-warning">'.$task_status_name.'</span>';
                    
                    $actions .= '
                        <div id="assign'.$task_id.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    '.form_open("customers/update-customer-task").'
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h5 class="modal-title" id="myModalLabel">Update '.$firstName.' '.$lastName.'</h5>
                                        </div>
                                        <div class="modal-body">
                                            <h5 class="mb-15">Customer Phone: '.$username.'</h5>
                                            <input type="hidden" name="customer_id" value="'.$customer_id.'"/>
                                            <input type="hidden" name="task_id" value="'.$task_id.'"/>
                                            <input type="hidden" name="task_status_id" value="3"/>
                                            <div class="form-group">
                                                <label class="control-label mb-10 text-left">Gender</label>
                                                <div class="radio radio-info">
                                                    <input type="radio" name="gender" value="Male">
                                                    <label for="radio1">
                                                        Male
                                                    </label>
                                                </div>
                                                <div class="radio radio-info">
                                                    <input type="radio" name="gender" value="Female">
                                                    <label for="radio2">
                                                        Female
                                                    </label>
                                                </div>	
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label mb-10 text-left">Location</label>
                                                <input type="text" class="form-control" name="customer_location">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label mb-10 text-left">Age</label>
                                                <input type="number" class="form-control" name="age">
                                            </div>
                                            <h6 class="mt-15">Customer Education</h6>
                                            <div class="form-group">
                                                <div class="checkbox checkbox-primary">
                                                    <input id="access_code'.$task_id.'" type="checkbox" value="1" name="access_code">
                                                    <label for="access_code'.$task_id.'">Access Code</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="checkbox checkbox-primary">
                                                    <input id="splash_page'.$task_id.'" type="checkbox" value="1" name="splash_page">
                                                    <label for="splash_page'.$task_id.'">Splash Page</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="checkbox checkbox-primary">
                                                    <input id="autoplay'.$task_id.'" type="checkbox" value="1" name="autoplay">
                                                    <label for="autoplay'.$task_id.'">Turn off Autoplay</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="checkbox checkbox-primary">
                                                    <input id="mpesa'.$task_id.'" type="checkbox" value="1" name="mpesa">
                                                    <label for="mpesa'.$task_id.'">M-Pesa Training</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label mb-10 text-left">Comments</label>
                                                <textarea class="form-control" name="comments"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-success">Update Customer</button>
                                        </div>
                                    '.form_close().'
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                        <!-- Button trigger modal -->
                        <a href="javascript:void(0)" class="btn btn-sm btn-success" data-toggle="modal" data-target="#assign'.$task_id.'">Update</a>
                    ';

                    $actions .= form_open("customers/update-status", array("onSubmit" => "return confirm('Are you sure you want to defer this customer?')", "class" => "pull-right")).
                        '<input type="hidden" name="task_id" value="'.$task_id.'"/>'.
                        '<input type="hidden" name="task_status_id" value="4"/>'.
                        '<button type="submit" class="btn btn-danger btn-sm">Defer Customer</button>'.
                    form_close();
                }

                else if($task_status_name == "Completed")
                {
                    $task_status_name = '<span class="label label-success">'.$task_status_name.'</span>';

                    $actions .= '
                        <div id="view_customer'.$task_id.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h5 class="modal-title" id="myModalLabel">View '.$firstName.' '.$lastName.'</h5>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-condensed table-hover table-stiped table-bordered">
                                            <tr>
                                                <th>Gender</th>
                                                <td>'.$customer_gender.'</td>
                                            </tr>
                                            <tr>
                                                <th>Location</th>
                                                <td>'.$customer_location.'</td>
                                            </tr>
                                            <tr>
                                                <th>Age</th>
                                                <td>'.$customer_age.'</td>
                                            </tr>
                                            <tr>
                                                <th>Access Code</th>
                                                <td>'.$customer_access_code.'</td>
                                            </tr>
                                            <tr>
                                                <th>Splash Page</th>
                                                <td>'.$customer_splash_page.'</td>
                                            </tr>
                                            <tr>
                                                <th>Turn off Autoplay</th>
                                                <td>'.$customer_autoplay.'</td>
                                            </tr>
                                            <tr>
                                                <th>M-Pesa Training</th>
                                                <td>'.$customer_mpesa.'</td>
                                            </tr>
                                            <tr>
                                                <th>Comments</th>
                                                <td>'.$customer_comments.'</td>
                                            </tr>
                                            <tr>
                                                <th>Updated By</th>
                                                <td>'.$customer_updated_by.'</td>
                                            </tr>
                                            <tr>
                                                <th>Updated On</th>
                                                <td>'.date('jS M Y H:i a',strtotime($customer_updated)).'</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                        <!-- Button trigger modal -->
                        <a href="javascript:void(0)" class="btn btn-sm btn-success" data-toggle="modal" data-target="#view_customer'.$task_id.'">View</a>
                    ';
                }

                else if($task_status_name == "Deferred")
                {
                    $task_status_name = '<span class="label label-danger">'.$task_status_name.'</span>';
                }
				
				$count++;
				$result .= 
				'
					<tr>
						<td>'.$count.'</td>
						<td>'.$firstName.'</td>
						<td>'.$lastName.'</td>
						<td>'.$username.'</td>
						<td>'.$task_status_name.'</td>
						<td>'.$created.'</td>
                        <td>
                            '.$actions.'
                        </td>
					</tr> 
				';
			}
			
			$result .= 
			'
						  </tbody>
						</table>
			';
		}
		
		else
		{
			$result .= "You have no tasks assigned";
		}
?>

<div class="panel panel-default card-view">
	<div class="panel-wrapper collapse in">
		<div class="panel-body">
			<?php echo form_open("customers/search-tasks");?>
				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label class="control-label mb-10">Customer Phone</label>
                            <input type="number" name="customer_phone"  class="form-control">
						</div>
					</div>
                    <div class="col-md-3">
						<div class="form-group">
							<label class="control-label mb-10">Task Status</label>
							<select class="form-control select2" name="task_status">
								<option value="">---Select Task Status---</option>
								<?php 
									if($task_statuses->num_rows() > 0)
									{
										foreach($task_statuses->result() as $row)
										{
											$task_status_id = $row->task_status_id;
											$task_status_name = $row->task_status_name;
											echo '<option value="'.$task_status_id.'|'.$task_status_name.'">'.$task_status_name.'</option>';
										}
									}
								?>
							</select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label class="control-label mb-10 text-left">Date Assigned</label>
							<input class="form-control input-daterange-datepicker" type="text" name="daterange" autocomplete="off"/>
							<a href="javascript:void(0);" onClick="clearDateRange()">Clear</a>
						</div>
					</div>
					<div class="col-md-3 mt-30">
						<!-- <a href="<?php echo site_url()."customers/export-tasks"?>" target="_blank" class="btn btn-success pull-right"><i class="fa fa-file-excel-o"></i> Export</a> -->
						<?php
						if(!empty($tasks_search))
						{
							?>
							<a href="<?php echo site_url()."customers/close-tasks-search"?>" class="btn btn-default pull-right"><i class="fa fa-search"></i> Close Search</a>
							<?php
						}
						?>
						<button type="submit" class="btn btn-warning pull-right"><i class="fa fa-search"></i> Search</button>
					</div>
				</div>
			<?php echo form_close();?>
			<div class="table-wrap">
                <div class="table-responsive">
                    <?php echo $result;?>
                </div>

                <div class="row mb-20">
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-6">
                        <div class="pull-right">
                            <?php if(isset($links)){echo $links;}?>
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>