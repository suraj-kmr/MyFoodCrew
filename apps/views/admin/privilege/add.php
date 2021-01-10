<div class="page-header">
	<h2>Add User</h2>
</div>
<div class="row">
	<div class="col-sm-12">
    	<?php echo form_open(admin_url('privilege/add/'.$m -> id), array('class' => 'form-horizontal')); ?>
        <!--<div class="form-group">
        	<label class="col-sm-2">Username</label>
            <div class="col-sm-6">
            	<input type="text" name="frm[username]" value="<?php /*echo $m -> username; */?>" class="form-control input-sm" />
            </div>

        </div>-->
        <div class="form-group">
        	<label class="col-sm-2">Email ID</label>
            <div class="col-sm-3">
            	<input type="text" name="frm[email_id]" value="<?php echo $m -> email_id; ?>" class="form-control input-sm" />
            </div>
                <label class="col-sm-1">Password</label>
                <div class="col-sm-2">
                    <input type="text" name="frm[password]" value="<?php echo base64_decode($m -> password); ?>" class="form-control input-sm" />
                </div>
        </div>
        <div class="form-group">

	        <label class="col-sm-2">Role</label>
	        <div class="col-sm-3">
		        <label class="radio radio-inline"><input type="radio" name="frm[role]" value="1" <?php if($m -> role == 1) echo 'checked'; ?> /> Admin</label>
		        <label class="radio radio-inline"><input type="radio" name="frm[role]" value="2" <?php if($m -> role == 2) echo 'checked'; ?> /> User</label>
	        </div>
        </div>
        <div class="form-group">
        	<label class="col-sm-2">Account Status</label>
            <div class="col-sm-3">
            	<label class="radio radio-inline">
                    <input type="radio" name="frm[status]" value="1" <?php if($m -> status == 1) echo 'checked'; ?> /> Active</label>
                <label class="radio radio-inline">
                    <input type="radio" name="frm[status]" value="0" <?php if($m -> status == 0) echo 'checked'; ?> /> Deactive</label>
            </div>
        </div>
        <div class="form-group">
        	<label class="col-sm-2">&nbsp;</label>
            <div class="col-sm-10">
            	<input type="submit" name="submit" value="Save Details" class="btn btn-sm btn-primary" />
                <a href="<?= admin_url('members'); ?>" class="btn btn-sm btn-warning">Cancel</a>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
