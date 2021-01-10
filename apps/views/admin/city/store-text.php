<div class="page-header">
	<h2>Store Page Text</h2>
	<div class="row">
		<!--<div class="col-sm-6 text-right">
			<a class="btn btn-sm btn-primary" href="<?php echo admin_url('city/add'); ?>"><i class="glyphicon glyphicon-plus-sign"></i> Add New City</a>
		</div>-->
	</div>
</div>

<table class="table table-striped">
    <thead>
		<tr>
			<th>ID</th>
			<th>Text</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php if(!is_array($store_text) && count($store_text) == 0) echo '<tr><td style="text-align:center;" colspan="3">No Occupation Found</td></tr>'?>

		<?php if(is_array($store_text) && count($store_text) > 0) { foreach($store_text as $row): ?>
        	<tr>
            	<td><?php echo $row->id; ?></td>
            	<td><?php echo $row->description; ?></td>
                <td>
					<div class="btn-group pull-right">
                        <a href="<?= admin_url('city/addstore_text/'.$row -> id); ?>" class="btn btn-sm btn-default"><i class="fa fa-pencil"></i> Edit</a>
                        <!--<a href="<?= admin_url('city/deletestore_text/'.$row -> id);?>" class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i> Delete</a>-->
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
