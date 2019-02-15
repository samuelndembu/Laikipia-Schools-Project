<?php
		
		$result = '';
		
		$merchants_search = $this->session->userdata('merchants_search');
		
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
						<th><a href="'.site_url().'reports/merchants/agents.cell/'.$order_method.'/'.$page.'">Merchant Phone</a></th>
						<th><a href="'.site_url().'reports/merchants/agents.username/'.$order_method.'/'.$page.'">Username</a></th>
						<th><a href="'.site_url().'reports/merchants/agents.firstName/'.$order_method.'/'.$page.'">First Name</a></th>
						<th><a href="'.site_url().'reports/merchants/agents.lastName/'.$order_method.'/'.$page.'">Last Name</a></th>
						<th><a href="'.site_url().'reports/merchants/agents.city/'.$order_method.'/'.$page.'">Customer Phone</a></th>
						<th><a href="'.site_url().'reports/merchants/agents.inserted/'.$order_method.'/'.$page.'">Created On</a></th>
					</tr>
				</thead>
				<tbody>
			';
			
			foreach ($query->result() as $row)
			{
				$agent_id = $row->agent_id;
				$cell = $row->cell;
				$username = $row->username;
				$firstName = $row->firstName;
				$lastName = $row->lastName;
				$city = $row->city;
				$inserted = $row->inserted;
				
				$count++;
				$result .= 
				'
					<tr>
						<td>
							<div class="checkbox checkbox-primary">
								<input id="checkbox'.$agent_id.'" type="checkbox" value="'.$agent_id.'" name="agent_id[]">
								<label for="checkbox'.$agent_id.'"></label>
							</div>
						</td>
						<td>'.$count.'</td>
						<td>'.$cell.'</td>
						<td>'.$username.'</td>
						<td>'.$firstName.'</td>
						<td>'.$lastName.'</td>
						<td>'.$city.'</td>
						<td>'.date('jS M Y H:i a',strtotime($row->inserted)).'</td>
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
			$result .= "There are no merchants";
		}
?>

<div class="panel panel-default card-view">
	<div class="panel-wrapper collapse in">
		<div class="panel-body">
			<?php echo form_open("reports/search-merchants");?>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label mb-10">Merchant</label>
							<select class="form-control select2" name="agent_id">
								<option value="">Select Merchant</option>
								<?php 
									if($transacted_merchants->num_rows() > 0)
									{
										foreach($transacted_merchants->result() as $row)
										{
											if(!empty($row->agent_id))
											{
												echo '<option value="'.$row->agent_id.'">'.$row->firstName.' '.$row->lastName.' '.$row->cell.'</option>';
											}
										}
									}
								?>
							</select>
						</div>
					</div>
					<div class="col-md-6 mt-30">
						<button type="submit" class="btn btn-warning pull-right"><i class="fa fa-search"></i> Search</button>
							<a href="<?php echo site_url()."reports/export-merchants"?>" target="_blank" class="btn btn-success pull-right"><i class="fa fa-file-excel-o"></i> Export</a>
							<?php
							if(!empty($merchants_search))
							{
								?>
								<a href="<?php echo site_url()."reports/close-merchants-search"?>" class="btn btn-default pull-right"><i class="fa fa-search"></i> Close Search</a>
								<?php
							}
							?>
					</div>
				</div>

			<?php echo form_close();?>
			<div class="table-wrap">
				<?php echo form_open("reports/merchants/bulk-actions", array("OnSubmit" => "return confirm('Are you sure you want to carry out the selected bulk action?')"));?>
					<div class="table-responsive">
						<?php echo $result;?>
					</div>
					<div class="row mb-20">
						<div class="col-md-6">
							<div class="row">
								<div class="col-md-8">
									<select class="form-control" required name="action_name">
										<option value="">---Select Bulk Action</option>
										<option value="reset">Reset Password</option>
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
