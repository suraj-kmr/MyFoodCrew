<div class="page-header">
	<h3>Administrator</h3>
</div>
<div class="btn-group pull-right">
	<a href="<?php echo base_url($this -> config -> item('admin_folder').'add'); ?>" class="btn">Add Admin</a>
</div>
<div class="row-fluid">
	<table class="table table-striped">
		<thead>
		<tr>
			<th>Email ID</th>
			<th>Password</th>
			<th>&nbsp;</th>
		</tr>
		</thead>
		<tbody>
		<?php
			foreach($admins as $row){
				?>
				<tr>
					<td><?php echo $row['email_id']; ?></td>
					<td><?php echo $row['password']; ?></td>
					<td>
					<div class="btn-group pull-right">
						<a href="<?php echo base_url('admin/add/'.$row['id']); ?>" class="btn">Edit</a>
                        <a href="<?php echo base_url('admin/delete/'.$row['id']); ?>" class="btn btn-danger delete">Delete</a>
                    </div>
                    </td>
				</tr>
				<?php
			}
		?>	
		</tbody>
	</table>
</div>

