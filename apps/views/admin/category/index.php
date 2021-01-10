<div class="page-header">
	<h2>Categories </h2>
</div>
<form method="get" action="<?= admin_url ('categories'); ?>">
	<div class="row form-search">
		<div class="col-sm-6">
			<div class="input-group">
				<input type="search" name="q" value="" placeholder="e.g Category Title, ID"
				       class="form-control input-sm"/>

				<div class="input-group-btn">
					<button type="submit" name="btnsearch" value="Search" class="btn btn-sm btn-primary"><i
							class="fa fa-search"></i> Search
					</button>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<a class="btn pull-right btn-sm btn-primary" href="<?php echo admin_url ('categories/add'); ?>"><i
					class="glyphicon glyphicon-plus-sign"></i> Add New Category</a>
		</div>
	</div>
</form>
<table class="table table-bordered table-striped">
	<thead>
	<tr>
		<th>Category ID</th>
		<th>Category name</th>
      <!--   <th class="hide">Product Type</th> -->
		<th>Parent</th>
		<th>Sequence</th>
		<th>Status</th>
		<th></th>
		
	</tr>
	</thead>
	<tbody>
	<?php
	if (is_array ($categories) && count ($categories) > 0) {
		foreach ($categories as $cat) {
            $ob = new AI_Category($cat -> id);
           // var_dump($ob);
			?>
			<tr>
				<td><?= $cat->id; ?></td>
				<td><a href="<?= site_url('category/'.$cat -> id); ?>" target="_blank"><?= $cat->name; ?></a></td>
               <!--  <td class="hide"><?= typeStr($cat->product_type); ?></td> -->
				<td>
					<?php
					if ($cat->parent_id == 0)
						echo 'Parent Category';
					else {
						$tc = $this->Category_model->getRow ($cat->parent_id);
						echo $tc->name;
					}
					?>
				</td>

                
				<td><input type="text" name="seq[]" value="<?= $cat->sequence; ?>" class="form-control input-sm"
				           style="width: 60px;"/></td>
				<td>
					<?php
					if ($cat->status == 1) {
						?>
						<a href="<?= admin_url ('categories/deactivate/' . $cat->id, TRUE); ?>"
						   class="label label-success">Active</a>
					<?php
					} else {
						?>
						<a href="<?= admin_url ('categories/activate/' . $cat->id, TRUE); ?>"
						   class="label label-danger">Deactive</a>
					<?php
					}
					?>
				</td>
				<td>
					<div class="btn-group pull-right">
						<a href="<?= admin_url ('categories/add/' . $cat->id); ?>" title="Edit"
						   class="btn btn-xs btn-info"><i class="fa fa-pencil"></i> </a>
						<a href="<?= admin_url ('categories/delete/' . $cat->id); ?>" title="Delete"
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
