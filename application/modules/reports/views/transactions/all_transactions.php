<?php
		
		$result = '';
		
		$transactions_search = $this->session->userdata('transactions_search');
		
		//if users exist display them
		if ($query->num_rows() > 0)
		{
			$count = $page;
			
			$result .= 
			'
			<table class="table table-bordered table-striped table-sm display pb-30">
				<thead>
					<tr>
						<th>
							<div class="checkbox checkbox-primary">
								<input id="allcheckbox" type="checkbox">
								<label for="allcheckbox"></label>
							</div>
						</th>
						<th>#</th>
						<th><a href="'.site_url().'reports/transactions/agents.firstName/'.$order_method.'/'.$page.'">Merchant</a></th>
						<th><a href="'.site_url().'reports/transactions/agents.cell/'.$order_method.'/'.$page.'">Merchant Phone</a></th>
						<th><a href="'.site_url().'reports/transactions/customers.firstName/'.$order_method.'/'.$page.'">Customer</a></th>
						<th><a href="'.site_url().'reports/transactions/customers.username/'.$order_method.'/'.$page.'">Customer Phone</a></th>
						<th><a href="'.site_url().'reports/transactions/customers.merchant_location/'.$order_method.'/'.$page.'">Location</a></th>
						<th><a href="'.site_url().'reports/transactions/mpesa_customer_register.created_at/'.$order_method.'/'.$page.'">Created On</a></th>
					</tr>
				</thead>
				<tbody>
			';
			
			foreach ($query->result() as $row)
			{
				$mpesa_customer_register_id = $row->mpesa_customer_register_id;
				$agent_firstName = $row->agent_firstName;
				$agent_lastName = $row->agent_lastName;
				$agent_phoneNumber = $row->agent_phoneNumber;
				$full_name = $row->full_name;
				$merchant_location = $row->merchant_location;
				$created_at = $row->created_at;
				$phone_number = $row->phone_number;
				
				$count++;
				$result .= 
				'
					<tr>
						<td>
							<div class="checkbox checkbox-primary">
								<input id="checkbox'.$mpesa_customer_register_id.'" type="checkbox" value="'.$mpesa_customer_register_id.'" name="mpesa_customer_register_id[]">
								<label for="checkbox'.$mpesa_customer_register_id.'"></label>
							</div>
						</td>
						<td>'.$count.'</td>
						<td>'.$agent_firstName.' '.$agent_lastName.'</td>
						<td>'.$agent_phoneNumber.'</td>
						<td>'.$full_name.'</td>
						<td>'.$phone_number.'</td>
						<td>'.$merchant_location.'</td>
						<td>'.date('jS M Y H:i a',strtotime($row->created_at)).'</td>
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
			$result .= "There are no transactions";
		}
?>

				<div class="panel panel-default card-view">
					<div class="panel-wrapper collapse in">
						<div class="panel-body">
							<?php echo form_open("reports/search-transactions");?>
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<label class="control-label mb-10">Customer</label>
											<select class="form-control select2" name="customer_phone">
												<option value="">---Select Customer---</option>
												<?php 
													if($transacted_customers->num_rows() > 0)
													{
														foreach($transacted_customers->result() as $row)
														{
															$customer_phone = $row->msisdn;
															if(!empty($customer_phone))
															{
																echo '<option value="'.$customer_phone.'">'.$customer_phone.'</option>';
															}
														}
													}
												?>
											</select>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label class="control-label mb-10">Merchant</label>
											<select class="form-control select2" name="merchant_phone">
												<option value="">Select Merchant</option>
												<?php 
													if($transacted_agents->num_rows() > 0)
													{
														foreach($transacted_agents->result() as $row)
														{
															if(!empty($row->agent_phoneNumber))
															{
																echo '<option value="'.$row->agent_phoneNumber.'">'.$row->agent_firstName.' '.$row->agent_lastName.' '.$row->agent_phoneNumber.'</option>';
															}
														}
													}
												?>
											</select>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label class="control-label mb-10 text-left">Date</label>
											<input class="form-control input-daterange-datepicker" type="text" name="daterange" value="sdfs"/>
											<a href="javascript:void(0);" onClick="clearDateRange()">Clear</a>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label class="control-label mb-10">Location</label>
											<select class="form-control select2" name="transaction_location">
												<option value="">Select Location</option>
												<?php 
													if($transacted_locations->num_rows() > 0)
													{
														foreach($transacted_locations->result() as $row)
														{
															if(!empty($row->merchant_location))
															{
																echo '<option value="'.$row->merchant_location.'">'.$row->merchant_location.'</option>';
															}
														}
													}
												?>
											</select>
										</div>
									</div>
								</div>

								<div class="row mb-20">
									<div class="col-md-12">
										<button type="submit" class="btn btn-warning pull-right"><i class="fa fa-search"></i> Search</button>
										<a href="<?php echo site_url()."reports/payments/get-false-payments"?>" target="_blank" class="btn btn-primary pull-right"><i class="fa fa-download"></i> Unverified Customers</a>
										<a href="<?php echo site_url()."reports/export-transactions"?>" target="_blank" class="btn btn-success pull-right"><i class="fa fa-file-excel-o"></i> Export</a>
										<?php
										if(!empty($transactions_search))
										{
											?>
											<a href="<?php echo site_url()."reports/close-search"?>" class="btn btn-default pull-right"><i class="fa fa-search"></i> Close Search</a>
											<?php
										}
										?>
									</div>
								</div>
							<?php echo form_close();?>
							<div class="table-wrap">
								<?php echo form_open("reports/transactions/bulk-actions", array("OnSubmit" => "return confirm('Are you sure you want to carry out the selected bulk action?')"));?>
									<div class="table-responsive">
										<?php echo $result;?>
									</div>
									<div class="row mb-20">
										<div class="col-md-6">
											<div class="row">
												<div class="col-md-8">
													<select class="form-control" required name="action_name">
														<option value="">---Select Bulk Action</option>
														<option value="delete">Delete</option>
													</select>
												</div>
												<div class="col-md-4">
													<button type="submit" class="btn btn-danger pull-right"> Go</button>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="pull-right">
												<?php if(isset($links)){echo $links;}?>
											</div>
										</div>
									</div>
								<?php echo form_close();?>
							</div>
						</div>
					</div>
				</div>
