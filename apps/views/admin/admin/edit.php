<h4>Modify Members</h4>
<div class="formview">
	<?php echo form_open('members/edit/'.$member['id']); ?>
	<input type="hidden" name="id" value="<?php echo $member['id']; ?>" />
	<input type="hidden" name="user_id" value="<?php echo $member['user_id']; ?>" />
	<div class="row">
		<div class="two columns">
		  <label class="right inline">Member Name:</label>
		</div>
		<div class="five columns">
		  <input type="text" name="first_name" placeholder="First Name" value="<?php echo set_value('first_name', $member['first_name']); ?>" />
		  <?php echo form_error('first_name'); ?>
		</div>
		<div class="five columns">
		  <input type="text" name="last_name" placeholder="Last Name" value="<?php echo set_value('last_name', $member['last_name']); ?>" />
		  <?php echo form_error('last_name'); ?>
		</div>
	</div> 
	<div class="row">
		<div class="two columns">
		  <label class="right inline">Login Details:</label>
		</div>
		<div class="five columns">
		  <input type="text" name="username" placeholder="Email ID" value="<?php echo set_value('email_id', $member['username']); ?>" />
		  <?php echo form_error('username'); ?>
		</div>
		<div class="five columns">
		  <input type="password" name="password" placeholder="Password" value="<?php echo set_value('password', $member['password']); ?>" />
		  <?php echo form_error('password'); ?>
		</div>
	</div>
	<div class="row">
		<div class="two columns">
		  <label class="right inline">Email ID:</label>
		</div>
		<div class="five columns end">
		  <input type="text" name="email_id" placeholder="Email ID" value="<?php echo set_value('email_id', $member['email_id']); ?>" />
		  <?php echo form_error('email_id'); ?>
		</div>
	</div>
	<div class="row">
		<div class="two columns">
			<label class="right inline">Address:</label>
		</div>
		<div class="ten columns">
			<textarea name="address" rows="" cols=""><?php echo set_value('address', $member['address']) ?></textarea>			
		</div>
	</div>
	<div class="row">
		<div class="two columns">
			<label class="right inline">&nbsp;</label>
		</div>
		<div class="five columns">
			<input type="text" name="city_name" placeholder="City name" value="<?php echo set_value('city_name', $member['city_name']); ?>" />	
		</div>
		<div class="two columns">
			<input type="text" name="state_name" placeholder="State name" value="<?php echo set_value('state_name', $member['state_name']); ?>"/>	
		</div>
		<div class="three columns">
			<input type="text" name="country_name" placeholder="Country" value="<?php echo set_value('country_name', $member['country_name']); ?>"/>	
		</div>	  	
    </div>
	<div class="row">
		<div class="two columns">
			<label class="right inline">Phone No</label>
		</div>
		<div class="five columns end">
			<!--<input type="text" placeholder="e.g. 9953709380" class="five"  /><span class="prefix">#</span>-->	
			<div class="row collapse">
			  <div class="two columns">
				<span class="prefix">91</span>
			  </div>
			  <div class="ten columns">
				<input type="text" name="contact_no" placeholder="9953709380" value="<?php echo set_value('contact_no', $member['contact_no']); ?>" />
			  </div>
			</div>
		</div>	  	
    </div>		
	<div class="row">
		<div class="two columns">
		  <label class="right inline">Role:</label>
		</div>
		<div class="two mobile-three columns">
			<?php echo form_dropdown('role', $role, $member['role']); ?>
		</div>
		<div class="two columns offset-by-two">
		  <label class="right inline">Status:</label>
		</div>
		<div class="two mobile-three columns end">
			<?php echo form_dropdown('status', $status, $member['status']); ?>
		</div>
	</div>
	<div class="row">
		<div class="two mobile-one columns">
			<label class="right inline">&nbsp;</label>
		</div>
		<div class="ten mobile-three columns">
		  <input type="submit" name="submit" class="button small radius" value="Update Now" />
		  <?php echo anchor('category','Cancel', array('class' => 'button small secondary radius')); ?>
		</div>
	</div>
	<?php echo form_close(); ?>
</div>
