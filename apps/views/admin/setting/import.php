<?php
/**
 * Created by PhpStorm.
 * User: Rohit
 * Date: 05/07/2017
 * Time: 3:55 PM
 */
?>
<div class="col-sm-12">
    <div class="page-header">
        <h3>Import</h3>
    </div>
</div>

<div class="col-sm-6">
    <?php echo form_open(admin_url('settings/import'), array('class' => 'form-horizontal', 'enctype'=>'multipart/form-data')); ?>
    <div class="form-group">
        <label class="col-sm-2 control-label">Quantity</label>
        <div class="col-sm-10">
            <input type="file" name="excel_file" />
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-3 col-sm-offset-2">
            <input name="qty_import" type="submit" class="btn btn-sm btn-primary" value="Import" />
        </div>
    </div>
    <?php echo form_close(); ?>
    <a href="<?= admin_url('settings/export_quantity'); ?>">Export Quantity</a>
</div>

<div class="col-sm-6">
    <?php echo form_open(admin_url('settings/import'), array('class' => 'form-horizontal', 'enctype'=>'multipart/form-data')); ?>
    <div class="form-group">
        <label class="col-sm-2 control-label">Price</label>
        <div class="col-sm-10">
            <input type="file" name="excel_filea" />
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-3 col-sm-offset-2">
            <input name="price_import" type="submit" class="btn btn-sm btn-primary" value="Import" />
        </div>
    </div>
    <?php echo form_close(); ?>
    <a href="<?= admin_url('settings/export_price'); ?>">Export Price</a>
</div>



