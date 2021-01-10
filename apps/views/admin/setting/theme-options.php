<div class="page-header">
	<h2>Global Settings</h2>
</div>
<?php
$arr_default['logo'] = 'http://localhost/aldivo/assets/images/logo-leng.png';
$arr_default['seo_title'] = 'Welcome to our website';
//$arr_default['seo_descripiton'] = 'Get Mobile Covers as per your choices';
$arr_default['email'] = '';
//$arr_default['header_block'] = '';
//$arr_default['body_start'] = '';
//$arr_default['body_end'] = '';
$arr_default['office_address'] = '';
$arr_default['facebook'] = '';
$arr_default['google'] = '';
$arr_default['linkedin'] = '';
$arr_default['twitter'] = '';
$arr_default['background'] = '';
$arr_default['pin_codes'] = '';
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
			<label class="col-sm-2 control-label">Page Background</label>
			<div class="col-sm-8">
				<input type="text" name="background" value="<?= get_option('background'); ?>" placeholder="url for page backgroung image" class="form-control input-sm" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Home page Email</label>
			<div class="col-sm-8">
				<input type="text" name="email" value="<?= get_option('email'); ?>" placeholder="Enter email for top header" class="form-control input-sm" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Facebook link</label>
			<div class="col-sm-8">
				<input type="text" name="facebook" value="<?= get_option('facebook'); ?>" placeholder="facebook link" class="form-control input-sm" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Google link</label>
			<div class="col-sm-8">
				<input type="text" name="google" value="<?= get_option('google'); ?>" placeholder="Google link" class="form-control input-sm" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Twitter link</label>
			<div class="col-sm-8">
				<input type="text" name="twitter" value="<?= get_option('twitter'); ?>" placeholder="twitter link" class="form-control input-sm" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">linkedin link</label>
			<div class="col-sm-8">
				<input type="text" name="linkedin" value="<?= get_option('linkedin'); ?>" placeholder="linkedin link" class="form-control input-sm" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Free Shipping Pin Codes</label>
			<div class="col-sm-8">
				<textarea name="pin_codes" class="form-control input-sm" rows="5" placeholder="Place code to put in header block"><?= get_option('pin_codes'); ?></textarea>
			</div>
		</div>
		<!-- <div class="form-group">
			<label class="col-sm-2 control-label">Primary Menu</label>
			<div class="col-sm-3">
				<input type="text" name="primary_menu" value="<?= get_option('primary_menu'); ?>" placeholder="Menu ID for Primary Menu" class="form-control input-sm" />
			</div>
		</div> -->
		<div class="form-group">
			<label class="col-sm-2 control-label">Office Address</label>
			<div class="col-sm-8">
				<textarea name="office_address" class="form-control input-sm" rows="5" placeholder="Place code to put in header block"><?= get_option('office_address'); ?></textarea>
			</div>
		</div>
		<!--<div class="form-group">-->
		<!--	<label class="col-sm-2 control-label">Header Block</label>-->
		<!--	<div class="col-sm-8">-->
		<!--		<textarea name="header_block" class="form-control input-sm" rows="5" placeholder="Place code to put in header block"><?= get_option('header_block'); ?></textarea>-->
		<!--	</div>-->
		<!--</div>-->
		
		<!--<div class="form-group">-->
		<!--	<label class="col-sm-2 control-label">After Body Start</label>-->
		<!--	<div class="col-sm-8">-->
		<!--		<textarea name="body_start" class="form-control input-sm" rows="5" placeholder="Place code to put in header block"><?= get_option('body_start'); ?></textarea>-->
		<!--	</div>-->
		<!--</div>-->
		<!--<div class="form-group">-->
		<!--	<label class="col-sm-2 control-label">Before Body End</label>-->
		<!--	<div class="col-sm-8">-->
		<!--		<textarea name="body_end" class="form-control input-sm" rows="5" placeholder="Place code to put in header block"><?= get_option('body_end'); ?></textarea>-->
		<!--	</div>-->
		<!--</div>-->
  <!--      <div class="form-group">-->
  <!--          <label class="col-sm-2 control-label">Footer About us</label>-->
  <!--          <div class="col-sm-8">-->
  <!--              <textarea name="about_us" class="form-control input-sm redactor ckeditor" rows="5" placeholder="Footer about us text"><?= get_option('about_us'); ?></textarea>-->
  <!--          </div>-->
  <!--      </div>-->
      <!--   <div class="form-group">
            <label class="col-sm-2 control-label">Coupon Details</label>
            <div class="col-sm-8">
                <textarea name="coupon" class="form-control input-sm redactor ckeditor" rows="5" placeholder="coupon"><?= get_option('coupon'); ?></textarea>
            </div>
        </div> -->
        <!--<div class="form-group">
            <label class="col-sm-2 control-label">Quick Links</label>
            <div class="col-sm-8">
                <textarea name="quick_links" class="form-control input-sm redactor ckeditor" rows="5" placeholder="quick_links"><?/*= get_option('quick_links'); */?></textarea>
            </div>
        </div>-->
        
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
