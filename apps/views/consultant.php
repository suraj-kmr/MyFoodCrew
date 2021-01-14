<div id="center" class="dashbord-pinner">
	<div class="container">
		<div class="section-dashbord">
			<?php $this->load->view('side-bar') ;?>
	<div id="main">
		<div class="dashbord-head">
			<div class="opnclose">
			<button id="btnsidebar" onclick="openNav()"><i class="fa fa-bars" aria-hidden="true"></i></button>
			</div>
			Name/Username
		</div>
		<div class="main_inner">
			<div class="page-title main_title">
				<h4 class="">Dashbord</h4>
			</div>
				
			<div class="row">
				<div class="col-sm-3">
					<div class="dbpl_box widget1">
						<div class="dbpl_boxicon"><i class="fa fa-desktop"></i></div>
						<div class="stats">CurrentProjects</div>
					</div><!--/dbpl_box-->
				</div><!--/col-sm-3-->
				
				<div class="col-sm-3">
					<div class="dbpl_box widget2">
						<div class="dbpl_boxicon"><i class="fa fa-star"></i></div>
						<div class="stats">Total Revenu</div>
					</div><!--/dbpl_box-->
				</div><!--/col-sm-3-->
				
				<div class="col-sm-3">
					<div class="dbpl_box widget3">
						<div class="dbpl_boxicon"><i class="fa fa-check-square-o"></i></div>
						<div class="stats">Total Completed Projects</div>
					</div><!--/dbpl_box-->
				</div><!--/col-sm-3-->
				
				<div class="col-sm-3">
					<div class="dbpl_box widget4">
						<div class="dbpl_boxicon"><i class="fa fa-gift"></i></div>
						<div class="stats">New Project Request</div>
					</div><!--/dbpl_box-->
				</div><!--/col-sm-3-->
				
				<div class="col-sm-3">
					<div class="dbpl_box widget5">
						<div class="dbpl_boxicon"><i class="fa fa-pie-chart"></i></div>
						<div class="stats">Average Project Revenue</div>
					</div><!--/dbpl_box-->
				</div><!--/col-sm-3-->
				
				<div class="col-sm-3">
					<div class="dbpl_box widget6">
						<div class="dbpl_boxicon"><i class="fa fa-calendar"></i></div>
						<div class="stats">Total Numberof Days Worked</div>
					</div><!--/dbpl_box-->
				</div><!--/col-sm-3-->
				
				
			</div>
			
			<div class="dbp_info">
								
					<div class="dbp_tinfo">
						<div class="dbp_tinfosearch">
							<div class="dbp_search">
								<div class="input-group">
								  <input type="text" class="form-control" placeholder="Search..">
								  <span class="input-group-addon" id="basic-addon2"><i class="fa fa-search" aria-hidden="true"></i></span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-9 col-md-10 col-lg-8">
								<div class="dbp_tinfo_list">
									<ul>
										<li>Date Filter</li>
										<li>	
											<div class="dbp_datefilter">
											<div class="input-group datepicker_box">
											  <input id="datasearch"  placeholder="Fill Date" type="text" data-plugin-datepicker class="form-control datepicker_input">
											  <span class="input-group-addon" id="basic-addon2"><i class="fa fa-calendar" aria-hidden="true"></i></span>
											</div>
											</div>
										</li>
										<li>To</li>
										<li>	
											<div class="dbp_datefilter">
											<div class="input-group datepicker_box">
											  <input id="datasearch2" placeholder="Fill Date" type="text" data-plugin-datepicker class="form-control datepicker_input">
											  <span class="input-group-addon" id="basic-addon2"><i class="fa fa-calendar" aria-hidden="true"></i></span>
											</div>
											</div>
										</li>										
										<li>
											<div class="dropdown dbfilter">
											  <button id="dLabel" type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												Dropdown trigger
												<span class="caret"></span>
											  </button>
											  <ul class="dropdown-menu" aria-labelledby="dLabel">
												<li><a href="#">Action</a></li> <li><a href="#">Another action</a></li> <li><a href="#">Something else here</a></li> <li role="separator" class="divider"></li> <li><a href="#">Separated link</a></li> 
											  </ul>
											</div>
										</li>
										<li>
											<button type="button" class="btn btn-default">
												<i class="fa fa-search" aria-hidden="true"></i>
											</button>
										</li>
									<ul>
								</div><!--/dbp_tinfo_left-->
							</div><!--/col-7-->
							
							<div class="col-sm-3 col-md-2 col-lg-4">
								<div class="dbp_tinfo_list right_list">
									<ul>
										<li>
											<button type="button" class="btn btn-default">
											<i class="fa fa-external-link" aria-hidden="true"></i> Export</button>
										</li>
									</ul>
								</div><!--/dbp_tinfo_left-->
							</div><!--/col-6-->
						
						</div>
						
						

					</div><!--/dbp_tinfo-->
					
					
					<div class="dbp_dinfo">
					<div class="dbp_table">
						<table class="table table-bordered">
						  <thead>
							<tr>
							  <th class="chkbox_thh">
								<div class="checkbox-custom checkbox-default checkbox-inline mt-xs">
									<input type="checkbox" checked="" id="ck1">
									<label for="ck1"></label>
								</div>
							  </th>
							  <th>Name <span class="th_updown"><i class="fa fa-sort" aria-hidden="true"></i></span></th>
							  <th>Date of request <span class="th_updown"><i class="fa fa-sort" aria-hidden="true"></i></span></th>
							  <th>Email Id <span class="th_updown"><i class="fa fa-sort" aria-hidden="true"></i></span></th>
							  <th>Category <span class="th_updown"><i class="fa fa-sort" aria-hidden="true"></i></span></th>
							  <th>Phone <span class="th_updown"><i class="fa fa-sort" aria-hidden="true"></i></span></th>
							  <th>Budget <span class="th_updown"><i class="fa fa-sort" aria-hidden="true"></i></span></th>
							  <th>Date to Complete <span class="th_updown"><i class="fa fa-sort" aria-hidden="true"></i></span></th>
							  <th>Status <span class="th_updown"><i class="fa fa-sort" aria-hidden="true"></i></span></th>
							  <th>Action <span class="th_updown"><i class="fa fa-sort" aria-hidden="true"></i></span></th>
							</tr>
						  </thead>
						  <tbody>
							<tr>
							<td>
								<div class="checkbox-custom checkbox-default checkbox-inline mt-xs">
									<input type="checkbox" checked="" id="ck2">
									<label for="ck2"></label>
								</div>
							  </td>
							  <td>Mark</td>
							  <td>15 Dec 2020</td>
							  <td>john@gmail.com</td>
							  <td>Food</td>
							  <td>12345678900</td>
							  <td>5000</td>
							  <td>12 jan 2021</td>
							  <td>
								<select class="custom-select_bk form-control">
									<option>Pending</option>
									<option>Accept</option>
									<option>Reject</option>
								</select>
							  </td>
							 <td><a href="dashboard-page10.html">View Details<a/></td>
							</tr>
							<tr>
								<td>
								<div class="checkbox-custom checkbox-default checkbox-inline mt-xs">
									<input type="checkbox" checked="" id="ck3">
									<label for="ck3"></label>
								</div>
							  </td>
							  <td>Mark</td>
							  <td>15 Dec 2020</td>
							  <td>john@gmail.com</td>
							  <td>Food</td>
							  <td>12345678900</td>
							  <td>5000</td>
							  <td>12 jan 2021</td>
							  <td>
								<select class="custom-select_bk form-control">
									<option>Pending</option>
									<option>Accept</option>
									<option>Reject</option>
								</select>
							  </td>
							 <td><a href="dashboard-page10.html">View Details<a/></td>
							</tr>
							<tr>
							<td>
								<div class="checkbox-custom checkbox-default checkbox-inline mt-xs">
									<input type="checkbox" checked="" id="ck4">
									<label for="ck4"></label>
								</div>
							  </td>
							  <td>Mark</td>
							  <td>15 Dec 2020</td>
							  <td>john@gmail.com</td>
							  <td>Food</td>
							  <td>12345678900</td>
							  <td>5000</td>
							  <td>12 jan 2021</td>
							  <td>
								<select class="custom-select_bk form-control">
									<option>Pending</option>
									<option>Accept</option>
									<option>Reject</option>
								</select>
							  </td>
							  <td><a href="dashboard-page10.html">View Details<a/></td>
							</tr>
						  </tbody>
						</table>
						</div><!--/dbp_table-->
					
					</div>
				
				</div><!--/dbp_info-->
				
				
		</div>	<!--/main_inner-->	
				
				
		</div><!--/main-->
		</div><!--/section-dashbord-->
	</div><!--/container-->
</div> <!--/center-->