<?php
/**
 * Created by PhpStorm.
 * User: Kamal Kumar
 * Date: 11/27/2014
 * Time: 8:55 AM
 */
?>
<div class="col-sm-12">
	<div class="page-header">
		<h3>Pincode Manager <a href="<?php echo admin_url('settings/addpin'); ?>" class="btn btn-sm btn-primary pull-right">Add Pincode</a> </h3>
	</div>
</div>
<div class="col-sm-12">
	<table class="table table-striped">
		<thead>
		<tr>
			<th>Sl No</th>
			<th>Pincode</th>
			<th>Categories</th>
			<th></th>
		</tr>
		</thead>
		<tbody>
		<?php
		$sl = 1;
		foreach($codes as $row): ?>
			<tr>
				<td><?php echo ++$offset; ?></td>
				<td><?php echo $row -> pincode; ?></td>
				<td><?php
					if($row -> status == 1){
						?>
						<a href="<?= admin_url('settings/dpin/' . $row -> id, true); ?>" class="label label-success">Active</a>
					<?php
					}else{
						?>
						<a href="<?= admin_url('settings/apin/' . $row -> id, true); ?>" class="label label-danger">Deactive</a>
					<?php
					}
					?></td>
				<td>
					<div class="pull-right btn-group">
						<a href="<?php echo admin_url('settings/addpin/'.$row -> id); ?>" class="btn btn-sm btn-default" title="Edit"><i class="fa fa-pencil"></i> </a>
						<a href="<?php echo admin_url('settings/delpin/'.$row -> id); ?>" class="btn btn-sm btn-danger delete" title="Delete"><i class="fa fa-trash"></i> </a>
					</div>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>
<div class="col-sm-12 text-center">
	<?php echo $paginate; ?>
</div>
