<?php
		
		$result = '';
		
		$payments_search = $this->session->userdata('payments_search');
		
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
						<th><a href="'.site_url().'reports/payments/msisdn/'.$order_method.'/'.$page.'">Customer</a></th>
						<th><a href="'.site_url().'reports/payments/amount/'.$order_method.'/'.$page.'">Amount</a></th>
						<th><a href="'.site_url().'reports/payments/resultCode/'.$order_method.'/'.$page.'">Result Code</a></th>
						<th><a href="'.site_url().'reports/payments/mpesaReceiptNumber/'.$order_method.'/'.$page.'">Transaction Code</a></th>
						<th><a href="'.site_url().'reports/payments/resultReceived/'.$order_method.'/'.$page.'">Date</a></th>
					</tr>
				</thead>
				<tbody>
			';
			
			foreach ($query->result() as $row)
			{
				$mpesalipatransaction_id = $row->mpesalipatransaction_id;
				$msisdn = $row->msisdn;
				$mpesaReceiptNumber = $row->mpesaReceiptNumber;
				$amount = $row->amount;
				$resultCode = $row->resultCode;
				$resultReceived = $row->resultReceived;
				$resultReceived = date('jS M Y H:i a',strtotime($resultReceived));
				if($resultReceived == "1st Jan 1970 03:00 am" || $resultReceived == "30th Nov -0001 00:00 am")
				{
					$resultReceived = "";
				}
				
				$count++;
				$result .= 
				'
					<tr>
						<td>'.$count.'</td>
						<td>'.$msisdn.'</td>
						<td>'.$amount.'</td>
						<td>'.$resultCode.'</td>
						<td>'.$mpesaReceiptNumber.'</td>
						<td>'.$resultReceived.'</td>
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
			$result .= "There are no payments";
		}
?>

<div class="panel panel-default card-view">
	<div class="panel-wrapper collapse in">
		<div class="panel-body">
			<?php echo form_open("reports/search-payments");?>
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
							<label class="control-label mb-10">Result Code</label>
							<select class="form-control select2" name="result_code">
								<option value="">---Select Result Code---</option>
								<option value="zero">0</option>
								<?php 
									if($result_codes->num_rows() > 0)
									{
										foreach($result_codes->result() as $row)
										{
											$result_code = $row->resultCode;
											if(!empty($result_code))
											{
												echo '<option value="'.$result_code.'">'.$result_code.'</option>';
											}
										}
									}
								?>
							</select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label class="control-label mb-10">Transaction Code</label>
							<select class="form-control select2" name="transaction_code">
								<option value="">---Select Transaction Code---</option>
								<option value="0">0</option>
								<?php 
									if($transaction_codes->num_rows() > 0)
									{
										foreach($transaction_codes->result() as $row)
										{
											$transaction_code = $row->mpesaReceiptNumber;
											if(!empty($transaction_code))
											{
												echo '<option value="'.$transaction_code.'">'.$transaction_code.'</option>';
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
				</div>
				<div class="row">
					<div class="col-md-12">
						<a href="<?php echo site_url()."reports/export-payments"?>" target="_blank" class="btn btn-success pull-right"><i class="fa fa-file-excel-o"></i> Export</a>
						<?php
						if(!empty($payments_search))
						{
							?>
							<a href="<?php echo site_url()."reports/close-payments-search"?>" class="btn btn-default pull-right"><i class="fa fa-search"></i> Close Search</a>
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
					<div class="col-md-12">
						<div class="pull-right">
							<?php if(isset($links)){echo $links;}?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>