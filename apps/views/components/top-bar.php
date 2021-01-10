<div class="what-hot">
    <div class="container mb-4">
        <div class="row mt-4">
            <div class="col-sm-4">
                
            </div>
            <div class="col-sm-8">
                <?php if(is_object($user) ){  ?>
                    <p class="user-info last_login float-right">Welcome back <b><?php $user -> first_name; ?></b> | Last Login: <?= date('jS M, Y h:i:s a', strtotime($user -> lastvisitdate)); ?></p>
                <?php } ?>
            </div>
        </div>