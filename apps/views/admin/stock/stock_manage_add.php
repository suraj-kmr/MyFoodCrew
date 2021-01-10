<div class="page-header">
	<h2>Stock Item Add/Edit</h2>
</div>
<?php //print_r($p); ?>
<div class="row">
	<?php echo form_open_multipart(admin_url('stock_manage/add/'.$p -> id), array('class' => 'form-horizontal')); ?>
	<div class="col-sm-9">
    <div class="form-group">
        <label class="col-sm-2 control-label">Rake Code</label>
        <div class="col-sm-10">
            <input type="text" name="frm[rake_code]" value="<?= set_value('frm[rake_code]', $p -> rake_code); ?>" class="form-control input-sm" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Name</label>
        <div class="col-sm-10">
            <input type="text" name="frm[name]" value="<?= set_value('frm[name]', $p -> name); ?>" class="form-control input-sm" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Quantity</label>
        <div class="col-sm-10">
            <input type="text" name="frm[quantity]" value="<?= set_value('frm[quantity]', $p -> quantity); ?>" class="form-control input-sm" />
        </div>
    </div>

        <div class="form-group">
        	<label class="col-sm-2 control-label">&nbsp;</label>
            <div class="col-sm-10">
            	<input type="submit" name="submit" value="Save Details" class="btn btn-sm btn-primary" />
                <a href="<?php echo admin_url('stock_manage'); ?>" class="btn btn-sm btn-default">Cancel</a>
            </div>
        </div>
    </div>

    </div>