<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<form method="post" action="<?php echo admin_url('office/theme_add/'.$theme -> id);?>" enctype="multipart/form-data" class="form-horizontal">
	<div class="panel panel-default">
		<div class="panel-heading">
			<i class="fa fa-external-link-square icon-external-link-sign"></i>
			<?php echo ($theme -> id == false) ? "New Theme" : "Edit Theme"; ?>
		</div>
		<div class="modal-body">

			<div class="form-group">
				<label class="col-sm-2 control-label">Theme <span class="symbol required"></span></label>
				<div class="col-sm-4">
					<input type="text" name="frm[title]" value="<?php echo set_value('frm[title]', $theme -> title); ?>" class="form-control input-sm" />
				</div>
			</div>
			<div class="form-group codeRow">
				<label class="control-label col-md-2">Description </label>
				<div class="col-md-4">
					<textarea name="frm[description]" rows="3" cols="" class="form-control input-sm"><?= $theme -> description; ?></textarea>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-6 col-sm-offset-2">
					<button name="submit" type="submit" class="btn btn-sm btn-primary btn-round" ><i class="fa fa-save"></i> Save</button>

				</div>
			</div>
		</div>
	</div>
</form>
