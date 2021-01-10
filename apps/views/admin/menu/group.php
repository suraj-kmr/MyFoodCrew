<div class="page-header">
	<h2>Menu Group Form</h2>
</div>
<?php if(isset($error)){
		echo '<div class="alert alert-error">';
		echo $error;
		echo '</div>';
	}
?>
<?php echo form_open(admin_url('menu/group/'.$menu -> id), array('class' => 'form-horizontal')); ?>
<div class="form-group">
	<label for="name" class="col-sm-2">Name</label>
	<div class="col-sm-4">
		<input type="text" name="m[group_name]" value="<?= set_value('m[group_name]', $menu -> group_name); ?>" class="form-control input-sm" />
	</div>
</div>
<div class="form-group">
	<label for="name" class="col-sm-2">Image SRC</label>
	<div class="col-sm-4">
		<input type="text" name="m[menu_src]" value="<?= set_value('m[menu_src]', $menu -> menu_src); ?>" class="form-control input-sm" />
	</div>
</div>
<div class="form-group">
	<label for="name" class="col-sm-2">Image ICON</label>
	<div class="col-sm-4">
		<input type="text" name="m[img_icon]" value="<?= set_value('m[img_icon]', $menu -> img_icon); ?>" class="form-control input-sm" />
	</div>
</div>
<div class="form-group">
	<label for="name" class="col-sm-2">Columns</label>
	<div class="col-sm-2">
		<?php
		$arcols = array(
			1 => 'Full Width',
			2 => '2 Columns',
			3 => '3 Columns',
			4 => '4 Columns',
			6 => '6 Columns'
		);
		echo form_dropdown('m[cols]', $arcols, set_value('m[cols]', $menu -> cols), 'class="form-control input-sm"');
		?>
	</div>
</div>
<div class="form-group">
	<div class="col-sm-4 col-sm-offset-2">
		<button type="submit" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-floppy-disk"></i> Save</button>						     <a href="<?php echo admin_url('menu'); ?>" class="btn btn-sm btn-default">Cancel</a>
	</div>
</div>
</form>
