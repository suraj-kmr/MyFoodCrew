<div class="page-header">
	<h2>Item Add/Edit</h2>
</div>
<div class="row">
	<?php echo form_open_multipart(admin_url('miscellaneous/add/'.$p -> id), array('class' => 'form-horizontal')); ?>
	<div class="col-sm-9">
    <div class="form-group">
        <label class="col-sm-2 control-label">Type</label>
        <div class="col-sm-10">
            <select name="frm[type]" class="form-control">
                <option <?php if($p->type =='Material') echo "selected"; ?> value="Material">Material</option>
                <option <?php if($p->type =='Theme') echo "selected"; ?> value="Theme">Theme</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Name</label>
        <div class="col-sm-10">
            <input type="text" name="frm[name]" value="<?= set_value('frm[name]', $p -> name); ?>" class="form-control input-sm" />
        </div>
    </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Image</label>

            <div class="col-sm-10">
                    <input type="file" name="image" class="filestyle" name="input-file-preview"/>
                <?php
                if($p->image!=='' || $p->image!=NULL){
                    ?>
                <img src="<?= site_url(upload_dir($p->image)); ?>" height="150px" />
                <?php
                }
                ?>
            </div>
        </div>

        <div class="form-group">
        	<label class="col-sm-2 control-label">&nbsp;</label>
            <div class="col-sm-10">
            	<input type="submit" name="submit" value="Save Details" class="btn btn-sm btn-primary" />
                <a href="<?php echo admin_url('miscellaneous'); ?>" class="btn btn-sm btn-default">Cancel</a>
            </div>
        </div>
    </div>

    </div>