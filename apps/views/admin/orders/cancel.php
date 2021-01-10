<div class="page-header">
	<h2>Cancel Orders</h2>
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
		Recent Cancel Orders
	</div>
	<div class="widget-content">
		<table class="table table-bordered table-striped table-text-centerd">
			<thead>
			<tr>
				<th>#ID</th>
				<th>Order ID</th>
				<th>Product ID</th>
				<th>User ID</th>
				<th>Status</th>
				<th></th>
			</tr>
			</thead>
			<tbody>
			<?php
			if(is_array($orders) && count($orders) > 0){
				foreach($orders as $ord){
					?>
					<tr>
						<td><?= $ord -> id; ?></td>
						<td><?= $ord -> order_id;?></td>
						<td><?= $ord -> product_id;?></td>
						<td><?= $ord -> user_id;?></td>
						<td><?php 
								if($ord -> status == 0){ 
									echo "processing"; 
								} elseif($ord -> status == 1){
									echo "Canceled"; 
								} ?>
						</td>
						<td>
							<div class="btn-group pull-right">
								<a href="<?= admin_url('orders/edit-cancel/'. $ord -> id); ?>" title="Edit" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i> Details</a>
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
