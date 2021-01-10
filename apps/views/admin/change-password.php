<div class="page-header">
	<h2>Change Password</h2>
</div>
<?php echo form_open(admin_url('dashboard/change_password'), array('class' => 'form-horizontal')); ?>
<div class="row">
	<div class="col-sm-12">
		<div class="tab-pane active" id="description_tab">
			<div class="form-group">
				<label class="col-sm-2 control-label">Old Password</label>
				<div class="col-sm-3">
					<input type="text" name="frm[old]" class="form-control" />
				</div>
				
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">new password </label>
				<div class="col-sm-3">
                    <input type="text" name="frm[new]" class="form-control" />
				</div>
				
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">retype-password</label>
				<div class="col-sm-3">
					<input type="text" name="frm[re_type]" class="form-control" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">&nbsp;</label>
				<div class="col-sm-8">
					<button type="submit" class="btn btn-primary btn-sm">Save</button> 
				</div>
			</div>
</form>

