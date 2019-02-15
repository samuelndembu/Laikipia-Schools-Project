<div class="card shadow mb-4">
	<div class="card-header py-3">
    <!-- <button type="button" class="btn btn-success">Add Partner</button> -->
    <?php echo anchor("laikipiaschools/partners/create_partner","Add Partner","class='btn btn-success'");?>

	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>#</th>
						<th>PartnerType</th>
						<th>PartnerName</th> 
						<th>PartnerEmail</th>
                        <th>PartnerLogo</th>
                        <th>Actions</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
                    <th>#</th>
						<th>PartnerType</th>
						<th>PartnerName</th> 
						<th>PartnerEmail</th>
                        <th>PartnerLogo</th>
                        <th>Actions</th>
					</tr>
				</tfoot>
				<tbody>
					<?php 
                    if($query->num_rows() > 0)
                    {
                        $count = 0;
                        foreach($query->result() as $row)
                        {
							$count++;
                            ?>
					<tr>
						<td>
							<?php echo $count?>
						</td>
						<td>
							<?php echo $row->partner_type_name;?>
						</td>
						<td>
							<?php echo $row->partner_name;?>
                        </td>
                        <td>
							<?php echo $row->partner_email;?>
                        </td>
                        <td>
							<?php echo $row->partner_logo;?>
						</td>
						<td>
						<!-- <?php echo anchor("laikipiaschools/addpartner","View","class='btn btn-info'");?> -->
						<?php echo anchor("laikipiaschools/edit/". $row->partner_id,"Edit","class='btn btn-warning'");?>
						<?php echo anchor("laikipiaschools/delete-partner/". $row->partner_id,"Delete","class='btn btn-danger'");?>
							
						</td>
					</tr>
					<?php
                        }
                    }
                    ?>
				</tbody>
			</table>
		</div>

		<p>
		
		</p>
	</div>
</div>
