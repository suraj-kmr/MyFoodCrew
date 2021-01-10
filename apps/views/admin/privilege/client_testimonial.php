<div class="page-header">
	<h2>Client Testimonial</h2>
</div>
<div class="row">
	<div class="col-sm-12">
    	<?php echo form_open_multipart(admin_url('privilege/client_testimonial/'.$m -> id), array('class' => 'form-horizontal')); ?>
        <!--<div class="form-group">
        	<label class="col-sm-2">Username</label>
            <div class="col-sm-6">
            	<input type="text" name="frm[username]" value="<?php /*echo $m -> username; */?>" class="form-control input-sm" />
            </div>

        </div>-->
        <div class="form-group">
        	<label class="col-sm-2 control-label">Client Name</label>
            <div class="col-sm-8">
            	<input type="text" name="frm[name]" value="<?php echo $m -> name; ?>" class="form-control input-sm" />
            </div>
               
        </div>
       <div class="form-group">
                <label class="col-sm-2 control-label">Description</label>
                <div class="col-sm-8">
                    <textarea name="frm[description]" rows="4" cols="" class="form-control"><?= set_value('frm[description]', $m -> description); ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Image</label>
                <div class="col-sm-8">
                    <div class="input-append">
                        <?php echo form_upload(array('name'=>'image'));?>
                    </div>

                    <?php if($m -> id && $m -> image != ''):?>

                        <div style="text-align:center; padding:5px; border:1px solid #ddd;"><img class="img-responsive img-thumbnail" src="<?php echo base_url('img/uploads/'.$m -> image);?>" alt="current"/><br/>Current File</div>
                        <label class="checkbox checkbox-inline">
                            <input type="hidden" name="hid_image" value="<?php echo $m -> image; ?>" />
                            <input type="checkbox" name="del_image" value="1" />Delete this image
                        </label>
                    <?php endif;?>
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
                    echo form_dropdown('frm[status]', $st, $m -> status, 'class="form-control input-sm"');
                    ?>
                </div>
               
            </div>
        <div class="form-group">
        	<label class="col-sm-2">&nbsp;</label>
            <div class="col-sm-10">
            	<input type="submit" name="submit" value="Save Details" class="btn btn-sm btn-primary" />
                <a href="<?= admin_url('privilege/client-testimonial'); ?>" class="btn btn-sm btn-warning">Cancel</a>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
