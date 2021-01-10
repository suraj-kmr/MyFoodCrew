<div class="page-header">
	<h2>Edit Post Form</h2>
</div>
<?php echo form_open_multipart('post/edit/'.$post['id']); ?> 
<input type="hidden" name="route_id" value="<?php echo $post['route_id']; ?>" />
<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#description_tab" data-toggle="tab">Description</a></li>
		<li><a href="#attributes_tab" data-toggle="tab">Attributes</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="description_tab">
			
			<fieldset>
				<label for="category">Category </label>
                <?php 
					$ddmenu[0] = 'No Category';
					foreach($categories as $row){
						$ddmenu[$row->id] = $row -> name;
					}
				?>
                <?php echo form_dropdown('category_id', $ddmenu, $post['category_id']); ?>
                <label for="name">Name</label>
                <input type="text" name="post_title" value="<?php echo set_value('post_title', $post['post_title']); ?>" class="span8" />
                <input type="checkbox" name="show_title" value="1" <?php if($post['show_title']) echo 'Checked';?> /> Show title                
				<?php echo form_error('post_title');?>
                <label for="uniquepath">Slug</label>
                <input type="text" name="slug" value="<?php echo set_value('slug', $post['slug']);  ?>" class="span8" />
                <?php 
					$path = base_url();
					$newpath = str_replace('admin/','',$path);
				?>
                <label>Full Path</label>
                <div class="well well-small"><?php echo $newpath; ?>post.php?q=<?php echo $post['slug'];  ?></div>
                <?php /*?><label for="price">Price</label>
                <input type="text" name="price" value="<?php echo set_value('price',$post['price']);  ?>" class="span8" /><?php */?>
                <label for="excerpt">Excerpt</label>
                <textarea rows="6" cols="" class="span8" name="excerpt"><?php echo set_value('excerpt', $post['excerpt']);  ?></textarea>
				<label for="Description">Description</label>
                <?php
				$data	= array('name'=>'description', 'class'=>'redactor', 'value'=>set_value('description', $post['description']));
				echo form_textarea($data);
				?>
                <label for="image">Image</label>
				<div class="input-append">
					<?php echo form_upload(array('name'=>'image'));?>
				</div>                
                <?php if($post['image'] != ''){ ?>
						<div style="text-align:center; padding:5px; border:1px solid #ddd;"><img src="<?php echo base_url('uploads/images/full/'.$post['image']);?>" alt="current"/><br/>Current File<br />                        
                        </div>
                        <label class="checkbox">
                        <input type="hidden" name="hid_image" value="<?php echo $post['image']; ?>" />
                        <input type="checkbox" name="del_image" value="1" />Delete this image
                        </label>
				<?php }?>
                <label for="status">Status</label>
                <?php echo form_dropdown('status', $status, $post['status']); ?>
			</fieldset>
		</div>

		<div class="tab-pane" id="attributes_tab">
			
			<fieldset>
            	<label for="name">SEO Title</label>
                <input type="text" name="seo_title" value="<?php echo set_value('seo_title', $post['seo_title']);?>" class="span4" />
                
				<label for="slug">Meta</label>
				<?php
				$data	= array('rows'=>3, 'name'=>'meta', 'value'=>set_value('meta', html_entity_decode($post['meta'])), 'class'=>'span12');
				echo form_textarea($data);
				?>
				<p class="help-block">ex. &lt;meta name=&quot;description&quot; content=&quot;We sell products that help you&quot; /&gt;</p>
			</fieldset>	
			
		</div>		
	</div>

</div>

<div class="form-actions">
	<input type="hidden" name="id" value="<?php echo $post['id']; ?>" />
	<input type="hidden" name="submit" value="Submit" />
	<button type="submit" class="btn btn-primary">Save</button>
</div>
</form>

<script type="text/javascript">
$('form').submit(function() {
	$('.btn').attr('disabled', true).addClass('disabled');
});
</script>