<div class="page-header">
	<h2>Global Settings</h2>
</div>
<?php
$arr_default['logo'] = 'http://localhost/aldivo/assets/images/logo-leng.png';
$arr_default['seo_title'] = 'Welcome to our website';
//$arr_default['seo_descripiton'] = 'Get Mobile Covers as per your choices';
$arr_default['you_tube_code'] = 'https://www.youtube.com/watch?v=iZIkKGKeN0I';
$arr_default['show_fb'] = 1;
$arr_default['show_tw'] = 1;
$arr_default['header_block'] = '';
$arr_default['body_start'] = '';
$arr_default['body_end'] = '';
$arr_default['banner_id'] = '';
$arr_default['primary_menu'] = '';
$arr_default['offer_name'] = 'Offers';
$arr_default['best_seller'] = 'Best Sellers';
$arr_default['new_arrival'] = 'New Arrivals';
$arr_default['fan_book'] = 'Fan Book';
$arr_default['offer_id'] = 0;
$arr_default['seller_id'] = 0;
$arr_default['arrival_id'] = 0;
$arr_default['book_id'] = 0;
$arr_default['men_src'] = '';
$arr_default['women_src'] = '';
$arr_default['mobile_src'] = '';
$arr_default['about_us'] = '';
$arr_default['fanbook_banner_image'] = '';
$arr_default['store_locator'] ='';
$arr_default['coupon'] = '';
$arr_default['allbrand'] = '';
$arr_default['officeproduct'] = '';
$arr_default['home_accessories'] = '';
$arr_default['tech_accessories'] = '';
$arr_default['event'] = '';

$_GET['options'] = $options;
$_GET['default'] = $arr_default;
function get_option($fname){
	$arr_options = $_GET['options'];
	$arr_default = $_GET['default'];
	if(isset($arr_options[$fname])){
		return $arr_options[$fname];
	}else{
		if(isset($arr_default[$fname])){
			return $arr_default[$fname];
		}else{
			return NULL;
		}
	}
}
?>
<?php echo form_open(admin_url('settings'), array('class' => 'form-horizontal')); ?>
<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<div class="form-group">
			<label class="col-sm-2 control-label">Logo</label>
			<div class="col-sm-8">
				<input type="text" name="logo" value="<?= get_option('logo'); ?>" class="form-control input-sm" />
			</div>
		</div>
		<div class="form-group">
            <label class="col-sm-2 control-label">SEO Title</label>
            <div class="col-sm-8">
                <input type="text" name="seo_title" value="<?= get_option('seo_title'); ?>" class="form-control input-sm" />
            </div>
        </div>
        
		<div class="form-group">
			<label class="col-sm-2 control-label">Title</label>
			<div class="col-sm-8">
				<input type="text" name="meta_title" value="<?= get_option('meta_title'); ?>" placeholder="Youtube Video code" class="form-control input-sm" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Banner ID</label>
			<div class="col-sm-3">
				<input type="text" name="banner_id" value="<?= get_option('banner_id'); ?>" placeholder="Gallery ID for banners" class="form-control input-sm" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">All Brand Banner</label>
			<div class="col-sm-3">
				<input type="text" name="allbrand" value="<?= get_option('allbrand'); ?>" placeholder="All Brand Banner" class="form-control input-sm" />
			</div>
		</div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Office Products Banner</label>
            <div class="col-sm-3">
                <input type="text" name="officeproduct" value="<?= get_option('officeproduct'); ?>" placeholder="Office Products Banner" class="form-control input-sm" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Home Accessories Banner</label>
            <div class="col-sm-3">
                <input type="text" name="home_accessories" value="<?= get_option('home_accessories'); ?>" placeholder="Home Accessories Banner" class="form-control input-sm" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Tech Accessories Banner</label>
            <div class="col-sm-3">
                <input type="text" name="tech_accessories" value="<?= get_option('tech_accessories'); ?>" placeholder="Tech Accessories Banner" class="form-control input-sm" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Event Banner</label>
            <div class="col-sm-3">
                <input type="text" name="event" value="<?= get_option('event'); ?>" placeholder="Event Banner" class="form-control input-sm" />
            </div>
        </div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Primary Menu</label>
			<div class="col-sm-3">
				<input type="text" name="primary_menu" value="<?= get_option('primary_menu'); ?>" placeholder="Menu ID for Primary Menu" class="form-control input-sm" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Youtube Code</label>
			<div class="col-sm-8">
				<input type="text" name="you_tube_code" value="<?= get_option('you_tube_code'); ?>" placeholder="Youtube Video code" class="form-control input-sm" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Fanbook Banner Image</label>
			<div class="col-sm-8">
				<input type="text" name="fanbook_banner_image" value="<?= get_option('fanbook_banner_image'); ?>" placeholder="Fanbook Banner Image Link" class="form-control input-sm" />
			</div>
		</div>
		<div class="form-group">
            <label class="col-sm-2 control-label">Store Locator Image</label>
            <div class="col-sm-8">
                <input type="text" name="store_locator" value="<?= get_option('store_locator'); ?>" placeholder="Store Banner Image Link" class="form-control input-sm" />
            </div>
        </div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Offer Rename</label>
			<div class="col-sm-4">
				<input type="text" name="offer_name" value="<?= get_option('offer_name'); ?>" placeholder="Rename Offers to " class="form-control input-sm" />
			</div>
			<label class="col-sm-2 control-label">Offer ID</label>
			<div class="col-sm-1">
				<input type="text" name="offer_id" value="<?= get_option('offer_id'); ?>" placeholder="Offer Id" class="form-control input-sm" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Best Seller</label>
			<div class="col-sm-4">
				<input type="text" name="best_seller" value="<?= get_option('best_seller'); ?>" placeholder="Rename Best Seller to " class="form-control input-sm" />
			</div>
			<label class="col-sm-2 control-label">Seller ID</label>
			<div class="col-sm-1">
				<input type="text" name="seller_id" value="<?= get_option('seller_id'); ?>" placeholder="Best Seller Id" class="form-control input-sm" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">New Arrivals</label>
			<div class="col-sm-4">
				<input type="text" name="new_arrival" value="<?= get_option('new_arrival'); ?>" placeholder="Rename New Arrival to " class="form-control input-sm" />
			</div>
			<label class="col-sm-2 control-label">Arrival ID</label>
			<div class="col-sm-1">
				<input type="text" name="arrival_id" value="<?= get_option('arrival_id'); ?>" placeholder="New Arrival Id" class="form-control input-sm" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Rename Fanbook</label>
			<div class="col-sm-4">
				<input type="text" name="fan_book" value="<?= get_option('fan_book'); ?>" placeholder="Rename Fanbook to " class="form-control input-sm" />
			</div>
			<label class="col-sm-2 control-label">Fanbook ID</label>
			<div class="col-sm-1">
				<input type="text" name="book_id" value="<?= get_option('book_id'); ?>" placeholder="Fanbook Id" class="form-control input-sm" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Men Image</label>
			<div class="col-sm-8">
				<input type="text" name="men_src" value="<?= get_option('men_src'); ?>" placeholder="First image src" class="form-control input-sm" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Men Image</label>
			<div class="col-sm-8">
				<input type="text" name="women_src" value="<?= get_option('women_src'); ?>" placeholder="Second image src" class="form-control input-sm" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Men Image</label>
			<div class="col-sm-8">
				<input type="text" name="mobile_src" value="<?= get_option('mobile_src'); ?>" placeholder="Mobile image src" class="form-control input-sm" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Facebook</label>
			<div class="col-sm-8">
				<label class="radio radio-inline">
					<input type="radio" name="show_fb" value="1" <?= (get_option('show_fb') == 1) ? 'checked' : ''; ?> /> Show
				</label>
				<label class="radio radio-inline">
					<input type="radio" name="show_fb" value="0" <?= (get_option('show_fb') == 0) ? 'checked' : ''; ?> /> Hide
				</label>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Twitter</label>
			<div class="col-sm-8">
				<label class="radio radio-inline">
					<input type="radio" name="show_tw" value="1" <?= (get_option('show_tw') == 1) ? 'checked' : ''; ?> /> Show
				</label>
				<label class="radio radio-inline">
					<input type="radio" name="show_tw" value="0" <?= (get_option('show_tw') == 0) ? 'checked' : ''; ?> /> Hide
				</label>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Header Block</label>
			<div class="col-sm-8">
				<textarea name="header_block" class="form-control input-sm" rows="5" placeholder="Place code to put in header block"><?= get_option('header_block'); ?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">After Body Start</label>
			<div class="col-sm-8">
				<textarea name="body_start" class="form-control input-sm" rows="5" placeholder="Place code to put in header block"><?= get_option('body_start'); ?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Before Body End</label>
			<div class="col-sm-8">
				<textarea name="body_end" class="form-control input-sm" rows="5" placeholder="Place code to put in header block"><?= get_option('body_end'); ?></textarea>
			</div>
		</div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Footer About us</label>
            <div class="col-sm-8">
                <textarea name="about_us" class="form-control input-sm redactor ckeditor" rows="5" placeholder="Footer about us text"><?= get_option('about_us'); ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Coupon Details</label>
            <div class="col-sm-8">
                <textarea name="coupon" class="form-control input-sm redactor ckeditor" rows="5" placeholder="coupon"><?= get_option('coupon'); ?></textarea>
            </div>
        </div>
        
		<div class="form-group">
			<label class="col-sm-2">&nbsp;</label>
			<div class="col-sm-5">
				<input type="submit" name="submit" value="Save Settings" class="btn btn-primary btn-sm" />
				<a href="<?= admin_url('settings/restore'); ?>" class="btn btn-sm btn-default reset">Restore Default</a>
			</div>
		</div>
	</div>
	<?php
	$str = '';
	if(is_array($arr_default) && count($arr_default) > 0){
		foreach($arr_default as $key => $val){
			$str .= $key . ',';
		}
	}
	$str = rtrim($str, ',');
	?>
	<input type="hidden" name="fields" value="<?= $str; ?>" />
</div>
<script>
	$(document).ready(function(){
		$('.reset').click(function(){
			if(!confirm('It will RESET all values. Are you sure to proceed?'))
				return false;
		});
	});
</script>
<?= form_close(); ?>
<script type="text/javascript" src="<?= site_url('js/ckeditor/ckeditor.js'); ?>"></script>
    <script>
        CKEDITOR.replace( '.ckeditor' );
    </script>
