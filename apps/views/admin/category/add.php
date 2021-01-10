<div class="page-header">
	<h2>Category Form</h2>
</div>
<?php echo validation_errors();
$url = '';
    if(isset($_GET['type']) && $_GET['type'] == 'link')
    {
        $url = 'categories/add/'.$cat -> id.'?type=link';
    }
    else{
        $url = 'categories/add/'.$cat -> id;
    }
?>
<?php echo form_open_multipart(admin_url($url), array('class' => 'form-horizontal')); ?>
<div class="row">
	<div class="col-sm-12">
		<div class="tab-pane active" id="description_tab">
			<div class="form-group">
               
				<label class="col-sm-2 control-label">Name</label>
				<div class="col-sm-3">
					<input type="text" name="cat[name]" value="<?= set_value('cat[name]', $cat -> name); ?>" class="form-control" />
				</div>
				<label class="col-sm-2 control-label">Parent </label>
				<div class="col-sm-3">
                    <select name="cat[parent_id]" class="form-control form-category input-sm">
                        <option value="">Select Parent</option>
                        <!--<option value="0">Parent</option>-->
                        <?php
                        $this->db->select('id,name');
                        $this -> db -> where('parent_id', 0);
                        $gift = $this -> db -> get('categories')->result();
                        if(is_array($gift) && count($gift) > 0){
                            foreach($gift as $gf){
                                ?>
                                <option value="<?= $gf -> id; ?>" <?php if($cat -> parent_id == $gf -> id) echo "selected=selected"; ?>><?= $gf -> name; ?></option>
                            <?php
                            }
                        }
                        ?>
					<?php

					//echo form_dropdown('cat[parent_id]', $categories, $cat -> parent_id,  'class="form-control form-category input-sm"');
					?>
                    </select>
				</div>
			</div>
			<script type="text/javascript">
				$(document).ready(function(){
					$('.form-category').change(function(){
						var this_id     = $(this).val();
						$.ajax({
							url: '<?= site_url('ajax/load_category') ?>',
							data: 'cat_id=' + this_id,
							type: 'POST',
							dataType: 'html',
							success: function(e){
								//alert(e);
								$('#subcatid').html(e);
							}
						});
					});
				});
			</script>
			<div class="form-group">
				<label class="col-sm-2 control-label">Sub Categories </label>
				<div class="col-sm-3">
                    <select name="cat[category_type]" class="form-control form-category1 input-sm" id="subcatid">
                     <?php
    					if($cat -> id){
    						$this->db->select('id,name');
                            $this -> db -> where('parent_id', $cat->parent_id);
                            $gift = $this -> db -> get('categories')->result();
                            //echo $this->db->last_query();die;
                            if(is_array($gift) && count($gift) > 0){
                                foreach($gift as $gf){
                                    ?>
                                    <option value="<?= $gf -> id; ?>" <?php if($cat -> parent_id == $gf -> id) echo "selected=selected"; ?>><?= $gf -> name; ?></option>
                                <?php
                                }
                            }
    
    					}
                        ?>   
					<?php

					//echo form_dropdown('cat[parent_id]', $categories, $cat -> parent_id,  'class="form-control form-category input-sm"');
					?>
                    </select>
				</div>
				<label class="col-sm-2 control-label">Popular Category</label>
				<div class="col-sm-5">
					<label class="checkbox-inline"><input type="checkbox" name="cat[popular_cat]" value="1" <?php if($cat -> popular_cat == 1) echo 'checked'; ?> /> Yes </label>
				</div>
				
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Slug</label>
				<div class="col-sm-4">
					<input type="text" name="cat[slug]" value="<?= set_value('cat[slug]', $cat -> slug); ?>" class="form-control" />
				</div>
				<label class="col-sm-2 control-label">Sequence</label>
				<div class="col-sm-2">
					<input type="text" name="cat[sequence]" value="<?= set_value('cat[sequence]', $cat -> sequence); ?>" class="form-control" />
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">Description</label>
				<div class="col-sm-8">
					<textarea name="cat[description]" rows="4" cols="" class="form-control"><?= set_value('cat[description]', $cat -> description); ?></textarea>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-2 control-label">Status</label>
				<div class="col-sm-3">
					<?php
					$st = array(
						1 => 'Active',
						0 => 'Deactive'
					);
					echo form_dropdown('cat[status]', $st, $cat -> status, 'class="form-control input-sm"');
					?>
				</div>
				<label class="col-sm-2 control-label">Image</label>
				<div class="col-sm-4">
					<div class="input-append">
						<?php echo form_upload(array('name'=>'image'));?>
					</div>

					<?php if($cat -> id && $cat -> image != ''):?>

						<div style="text-align:center; padding:5px; border:1px solid #ddd;"><img class="img-responsive img-thumbnail" src="<?php echo base_url('img/uploads/'.$cat -> image);?>" alt="current"/><br/>Current File</div>
						<label class="checkbox checkbox-inline">
							<input type="hidden" name="hid_image" value="<?php echo $cat -> image; ?>" />
							<input type="checkbox" name="del_image" value="1" />Delete this image
						</label>
					<?php endif;?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">SEO Title</label>
				<div class="col-sm-8">
					<input type="text" name="cat[seo_title]" value="<?= set_value('cat[seo_title]', $cat -> seo_title); ?>" class="form-control" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">SEO Description</label>
				<div class="col-sm-8">
					<textarea name="cat[seo_description]" rows="2" cols="" class="form-control"><?= set_value('cat[seo_description]', $cat -> seo_description); ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">SEO Keywords</label>
				<div class="col-sm-8">
					<textarea name="cat[seo_keywords]" rows="2" cols="" class="form-control"><?= set_value('cat[seo_keywords]', $cat -> seo_keywords); ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Mobile Veiw Category</label>
				<div class="col-sm-3">
					<label class="checkbox-inline"><input type="checkbox" name="cat[mobile_cat]" value="1" <?php if($cat -> mobile_cat == 1) echo 'checked'; ?> /> Yes </label>
				</div>
				<label class="col-sm-2 control-label">color</label>
				<div class="col-sm-1">
					<input type="color" name="cat[color]" value="<?= set_value('cat[color]', $cat -> color); ?>" class="form-control" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">&nbsp;</label>
				<div class="col-sm-8">
					<button type="submit" class="btn btn-primary btn-sm">Save</button> <a href="<?= admin_url('categories'); ?>" class="btn btn-sm btn-default">Cancel</a>
				</div>
			</div>
		</div>
	</div>
</div>

</form>
<script type="text/javascript">
    $('#pid').change(function(){
        var pid = $('#pid').val();
        //alert(pid);
        $.ajax({
            type: "POST",
            url: "<?php echo admin_url('categories/getparentcat'); ?>",
            data: 'pid=' + pid,
            success: function(f){
                $('.form-category1').empty().append(f);
            }
        })
    });

</script>
