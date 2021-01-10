<div class="page-header">
    <h3>Edit Image</h3>
</div>
<?php echo form_open(admin_url('gallery/edit_image/' . $image->id), array('class' => 'form-horizontal')); ?>
<div class="form-group">
    <label class="col-sm-2 control-label">Title</label>

    <div class="col-sm-4">
        <input type="text" name="im[title]" value="<?php echo set_value('im[title]', $image->title); ?>"
               class="form-control input-sm"/>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Description</label>
    <div class="col-sm-8">
        <textarea rows="12" cols="" class="form-control input-sm redactor ckeditor" name="im[img_desc]"><?= set_value ('im[img_desc]', $image->img_desc); ?></textarea>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Image Thumbnail</label>

    <div class="col-sm-4">
        <img src="<?php echo base_url(upload_dir($image->image)); ?>" width="200" class="img-thumbnail img-sm"/>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Sequence</label>

    <div class="col-sm-2">
        <input type="text" name="im[sequence]" value="<?php echo set_value('im[sequence]', $image->sequence); ?>"
               class="form-control"/>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Title Tag</label>
    <div class="col-sm-3">
        <input type="text" name="im[img_title]" value="<?php echo set_value('im[img_title]', $image -> img_title); ?>" class="form-control input-sm" />
    </div>
    <label class="col-sm-1 control-label">Alt Tag</label>
    <div class="col-sm-3">
        <input type="text" name="im[img_alt]" value="<?php echo set_value('im[img_alt]', $image -> img_alt); ?>" class="form-control input-sm" />
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Link URL</label>

    <div class="col-sm-6">
        <input type="text" name="im[link_url]" value="<?php echo set_value('im[link_url]', $image->link_url); ?>"
               class="form-control"/>
    </div>
    <div class="col-sm-3">
        <label class="checkbox-inline">
            <input type="checkbox" name="new_tab" value="1" <?php if($image -> new_tab == 1) echo 'Checked'; ?>/> Open in New Tab
        </label>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2">&nbsp;</label>

    <div class="col-sm-4">
        <input type="hidden" name="submit" value="Submit">
        <button type="submit" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-floppy-disk"></i> Save
        </button>
        <a href="<?php echo admin_url('gallery'); ?>" class="btn btn-default btn-sm">Cancel</a>
    </div>
</div>
<?php echo form_close(); ?>
<script type="text/javascript" src="https://www.aldivo.com/js/ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( '.ckeditor' );
    </script>