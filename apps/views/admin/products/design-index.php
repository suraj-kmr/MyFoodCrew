<div class="page-header">
	<h2>T-Shirt Designs <a href="<?= admin_url('products/designs/?act=add'); ?>" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus-circle"></i> Add Design</a> </h2>
</div>
<div class="row">
	<div class="col-sm-4">
		<div class="widget">
			<div class="widget-head">
				<?php
				if($d -> id){
					?>
					<i class="fa fa-pencil"></i> Edit Design
					<?php
				}else{
					?>
					<i class="fa fa-plus"></i> Add Design
					<?php
				}
				?>

			</div>
			<div class="widget-content">
				<div class="box-p">
					<?= form_open(admin_url('products/designs/' . $d -> id)); ?>
					<label>Design name</label>
					<div class="input-group">
						<input type="text" name="frm[design]" required="required" value="<?= set_value('frm[design]', $d -> design); ?>" class="form-control input-sm" />
						<div class="input-group-btn">
							<input type="submit" name="submit" value="Save" class="btn btn-sm btn-primary" />
						</div>
					</div>
					<?= form_close(); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-8">
    	<table class="table table-bordered table-striped">
		    <thead>
		    <tr>
			    <th>Ad #</th>
			    <th>Design</th>
			    <th>Options</th>
		    </tr>
		    </thead>
        	<tbody>
	        <?php
	        if(is_array($designs) && count($designs) > 0){
		        foreach($designs as $p){
			        ?>
	                <tr>
		                <td><?= $p -> id; ?></td>
		                <td><?= $p -> design; ?></td>
		                <td>
			                <div class="btn-group pull-right">
				                <a href="<?= admin_url('products/designs/'. $p -> id); ?>" title="Edit" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i> </a>
				                <a href="<?= admin_url('products/del-designs/'. $p -> id); ?>" title="Delete" class="btn btn-xs btn-danger delete"><i class="fa fa-trash"></i> </a>
			                </div>
		                </td>
	                </tr>
	                <?php
		        }
	        }
	        ?>
            </tbody>
        </table>

    </div>
</div>
