<div class="page-header">
	<h2>Manage Pages  </h2>
</div>
<form method="get" action="<?= admin_url ('pages'); ?>">
	<div class="row form-search">
		<div class="col-sm-6">
			<div class="input-group">
				<input type="search" name="q" value="" placeholder="e.g Page title"
				       class="form-control input-sm"/>

				<div class="input-group-btn">
					<button type="submit" name="btnsearch" value="Search" class="btn btn-sm btn-primary"><i
							class="fa fa-search"></i> Search
					</button>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<a href="<?= admin_url('pages/add'); ?>" class="btn btn-sm btn-primary pull-right">Add Page</a>
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
				<th>Page Title</th>
				<th>Status</th>
				<th></th>
			</tr>
			</thead>
			<tbody>
			<?php
			$sl = 1;
			foreach($post_list as $row){
				?>
				<tr>
					<td><?= $row -> id; ?></td>
					<td><?= $row -> title; ?></td>
					<td><?php
						if($row -> status == 1){
							?>
							<a href="<?= admin_url('pages/deactivate/' . $row -> id, true); ?>" class="label label-success">Published</a>
						<?php
						}else{
							?>
							<a href="<?= admin_url('pages/activate/' . $row -> id, true); ?>" class="label label-danger">Draft</a>
						<?php
						}
						?>
					</td>
					<td>
						<div class="btn-group pull-right">

							<a class="btn btn-xs btn-default" href="<?=  admin_url('pages/add/'.$row -> id);?>"><i class="fa fa-pencil"></i></a>

							<a class="btn btn-xs btn-danger delete" href="<?= admin_url('pages/delete/'.$row -> id);?>"><i class="fa fa-trash"></i></a>
						</div>
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
