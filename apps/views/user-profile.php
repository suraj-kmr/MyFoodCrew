<div id="center" class="dashbord-pinner">
	<div class="container">
		<div class="section-dashbord">

		<?php  $this->load->view('side-bar') ?>

	<div id="main">
		<div class="dashbord-head">
			<div class="opnclose">
			<button id="btnsidebar" onclick="openNav()"><i class="fa fa-bars" aria-hidden="true"></i></button>
			</div>
			<?= ucfirst($user->first_name); ?>
		</div>
		<div class="main_inner">
			<div class="page-title main_title">
				<h4 class="">User Profile</h4>
			</div>
			<div class="dbp_info userprofile_page">
			
				<div class="user_leftside usrdiv">
					<div class="userl_top">
						<div class="userimg">
							<img src="img/logged-user.jpg">
							<div class="user_img_change">
								<div class="edit_btn"><button type="submit" class="btn"><i class="fa fa-pencil" aria-hidden="true"></i></button></div>
							</div>
						</div>
						<h4 class=""><?= ucfirst($user->first_name); ?></h4>
						<h6 class=""><?= $user-> job_title ?></h6>
					</div><!--ul_top-->
					
					<div class="userl_down">
						<ul>
							<li>
								<small>Email address</small> <?= $user-> email_id ?>
							</li>
							
							<li>
								<small>Phone </small> <?= $user -> phone_no ?>
							</li>
							
							<li>
								<small>Address </small> <?= $user-> address ?>
							</li>
							
							<li>
								<small>Social Profile </small>
								<div class="social_link">
									<a href="#"><i class="fa fa-facebook-f"></i></a>
									<a href="#"><i class="fa fa-twitter"></i></a>
									<a href="#"><i class="fa fa-youtube"></i></a>
								</div>
							</li>
						</ul>
					</div>					
				</div><!--/user_leftside-->
				
				<div class="user_rightside usrdiv">
					<div class="rightside_inn">
						<div class="tabs">
								<ul class="nav nav-tabs tabs-primary">
									<li class="active">
										<a href="#overview" data-toggle="tab">Overview</a>
									</li>
									<li>
										<a href="#info_pp" data-toggle="tab">Personal  Info</a>
									</li>
									<li>
										<a href="#profile_tab" data-toggle="tab">Profile</a>
									</li>
									<li>
										<a href="#change_password" data-toggle="tab">Password</a>
									</li>
								</ul>
								<?php $this->load->view('alert') ?>
								<div class="tab-content">
									<div id="overview" class="tab-pane active">
										<h4 class="mb-md">Details</h4>

										<div class="timeline timeline-simple mt-xlg mb-md">
											<div class="tm-body">
												<ol class="tm-items">
													<li>
														<div class="tm-box">
															<p class="text-muted mb-none">7 months ago.</p>
															<p>
																It's awesome when we find a good solution for our projects, Porto Admin is <span class="text-primary">#awesome</span>
															</p>
														</div>
													</li>
												</ol>
											</div>
										</div>
									</div>
									<div id="info_pp" class="tab-pane">

										<form class="form-horizontal" action="<?=site_url('update-personal-info')?>" method="post">
											<h4 class="mb-xlg">Personal Information</h4>
											<fieldset>
												<div class="form-group">
													<label class="col-md-12 control-label" for="profileFirstName">First Name</label>
													<div class="col-md-12">
														<input type="text" class="form-control" id="profileFirstName" name="data[first_name]" value="<?php echo set_value('first_name', $user->first_name) ?>">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-12 control-label" for="profileLastName">Last Name</label>
													<div class="col-md-12">
														<input type="text" class="form-control" id="profileLastName" name="data[last_name]" value="<?php echo set_value('last_name', $user->last_name) ?>">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-12 control-label" for="profileAddress">Address</label>
													<div class="col-md-12">
														<input type="text" class="form-control" id="profileAddress" name="data[address]" value="<?php echo set_value('address', $user->address) ?>" >
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-12 control-label" for="profileCompany">Company</label>
													<div class="col-md-12">
														<input type="text" class="form-control" id="profileCompany" name="data[company]" value="<?php echo set_value('company', $user->company) ?>">
													</div>
												</div>
											</fieldset>
											<hr class="dotted tall">
											<h4 class="mb-xlg">About Yourself</h4>
											<fieldset>
												<div class="form-group">
													<label class="col-md-12 control-label" for="profileBio">Biographical Info</label>
													<div class="col-md-12">
														<textarea class="form-control" rows="3" id="profileBio" name="data[about_us]" ><?php echo set_value('about_us', $user->about_us) ?></textarea>
													</div>
												</div>
												<div class="form-group">
													<label class="col-xs-12 control-label mt-xs pt-none">Public</label>
													<div class="col-md-8">
														<div class="checkbox-custom checkbox-default checkbox-inline mt-xs">
															<input type="checkbox" checked="" id="profilePublic" required>
															<label for="profilePublic"></label>
														</div>
													</div>
												</div>
											</fieldset>
											<div class="panel-footer">
												<div class="row">
													<div class="col-md-12">
														<button type="submit" class="btn btn-primary">Submit</button>
														<button type="reset" class="btn btn-default">Reset</button>
													</div>
												</div>
											</div>

										</form>

									</div>
									
									<div id="profile_tab" class="tab-pane ">
										<form class="form-horizontal" method="get">
										<h4 class="mb-xlg">Personal Information</h4>
											<fieldset>
												<div class="form-group">
													<label class="col-md-12 control-label" for="">Service Locations</label>
													<div class="col-md-12">
														<input type="text" class="form-control" id="">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-12 control-label" for="">Company Phone Number</label>
													<div class="col-md-12">
														<input type="text" class="form-control" id="">
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-md-12 control-label" for="">Company Phone Number</label>
													<div class="col-md-12">
															<div class="row">
															
																<div class="col-sm-6 ">
																	<select class="custom-select form-control">
																	   <option selected="">Business Life Cycle</option>
																	   <option value="1">One</option>
																	   <option value="2">Two</option>
																	   <option value="3">Three</option>
																	</select>
																</div>
																
																<div class="col-sm-6 ">
																	<select class="custom-select form-control">
																	   <option selected="">Industry Category</option>
																	   <option value="1">One</option>
																	   <option value="2">Two</option>
																	   <option value="3">Three</option>
																	</select>
																</div>
																
																<div class="col-sm-6 ">
																	<select class="custom-select form-control">
																	   <option selected="">Service Needed</option>
																	   <option value="1">One</option>
																	   <option value="2">Two</option>
																	   <option value="3">Three</option>
																	</select>
																</div>
																
																<div class="col-sm-6">
																	<select class="custom-select form-control">
																	   <option selected="">Service</option>
																	   <option value="1">One</option>
																	   <option value="2">Two</option>
																	   <option value="3">Three</option>
																	</select>
																</div>
															
															</div>
													</div>
												</div>												
											</fieldset>
										<hr class="dotted tall">
											
										<h4 class="mb-xlg">Profile</h4>
											<fieldset>
												<div class="form-group">
													<label class="col-md-12 control-label" for="">Professional Headline</label>
													<div class="col-md-12">
														<input type="text" class="form-control" id="">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-12 control-label" for="">Summary </label>
													<div class="col-md-12">
														<input type="text" class="form-control" id="">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-12 control-label" for="">Hourly rate  </label>
													<div class="col-md-12">
														<input type="text" class="form-control" id="">
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-md-12 control-label" for="">Experience  </label>
													<div class="col-md-12">
														<input type="text" class="form-control" id="">
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-md-12 control-label" for="">Education  </label>
													<div class="col-md-12">
														<input type="text" class="form-control" id="">
													</div>
												</div>												
												
											</fieldset>
										<hr class="dotted tall">
										
										<h4 class="mb-xlg">Qualification</h4>
											<fieldset>
												<div class="form-group">
													<label class="col-md-12 control-label" for="">Professional Certificate or Accolades</label>
													<div class="col-md-12">
														<input type="text" class="form-control" id="">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-12 control-label" for="">Summary </label>
													<div class="col-md-12">
														<input type="text" class="form-control" id="">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-12 control-label" for="">Year Acquired </label>
													<div class="col-md-12">
														<input type="text" class="form-control" id="">
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-md-12 control-label" for="">Skills  </label>
													<div class="col-md-12">
														<div class="row">
															<div class="col-sm-5">
																<div class="custom-inputfile">
																	<input type="file" name="file-2[]" id="file-2" class="inputfile" data-multiple-caption="{count} files selected" multiple="">
																	<label for="file-2" class="form-control"><span>Choose a file…</span></label>
																</div>
															</div>
															<div class="col-sm-2">
																<button class="btn btn_addmore">Add more</button>
															</div>
														</div>
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-md-12 control-label" for="">Upload Additional Documents  </label>
													<div class="col-md-12">
														<div class="row">
															<div class="col-sm-5">
																<div class="custom-inputfile">
																	<input type="file" name="file-2[]" id="file-2" class="inputfile" data-multiple-caption="{count} files selected" multiple="">
																	<label for="file-2" class="form-control"><span>Choose a file…</span></label>
																</div>
															</div>
															<div class="col-sm-2">
																<button class="btn btn_addmore">Add more</button>
															</div>
														</div>
													</div>
												</div>	
												
												<div class="form-group">
													<label class="col-md-12 control-label" for="">Expertise Provided </label>
													<div class="col-md-12">
														<input type="text" class="form-control" id="">
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-md-12 control-label" for="">Licence </label>
													<div class="col-md-12">
														<div class="row">
															<div class="col-sm-4""><input type="text" class="form-control" id=""></div>
															<div class="col-sm-4">
																<div class="custom-inputfile">
																	<input type="file" name="file-2[]" id="file-2" class="inputfile" data-multiple-caption="{count} files selected" multiple="">
																	<label for="file-2" class="form-control"><span>Choose a file…</span></label>
																</div>
															</div>
															<div class="col-sm-2">
																<button class="btn btn_addmore">Add more</button>
															</div>
														</div>
													</div>
												</div>	
												<div class="form-group">
													<label class="col-md-12 control-label" for="">Accrediation </label>
													<div class="col-md-12">
														<div class="row">
															<div class="col-sm-4"><input type="text" class="form-control" id=""></div>
															<div class="col-sm-4">
																<div class="custom-inputfile">
																	<input type="file" name="file-2[]" id="file-2" class="inputfile" data-multiple-caption="{count} files selected" multiple="">
																	<label for="file-2" class="form-control"><span>Choose a file…</span></label>
																</div>
															</div>
															<div class="col-sm-2">
																<button class="btn btn_addmore">Add more</button>
															</div>
														</div>
													</div>
												</div>	
												
											</fieldset>
										
											<div class="panel-footer">
												<div class="row">
													<div class="col-md-12">
														<button type="submit" class="btn btn-primary">Submit</button>
														<button type="reset" class="btn btn-default">Reset</button>
													</div>
												</div>
											</div>
										
										</form>
									</div>
									
									<div id="change_password" class="tab-pane">

										<form class="form-horizontal" id="createform" action="<?=site_url('change-password')?>" method="post">
											
											<h4 class="mb-xlg">Change Password</h4>
											<fieldset class="mb-xl">
												<div class="form-group">
													<label class="col-md-12 control-label" for="profileoldPassword">Old Password</label>
													<div class="col-md-12">
														<input type="text" class="form-control" id="oldpass" name="oldpass" value="">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-12 control-label" for="profileNewPassword">New Password</label>
													<div class="col-md-12">
														<input type="text" class="form-control" id="password" name="password" value="" >
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-12 control-label" for="profileNewPasswordRepeat">Repeat New Password</label>
													<div class="col-md-12">
														<input type="text" class="form-control" id="cnfpassword" name="cnfpassword" value="">
													</div>
												</div>
											</fieldset>
											<div class="panel-footer">
												<div class="row">
													<div class="col-md-12">
														<button type="submit" class="btn btn-primary" id="btn_save">Submit</button>
														<button type="reset" class="btn btn-default">Reset</button>
													</div>
												</div>
											</div>

										</form>

									</div>
									
									
								</div>
							</div>
					
					</div><!--/-->
				</div>
					
			</div>
			
				
				
		</div>	<!--/main_inner-->	
				
				
		</div><!--/main-->
		</div><!--/section-dashbord-->
	</div><!--/container-->
</div> <!--/center-->

<script type="text/javascript">
     
	$("#createform").submit(function(event){
		event.preventDefault();
		alert("hello")
	})
	
	 
</script>
