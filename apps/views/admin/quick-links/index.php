<div class="page-header">
	<h2>Quick Links </h2>
</div>
<form method="get" action="<?= admin_url ('categories'); ?>">
	<div class="row form-search">
		<div class="col-sm-6">
			<!--<div class="input-group">
				<input type="search" name="q" value="" placeholder="e.g Category Title, ID"
				       class="form-control input-sm"/>

				<div class="input-group-btn">
					<button type="submit" name="btnsearch" value="Search" class="btn btn-sm btn-primary"><i
							class="fa fa-search"></i> Search
					</button>
				</div>
			</div>-->
		</div>
		<div class="col-sm-6">
			<a class="btn pull-right btn-sm btn-primary" href="<?php echo admin_url ('categories/add?type=link'); ?>"><i
					class="glyphicon glyphicon-plus-sign"></i> Add New Quick Link</a>
		</div>
	</div>
</form>

<table class="table table-bordered table-striped">
	<thead>
	<tr>
		<th>Link ID</th>
		<th>Link name</th>
        <th>Link URL</th>
        <th>Type</th>
		<th></th>
	</tr>
	</thead>
	<tbody>
	<?php
	if (is_array ($categories) && count ($categories) > 0) {
		foreach ($categories as $cat) {
            $ob = new AI_Category($cat -> id);
			?>
			<tr>
				<td><?= $cat->id; ?></td>
				<td><a href="<?= $ob -> permalink(); ?>" target="_blank"><?= $cat->name; ?></a></td>
                <td><?= $cat->slug; ?></td>
                <td>
                    <?php
                    if ($cat->status == 1) {
                        ?>
                        <span class="label label-success">New</span>
                        <?php
                    } elseif($cat->status == 2) {
                        ?>
                        <span class="label label-danger">Hot</span>
                        <?php
                    }else{
                        ?>
                        <span class="label label-default">None</span>
                        <?php
                    }
                    ?>
                </td>
				<td>
					<div class="btn-group pull-right">
						<a href="<?= admin_url ('categories/add/' . $cat->id.'?type=link'); ?>" title="Edit"
						   class="btn btn-xs btn-info"><i class="fa fa-pencil"></i> </a>
						<a href="<?= admin_url ('categories/delete_link/' . $cat->id); ?>" title="Delete"
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
