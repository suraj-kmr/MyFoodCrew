<div class="page-header">
	<h3>Email Subscriptions</h3>
</div>
<form method="get" action="<?= admin_url ('members/subscriptions'); ?>">
	<div class="row form-search">
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
		<div class="col-sm-6">
			<a href="<?= admin_url('members/addemails'); ?>" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus-circle"></i> Add User</a>
		</div>
	</div>
</form>
<table class="table table-bordered table-striped">
	<tbody>
    	<tr>
            <th>Email ID</th>
            <th>Subscription</th>
            <th></th>
        </tr>
        <?php
			foreach($emails as $m){
				?>
                <tr>
                    <td><?php echo $m -> email_id; ?></td>
                    <td>
	                    <?php
	                    if($m -> status == 1){
		                    ?>
		                    <a href="<?= admin_url('members/unsubscribe/' . $m -> id, true); ?>" class="label label-success">Subscribed</a>
	                    <?php
	                    }else{
		                    ?>
		                    <a href="<?= admin_url('members/subscribe/' . $m -> id, true); ?>" class="label label-danger">Unsubscribed</a>
	                    <?php
	                    }
	                    ?>
                    </td>
                    <td>
                    	<div class="pull-right btn-group">
                        	<a href="<?php echo admin_url('members/delsubscribe/'.$m -> id); ?>" class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i> </a>
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
