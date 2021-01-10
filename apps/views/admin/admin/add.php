<div class="page-header">
	<h3>Administrator</h3>
</div>
<?php echo form_open_multipart($this -> config -> item('admin_folder').'add/'.$id); ?>
<div class="tabbable">

	<ul class="nav nav-tabs">
		<li class="active"><a href="#description_tab" data-toggle="tab">Login Details</a></li>
	</ul>

	<div class="tab-content">
		<div class="tab-pane active" id="description_tab">			
			<fieldset>
				<label class="right inline">Username:</label>
                <input type="text" name="username" placeholder="Username" value="<?php echo set_value('username', $username); ?>" />
		  		<?php echo form_error('username'); ?>
                <label class="right inline">Email ID:</label>
                <input type="text" name="email_id" placeholder="Email ID" value="<?php echo set_value('email_id', $email_id); ?>" />
		  		<?php echo form_error('email_id'); ?>
                <label for="name">Password</label>
		  		<input type="password" name="password" placeholder="Password" value="<?php echo set_value('password', $password); ?>" />
		  		<?php echo form_error('password'); ?>
                <label for="role">Role</label>
                <?php
					$r = array(
						1 => 'Admin',
						2 => 'User'
					);
					echo form_dropdown('role', $r, $role);
				?>
			</fieldset>
		</div>						
	</div>

</div>

<div class="form-actions">
	<button type="submit" class="btn btn-primary">Save</button>
</div>
</form>

