<div class="page-header">
	<h2>Events </h2>
</div><div class="btn-group pull-right">
    <a href="<?= admin_url ('categories/add_event/'); ?>" title="Edit"
       class="btn btn-xs btn-info"><i class="fa fa-plus"></i> New Event </a>
</div>
<table class="table table-bordered table-striped">
	<thead>
	<tr>
		<th>Event ID</th>
        <th>Image</th>
		<th>Event name</th>
		<th>Sequence</th>
		<th></th>
	</tr>
	</thead>
	<tbody>
	<?php
	if (is_array ($events) && count ($events) > 0) {
		foreach ($events as $cat) {
			?>
			<tr>
				<td><?= $cat->id; ?></td>
                <td><img src="<?= site_url(upload_dir($cat->image)); ?>" class="img-thumbnail" style="height: 100px"/></td>
                <td><?= $cat->event_name; ?></td>
				<td><?= $cat->sequence; ?></td>
				<td>
					<div class="btn-group pull-right">
						<a href="<?= admin_url ('categories/add_event/' . $cat->id); ?>" title="Edit"
						   class="btn btn-xs btn-info"><i class="fa fa-pencil"></i> </a>
						<a href="<?= admin_url ('categories/delete_event/' . $cat->id); ?>" title="Delete"
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
</div>
