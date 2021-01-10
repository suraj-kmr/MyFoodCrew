<div class="page-header">
	<h2>Client Testimonial </h2>
</div>
<div class="row">
	<div class="col-sm-10"></div>

		<div class="col-sm-2">
			<a class="btn pull-right btn-sm btn-primary" href="<?php echo admin_url ('privilege/client-testimonial'); ?>"><i
					class="glyphicon glyphicon-plus-sign"></i> Add New Client</a>
		</div>
	</div>
</form>
<table class="table table-bordered table-striped">
	<thead>
	<tr>
		<th>Client ID</th>
		<th>Client name</th>
      <!--   <th class="hide">Product Type</th> -->
		
		<th>Status</th>
		<th></th>
		
	</tr>
	</thead>
	<tbody>
	<?php
	if (is_array ($client) && count ($client) > 0) {
		foreach ($client as $cat) {
           
			?>
			<tr>
				<td><?= $cat->id; ?></td>
				<td><?= $cat->name; ?></td>
               <!--  <td class="hide"><?= typeStr($cat->product_type); ?></td> -->
			

                
				
				<td>
					<?php
					if ($cat->status == 1) {
						?>
						<a href="<?= admin_url ('privilege/deactivate/' . $cat->id, TRUE); ?>"
						   class="label label-success">Active</a>
					<?php
					} else {
						?>
						<a href="<?= admin_url ('privilege/activate/' . $cat->id, TRUE); ?>"
						   class="label label-danger">Deactive</a>
					<?php
					}
					?>
				</td>
				<td>
					<div class="btn-group pull-right">
						<a href="<?= admin_url ('privilege/client_testimonial/' . $cat->id); ?>" title="Edit"
						   class="btn btn-xs btn-info"><i class="fa fa-pencil"></i> </a>
						<a href="<?= admin_url ('privilege/deletec/' . $cat->id); ?>" title="Delete"
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

