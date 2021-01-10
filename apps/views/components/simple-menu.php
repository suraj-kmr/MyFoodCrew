<style type="text/css">
header{padding:0;}
.navmenu{display: table;}
/* The side navigation menu */
.sidenav {
    height: 100%; /* 100% Full-height */
    width: 0; /* 0 width - change this with JavaScript */
    position: fixed; /* Stay in place */
    z-index: 999; /* Stay on top */
    top: 0;
    left: 0;
    background-color: #111; /* Black*/
    overflow-x: hidden; /* Disable horizontal scroll */
    padding-top: 30px; /* Place content 60px from the top */
    transition: 0.5s; /* 0.5 second transition effect to slide in the sidenav */
}
.navmenu > li > a{padding: 5px; height: auto;}
.sidenav ul{margin: 0; padding: 0;}
.sidenav li{width: 100%;}
/* The navigation menu links */
.sidenav li a {
    padding: 8px 8px 8px 32px;
    text-decoration: none;
    font-size: 12px;
    color: #fff;
    display: block;
    transition: 0.3s
}

/* When you mouse over the navigation links, change their color */
.sidenav a:hover, .offcanvas a:focus{
    color: #f1f1f1;
}

/* Position and style the close button (top right corner) */
.sidenav .closebtn {
    position: absolute;
    top: 0;
    right: 25px;
    font-size: 20px;
    margin-left: 50px; color: #fff;
}

/* Style page content - use this if you want to push the page content to the right when you open the side navigation */
#main {
    transition: margin-left .5s;
    padding: 20px;
}
.mobile-menu-container{padding: 10px 0; background: #fff; border-bottom: solid 1px #EEE; position: fixed; left: 0; width: 100%; z-index: 99;}

.menutabgroup{text-align: right; padding-top: 8px; font-size: 16px;}
.menutabgroup .menutab{display: inline-block; margin-left: 15px;}
.menu-mobile-search{padding-top: 10px;}
.main-body{padding-top: 50px;}
.menunav{padding-top: 8px;}
.my-logo{margin-top: 8px; width: 40%; }
.my-menu{width:50%;}
.logo-img{margin-top:-2px !important;}
@media screen and (max-height: 450px) {
    .sidenav {padding-top: 15px;}
    .sidenav a {font-size: 14px;}
    .mobile-menu .col-xs-2{text-align: center;}
    
}

</style>
<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <?php
                    $menu_id = theme_option('primary_menu');
                    echo $menu_html = $this -> Menu_model -> simpleMenu($menu_id, array('ul_class' => 'navmenu'));
                    ?>
</div>

    <div class="mobile-menu-container">
    <div class="container">
        <div class="row mobile-menu">
            <div class="col-xs-1 menunav" onclick="openNav()"><i class="fa fa-align-justify"></i> </div>
            <div class="col-xs-3 my-logo">
                <a href="<?= site_url (); ?>"><img src="<?php echo base_url(upload_dir('aldivo_new_logo.png')); ?>"
                                                       class="img-responsive logo-img" /> </a>
            </div>
            <div class="col-xs-7 my-menu">
                <div class="menutabgroup">
                    <span class="menutab"><i class="fa fa-search" id="searchicon"></i></span>
                    <span class="menutab"><a href="<?= site_url('accounts/wishlists'); ?>"><i class="fa fa-heart-o"></i></a></span>
                    <span class="menutab"><a href="<?php echo site_url('cart') ?>"><i class="fa fa-shopping-cart"></i></a></span>
                <span class="menutab">
                    <?php
                    $login = site_url("user/login");
                    if($this -> session -> has_userdata('login')){
                        $login = site_url("accounts");
                    }
                    ?>
                    <a href="<?= $login; ?>"><i class="fa fa-user"></i></a>
                </span>
                </div>
            </div>
        </div>
        <div class="menu-search-mobile" style="display: none;">
                            <form method="get" action="<?= site_url('store/search'); ?>">
                                <div class="input-group">
                                    <input type="search" name="q" class="form-control input-sm" placeholder="Search" />
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-sm btn-inverse"><span style="color: #f68122;" class="fa fa-search"></span></button>
                                    </div>
                                </div>
                            </form>
                        </div>
    </div>
    </div>	
<!-- Use any element to open the sidenav -->

<script type="text/javascript">
/* Set the width of the side navigation to 250px */
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
}

/* Set the width of the side navigation to 0 */
function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}

	$(document).ready(function(){		
		$('#searchicon').click(function(){
			$('.menu-search-mobile').slideToggle("show");
		});
	});
</script>


