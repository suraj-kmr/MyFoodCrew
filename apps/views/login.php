<div id="center">
	<div class="container">
		<div class="section">
			<div class="login_signup_form">
				<h3>Login</h3>
				<div class="form_inner">
					<?php $this->load->view('alert') ?>
				<form action="<?= site_url('login') ?>" method="post" >
					  <div class="form-group">
						<label for="">Email </label>
						<input type="text" class="form-control" id="" name="data[email_id]" value="" placeholder="">
					  </div>
					  
					  <div class="form-group">
						<label for="">Password </label>
						<input type="text" class="form-control" id="" name="data[pass]" value="" placeholder="">
					  </div>

					  <div class="form_btn">
						<button type="submit" class="btn btn-default">Create New Account</button>
						<a class="forget_pass" href="">Forgot Password</a>
					  </div>
					</form>
				</div><!--/form_inner-->

			</div><!--/login_signup_form-->
			
		</div>
	</div>
</div> <!--/center-->

	