<div class="page-header">
	<h2>Add Menu Link</h2>
</div>
<?php echo form_open_multipart(admin_url('menu/editlink/'.$menu['id']), array('class' => 'form-horizontal')); ?>
<div class="tabbable">
	<div class="form-group">
    	<label for="menu_group" class="col-sm-2">Menu Group</label>
        <div class="col-sm-2">
		<?php
            $options = '';
            foreach($menu_group as $row){
                $options[$row['id']] = $row['group_name'];
            }
        ?>
        <?php echo form_dropdown('group_id', $options, $group_id, 'id = "group_id" class="form-control input-sm"');?>
    	</div>
    </div>
    <div class="form-group">
		<label for="title" class="col-sm-2">Title</label>
    	<div class="col-sm-6">
        	<input type="text" name="menu_title" class="form-control input-sm" value="<?php echo set_value('menu_title', $menu['menu_title']); ?>" />
        </div>
    </div>
    <div class="form-group">
   	 	<label for="parent_id" class="col-sm-2">Child Of</label>
    	<div id="parent_id" class="col-sm-2">
            <select name="parent_id" class="form-control input-sm">
            	<option value="0" <?php if($menu['menu_parent'] == 0) echo 'Selectd'; ?>>Top Page</option>
            	<?php list_pages($parents, $menu['menu_parent']); ?>
            </select>
            <?php
				function list_pages($parents, $sel = 0, $sep = ''){
					foreach($parents as $p){
						$selected = 0;
						if($p['id'] == $sel) $selected = 'selected';
						echo '<option value="'.$p['id'].'" '.$selected.'>'.$sep.$p['menu_title'].'</option>';
						if(count($p['children']) > 0){
							list_pages($p['children'], $sel, $sep.$p['menu_title'].'&rarr; ');
						}
					}
				}
			?>
        </div>
    </div>
    <div class="form-group">
		<label for="title" class="col-sm-2">Sequence</label>
    	<div class="col-sm-1">
        	<input type="text" name="sequence" class="form-control input-sm" value="<?php echo set_value('sequence', $menu['sequence']); ?>"/>
        </div>
    </div>
    <div class="form-group">
    	<label for="target" class="col-sm-2">Link Type</label>
    	<div class="col-sm-6">
        <label class="radio-inline">
            <input type="radio" name="link_type" value="1" data-type="linkbox" class="option" <?php if($menu['link_type'] == 1) echo 'checked'; ?> />Link
        </label>
        <label class="radio-inline">
            <input type="radio" name="link_type" value="2" data-type="categorydd" class="option" <?php if($menu['link_type'] == 2) echo 'checked'; ?>/>Category
         </label>
         <label class="radio-inline">
            <input type="radio" name="link_type" value="3" data-type="pagedd" class="option" <?php if($menu['link_type'] == 3) echo 'checked'; ?>/>Pages
         </label>
         <label class="radio-inline">
            <input type="radio" name="link_type" value="4" data-type="postdd" class="option" <?php if($menu['link_type'] == 4) echo 'checked'; ?>/>Post
        </label>
        <div id="linkbox" class="linktype <?php if($menu['link_type'] == 1) echo 'active'; ?>">
    		<input type="text" name="link_url" id="link_url_id" class="form-control input-sm" value="<?php echo set_value('link_url', $menu['menu_url']); ?>">
    	</div>
        <div id="categorydd" class="linktype <?php if($menu['link_type'] == 2) echo 'active'; ?>">
    	<?php $category_dd[0] = 'Select'; ?>
		<?php echo form_dropdown('category_dd', $category_dd, $menu['menu_url'], 'class="linkdd form-control input-sm"');?>
        </div>
        <div id="pagedd" class="linktype <?php if($menu['link_type'] == 3) echo 'active'; ?>">
            <?php $page_dd[0] = 'Select'; ?>
            <?php echo form_dropdown('page_dd', $page_dd, $menu['menu_url'], 'class="linkdd form-control input-sm"');?>
        </div>
        <div id="postdd" class="linktype <?php if($menu['link_type'] == 4) echo 'active'; ?>">
            <?php
                $post_dd[0] = 'Select';
                echo form_dropdown('post_dd', $post_dd, $menu['menu_url'], 'class="linkdd form-control input-sm"');
            ?>
        </div>
        </div>
    </div>
    <input type="hidden" name="link_hid" id="link_hid_id" />
    <div class="form-group">
    	<label for="target" class="col-sm-2">Target</label>
    	<div class="col-sm-2">
        	<label class="checkbox checkbox-inline">
    		        <input type="checkbox" name="target" value="1" <?php if($menu['target'] == 1) echo 'checked'; ?>>Open in New Window
	        </label>
       </div>
	    <div class="col-sm-2">
		    <label class="checkbox checkbox-inline">
			    <input type="checkbox" name="use_heading" value="1" <?php if($menu['use_heading'] == 1) echo 'checked'; ?>> Use As Headings
		    </label>
	    </div>
    </div>
    <div class="form-group">
        <label for="title" class="col-sm-2">Upload Image</label>
        <div class="col-sm-3">
            <input type="file" name="image" class="form-control" />
        </div>
        <?php
        if($menu['image']!='') {
            ?>
            <div class="col-sm-1">
                <img src="<?= site_url(upload_dir($menu['image'])); ?>" />
            </div>
        <?php
        }
        ?>
    </div>
    <div class="form-group">
        <label for="title" class="col-sm-2">Description</label>
        <div class="col-sm-6">
            <textarea name="description" class="form-control ckeditor">
<?= $menu['description']; ?>
            </textarea>
        </div>
    </div>
    <div class="form-group">
    	<div class="col-sm-6 col-sm-offset-2">
        <input type="hidden" name="submit" value="Save" />
        <button type="submit" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-floppy-disk"></i> Save</button>
        </div>
    </div>
</div>
</form>
<script>
$(document).ready(function(){
	$('.linktype').hide();
	$('.active').show();
	$('.option').click(function(){
		var showid = $(this).attr('data-type');
		$('.linktype').hide('slow');
		$('#'+showid).show('slow');
	});
	$('#cat_dd').change(function(){
		$('#category_url').val($(this).val());
	});
	$('.linkdd').change(function(){
		var v = $(this).val();
		$('#link_hid_id').val(v);
	});
	$('#group_id').change(function(){
		var v = $(this).val();
		$.ajax({
            url: '<?php echo site_url().'menu/get_menu/';?>' + v,
            type:'POST',
            dataType: 'json',
            success: function(output_string){
                    $('#parent_id').html(output_string);
                } // End of success function of ajax form
            });
	});
});
</script>
<script type="text/javascript" src="http://www.mrjugadu.com/assets/js/ckeditor/ckeditor.js"></script>
<script>
    CKEDITOR.replace( '.ckeditor' );
</script>
