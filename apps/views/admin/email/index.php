<div class="page-header">
	<h2>Manage Emails</h2>
</div>

<div class="row-fluid">
	<table class="table table-striped" id="post-index">
		<thead>
		<tr>
			<th>Email From</th>
			<th>Message Summary</th>
            <th>Date</th>			
            <th>&nbsp;</th>
		</tr>
		</thead>
		<tbody>
		<?php
			$sl = 1;
			foreach($email_list as $row){
				?>
				<tr>
					<td><?php echo $row['msg_from']; ?></td>
					<td><?php echo substr($row['msg_details'], 0, 100); ?></td>
                    <td><?php echo date('jS-M-Y', strtotime($row['created'])); ?></td>
                    <td>
                    <div class="btn-group" style="float:right">

						<a class="btn btn-small" href="<?php echo  site_url('emails/view/'.$row['id']);?>"><i class="icon-pencil"></i> View</a>
						
						<a class="btn btn-small btn-danger delete" href="<?php echo  site_url('emails/delete/'.$row['id']);?>"><i class="icon-trash icon-white"></i> Delete</a>
					</div>
					</td>
				</tr>
				<?php
			}
		?>
		</tbody>
	</table>
    </div>
<div class="pagination">
	<?php echo $paginate; ?>
</div>
