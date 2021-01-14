<div id="center">
	<div class="container">
		<div class="section">
			<div class="login_signup_form">
				<h3>Customer Registration</h3>
				<div class="form_inner">
					<?php $this->load->view('alert')?>
					<form action="<?= site_url('register') ?>" method="post">
					  <div class="form-group">
						<label for="">First Name</label>
						<input type="text" class="form-control" id="" name="data[first_name]" value="" placeholder="">
					  </div>
					  
					  <div class="form-group">
						<label for="">Last  Name</label>
						<input type="text" class="form-control" id="" name="data[last_name]" value="" placeholder="">
					  </div>
					  
					  <div class="form-group">
						<label for="">Job Title</label>
						<input type="text" class="form-control" id="" name="data[job_title]" value="" placeholder="">
					  </div>

					  <div class="form-group">
						<label for="">User Type</label>
						<select name="data[user_type]" class="form-control">
							<option value="1">Seeker</option>
							<option value="2">Consultant</option>
						</select>
					  </div>
					  
					  <div class="form-group">
						<label for="">Email</label>
						<input type="text" class="form-control" id="" name="data[email_id]" value="" placeholder="">
					  </div>
					  
					  <div class="form-group">
						<label for="">Phone Number</label>
						<input type="text" class="form-control" id="" name="data[phone_no]" value="" placeholder="">
					  </div>
					  
					  <div class="form-group">
						<label for="">Company Name</label>
						<input type="text" class="form-control" id="" name="data[company]" value="" placeholder="">
					  </div>
					  
					  <div class="form-group">
						<label for="">Password </label>
						<input type="text" class="form-control" id="" name="data[pass]" value="" placeholder="">
					  </div>
					  
					  <div class="checkbox-custom checkbox-default">
						<input type="checkbox" checked="" id="checkboxExample1" required="">
						<label for="checkboxExample1">Terms and Condition</label>
					  </div>
					  
					  <div class="form_btn"><button type="submit" class="btn btn-default">SIGN UP</button></div>
					</form>
				</div><!--/form_inner-->

			</div><!--/login_signup_form-->
			
		</div>
	</div>
</div> <!--/center-->