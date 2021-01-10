<div class="page-header">
	<h2>Event Form</h2>
</div>
<?php echo validation_errors(); ?>
<?php echo form_open_multipart(admin_url('categories/add_event/'.$cat -> id), array('class' => 'form-horizontal')); ?>
<div class="row">
	<div class="col-sm-12">
		<div class="tab-pane active" id="description_tab">
			<div class="form-group">
				<label class="col-sm-2 control-label">Event Name</label>
				<div class="col-sm-4">
					<input type="text" name="cat[event_name]" value="<?= set_value('cat[event_name]', $cat -> event_name); ?>" class="form-control" />
				</div>
				<label class="col-sm-2 control-label">Sequence</label>
				<div class="col-sm-2">
					<input type="text" name="cat[sequence]" value="<?= set_value('cat[sequence]', $cat -> sequence); ?>" class="form-control" />
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">Description</label>
				<div class="col-sm-8">
					<textarea name="cat[description]" rows="4" cols="" class="form-control"><?= set_value('cat[description]', $cat -> description); ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Image</label>
				<div class="col-sm-8">
					<div class="input-append">
						<?php echo form_upload(array('name'=>'image'));?>
					</div>

					<?php if($cat -> id && $cat -> image != ''):?>

						<div style="text-align:center; padding:5px; border:1px solid #ddd;"><img class="img-responsive img-thumbnail" src="<?php echo base_url('img/uploads/'.$cat -> image);?>" alt="current"/><br/>Current File</div>
						<label class="checkbox checkbox-inline">
							<input type="hidden" name="hid_image" value="<?php echo $cat -> image; ?>" />
							<input type="checkbox" name="del_image" value="1" />Delete this image
						</label>
					<?php endif;?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">SEO Title</label>
				<div class="col-sm-8">
					<input type="text" name="cat[seo_title]" value="<?= set_value('cat[seo_title]', $cat -> seo_title); ?>" class="form-control" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">SEO Description</label>
				<div class="col-sm-8">
					<textarea name="cat[seo_description]" rows="2" cols="" class="form-control"><?= set_value('cat[seo_description]', $cat -> seo_description); ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">SEO Keywords</label>
				<div class="col-sm-8">
					<textarea name="cat[seo_keywords]" rows="2" cols="" class="form-control"><?= set_value('cat[seo_keywords]', $cat -> seo_keywords); ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">&nbsp;</label>
				<div class="col-sm-8">
					<button type="submit" class="btn btn-primary btn-sm">Save</button> <a href="<?php echo site_url($this -> config -> item('admin_folder').'categories'); ?>" class="btn btn-sm btn-default">Cancel</a>
				</div>
			</div>
		</div>
	</div>
</div>

</form>
<script type="text/javascript">
    $('#pid').change(function(){
        var pid = $('#pid').val();
        //alert(pid);
        $.ajax({
            type: "POST",
            url: "<?php echo admin_url('categories/getparentcat'); ?>",
            data: 'pid=' + pid,
            success: function(f){
                $('.form-category1').empty().append(f);
            }
        })
    });

</script>
