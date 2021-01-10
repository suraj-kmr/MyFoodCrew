<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<form enctype="multipart/form-data" method="post" action="<?php echo admin_url('campus/addcampus/'.$brand -> id); ?>" class="form-horizontal">
	<div class="row">
		<div class="col-md-12">
			<p class="pull-right">

			</p>
		</div>
	</div>
	<div class="box panel-default">
		<div class="box-header">
			<i class="fa fa-external-link-square icon-external-link-sign"></i>
			<?php echo ($brand -> id == false) ? "New Campus" : "Edit Campus"; ?>
		</div>
		<div class="box-p">
			<div class="form-group">
				<label class="control-label col-md-2">Campus Name<span class="symbol required"></span></label>
				<div class="col-md-4">
					<input type="text" name="data[title]" value="<?php echo set_value('data[title]', $brand -> title); ?>" class="form-control input-sm"  />
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-2">About </label>
				<div class="col-md-4">
					<textarea name="data[about]" class="form-control input-sm" rows="3"><?php echo set_value('data[about]', $brand -> about); ?></textarea>
				</div>
			</div>
            <div class="form-group">
                <label class="control-label col-md-2"> Logo </label>
                <div class="col-md-4">
                    <input type="file" name="logo" />
                    <?php
                    if($brand->logo != '')
                    {
                        ?>
                        <img src="<?php echo site_url(upload_dir($brand->logo)); ?>" class="img-responsive" style="height: 55px;">
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2"> Image </label>
                <div class="col-md-4">
                    <input type="file" name="image" />
                    <?php
                    if($brand->image != '')
                    {
                        ?>
                        <img src="<?php echo site_url(upload_dir($brand->image)); ?>" class="img-responsive" style="height: 55px;">
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2">SEO Title<span class="symbol required"></span></label>
                <div class="col-md-4">
                    <input type="text" name="data[seo_title]" value="<?php echo set_value('data[seo_title]', $brand -> seo_title); ?>" class="form-control input-sm" />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2">SEO Description </label>
                <div class="col-md-4">
                    <textarea name="data[seo_description]" class="form-control input-sm" rows="3"><?php echo set_value('data[seo_description]', $brand -> seo_description); ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2">SEO Keywords </label>
                <div class="col-md-4">
                    <textarea name="data[seo_keywords]" class="form-control input-sm" rows="3"><?php echo set_value('data[seo_keywords]', $brand -> seo_keywords); ?></textarea>
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
