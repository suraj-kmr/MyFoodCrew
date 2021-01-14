<div id="center" class="dashbord-pinner">
	<div class="container">
	<div class="section-dashbord">

	<?php  $this->load->view('side-bar') ?>

	<div id="main">
		<div class="dashbord-head">
			<div class="opnclose">
			<button id="btnsidebar" onclick="openNav()"><i class="fa fa-bars" aria-hidden="true"></i></button>
			</div>
			Name/Username
		</div>
		<div class="main_inner">
		
		<div class="page-title main_title">
			<h4 class="">Project</h4>
		</div>
		
		<div class="dashbord_tabs">
			<!-- Nav tabs -->
			<ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active"><a href="#all_project" aria-controls="all_project" role="tab" data-toggle="tab">All </a></li>
				<li role="presentation"><a href="#new_project" aria-controls="new_project" role="tab" data-toggle="tab">New</a></li>
				<li role="presentation"><a href="#current_project" aria-controls="current_project" role="tab" data-toggle="tab">Current </a></li>
				<li role="presentation"><a href="#completed_project" aria-controls="completed_project" role="tab" data-toggle="tab">Completed </a></li>
			</ul>
			  <!-- Tab panes -->
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="all_project"><div class="dbp_info">
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
					
					<div class="pagination_main">
						<nav aria-label="Page navigation">
						  <ul class="pagination">
							<li>
							  <a href="#" aria-label="Previous">
								<span aria-hidden="true">&laquo;</span>
							  </a>
							</li>
							<li><a href="#">1</a></li>
							<li><a href="#">2</a></li>
							<li><a href="#">3</a></li>
							<li><a href="#">4</a></li>
							<li><a href="#">5</a></li>
							<li>
							  <a href="#" aria-label="Next">
								<span aria-hidden="true">&raquo;</span>
							  </a>
							</li>
						  </ul>
						</nav>
					</div><!--/pagination_main-->
				
				</div><!--/dbp_info-->
				</div>
				<div role="tabpanel" class="tab-pane" id="new_project">New</div>
				<div role="tabpanel" class="tab-pane" id="current_project">Current</div>
				<div role="tabpanel" class="tab-pane" id="completed_project">Completed</div>
			</div>

			
			
		</div><!--/dashbord_tabs-->
				
				
		</div>	<!--/main_inner-->	
				
				
		</div><!--/main-->
		</div><!--/section-dashbord-->
		
	</div><!--/container-->
</div> <!--/center-->