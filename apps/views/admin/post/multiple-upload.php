<div class="page-header">
	<h2>Upload Multiple Files</h2>
</div>
    <?php echo form_open_multipart('post/multiple', array('id' => 'frmupload')); ?>
        
        <label for="category">Category </label>
                <?php 
					$ddmenu = '';
					foreach($categories as $row){
						$ddmenu[$row->id] = $row -> name;
					}
				?>
                <?php echo form_dropdown('category_id', $ddmenu); ?>
                <label for="name">Name</label>
                <input type="text" name="post_title" value="<?php echo set_value('post_title', 'Untitled'); ?>" class="span8" />
				<?php echo form_error('post_title');?>
                <label for="name">Tag</label>
                <?php
					$tags = array(
						1 => 'Standard',
						2 => 'Premium B',
						3 => 'Premium A'
					);
				echo form_dropdown('tags', $tags, 1); ?>				
                <label for="location">Location</label>
				<input type="text" name="location" value="<?php echo set_value('location'); ?>" class="span8"/>
        		<p><strong>Upload Files:</strong> <input type="file" name="filesToUpload[]" id="filesToUpload" multiple="" onChange="makeFileList();" /></p>
	
	<p>
		<strong>Files You Selected:</strong>
	</p>
	<ul id="fileList"><li>No Files Selected</li></ul>
	
		<script type="text/javascript">
		function makeFileList() {
			var input = document.getElementById("filesToUpload");
			var ul = document.getElementById("fileList");
			while (ul.hasChildNodes()) {
				ul.removeChild(ul.firstChild);
			}
			for (var i = 0; i < input.files.length; i++) {
				var li = document.createElement("li");
				li.innerHTML = input.files[i].name;
				ul.appendChild(li);
			}
			if(!ul.hasChildNodes()) {
				var li = document.createElement("li");
				li.innerHTML = 'No Files Selected';
				ul.appendChild(li);
			}
		}
		</script> 
        <label for="keywords">Search Keywords (Seperated by comma)</label>
        <textarea name="search_keywords" class="span8" cols="" rows="5"><?php echo set_value('search_keywords'); ?></textarea>                
        <label for="status">Status</label>
        <?php echo form_dropdown('status', $status); ?>       
        <div class="form-actions">
            <input type="submit" name="submit" value="Save" class="btn btn-primary" />
        </div>
    	</form>