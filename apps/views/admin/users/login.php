<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Login</title>
<link href="<?php echo base_url('css/bootstrap.min.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url('css/style.css'); ?>" rel="stylesheet">
</head>

<body>

<div class="container" style="margin-top:120px;">
    <div class="col-lg-6 col-lg-offset-3">
        <div class="box">
            <div class="box-header">
                <h4 class="box-title"><b>Secure Login</b></h4>
            </div>
            <div class="box-p">
                <?php $this -> load -> view('alert'); ?>
                <?php echo form_open(admin_url('users/login'), array('class' => 'form-horizontal')); ?>
                <div class="form-group">
                    <label class="col-lg-3 control-label" for="username">Email ID:</label>
                    <div class="col-lg-6">
                        <input type="text" name="username" value="<?php echo set_value('username'); ?>" placeholder="Username" class="form-control input-sm"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label" for="password">Password:</label>
                    <div class="col-lg-6">
                        <input type="password" name="password" placeholder="Password" class="form-control input-sm" value="<?php echo set_value('password'); ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-6 col-lg-offset-3">
                        <input type="hidden" value="Login" name="submit" />
                        <button class="btn btn-primary btn-sm"><i class="fa fa-lock"></i> Login</button>
                    </div>
                </div>
                <input type="hidden" value="" name="redirect"/>
                <input type="hidden" value="submitted" name="submitted"/>
                <?php echo form_close(); ?>
            </div>
            <div class="box-bt box-p">
                <a href="<?= admin_url('users/forget'); ?>">Forgot Password</a>
                <a href="<?= site_url(); ?>" class="pull-right">Back to Website</a>
            </div>
        </div>
    </div>
</div>
</div>
<div class="footer text-center" style="position: fixed; bottom: 0; width: 100%;">
    Copyright &copy; <?php echo date('Y'); ?>. Version 1.1. Powered by <a href="http://www.arnavinfotech.com" title="Arnav Infotech" target="_blank">Arnav Infotech</a>
</div>
</body>
</html>
