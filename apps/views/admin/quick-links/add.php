<div class="page-header">
	<h2>Quick Links</h2>
</div>
<?php echo validation_errors();
$url = '';
if(isset($_GET['type']) && $_GET['type'] == 'link')
{
    $url = 'categories/add/'.$cat -> id.'?type=link';
}
else{
    $url = 'categories/add/'.$cat -> id;
}
?>
<?php echo form_open_multipart(admin_url($url), array('class' => 'form-horizontal')); ?>
<div class="row">
	<div class="col-sm-12">
		<div class="tab-pane active" id="description_tab">
			<div class="form-group">

				<label class="col-sm-2 control-label">Name</label>
				<div class="col-sm-4">
					<input type="text" name="cat[name]" value="<?= set_value('cat[name]', $cat -> name); ?>" class="form-control" />
				</div>

			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">URL</label>
				<div class="col-sm-4">
					<input type="text" name="cat[slug]" value="<?= set_value('cat[slug]', $cat -> slug); ?>" class="form-control" />
				</div>

			</div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Type</label>
                <div class="col-sm-4">
                    <select class="form-control" name="cat[status]">
                        <option value="0" <?php if($cat->status == 0){echo 'selected = "selected"';} ?>>None</option>
                        <option value="1" <?php if($cat->status == 1){echo 'selected = "selected"';} ?>>New</option>
                        <option value="2" <?php if($cat->status == 2){echo 'selected = "selected"';} ?>>Hot</option>

                    </select>
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

