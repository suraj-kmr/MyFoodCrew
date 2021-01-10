<div class="page-header">
	<h3>All Users </h3>
</div>


	<div class="row form-search">
        <!--<form method="get" action="<?/*= admin_url ('members'); */?>">
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
        </form>-->
		<div class="col-sm-12">
			<a id="pageload" href="<?= admin_url('privilege/add'); ?>" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus-circle"></i> Add User</a>
            <!-- Modal -->
		</div>
	</div>

<table class="table table-bordered table-striped">
	<tbody>
    	<tr>

            <th>Email ID</th>
            <th>Status</th>
            <th>Password</th>
            <th></th>
        </tr>
        <?php
			foreach($list as $m){
				?>
                <tr>

                    <td><?php echo $m -> email_id; ?></td>
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
                        <?= base64_decode($m->password);?>
                    </td>
                    <td>
                    	<div class="pull-right btn-group">
                        	<a href="<?php echo admin_url('privilege/add/'.$m -> id); ?>" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i> </a>
                        	<a href="<?php echo admin_url('privilege/setting/'.$m -> id); ?>" class="btn btn-info btn-sm"><i class="fa fa-cogs"></i> </a>
                            <a href="<?php echo admin_url('privilege/delete/'.$m -> id); ?>" class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i> </a>
                        </div>
                    </td>
                </tr>
                <?php
			}
		?>
    </tbody>
</table>

