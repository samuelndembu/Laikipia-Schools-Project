<?php
		
		$result = '';
		
		$customers_search = $this->session->userdata('customers_search');
		
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
						<th><a href="'.site_url().'customers/all-customers/customers.firstName/'.$order_method.'/'.$page.'">First Name</a></th>
						<th><a href="'.site_url().'customers/all-customers/customers.lastName/'.$order_method.'/'.$page.'">Last Name</a></th>
						<th><a href="'.site_url().'customers/all-customers/customers.username/'.$order_method.'/'.$page.'">Phone</a></th>
						<th><a href="'.site_url().'customers/all-customers/task_status.task_status_name/'.$order_method.'/'.$page.'">Status</a></th>
						<th>Assigned To</th>
						<th><a href="'.site_url().'customers/all-customers/customers.inserted/'.$order_method.'/'.$page.'">Created</a></th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
			';
			
			foreach ($query->result() as $row)
			{
				$customer_id = $row->customer_id;
				$firstName = $row->firstName;
				$lastName = $row->lastName;
				$city = $row->city;
				$username = $row->username;
				$inserted = $row->inserted;
                $task_assignee = $row->task_assignee;
                $task_status_name = $row->task_status_name;
                $assigned_to = "";

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

				$inserted = date('jS M Y H:i a',strtotime($inserted));
                $assign_action = '';

				if($inserted == "1st Jan 1970 03:00 am" || $inserted == "30th Nov -0001 00:00 am")
				{
					$inserted = "";
                }

                else if($task_status_name == "Assigned")
                {
                    $task_status_name = '<span class="label label-primary">'.$task_status_name.'</span>';
                }

                else if($task_status_name == "In Progress")
                {
                    $task_status_name = '<span class="label label-warning">'.$task_status_name.'</span>';
                }

                else if($task_status_name == "Completed")
                {
                    $task_status_name = '<span class="label label-success">'.$task_status_name.'</span>';

                    $assign_action .= '
                        <div id="view_customer'.$customer_id.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                        <a href="javascript:void(0)" class="btn btn-sm btn-success" data-toggle="modal" data-target="#view_customer'.$customer_id.'">View</a>
                    ';
                }

                else if($task_status_name == "Deferred")
                {
                    $task_status_name = '<span class="label label-danger">'.$task_status_name.'</span>';
                }

                else
                {
                    $assign_action = '
                    <!-- sample modal content -->
                        <div id="assign'.$customer_id.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    '.form_open("customers/assign-customer").'
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h5 class="modal-title" id="myModalLabel">Assign '.$firstName.' '.$lastName.'</h5>
                                        </div>
                                        <div class="modal-body">
                                            <h5 class="mb-15">Customer Phone: '.$username.'</h5>
                                            <input type="hidden" name="customer_id" value="'.$customer_id.'"/>
                                            <div class="form-group">
                                                <label class="control-label mb-10">Assignee</label>
                                                <select class="form-control select2" name="personnel_id">
                                                    <option value="">---Select Assignee---</option>
                                                    '.$assignees.'
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-info">Assign Customer</button>
                                        </div>
                                    '.form_close().'
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                        <!-- Button trigger modal -->
                        <a href="javascript:void(0)" class="btn btn-sm btn-info" data-toggle="modal" data-target="#assign'.$customer_id.'">Assign</a>
                    ';
                }

                $assignees = "";
                if($task_assignees->num_rows() > 0)
                {
                    foreach($task_assignees->result() as $row)
                    {
                        $personnel_id = $row->personnel_id;
                        $personnel_fname = $row->personnel_fname;
                        $personnel_onames = $row->personnel_onames;
                        $personnel_phone = $row->personnel_phone;

                        $assignees .= '<option value="'.$personnel_id.'">'.$personnel_fname.' '.$personnel_onames.' '.$personnel_phone.'</option>';

                        //Get task assignee
                        if($task_assignee == $personnel_id)
                        {
                            $assigned_to = $personnel_fname.' '.$personnel_onames;
                        }

                        if($customer_updated_by == $personnel_id)
                        {
                            $customer_updated_by = $personnel_fname.' '.$personnel_onames;
                        }
                    }
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
						<td>'.$assigned_to.'</td>
						<td>'.$inserted.'</td>
                        <td>
                            '.$assign_action.'
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
			$result .= "There are no customers";
		}
?>

<div class="panel panel-default card-view">
	<div class="panel-wrapper collapse in">
		<div class="panel-body">
			<?php echo form_open("customers/search-customers");?>
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
							<label class="control-label mb-10 text-left">Date Registered</label>
							<input class="form-control input-daterange-datepicker" type="text" name="daterange" autocomplete="off"/>
							<a href="javascript:void(0);" onClick="clearDateRange()">Clear</a>
						</div>
					</div>
					<div class="col-md-3 mt-30">
						<!-- <a href="<?php echo site_url()."customers/export-customers"?>" target="_blank" class="btn btn-success pull-right"><i class="fa fa-file-excel-o"></i> Export</a> -->
						<?php
						if(!empty($customers_search))
						{
							?>
							<a href="<?php echo site_url()."customers/close-customers-search"?>" class="btn btn-default pull-right"><i class="fa fa-search"></i> Close Search</a>
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