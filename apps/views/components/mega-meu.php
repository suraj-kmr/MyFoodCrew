<div class="navouter clearfix navbar-static-top affix-top" id="nav">
    <div class="container menu_img_dropdown">
        <!--<ul class="navmenu">-->
        <!--    <li>-->
        <!--        <a class="home_icon" href="<?= site_url(); ?>">-->
        <!--            <i class="fa fa-home"></i>-->
        <!--        </a>-->
        <!--    </li>-->
        <!--</ul>-->
        <ul class="menu-drop-down1 navmenu">
<?php
$menu_id = theme_option('primary_menu');
$menu_html = $this -> Menu_model -> allMenuGroup($menu_id);
foreach($menu_html as $menu){
    if($menu -> menu_parent == 0){
            ?>
    <li><a href="<?= $menu -> menu_url; ?>"><?php echo $menu -> menu_title; ?></a><?php }
    $has_child = $this->Menu_model->hasChild($menu->id);
    if (is_array($has_child) && count($has_child) > 0) {
        ?>
                <div class="mdrop-down">
                    <?= $menu -> description; ?>
                    <p></p>
                    <ul class="menu-drop-down1 menu-1">
                        <?php
        foreach($has_child as $chid) {
            //print_r($chid);
            ?>
            <li class="menu-drop-down2">
                <?php
                if($chid->link_type==1){
                    //$cob = new AI_Category($chid->menu_url);
                    echo '<a style="text-align:center" href="'.$chid->menu_url.'">';
                }
                elseif($chid->link_type==2){
                    $cob = new AI_Category($chid->menu_url);
                    echo '<a style="text-align:center" href="'.$cob->permalink().'">';
                }
                elseif($chid->link_type==3){ ?>
                    <a style="text-align:center" href="<?= site_url('page/'.$cob->permalink()); ?>">
                    <?php
                }
                    else{
                        echo '<a style="text-align:center" href="#">';
                    }
                ?>

                    <?php
                    if(!$chid->image==''){
                    ?>
                    <img class="menu_image_dropdown" src="<?= site_url(upload_dir($chid->image)); ?>"> <?php } ?> <br><?= $chid->menu_title; ?>
                </a></li>
        <?php
        }
            ?>
                    </ul>
                </div>
        </li>
        <?php
    }
}
?>
        </ul>
    </div>
</div>