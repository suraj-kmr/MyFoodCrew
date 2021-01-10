<div class="page-header">
	<h2>Rencent Canceled Orders</h2>
</div>
<form method="get" action="<?= admin_url ('orders'); ?>">
	<div class="row form-search">
		<div class="col-sm-6">

		</div>
		<div class="col-sm-6">
			<div class="input-group">
				<input type="search" name="q" value="" placeholder="e.g Order ID"
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
		Canceled Orders
	</div>
	<div class="widget-content">
		<table class="table table-bordered table-striped table-text-centerd">
			<thead>
			<tr>
				<th>#ID</th>
				<th>Product</th>
				<th>Date</th>
				<th>Quantity</th>
				<th>Amount</th>
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
                        <td>Rs <?= $ord -> product_name; ?></td>
						<td><?= date('d M, Y', strtotime($ord -> modified_on)); ?></td>

						<td><?= $ord -> quantity; ?></td>
						<td><?= $ord -> subtotal_price; ?></td>
						<td>
							<div class="btn-group pull-right">
								<!--<a href="<?= admin_url('orders/details/'. $ord -> id); ?>" title="Edit" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i> Details</a>-->
								<a href="<?= admin_url('orders/delete/'. $ord -> id, true); ?>" title="Delete" class="btn btn-xs btn-danger delete"><i class="fa fa-trash"></i> </a>
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
	<?php // $paginate; ?>
</div>
