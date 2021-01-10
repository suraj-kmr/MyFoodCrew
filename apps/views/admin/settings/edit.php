<?php
/**
 * Created by PhpStorm.
 * User: Kamal Kumar
 * Date: 11/27/2014
 * Time: 8:55 AM
 */
?>
<div class="col-sm-12">
    <div class="page-header">
        <h3>Edit Option</h3>
    </div>
</div>
<div class="col-sm-12">
    <?php echo form_open($this -> config -> item('admin_folder').'settings/edit/'.$o['option_name'], array('class' => 'form-horizontal')); ?>
    <div class="form-group">
        <label class="col-sm-2"><?php echo ucwords(str_replace('_', ' ', $o['option_name'])); ?></label>
        <div class="col-sm-4">
            <input type="text" name="option_value" value="<?php echo set_value('option_value', $o['option_value']); ?>" class="form-control input-sm" required="required" />
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-3 col-sm-offset-2">
            <input name="submit" type="submit" class="btn btn-sm btn-primary" value="Update" />
            <a href="<?php echo base_url('settings'); ?>" class="btn btn-sm btn-default">Cancel</a>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<div class="col-sm-12">
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Sl No</th>
            <th>Option Name</th>
            <th>Option Value</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sl = 1;
        foreach($options as $opt): ?>
            <tr>
                <td><?php echo $sl++; ?></td>
                <td><?php echo ucwords(str_replace('_', ' ', $opt['option_name'])); ?></td>
                <td><?php echo $opt['option_value']; ?></td>
                <td>
                    <div class="pull-right">
                        <a href="<?php echo base_url($this -> config -> item('admin_folder').'settings/edit/'.$opt['option_name']); ?>" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
