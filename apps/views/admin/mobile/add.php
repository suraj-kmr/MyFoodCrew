<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<form method="post" action="<?php echo admin_url('mobiles/add/'.$m -> id);?>" enctype="multipart/form-data" class="form-horizontal">
	<div class="panel panel-default">
		<div class="panel-heading">
			<i class="fa fa-external-link-square icon-external-link-sign"></i>
			<?php echo ($m -> id == false) ? "New Mobile Set" : "Edit Mobile Set"; ?>
		</div>
		<div class="modal-body">
			<div class="form-group">
				<label class="control-label col-md-2">Select Brand <span class="symbol required"></span></label>
				<div class="col-md-4">
					<?php
					$d = array(
						'' => 'Select Brand'
					);
					if(is_array($brands) && count($brands) > 0){
						foreach($brands as $b){
							$d[$b -> id] = $b -> brand;
						}
					}

					echo form_dropdown('data[brand_id]', $d, set_value('data[brand_id]', $m -> brand_id), 'class="form-control input-sm"');
					?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Mobile Set <span class="symbol required"></span></label>
				<div class="col-sm-4">
					<input type="text" name="data[title]" value="<?php echo set_value('data[title]', $m -> title); ?>" class="form-control input-sm" />
				</div>
			</div>
			<div class="form-group codeRow">
				<label class="control-label col-md-2">About </label>
				<div class="col-md-4">
					<textarea name="data[about]" rows="3" cols="" class="form-control input-sm"><?= $m -> about; ?></textarea>
				</div>
			</div>
			<div class="form-group codeRow">
				<label class="control-label col-md-2">Available Cover Set </label>
				<?php
				$f = json_decode($m -> features, true);
				?>
				<div class="col-md-8">
					<label class="checkbox-inline">
						<input type="checkbox" name="features[]" value="3D" <?php if(in_array('3D', $f)) echo 'Checked'; ?> /> 3D Cover
					</label>
					<label class="checkbox-inline">
						<input type="checkbox" name="features[]" value="2D" <?php if(in_array('2D', $f)) echo 'Checked'; ?>/> 2D Cover
					</label>
					<label class="checkbox-inline">
						<input type="checkbox" name="features[]" value="Transparent 2D" <?php if(in_array('Transparent 2D', $f)) echo 'Checked'; ?>/> Transparent 2D Cover
					</label>
				</div>
			</div>

            <div class="form-group">
                <label class="control-label col-md-2">Image </label>
                <div class="col-md-2">
                    <input type="file" name="image"/>
                    <img src="<?php echo site_url(upload_dir($m->image)); ?>" height="50px" />
                </div>
            </div>
			
			<div class="form-group">
				<label class="control-label col-md-2">Sequence </label>
				<div class="col-md-2">
					<input type="text" name="data[sequence]" value="<?php echo set_value('data[sequence]', $m -> sequence); ?>" class="form-control input-sm" />
				</div>
			</div>
            <div class="form-group">
                <label class="control-label col-md-2">SEO Title<span class="symbol required"></span></label>
                <div class="col-md-4">
                    <input type="text" name="data[seo_title]" value="<?php echo set_value('data[seo_title]', $m -> seo_title); ?>" class="form-control input-sm" />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2">SEO Description </label>
                <div class="col-md-4">
                    <textarea name="data[seo_description]" class="form-control input-sm" rows="3"><?php echo set_value('data[seo_description]', $m -> seo_description); ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2">sSEO Keywords </label>
                <div class="col-md-4">
                    <textarea name="data[seo_keywords]" class="form-control input-sm" rows="3"><?php echo set_value('data[seo_keywords]', $m -> seo_keywords); ?></textarea>
                </div>
            </div>
			<div class="form-group">
				<label class="control-label col-md-2">Status </label>
				<div class="col-md-2">
					<?php
					echo form_dropdown('data[status]', array('1' => 'Publish', '0' => 'Unpublish'), set_value('data[status]', $m -> status), 'class="form-control input-sm"');
					?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-6 col-sm-offset-2">
					<button type="submit" class="btn btn-sm btn-primary btn-round" ><i class="fa fa-save"></i> Save</button>
					<a href="<?php echo admin_url('mobiles'); ?>" class="btn btn-sm btn-danger btn-round" ><i class="fa fa-times"></i> Cancel</a>
				</div>
			</div>
		</div>
	</div>
</form>
<script type="text/javascript">
	jQuery(document).ready(function(){
		$('.datepicker').datepicker(); //.datepicker("option", "dateFormat", "yy-mm-dd");
		$('#codeAd').click(function(){
			$(".codeRow").show();
			$(".imageRow").hide();
		});
		$('#imageAd').click(function(){
			$(".codeRow").hide();
			$(".imageRow").show();
		});
		var ads = '<?php echo $data -> ads_type; ?>';
		if(ads == '' || ads == 1){
			$('#codeAd').trigger('click');
		}else{
			$('#imageAd').trigger('click');
		}
	});
</script>
