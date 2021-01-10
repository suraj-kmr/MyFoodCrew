<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<form method="post" action="<?php echo admin_url('fanbook/add/'.$m -> id);?>" class="form-horizontal" enctype="multipart/form-data">
	<div class="panel panel-default">
		<div class="panel-heading">
			<i class="fa fa-external-link-square icon-external-link-sign"></i>
			<?php echo ($m -> id == false) ? "New Fanbook" : "Edit Fanbook"; ?>
		</div>
		<div class="modal-body">
			
			<div class="form-group">
				<label class="col-sm-2 control-label">Title <span class="symbol required"></span></label>
				<div class="col-sm-4">
					<input type="text" name="data[title]" value="<?php echo set_value('data[title]', $m -> title); ?>" class="form-control input-sm" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Upload Image <span class="symbol required"></span></label>
				<div class="col-sm-4">
					<input class="form-control file-sm" type="file" name="picture" />
				</div>
			</div>
			
			<div class="form-group codeRow">
				<label class="control-label col-md-2">Short Info </label>
				<div class="col-md-4">
					<textarea name="data[short_info]" rows="3" cols="" class="form-control input-sm"><?= $m -> short_info; ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-2">URL </label>
				<div class="col-sm-4">
				<input type="text" name="data[url]" value="<?= $m -> url; ?>" class="form-control input-sm" />
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
					<a href="<?php echo admin_url('fanbook'); ?>" class="btn btn-sm btn-danger btn-round" ><i class="fa fa-times"></i> Cancel</a>
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
