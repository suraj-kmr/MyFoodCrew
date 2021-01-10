<div class="page-header">
	<h2>All Product </h2>
</div>
<form method="get" action="<?= admin_url ('categories/inventory'); ?>">
	<div class="row form-search">
		<div class="col-sm-6">
			<div class="input-group">
				<input type="search" name="q" value="" placeholder="e.g Product name"
				       class="form-control input-sm"/>

				<div class="input-group-btn">
					<button type="submit" name="btnsearch" value="Search" class="btn btn-sm btn-primary"><i
							class="fa fa-search"></i> Search
					</button>
				</div>
			</div>
		</div>
		<div class="col-sm-3">
<a href="<?= admin_url('categories/import'); ?>" style="margin-left:5px;" class="btn btn-sm btn-warning pull-right"> <i class="fa fa-upload"></i> Import File</a>
		</div>

		<div class="col-sm-3">
 <a href="<?= admin_url('categories/export'); ?>"  class="btn btn-sm btn-warning pull-right"> Export Products </a>
		</div>
		
	</div>
</form>
<?php echo form_open('post/bulksave'); ?>
<div class="row">
	<div class="col-sm-12">
		<table class="table table-bordered table-striped">
			<thead>
			<tr>
				
				<th>#ID</th>
				<th>Product Name </th>
				<th>Quantity</th>
				
			</tr>
			</thead>
			<tbody>
			<?php
			$sl = 1;
			foreach($post_list as $row){
				?>
				<tr>
					
					<td><?= $row -> id; ?></td>
					<td><?= $row -> ptitle; ?></td>
					<td><?= $row -> qty;?>
						
						
					</td>
					<td>
						<!-- <div class="btn-group pull-right">

							

							<a class="btn btn-xs btn-danger delete" href="<?= admin_url('categories/deletep/'.$row -> id);?>"><i class="fa fa-trash"></i></a>
						</div> -->
					</td>
				</tr>
			<?php
			}
			?>
			</tbody>
		</table>
	</div>
</div>
</form>
<div class="pagination">
	<?php echo $paginate; ?>
</div>
