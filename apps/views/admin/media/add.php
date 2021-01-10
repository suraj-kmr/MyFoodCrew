<div class="page-header">
<h3>Upload Media</h3>
</div>
<div class="formview">
	<?php echo form_open_multipart(admin_url('media/add'), array('class' => 'form-horizontal')) ?>
    <div class="form-group">
		  <label class="col-sm-2">Title:</label>
		<div class="col-sm-5">
		  <input type="text" name="title" value="<?php echo set_value('title'); ?>" class="form-control input-sm">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2">Upload Files:</label>
		<div class="col-sm-3">
			<input type="file" name="filesToUpload[]" id="filesToUpload" multiple="" onChange="makeFileList();" />
			<p><strong>Files You Selected:</strong></p>
			<ul id="fileList"><li>No Files Selected</li></ul>
		</div>
	</div>
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
	<div class="form-group">
		<label class="col-sm-2">&nbsp;</label>
		<div class="col-sm-5">
		  <input type="submit" name="submit" class="btn btn-primary btn-sm" value="Upload">
		</div>
	</div>
	<?php echo form_close(); ?>
</div>
