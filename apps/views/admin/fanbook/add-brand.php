<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<form enctype="multipart/form-data" method="post" action="<?php echo admin_url('mobiles/addbrand/'.$brand -> id); ?>" class="form-horizontal">
	<div class="row">
		<div class="col-md-12">
			<p class="pull-right">

			</p>
		</div>
	</div>
	<div class="box panel-default">
		<div class="box-header">
			<i class="fa fa-external-link-square icon-external-link-sign"></i>
			<?php echo ($brand -> id == false) ? "New Brand" : "Edit Brand"; ?>
		</div>
		<div class="box-p">
			<div class="form-group">
				<label class="control-label col-md-2">Brand Name<span class="symbol required"></span></label>
				<div class="col-md-4">
					<input type="text" name="data[brand]" value="<?php echo set_value('data[brand]', $brand -> brand); ?>" class="form-control input-sm" />
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-2">About </label>
				<div class="col-md-4">
					<textarea name="data[about]" class="form-control input-sm" rows="3"><?php echo set_value('data[about]', $brand -> about); ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-6 col-sm-offset-2">
					<button type="submit" class="btn btn-sm btn-primary btn-round" ><i class="fa fa-save"></i> Save</button>
					<a href="<?php echo admin_url('mobiles/brands'); ?>" class="btn btn-sm btn-danger btn-round" ><i class="fa fa-times"></i> Cancel</a>
				</div>
			</div>
		</div>
	</div>
</form>
