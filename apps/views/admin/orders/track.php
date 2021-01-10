<div class="page-header">
	<h2>Track Orders</h2>
</div>
<form method="get" action="<?= admin_url ('orders'); ?>">
	<div class="row form-search">
		<div class="col-sm-6">

		</div>
		<div class="col-sm-6">
			<div class="input-group">
				<input type="search" name="q" value="" placeholder="e.g Order ID, Tracing Code"
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
		Recent Orders
	</div>
	<div class="widget-content">
		<table class="table table-bordered table-striped table-text-centerd">
			<thead>
			<tr>
				<th>#ID</th>
				<th>Order Date</th>
				<th>Courier Partner</th>
				<th>Tracking Code</th>
				<th>Amount</th>
				<th></th>
			</tr>
			</thead>
			<tbody>
			<?php
			if(is_array($orders) && count($orders) > 0){
				foreach($orders as $ord){
					$lu = $this -> Order_model -> lastUpdateTracking($ord -> tracking_code);
					$courier = '';
					if($lu <> null){
						$courier = $lu -> courier;
					}
					?>
					<tr>
						<td><?= $ord -> id; ?></td>
						<td><?= date('d M, Y', strtotime($ord -> created_on)); ?></td>
						<td><?= $courier; ?></td>
						<td><?= $ord -> tracking_code; ?></td>
						<td><?= $ord -> payment_price; ?></td>
						<td>
							<div class="btn-group pull-right">
								<a href="<?= admin_url('orders/edit-track/'. $ord -> id); ?>" title="Edit" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i> Details</a>
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
