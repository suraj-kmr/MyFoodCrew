<div class="page-header">
	<h3>New Registered Members  </h3>
</div>


	
  

<table class="table table-bordered table-striped">
	<tbody>
    	<tr>
            <th>Type</th>
             <th>Username</th>
        	<th>Full Name</th>
            <th>Email ID</th>
            <th>Gender</th>
            <th>Status</th>
            <th></th>
        </tr>
        <?php
			foreach($member as $m){
				?>
                <tr>
                     <td><?php echo $m -> user_type; ?></td>
                      <td><?php echo $m -> username; ?></td>
                	<td><?php echo $m -> first_name.' '.$m -> last_name; ?></td>
                    <td><?php echo $m -> email_id; ?></td>
                    <td><?php echo $m -> gender; ?></td>
                    <td>
	                    <?php
	                    if($m -> status == 1){
		                    ?>
		                    <a href="<?= admin_url('members/deactivate/' . $m -> id, true); ?>" class="label label-success">Active</a>
	                    <?php
	                    }else{
		                    ?>
		                    <a href="<?= admin_url('members/activate/' . $m -> id, true); ?>" class="label label-danger">Deactive</a>
	                    <?php
	                    }
	                    ?>
                    </td>
                    <td>
                    	<div class="pull-right btn-group">
                        	<a href="<?php echo admin_url('members/add/'.$m -> id); ?>" class="btn btn-default btn-sm"><i class="fa fa-pencil"></i> </a><a href="<?php echo admin_url('members/delete/'.$m -> id, true); ?>" class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i> </a>
                        </div>
                    </td>
                </tr>
                <?php
			}
		?>
    </tbody>
</table>
