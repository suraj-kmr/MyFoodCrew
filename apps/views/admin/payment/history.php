
<form method="get" action="<?= admin_url ('payment/history'); ?>">
	<div class="row form-search">
		<div class="col-sm-6">

		</div>
		<div class="col-sm-6">
			<div class="input-group">
				<input type="search" name="q" value="" placeholder="e.g User Id"
				       class="form-control input-sm"/>

				<div class="input-group-btn">
					<button type="submit" name="btnsearch" value="Search" class="btn btn-sm btn-primary"><i
							class="fa fa-search"></i> Search
					</button>
				</div>
			</div>
		</div>
	</div>
</form>
<div class="widget">
	<div class="widget-head">
		Payout History
	</div>
	<div class="widget-content">
		<table class="table table-bordered table-striped table-text-centerd">
			<thead>
			<tr>
				<th>#SL No.</th>
				<th>Order ID</th>
				<th>User Name</th>
				<!-- <th>Payment ID</th> -->
				<th>Payment Price</th>
				<th>Total</th>
				
				<!-- <th>Payment Status</th> -->
				<!-- <th>Delivery On</th> -->
				<th></th>
			</tr>
			</thead>
			<tbody>
			<?php
			if(is_array($orders) && count($orders) > 0){
				$i=1;
				foreach($orders as $ord){
					?>
					<tr>
						<td><?= $i++; ?></td>
						<td><?= $ord ->id;?></td>
						<td><?php
						$u=$this->db->get_where('users',array('id'=>$ord->user_id))->row();
						echo $u->username;
						 ?></td>
						<!-- <td><?= $ord -> payment_id;?></td> -->
						<td><?= $ord -> payment_price;?></td>
						<td><?= $ord -> total;?></td>
						<!-- <td><?= $ord -> pay_status;?></td> -->
						<!-- <td><?= $ord -> delivery_on;?></td> -->
						
						<td>
							<div class="btn-group pull-right">
								<a href="<?= admin_url('payment/detail/'. $ord -> id); ?>" title="Edit" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i> Details</a>
							</div>
						</td>
					</tr>
				<?php
				}
			}
			?>
			</tbody>
		</table>
	</div>
</div>
<div class="pagination pagination-small">
	<?= $paginate; ?>
</div>
