<div class="page-header">
	<h2>Coupons </h2>
</div>
<form method="get" action="<?= admin_url ('coupons'); ?>">
	<div class="row form-search">
		<div class="col-sm-6">
			<div class="input-group">
				<input type="search" name="q" value="" placeholder="e.g Coupon Code Title ID Expiry Date"
				       class="form-control input-sm"/>

				<div class="input-group-btn">
					<button type="submit" name="btnsearch" value="Search" class="btn btn-sm btn-primary"><i
							class="fa fa-search"></i> Search
					</button>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<a class="btn pull-right btn-sm btn-primary" href="<?php echo admin_url ('coupons/add'); ?>"><i
					class="glyphicon glyphicon-plus-sign"></i> Add New Coupons</a>
		</div>
	</div>
</form>
<table class="table table-bordered table-striped">
	<thead>
	<tr>
		<th>ID</th>
		<th>Title</th>
        <th>Coupon Code</th>
        <th>Discount (%)</th>
		<th>Expiry Date</th>
		<th>No of Uses</th>
		<th>Date Created</th>
        <th>Status</th>
		<th></th>
	</tr>
	</thead>
	<tbody>
	<?php
	if (is_array ($coupons) && count ($coupons) > 0) {
		foreach ($coupons as $fr) {
            //$ob = new AI_Category($cat -> id);
			?>
			<tr>
				<td><?= $fr->id; ?></td>
                <td><?= $fr->title; ?></td>
				<td><?= $fr->coupon_code; ?></td>
                <td><?= $fr->discount; ?></td>
				<td><?= $fr->validity; ?></td>
				<td><?= $fr->no_of_use; ?></td>
                <td><?= $fr->created; ?></td>
                <td><?php
                    if ($fr->status == 1) {
                        ?>
                        <a href="<?= admin_url ('coupons/deactivate/' . $fr->id); ?>"
                           class="label label-success">Active</a>
                    <?php
                    } else {
                        ?>
                        <a href="<?= admin_url ('coupons/activate/' . $fr->id); ?>"
                           class="label label-danger">Deactive</a>
                    <?php
                    }
                    ?></td>
                <td>
					<div class="btn-group pull-right">
						<a href="<?= admin_url ('coupons/add/' . $fr->id); ?>" title="Edit"
						   class="btn btn-xs btn-info"><i class="fa fa-pencil"></i> </a>
						<a href="<?= admin_url ('coupons/delete/' . $fr->id); ?>" title="Delete"
						   class="btn btn-xs btn-danger delete"><i class="fa fa-trash"></i> </a>
					</div>
				</td>
			</tr>
		<?php
		}
	}
	?>
	</tbody>
</table>
<div class="pagination pagination-small">
	<?= $paginate; ?>
</div>
