<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Dashboard</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<!-- Bootstrap core CSS -->
	<link href="<?php echo base_url ('css/bootstrap.min.css'); ?>" rel="stylesheet">
	<link href="<?php echo base_url ('assets/fa/css/font-awesome.min.css'); ?>" rel="stylesheet">
	<link href="<?php echo base_url ('css/jquery-ui.css'); ?>" rel="stylesheet">
	<link href="<?php echo base_url ('css/style.css'); ?>" rel="stylesheet">
	<!-- Load Javascript at footer for faster loading page -->
	<script type="text/javascript" src="<?php echo base_url ('js/jquery-1.10.2.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url ('js/jquery-ui.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url ('js/bootstrap.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url ('js/ckeditor/ckeditor.js'); ?>"></script>
	<script>
		CKEDITOR.replace('.ckeditor');
	</script>
	<script type="text/javascript">
		$(document).ready(function () {
			$('.delete').click(function () {
				if (!confirm('Are you sure to delete??'))
					return false;
			});
			$('.datepicker').datepicker({dateFormat: 'yy-mm-dd'});
		});
	</script>
</head>

<body>
<div class="top-header">
	<b>Origin CMS</b> | Dashboard
</div>
<nav class="navbar navbar-default" role="navigation">
	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="<?php echo site_url ($this->config->item ('admin') . '/dashboard'); ?>">Admin
			Panel</a>
	</div>

	<!-- Collect the nav links, forms, and other content for toggling -->
	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		<ul class="nav navbar-nav">
			<li class="active"><a href="<?php echo site_url ($this->config->item ('admin') . '/dashboard'); ?>">Dashboard</a>
			</li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Catalog <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo site_url ($this->config->item ('admin') . '/categories'); ?>">Categories</a>
					</li>
					<li><a href="<?php echo site_url ($this->config->item ('admin') . '/categories/add'); ?>">Add
							New</a></li>
					<li class="divider"></li>
					<li><a href="<?php echo site_url ($this->config->item ('admin') . '/products'); ?>">Products</a>
					</li>
					<li><a href="<?php echo site_url ($this->config->item ('admin') . '/products/add'); ?>">Add
							Product</a></li>
					<li class="divider"></li>
					<li><a href="<?php echo site_url ($this->config->item ('admin') . '/posted_ads/subscriptions'); ?>">Subscription</a>
					</li>
				</ul>
			</li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Pages <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo site_url ($this->config->item ('admin') . '/pages'); ?>">All Pages</a></li>
					<li><a href="<?php echo site_url ($this->config->item ('admin') . '/pages/add'); ?>">Add New</a>
					</li>
				</ul>
			</li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Content<b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo site_url ($this->config->item ('admin') . '/media'); ?>">All Media</a></li>
					<li><a href="<?php echo site_url ($this->config->item ('admin') . '/media/add'); ?>">Add New</a>
					</li>
					<li class="divider"></li>
					<li><a href="<?php echo site_url ($this->config->item ('admin') . '/emails'); ?>">Emails</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Users<b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo site_url ($this->config->item ('admin') . '/members'); ?>">All Users</a>
					</li>
					<li><a href="<?php echo site_url ($this->config->item ('admin') . '/members/add'); ?>">Add New</a>
					</li>
				</ul>
			</li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Settings<b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo site_url ($this->config->item ('admin') . '/settings'); ?>">Plans</a></li>
					<li>
						<a href="<?php echo site_url ($this->config->item ('admin') . '/settings/options'); ?>">Options</a>
					</li>
					<li class="divider"></li>
					<li><a href="<?php echo site_url ($this->config->item ('admin') . '/city/statelist'); ?>">State</a>
					</li>
					<li><a href="<?php echo site_url ($this->config->item ('admin') . '/city'); ?>">City</a></li>
					<li>
						<a href="<?php echo site_url ($this->config->item ('admin') . '/city/locations'); ?>">Locations</a>
					</li>
				</ul>
			</li>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Account <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo site_url (); ?>" target="_blank">Front End</a></li>
					<li class="divider"></li>
					<li><a href="<?php echo site_url ($this->config->item ('admin') . '/users/logout'); ?>">Logout</a>
					</li>
				</ul>
			</li>
		</ul>
	</div>
	<!-- /.navbar-collapse -->
</nav>
<div class="container" style="padding-top: 10px; padding-bottom: 10px;">
	<div class="row">
		<?php
		if ($this->session->flashdata ('success')) {
			?>
			<div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<?php echo $this->session->flashdata ('success'); ?>
			</div>
		<?php
		}
		?>
		<?php
		if ($this->session->flashdata ('info')) {
			?>
			<div class="alert alert-info">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<?php echo $this->session->flashdata ('info'); ?>
			</div>
		<?php
		}
		?>
		<?php
		if ($this->session->flashdata ('error')) {
			?>
			<div class="alert alert-danger">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<?php echo $this->session->flashdata ('error'); ?>
			</div>
		<?php
		}
		?>
		<?php
		if ($this->session->flashdata ('warning')) {
			?>
			<div class="alert alert-warning">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<?php echo $this->session->flashdata ('warning'); ?>
			</div>
		<?php
		}
		?>
		<?php
		$err = validation_errors ();
		if ($err) {
			?>
			<div class="alert alert-danger">
				<?php echo $err; ?>
			</div>
		<?php
		}
		?>
	</div>
	<?php $this->load->view ($main); ?>
</div>
<div class="footer text-center">
	Copyright &copy; <?php echo date ('Y'); ?>. Version 1.1. Powered by <a href="http://www.originitsolution.com"
	                                                                       title="Origin IT Solution" target="_blank">Origin
		IT Solution</a>
</div>
</body>
</html>
