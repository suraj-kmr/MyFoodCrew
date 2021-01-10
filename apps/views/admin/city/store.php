<div class="page-header">
	<h2>Store</h2>
	<div class="row">
		<div class="col-sm-6">
			<form method="get" action="<?= current_url(); ?>">
				<div class="input-group">
					<input type="text" name="q" value="" class="form-control input-sm" />
					<div class="input-group-btn">
						<input type="submit" name="btn_search" value="Seach" class="btn btn-primary btn-sm" />
					</div>
				</div>
			</form>
		</div>
		<div class="col-sm-6 text-right">
			<a class="btn btn-sm btn-primary" href="<?php echo admin_url('city/addstore'); ?>"><i class="glyphicon glyphicon-plus-sign"></i> Add New Store</a>
		</div>
	</div>
</div>

<table class="table table-striped">
    <thead>
		<tr>
			<th>Store ID</th>
			<th>Store Name</th>
            <th>Store Address</th>
            <th>Mobile No</th>
            <th>Email</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php if(!is_array($store) && count($store) == 0) echo '<tr><td style="text-align:center;" colspan="3">No Occupation Found</td></tr>'?>

		<?php if(is_array($store) && count($store) > 0) { foreach($store as $row): ?>
        	<tr>
            	<td><?php echo $row->id; ?></td>
            	<td><?php echo $row->store_name; ?></td>
                <td><?php echo $row->address; ?></td>
                <td><?php echo $row->mobile; ?></td>
                <td><?php echo $row -> email_id; ?></td>
                <td>
					<div class="btn-group pull-right">
                        <a href="<?= admin_url('city/addstore/'.$row -> id); ?>" class="btn btn-sm btn-default"><i class="fa fa-pencil"></i> Edit</a>
                        <a href="<?= admin_url('city/deletestore/'.$row -> id);?>" class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i> Delete</a>
                    </div>
				<?php

				?></td>
        	</tr>
        <?php endforeach; } ?>
	</tbody>
</table>
<div class="pagination pagination-sm">
	<?php echo $paginate; ?>
</div>
