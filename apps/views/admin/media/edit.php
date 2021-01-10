<div class="page-header">
	<h3>Modify Media</h3>
</div>
<div class="row-fluid">
	<?php echo form_open_multipart($this -> config -> item('admin').'/media/edit/'.$media -> id, array('class'=> 'form-horizontal')) ?>
    <div class="form-group">
		  <label class="col-sm-2">Image Title:</label>
		<div class="col-sm-5">
		  <input type="text" name="frm[img_title]" value="<?php echo set_value('frm[img_title]', $media -> img_title); ?>" class="form-control input-sm">
		</div>
	</div>
    <div class="form-group">
		<label class="col-sm-2">Image File:</label>
		<div class="col-sm-8">
		  <img src="<?php echo base_url().'img/products/'.$media -> file_name; ?>" width="100" class="thumbnail" />
          <input type="text" name="img_url" value="<?php echo base_url().'img/products/'.$media -> file_name; ?>" class="form-control input-sm" />
		</div>
	</div>
	<input type="hidden" name="id" value="<?php echo $media -> id; ?>" />
	<div class="form-group">
		  <label class="col-sm-2">Image Alt</label>
		<div class="col-sm-2">
			<input type="text" name="frm[img_alt]" value="<?= set_value('frm[img_alt]', $media -> img_alt); ?>"	class="form-control input-sm" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2">&nbsp;</label>
		<div class="col-sm-5">
		    <input type="submit" name="submit" class="btn btn-primary btn-sm" value="Update">
			<a href="<?= admin_url('media'); ?>" class="btn btn-sm btn-default">Cancel</a>
		</div>
	</div>
	<?php echo form_close(); ?>
</div>
