<div class="page-header">
	<h3>All Registered Members  </h3>
</div>


	<div class="row form-search">
        <form method="get" action="<?= admin_url ('members'); ?>">
		<div class="col-sm-6">
			<div class="input-group">

				<input type="search" name="q" value="" placeholder="e.g Member name, Email Id"
				       class="form-control input-sm"/>

				<div class="input-group-btn">
					<button type="submit" name="btnsearch" value="Search" class="btn btn-sm btn-primary"><i
							class="fa fa-search"></i> Search
					</button>
				</div>

			</div>
		</div>
        </form>
		<div class="col-sm-6">
			<a id="pageload" href="<?= admin_url('members/add'); ?>" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus-circle"></i> Add User</a>
		</div>
	</div>
    <div class="box box-header box-status">
    <form method="POST" id="frm" action="<?= admin_url('members/export'); ?>">

                                <div class="row">
                                    <div class="col-sm-2"><label>Date to</label></div>
                                    <div class="col-sm-3"><input type="date" name="to" class="form-control"></div>
                                    <div class="col-sm-2"><label>Date from</label></div>
                                    <div class="col-sm-3"><input type="date" name="from" class="form-control"></div>
                                    <div class="col-sm-2">    <input type="submit" id="export" class="btn btn-success" name="submit" value="Export"> </div>
                                </div>
                        </form>
                                
                               
                        </div>

<table class="table table-bordered table-striped">
	<tbody>
    	<tr>
           
            <th>ID</th>
            <th> User Type</th>
        	<th>Full Name</th>
            <th>Email ID</th>
             <th>Password</th>
            <th>Gender</th>
            <th>Status</th>
            <th></th>
        </tr>
        <?php
			foreach($mem_list as $m){
				?>
                <tr>
                     <td><?php echo $m -> id; ?></td>
                      <td><?php echo $m -> user_type; ?></td>
                      
                	<td><?php echo $m -> first_name.' '.$m -> last_name; ?></td>
                    <td><?php echo $m -> email_id; ?></td>
                     <td><?php echo $m -> pass; ?></td>
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
<div class="pagination">
	<?php echo $paginate; ?>
</div>
