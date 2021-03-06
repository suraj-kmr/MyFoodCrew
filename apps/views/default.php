<!DOCTYPE html>
<html  style=""><head>
 <meta http-equiv="content-type" content="text/html; charset=windows-1252">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
 <title>My Food Crew</title>

 
 <link rel="stylesheet" href="assets/css/style.css" type="text/css" media="all">
 <link rel="stylesheet" href="assets/css/font-awesome.css">
 <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css" media="all">
 <link rel="stylesheet" href="assets/css/font-awesome.css">
 <link rel="stylesheet" href="assets/css/theme-custom.css">
  
</head>

<body id="dashbord-pages">

<?php 

if($this->session->userdata('login')){ ?>
<div id="header">
	<nav class="navbar navbar-default" role="navigation">
    	  <div class="container">
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-brand-centered">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <div class="navbar-brand logo navbar-brand-centered"><img src="img/logo.png"></div>
		    </div>

		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="collapse navbar-collapse" id="navbar-brand-centered">
		      <ul class="nav navbar-nav">
		        <li><a href="#">Home</a></li>
		        <li><a href="#">How It Works</a></li>
		      </ul>
		      <ul class="nav navbar-nav navbar-right">
		       <li>
					<div class="dropdown notificatin_drop">
						<a id="notifi_pop" role="button" data-toggle="dropdown" data-target="#" href="/page.html">
							<i class="fa fa-bell"></i>
							<div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
						</a>
							  
						<ul class="dropdown-menu notifications" role="menu" aria-labelledby="notifi_pop">
							
							<div class="notification-heading">
								<h4 class="menu-title">Notifications</h4>
							</div>
							
						   <div class="notifications-wrapper">
								<ul>
									<li>
										<a class="content" href="#">
										   <div class="notification-item">
											<h4 class="item-title">Evaluation Deadline 1 · day ago</h4>
											<p class="item-info">Marketing 101, Video Assignment</p>
										   </div>
										</a>
									</li>
									<li>
										<a class="content" href="#">
										   <div class="notification-item">
											<h4 class="item-title">Evaluation Deadline 1 · day ago</h4>
											<p class="item-info">Marketing 101, Video Assignment</p>
										   </div>
										</a>
									</li>
									<li>
										<a class="content" href="#">
										   <div class="notification-item">
											<h4 class="item-title">Evaluation Deadline 1 · day ago</h4>
											<p class="item-info">Marketing 101, Video Assignment</p>
										   </div>
										</a>
									</li>
									<li>
										<a class="content" href="#">
										   <div class="notification-item">
											<h4 class="item-title">Evaluation Deadline 1 · day ago</h4>
											<p class="item-info">Marketing 101, Video Assignment</p>
										   </div>
										</a>
									</li>
									<li>
										<a class="content" href="#">
										   <div class="notification-item">
											<h4 class="item-title">Evaluation Deadline 1 · day ago</h4>
											<p class="item-info">Marketing 101, Video Assignment</p>
										   </div>
										</a>
									</li>
								</ul>
						   </div>
						   <div class="notification-footer">
							 <h4 class="menu-title"><a href="#">View all<i class="glyphicon glyphicon-circle-arrow-right"></i></a></h4>
						   </div>
						</ul>					  
					</div>
				
				</li>
		        <li><a href="user-profile.html"><i class="fa fa-user" aria-hidden="true"></i></a></li>
		        <li><a href="<?= site_url('logout') ?>">Logout</a></li>
		      </ul>
		    </div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>

</div><!--/header-->
<?php }else{ ?>
<div id="header">
	<div class="head_top">
		<div class="container">
			<div class="row">
				<div class="col-sm-6">
					<div class="head_list">
						<ul>
							<li><a href="#."><i class="fa fa-phone" aria-hidden="true"></i> +3214569870</a></li>
							<li><a href="#."><i class="fa fa-envelope-o" aria-hidden="true"></i> info@myfoodcrew.it</a></li>
						</ul>
					</div><!--/head_list-->
				</div>
				<div class="col-sm-6">
					<div class="head_list hl_right">
						<ul>
							<li><a href="#."><i class="fa fa-facebook-square" aria-hidden="true"></i></a></li>
							<li><a href="#."><i class="fa fa-twitter-square" aria-hidden="true"></i></a></li>
							<li><a href="#."><i class="fa fa-instagram" aria-hidden="true"></i> </a></li>
							<li><a href="#."><i class="fa fa-pinterest-square" aria-hidden="true"></i> </a></li>
						</ul>
					</div><!--/head_list-->
				</div>
			</div>
		</div><!--/container-->
	</div><!--/head-top-->
	<nav class="navbar navbar-default" role="navigation">
    	  <div class="container">
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-brand-centered">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <div class="navbar-brand logo navbar-brand-centered"><img src="img/logo.png"></div>
		    </div>

		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="collapse navbar-collapse" id="navbar-brand-centered">
		      <ul class="nav navbar-nav">
		        <li><a href="<?= site_url() ?>">Home</a></li>
		        <li><a href="#">How It Works</a></li>
		      </ul>
		      <ul class="nav navbar-nav navbar-right">
		        <li><a href="<?= site_url('login') ?>" >Login</a></li>
		        <li><a href="<?= site_url('register') ?>" >Sign Up</a></li>
		      </ul>
		      <!-- <ul class="nav navbar-nav navbar-right">
		        <li><a href="#" data-toggle="modal" data-target="#login_poup">Login</a></li>
		        <li><a href="#" data-toggle="modal" data-target="#signup_poup">Sign Up</a></li>
		      </ul> -->
		    </div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>

</div><!--/header-->

<?php } ?>



<!-- ========================================================================= -->

                      <?php $this->load->view($main); ?>

<!-- ========================================================================= -->



<div id="footer">
	<div class="container">
		<div class="footer_top">
		<div class="row">
			<div class="col-sm-12 col-md-6 col-lg-3">
				<div class="footer_box">
					<div class="foot-logo"><img src="img/logo.png"></div>
					<ul>
						<li>Lorem ipsum dolor amet coadipisicing elit sed do eiusmod tempor incididun</li>
						<li><a href="#.">info@myfoodcrew.it</a></li>
					</ul>
				</div>
			</div><!--/col-4-->
			
			<div class="col-sm-6 col-lg-3">
				<div class="footer_box">
					<h4>Lorem ipsum dolor</h4>
					<ul>  
						<li><a href="#.">Lorem ipsum dolor</a></li>
						<li><a href="#.">Lorem ipsum dolor</a></li>
						<li><a href="#.">Lorem ipsum dolor</a></li>
						<li><a href="#.">Lorem ipsum dolor</a></li>
						<li><a href="#.">Lorem ipsum dolor</a></li>
						<li><a href="#.">Lorem ipsum dolor</a></li>
					</ul>
				</div>
			</div><!--/col-4-->

			<div class="col-sm-6 col-lg-3">
				<div class="footer_box">
					<h4>Lorem ipsum dolor</h4>
					<ul>    
						<li><a href="#.">Lorem ipsum dolor</a></li>
						<li><a href="#.">Lorem ipsum dolor</a></li>
						<li><a href="#.">Lorem ipsum dolor </a></li>
						<li><a href="#.">Lorem ipsum dolor</a></li>
						<li><a href="#.">Lorem ipsum dolor</a></li>
						<li><a href="#.">Lorem ipsum dolor</a></li>
					</ul>
				</div>
			</div><!--/col-4-->

			<div class="col-sm-12 col-md-6 col-lg-3">
				<div class="footer_box">
					<div class="row">
						<div class="col-sm-6 col-md-12">
							<h4>Newsletter</h4>
							<div class="newsletter_fom">
								<input type="email" class="form-control" placeholder="Email">
								<button type="submit" class="btn"><img src="img/arrow_next.png"></button>
							</div>
						</div>
						
						<div class="col-sm-5 col-md-12">
							<h4>Follow Us</h4>
							<div class="footsocial">
								<ul>
									<li><a href="#."><img src="img/foot_fb.png"></a></li>
									<li><a href="#."><img src="img/foot_insta.png"></a></li>
								</ul>
							</div>
						</div>
					
					</div>
					<p>Copyright 2020 All Rights Reserved </p>
				
				</div>
			</div><!--/col-4-->
		</div>
		</div><!--/footer_top-->

	</div>
</div>



<script type="text/javascript" src="assets/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="assets/css/bootstrap-datepicker3.css"/>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" ></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script>
$(window).scroll(function(){
    if ($(this).scrollTop() > 150) {
       $('#header').addClass('header_fix');
    } else {
       $('#header').removeClass('header_fix');
    }
});
</script>

<script>
	$('#datasearch').datepicker({
		uiLibrary: 'bootstrap'
	});
	$('#datasearch2').datepicker({
		uiLibrary: 'bootstrap'
	});
</script>
<script>
$(document).ready(function(){  
    $("#btnsidebar").click(function(){  
        $("#dashbord-pages").toggleClass("opensidebar");  
    });  
});
</script>
<script>
$(function(){
    $('[data-toggle="tooltip"]').tooltip();
    $(".side-nav .collapse").on("hide.bs.collapse", function() {                   
        $(this).prev().find(".fa").eq(1).removeClass("fa-angle-right").addClass("fa-angle-down");
    });
    $('.side-nav .collapse').on("show.bs.collapse", function() {                        
        $(this).prev().find(".fa").eq(1).removeClass("fa-angle-down").addClass("fa-angle-right");        
    });
})    
    

</script>



</body>

</html>