<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<form enctype="multipart/form-data" method="post" action="<?php echo admin_url('brands/add_grocery_brands/'.$m->id); ?>" class="form-horizontal">
	<div class="row">
		<div class="col-md-12">
			<p class="pull-right">

			</p>
		</div>
	</div>
	<div class="box panel-default">
		<div class="box-header">
			<i class="fa fa-external-link-square icon-external-link-sign"></i>
			<?php echo ($m -> id == false) ? "New Brand" : "Edit Brand"; ?> 
		</div>
		<div class="box-p">
			<div class="form-group">
				<label class="control-label col-md-2">Brand Name<span class="symbol required"></span></label>
				<div class="col-md-4">
					<input type="text" name="data[title]" value="<?php echo set_value('data[title]', $m -> title); ?>" class="form-control input-sm" />
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-2">About </label>
				<div class="col-md-4">
					<textarea name="data[description]" class="form-control input-sm" rows="3"><?php echo set_value('data[description]', $m -> description); ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-2">Top Brands </label>
				<div class="col-md-4" style="margin-top: 9px;">
					<input type="checkbox" name="data[top_brand]" value="1" class="" <?php if($m->top_brand == 1){ echo "checked"; }?>> Top Brand
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-2">Image </label>
				<div class="col-md-4" style="margin-top: 9px;">
					<input type="file" name="image" value="1" class="form-control input-sm" >
					<?php
					if($m->images !=""){
						?>
						<img src="<?=site_url(upload_dir($m->images));?>" class="img-responsive" style="width: 100px;">
						<?php
					}
					?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-6 col-sm-offset-2">
					<button type="submit" class="btn btn-sm btn-primary btn-round" ><i class="fa fa-save"></i> Save</button>
					<a href="<?php echo admin_url('brands/grocery'); ?>" class="btn btn-sm btn-danger btn-round" ><i class="fa fa-times"></i> Cancel</a>
				</div>
			</div>
		</div>
	</div>
</form>
