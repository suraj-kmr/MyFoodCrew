<div class="page-header">
	<h3>Gallery Form</h3>
</div>

	<?php echo form_open(admin_url('gallery/create/'.$gallery -> id), array('class' => 'form-horizontal')); ?>
    	<div class="form-group">
        	<label for="name" class="col-lg-2">Gallery Name</label>
            <div class="col-lg-4">
				<input type="text" name="gal[gallery_name]" value="<?php echo set_value('gal[gallery_name]', $gallery -> gallery_name); ?>" class="form-control input-sm" />
            </div>
        </div>
        <div class="form-group">
        	<label for="description" class="col-lg-2">Description</label>
            <div class="col-lg-4">
                <textarea name="gal[description]" rows="4" cols="" class="form-control input-sm"><?php echo set_value('description', $gallery -> description); ?></textarea>
			</div>
       	</div>
       	<div class="form-group">
       		<label for="layout" class="col-lg-2">Sequence</label>
           <div class="col-lg-1">
                <input type="text" name="gal[sequence]" value="<?php echo set_value('gal[sequence]', $gallery -> sequence); ?>" class="form-control input-sm" />
           </div>
      	</div>
      	<div class="form-group">
            <div class="col-lg-4 col-lg-offset-2">
            	<input type="hidden" name="submit" value="Create" />
                <button type="submit" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-floppy-disk"></i> Create</button>
                <a href="<?php echo admin_url('gallery'); ?>" class="btn btn-default btn-sm">Cancel</a>
             </div>
		</div>
    <?php echo form_close(); ?>
