<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title><?php if (isset($page_title)) echo $page_title; else echo 'Dashboard'; ?></title>
	<link rel="shortcut icon" href="http://www.originitsolution.com/img/fevi.ico"/>
	<link href="<?php echo base_url ('assets/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css"/>
	<link href="<?php echo base_url ('assets/fa/css/font-awesome.css'); ?>" rel="stylesheet" type="text/css"/>
	<link type="text/css" href="<?php echo base_url ('css/jquery-ui.css'); ?>" rel="stylesheet"/>
	<link type="text/css" href="<?php echo base_url ('css/redactor.css'); ?>" rel="stylesheet"/>
	<link href="<?php echo base_url ('css/style.css'); ?>" rel="stylesheet" type="text/css"/>
	<script src="<?php echo base_url ('js/jquery-1.10.2.min.js'); ?>"></script>
	<script src="<?php echo base_url ('js/jquery-ui.js'); ?>"></script>
	<script src="<?php echo base_url ('js/bootstrap.min.js'); ?>"></script>
	<script src="<?php echo base_url ('js/redactor.js'); ?>"></script>
	<script src="<?php echo base_url ('js/custom.js'); ?>"></script>
	<script>
		$(document).ready(function () {
			$('.calender').datepicker();
			$('a.delete').click(function () {
				if (!confirm('Are you sure to delete?'))
					return false;
			});
			$('.datepicker').datepicker({dateFormat: 'yy-mm-dd'});
			$('.redactor').redactor({
				focus: true
			});
			$('.tip').tooltip();
		});
	</script>
</head>

<body>
<?php
$nick_name = $this -> session -> userdata('username');
?>
<div class="navbar navbar-fixed-top bs-docs-nav" role="banner">
	<div class="conjtainer">
		<!-- Menu button for smallar screens -->
		<div class="navbar-header">
			<button class="navbar-toggle btn-navbar" type="button" data-toggle="collapse"
			        data-target=".bs-navbar-collapse">
				<span>Menu</span>
			</button>
			<!-- Site name for smallar screens -->
			<a href="<?php echo admin_url ('dashboard'); ?>" class="navbar-brand hidden-lg">Admin</a>
		</div>


		<!-- Navigation starts -->
		<nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">

			<ul style="display: none;" class="nav navbar-nav">

				<!-- Upload to server link. Class "dropdown-big" creates big dropdown -->
				<li class="dropdown dropdown-big">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-success"><i
								class="fa fa-cloud-upload"></i></span> Upload to Cloud</a>
					<!-- Dropdown -->
					<ul class="dropdown-menu">
						<li>
							<!-- Progress bar -->
							<p>Photo Upload in Progress</p>
							<!-- Bootstrap progress bar -->
							<div class="progress progress-striped active">
								<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="40"
								     aria-valuemin="0" aria-valuemax="100" style="width: 40%">
									<span class="sr-only">40% Complete</span>
								</div>
							</div>

							<hr/>

							<!-- Progress bar -->
							<p>Video Upload in Progress</p>
							<!-- Bootstrap progress bar -->
							<div class="progress progress-striped active">
								<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="80"
								     aria-valuemin="0" aria-valuemax="100" style="width: 80%">
									<span class="sr-only">80% Complete</span>
								</div>
							</div>

							<hr/>

							<!-- Dropdown menu footer -->
							<div class="drop-foot">
								<a href="#">View All</a>
							</div>

						</li>
					</ul>
				</li>

				<!-- Sync to server link -->
				<li class="dropdown dropdown-big">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-danger"><i
								class="fa fa-refresh"></i></span> Sync with Server</a>
					<!-- Dropdown -->
					<ul class="dropdown-menu">
						<li>
							<!-- Using "icon-spin" class to rotate icon. -->
							<p><span class="label label-info"><i class="fa fa-cloud"></i></span> Syncing Members Lists
								to Server</p>
							<hr/>
							<p><span class="label label-warning"><i class="fa fa-cloud"></i></span> Syncing Bookmarks
								Lists to Cloud</p>

							<hr/>

							<!-- Dropdown menu footer -->
							<div class="drop-foot">
								<a href="#">View All</a>
							</div>

						</li>
					</ul>
				</li>

			</ul>

			<!-- Search form -->
			<a href="<?= admin_url('dashboard'); ?>" class="nav-dashboard">Dashboard</a>
			<!-- Links -->
			<ul class="nav navbar-nav pull-right">
				<li class="dropdown pull-right">
					<a data-toggle="dropdown" class="dropdown-toggle" href="#">
						<i class="fa fa-user"></i> Admin <b class="caret"></b>
					</a>

					<!-- Dropdown menu -->
					<ul class="dropdown-menu">
						<li><a href="<?= site_url(); ?>" target="_blank"><i class="fa fa-desktop"></i> Front View</a></li>
						<li><a href="<?= admin_url ('profile'); ?>"><i class="fa fa-user"></i> Profile</a></li>
						<li><a href="<?= admin_url ('settings'); ?>"><i class="fa fa-cogs"></i> Settings</a></li>
						<li><a href="<?= admin_url ('users/logout'); ?>"><i
									class="fa fa-sign-out"></i> Logout</a></li>
					</ul>
				</li>

			</ul>
		</nav>

	</div>
</div>


<!-- Header starts -->
<header>
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<div class="logo">
					<h1><a href="<?php echo admin_url('dashboard'); ?>"><span class="bold">Dashboard</span></a></h1>

					<p class="meta">Secure Admin area by Origin IT Solution</p>
				</div>
			</div>
		</div>
	</div>
</header>

<!-- Header ends -->
<div class="content">
	<div class="sidebar">
		<div class="sidebar-dropdown"><a href="#">Navigation</a></div>
		<ul id="nav">
			<li class="<?php if ($active_tabs == 'dashboard') echo 'open'; ?>"><a
					href="<?= admin_url ('dashboard'); ?>"><i class="fa fa-home"></i> Dashboard</a></li>
			<li class="has_sub <?php if ($active_tabs == 'catalog') echo 'open'; ?>"><a href="#"><i
						class="fa fa-list-alt"></i> Catalog <span class="pull-right"><i
							class="fa fa-chevron-right"></i></span></a>
				<ul>
					<li><a href="<?= admin_url ('categories'); ?>">Manage Categories</a></li>
					<li><a href="<?= admin_url ('categories/add'); ?>">Add Category</a></li>
					<li><a href="<?= admin_url ('products'); ?>">Manage Products</a></li>
					<li><a href="<?= admin_url ('products/add'); ?>">Add Product</a></li>
					<li><a href="<?= admin_url ('products/designs'); ?>">T-Shirt Designs</a></li>
					<li><a href="<?= admin_url ('products/offers'); ?>">Offers &amp; Discounts</a></li>
					<li><a href="<?= admin_url ('mobiles'); ?>">Mobile Handsets</a></li>
					<li><a href="<?= admin_url ('mobiles/brands'); ?>">Mobile Brands</a></li>
				</ul>
			</li>
			<li class="has_sub <?php if ($active_tabs == 'orders') echo 'open'; ?>"><a href="#"><i
						class="fa fa-shopping-cart"></i> Sales &amp; Orders <span class="pull-right"><i
							class="fa fa-chevron-right"></i></span></a>
				<ul>
					<li><a href="<?= admin_url ('orders'); ?>">Recent Orders</a></li>
					<li><a href="<?= admin_url ('orders/?status=0'); ?>">Pendings Orders</a></li>
					<li><a href="<?= admin_url ('orders/track'); ?>">Track Orders</a></li>
					<li><a href="<?= admin_url ('orders/refund'); ?>">Refund Request</a></li>
				</ul>
			</li>
			<li class="has_sub <?php if ($active_tabs == 'members') echo 'open'; ?>"><a href="#"><i
						class="fa fa-users"></i> Members <span class="pull-right"><i
							class="fa fa-chevron-right"></i></span></a>
				<ul>
					<li><a href="<?= admin_url ('members'); ?>">Registered Users</a></li>
					<li><a href="<?= admin_url ('members/add'); ?>">Add User</a></li>
					<li><a href="<?= admin_url ('members/subscriptions'); ?>">Email Subscription</a></li>
				</ul>
			</li>
			<li class="has_sub <?php if ($active_tabs == 'payments') echo 'open'; ?>"><a href="#"><i
						class="fa fa-money"></i> Payments <span class="pull-right"><i
							class="fa fa-chevron-right"></i></span></a>
				<ul>
					<li><a href="<?= admin_url ('payments'); ?>">Recent Payments</a></li>
					<li><a href="<?= admin_url ('payments/history'); ?>">Payment History</a></li>
				</ul>
			</li>
			<li class="has_sub <?php if ($active_tabs == 'appearance') echo 'open'; ?>"><a href="#"><i class="fa fa-desktop"></i> Appearance <span class="pull-right"><i class="fa fa-chevron-right"></i></span></a>
				<ul>
					<li><a href="<?= admin_url ('gallery'); ?>">Gallery</a></li>
					<li><a href="<?= admin_url ('menu'); ?>">Menus</a></li>
				</ul>
			</li>
			<li class="has_sub <?php if ($active_tabs == 'media') echo 'open'; ?>"><a href="#"><i class="fa fa-image"></i> Media &amp; Settings <span class="pull-right"><i class="fa fa-chevron-right"></i></span></a>
				<ul>
					<li><a href="<?= admin_url ('media'); ?>">Media Manager</a></li>
					<li><a href="<?= admin_url ('media/add'); ?>">Upload Media</a></li>
					<li><a href="<?= admin_url ('settings'); ?>">Global Settings</a></li>
					<li><a href="<?= admin_url ('pages'); ?>">Static Pages</a></li>
					<li><a href="<?= admin_url ('settings/pincodes'); ?>">Pincode Coverage</a></li>
				</ul>
			</li>
		</ul>
	</div>
	<div class="mainbar">
		<div class="page-head">
			<h2 class="pull-left"><i class="fa fa-home"></i> <?= $dashboard_title; ?></h2>

			<!-- Breadcrumb -->
			<div class="bread-crumb pull-right">
				<a href="<?= admin_url ('dashboard'); ?>"><i class="fa fa-home"></i>
					Home</a>
				<!-- Divider -->
				<span class="divider">/</span>
				<a href="#" class="bread-current"><?= $dashboard_title; ?></a>
			</div>

			<div class="clearfix"></div>

		</div>
		<div class="matter">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<?php
						if ($this->session->flashdata ('error')) {
							?>
							<div class="alert alert-danger alert-dismissable"><i
									class="fa fa-remove"></i> <?= $this->session->flashdata ('error'); ?>
								<a
									href="" class="close">&times;</a></div>
						<?php
						}
						if ($this->session->flashdata ('success')) {
							?>
							<div class="alert alert-success alert-dismissable"><i
									class="fa fa-check"></i> <?= $this->session->flashdata ('success'); ?>
								<a
									href="" class="close">&times;</a></div>
						<?php
						}
						?>
						<?php
						$error = validation_errors ();
						if ($error != '') {
							echo '<div class="alert alert-danger">';
							echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
							echo validation_errors ();
							echo '</div>';
						}
						?>
					</div>
				</div>
			</div>
			<div class="container">
				<?php $this->load->view ($main); ?>
			</div>
		</div>
	</div>
</div>

<div class="footer text-center">
    Copyright &copy; <?php echo date('Y'); ?>. Version 1.1. Powered by <a href="http://www.arnavinfotech.com" title="Arnav Infotech" target="_blank">Arnav Infotech</a>
</div>
</body>
</html>
