<div id="mySidebar" class="sidebar">
		<ul class="nav navbar-nav side-nav sidebar-link">
			<li class="active"><a href="<?= site_url('user-dashboard') ?>"><i class="fa fa-tachometer"></i> <span>Dashboard  </span></a></li>
			<li>
				<a onclick="myFunction()" data-toggle="collapse" data-target="#submenu-2"><i class="fa fa-database"></i> <span>Project</span> </a>
				<ul id="submenu-2" class="collapse">
					<li><a href="#"><i class="fa fa-gift"></i>  <span>New project Reqest </span></a></li>
					<li><a href="#"><i class="fa fa-bookmark-o"></i>  <span>Current project </span></a></li>
					<li><a href="#"><i class="fa fa-check-square-o"></i>  <span>Completed project </span></a></li>
				</ul>
			</li>
			<li><a href="#"><i class="fa fa-cubes"></i> <span>Finance </span></a></li>
			<li><a href="#"><i class="fa fa-comments-o"></i> <span>Reviews </span></a></li>
			<li><a href="<?= site_url('user-profile') ?>"><i class="fa fa-id-card-o"></i> <span>Profile  </></a></li>
		</ul>
	</div>