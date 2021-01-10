<div class="page-header">
	<h2>Franchisee</h2>
</div>
<form method="get" action="<?= admin_url ('franchisee'); ?>">
	<div class="row form-search">
		<div class="col-sm-6">
			<div class="input-group">
				<input type="search" name="q" value="" placeholder="e.g Name Email, ID"
				       class="form-control input-sm"/>

				<div class="input-group-btn">
					<button type="submit" name="btnsearch" value="Search" class="btn btn-sm btn-primary"><i
							class="fa fa-search"></i> Search
					</button>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<a class="btn pull-right btn-sm btn-primary" href="<?php echo admin_url ('franchisee/add'); ?>"><i
					class="glyphicon glyphicon-plus-sign"></i> Add New Franchisee</a>
		</div>
	</div>
</form>
<table class="table table-bordered table-striped">
	<thead>
	<tr>
		<th>ID</th>
		<th>Name</th>
        <th>Email</th>
		<th>Mobile</th>
		<th>Capital</th>
		<th>Description</th>
		<th></th>
	</tr>
	</thead>
	<tbody>
	<?php
	if (is_array ($franchisee) && count ($franchisee) > 0) {
		foreach ($franchisee as $fr) {
            //$ob = new AI_Category($cat -> id);
			?>
			<tr>
				<td><?= $fr->id; ?></td>
                <td><?= $fr->name; ?></td>
				<td><?= $fr->email; ?></td>
				<td><?= $fr->mobile; ?></td>
				<td><?= $fr->capital; ?></td>
                <td><?= $fr->description; ?></td>
                <td>
					<div class="btn-group pull-right">
						<a href="<?= admin_url ('franchisee/add/' . $fr->id); ?>" title="Edit"
						   class="btn btn-xs btn-info"><i class="fa fa-pencil"></i> </a>
						<a href="<?= admin_url ('franchisee/delete/' . $fr->id); ?>" title="Delete"
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
