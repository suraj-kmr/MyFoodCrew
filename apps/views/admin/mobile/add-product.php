<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script src="<?php echo base_url('assets/plugins/tinymce/tinymce.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/jquery-fancybox/jquery.fancybox.js'); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/jquery-fancybox/jquery.fancybox.css'); ?>">
<script src="<?php echo base_url('assets/plugins/validate/validate.js'); ?>"></script>
<script type="text/javascript">
	var base_url = '<?php echo base_url(); ?>';
	var url = '<?php echo base_url(); ?>';
	var areaZoom = 10;
	function descriptMedia(images){
		if(images.length > 0)
		{
			var html = '';
			for(i=0; i<images.length; i++)
			{
				html = html + '<img src="'+images[i]+'" alt="" />';
			}
			tinymce.activeEditor.execCommand('mceInsertContent', false, html);
			jQuery.fancybox.close();
		}
	}
</script>
<script type="text/javascript">
	var base_url = '<?php echo base_url(); ?>';
	var url = '<?php echo base_url(); ?>';
	var areaZoom = 10;
	function descriptMedia(images){
		if(images.length > 0)
		{
			var html = '';
			for(i=0; i<images.length; i++)
			{
				html = html + '<img src="'+images[i]+'" alt="" />';
			}
			tinymce.activeEditor.execCommand('mceInsertContent', false, html);
			jQuery.fancybox.close();
		}
	}
	tinymce.PluginManager.add('dgmedia', function(editor, url) {
		// Add a button that opens a window
		editor.addButton('dgmedia', {
			text: 'Add images',
			icon: false,
			onclick: function() {
				jQuery.fancybox( {href : base_url + 'admin/media/modals/descriptMedia/1', type: 'iframe'} );
			}
		});
	});
	tinymce.init({
		selector: ".text-edittor",
		menubar: false,
		toolbar_items_size: 'small',
		statusbar: false,
		setup: function(editor) {
			editor.addButton('mybutton', {
				text: 'My button',
				icon: false,
				onclick: function() {
					editor.insertContent('Main button');
				}
			});
		},
		plugins: [
			"advlist autolink lists link image charmap print preview anchor",
			"searchreplace visualblocks code fullscreen",
			"insertdatetime media table contextmenu paste dgmedia"
		],
		toolbar: "code | insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | dgmedia"
	});
</script>
<?php
if(validation_errors() <> ''){
	?>
	<div class="alert alert-danger">
		<?php echo validation_errors('<p>'); ?>
	</div>
<?php
}
?>
<form enctype="multipart/form-data" method="post" action="<?= site_url().'admin/mobile/addcover/'.$data -> id;?>" class="form-horizontal">
	<div class="panel panel-default">
		<div class="panel-heading">
			<i class="fa fa-external-link-square icon-external-link-sign"></i>
			<?php echo ($data -> id == false) ? "New Ads" : "Edit Ads"; ?>
		</div>
		<div class="modal-body">
			<div class="form-group">
				<label class="control-label col-sm-2">Mobile Brand</label>
				<div class="col-sm-3">
					<?php
					$d = array(
						'' => 'Select Brand'
					);
					if(is_array($albrands) && count($albrands) > 0){
						foreach($albrands as $b){
							$d[$b -> id] = $b -> brand;
						}
					}
					echo form_dropdown('data[brand_id]', $d, set_value('data[brand_id]', $data -> brand_id), 'class="form-control" id="brandid"');
					?>
				</div>
				<label class="control-label col-sm-2">Mobile Set</label>
				<div class="col-sm-3">
					<?php
					$dr = array(
						'' => 'Mobile Set'
					);
					if($data -> brand_id > 0){
						$subset = $this -> mobile_m -> allMobile($data -> brand_id);
						if(is_array($subset) && count($subset) > 0){
							foreach($subset as $ss){
								$dr[$ss -> id] = $ss -> title;
							}
						}
					}
					echo form_dropdown('data[mobile_id]', $dr, set_value('data[mobile_id]', $data -> mobile_id), 'class="form-control" id="mobileid"');
					?>
				</div>
			</div>
			<script type="text/javascript">
				$(document).ready(function(){
					$('#brandid').on('change', function(e){
						var vi = $(this).val();
						$.ajax({
							url: '<?= site_url('ajax/mobile_sets'); ?>',
							data: 'bid=' + vi,
							method: 'POST',
							dataType: 'html',
							success: function(r){
								$('#mobileid').empty().append(r);
							}
						});
					});
				});
			</script>
			<div class="form-group">
				<label class="col-sm-2 control-label">Cover Type</label>
				<div class="col-sm-10">
					<label class="radio radio-inline">
						<input type="radio" name="data[cover_type]" value="2D" <?= set_radio('data[cover_type]', '2D', ($data -> cover_type == '2D')); ?> /> 2D
					</label>
					<label class="radio radio-inline">
						<input type="radio" name="data[cover_type]" value="3D" <?= set_radio('data[cover_type]', '3D', ($data -> cover_type == '3D')); ?> /> 3D
					</label>
					<label class="radio radio-inline">
						<input type="radio" name="data[cover_type]" value="Transparent" <?= set_radio('data[cover_type]', 'Transparent', ($data -> cover_type == 'Transparent')); ?> /> Transparent
					</label>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2">Product name<span class="symbol required"></span></label>
				<div class="col-sm-6">
					<input type="text" name="data[pname]" value="<?= set_value('data[pname]', $data -> pname); ?>" class="form-control input-sm"  />
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2">Slug</label>
				<div class="col-sm-4">
					<input type="text" name="data[slug]" value="<?= set_value('data[slug]', $data -> slug); ?>" class="form-control input-sm"  />
				</div>
				<label class="control-label col-sm-2">SKU</label>
				<div class="col-sm-2">
					<input type="text" name="data[sku]" value="<?= set_value('data[sku]', $data -> sku); ?>" class="form-control input-sm"  />
				</div>
			</div>
			<div class="form-group imageRow">
				<label class="control-label col-sm-2">Banner Image</label>
				<div class="col-sm-4">
					<?php
					if(isset($d['image']))
					{
						echo '<div id="image-box-img-bg" class="pull-left" style="display:inline;">';
						echo '<img src="'.base_url($d['image']).'" class="pull-left box-image" style="width: 80px;" alt="image" />';
					}elseif($data->image != '')
					{
						echo '<div id="image-box-img-bg" class="pull-left" style="display:inline;">';
						echo '<img src="'.base_url($data->image).'" class="pull-left box-image" style="width: 80px;" alt="image" />';
					}else
					{
						echo '<div id="image-box-img-bg" class="pull-left" style="display:none;">';
					}
					?>
				</div>
				<input type="hidden" name="data[image]" id="image-box-img-view" value="<?= $data->image; ?>">
				<a href="#" onclick="jQuery.fancybox( {href : '<?php echo site_url().'admin/media/modals/imageImg/1'; ?>', type: 'iframe'} );" class="btn btn-sm btn-primary">Choose File</a>
				</div>
			</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Description</label>
			<div class="col-sm-10">
				<textarea name="data[description]" rows="" cols="" class="form-control text-edittor"><?= set_value('data[description]', $data -> description); ?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Key Points</label>
			<div class="col-sm-10">
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#key1" role="tab" data-toggle="tab">Key Points 1</a></li>
					<li role="presentation"><a href="#key2" role="tab" data-toggle="tab">Key Points 2</a></li>
					<li role="presentation"><a href="#key3" role="tab" data-toggle="tab">Key Points 3</a></li>
					<li role="presentation"><a href="#key4" role="tab" data-toggle="tab">Key Points 4</a></li>
				</ul>
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="key1">
						<textarea name="data[key_points1]" rows="" cols="" class="form-control text-edittor"><?= set_value('data[key_points1]', $data -> key_points1); ?></textarea>
					</div>
					<div role="tabpanel" class="tab-pane" id="key2">
						<textarea name="data[key_points2]" rows="" cols="" class="form-control text-edittor"><?= set_value('data[key_points2]', $data -> key_points2); ?></textarea>
					</div>
					<div role="tabpanel" class="tab-pane" id="key3">
						<textarea name="data[key_points3]" rows="" cols="" class="form-control text-edittor"><?= set_value('data[key_points3]', $data -> key_points3); ?></textarea>
					</div>
					<div role="tabpanel" class="tab-pane" id="key4">
						<textarea name="data[key_points4]" rows="" cols="" class="form-control text-edittor"><?= set_value('data[key_points4]', $data -> key_points4); ?></textarea>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Key Features</label>
			<div class="col-sm-10">
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#feature1" aria-controls="home" role="tab" data-toggle="tab">Features 1</a></li>
					<li role="presentation"><a href="#feature2" aria-controls="profile" role="tab" data-toggle="tab">Features 2</a></li>
					<li role="presentation"><a href="#feature3" aria-controls="messages" role="tab" data-toggle="tab">Features 3</a></li>
					<li role="presentation"><a href="#feature4" aria-controls="settings" role="tab" data-toggle="tab">Features 4</a></li>
				</ul>
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="feature1">
						<textarea name="data[key_features1]" rows="" cols="" class="form-control text-edittor"><?= set_value('data[key_features1]', $data -> key_features1); ?></textarea>
					</div>
					<div role="tabpanel" class="tab-pane" id="feature2">
						<textarea name="data[key_features2]" rows="" cols="" class="form-control text-edittor"><?= set_value('data[key_features2]', $data -> key_features2); ?></textarea>
					</div>
					<div role="tabpanel" class="tab-pane" id="feature3">
						<textarea name="data[key_features3]" rows="" cols="" class="form-control text-edittor"><?= set_value('data[key_features3]', $data -> key_features3); ?></textarea>
					</div>
					<div role="tabpanel" class="tab-pane" id="feature4">
						<textarea name="data[key_features4]" rows="" cols="" class="form-control text-edittor"><?= set_value('data[key_features4]', $data -> key_features4); ?></textarea>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Design &amp; Style</label>
			<div class="col-sm-6">
				<input type="text" name="data[design_style]" value="<?= set_value('data[design_style]', $data -> design_style); ?>" class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Brand</label>
			<div class="col-sm-2">
				<input type="text" name="data[brand_name]" value="<?= set_value('data[brand_name]', $data -> brand_name); ?>" class="form-control" />
			</div>
			<label class="col-sm-2 control-label">Material</label>
			<div class="col-sm-2">
				<input type="text" name="data[material]" value="<?= set_value('data[material]', $data -> material); ?>" class="form-control" />
			</div>
			<label class="col-sm-2 control-label">Model</label>
			<div class="col-sm-2">
				<input type="text" name="data[model]" value="<?= set_value('data[model]', $data -> model); ?>" class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Weight(gm)</label>
			<div class="col-sm-2">
				<input type="text" name="data[weight]" value="<?= set_value('data[weight]', $data -> weight); ?>" class="form-control" />
			</div>
			<label class="col-sm-2 control-label">Water Proof</label>
			<div class="col-sm-2">
				<?php
				$wp = array(
					1 => 'Yes',
					0 => 'No'
				);
				echo form_dropdown('data[water_proof]', $wp, set_value('data[water_proof]', $data -> water_proof), 'class="form-control"');
				?>
			</div>
			<label class="col-sm-2 control-label">Sale Package</label>
			<div class="col-sm-2">
				<input type="text" name="data[sale_package]" value="<?= set_value('data[sale_package]', $data -> sale_package); ?>" class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">MRP</label>
			<div class="col-sm-2">
				<input type="text" name="data[mrp]" value="<?= set_value('data[mrp]', $data -> mrp); ?>" class="form-control" />
			</div>
			<label class="col-sm-2 control-label">Sell Price</label>
			<div class="col-sm-2">
				<input type="text" name="data[sell_price]" value="<?= set_value('data[sell_price]', $data -> sell_price); ?>" class="form-control" />
			</div>
			<label class="col-sm-2 control-label">Shipping Charge</label>
			<div class="col-sm-2">
				<input type="text" name="data[shipping_charge]" value="<?= set_value('data[shipping_charge]', $data -> shipping_charge); ?>" class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-2">Status <span class="symbol required"></span></label>
			<div class="col-md-2">
				<?php
				echo form_dropdown('data[status]', array('1' => 'Publish', '0' => 'Unpublish'), set_value('data[status]', $data -> status), 'class="form-control input-sm"');
				?>
			</div>
		</div>
		<hr />
		<div class="form-group">
			<div class="col-sm-10 col-sm-offset-2">
				<button type="submit" class="btn btn-primary" ><?php echo lang('save'); ?></button>
				<a href="<?php echo base_url('admin/banners'); ?>" class="btn btn-danger" ><?php echo lang('cancel'); ?></a>
			</div>
		</div>
	</div>
</form>
<script type="text/javascript">

	function imageImg(images)
	{
		if(images.length > 0)
		{
			var e = jQuery('#image-box-img-bg');
			if(e.children('img').length > 0)
				e.children('img').attr('src', images[0]);
			else
				e.append('<img src="'+images[0]+'" class="pull-left box-image" style="width: 80px;" alt="" width="100" />');
			e.css('display', 'inline');
			var str = images[0];
			str = str.replace("<?php echo site_url();?>", "");
			jQuery('#image-box-img-view').val(str);
			jQuery.fancybox.close();
		}
	}

	function removeImg(e){
		var e = jQuery('#image-box-img-bg');
		e.children('img').remove();
		e.css('display', 'none');
		jQuery('#image-box-img-view').val('');
	}
</script>
