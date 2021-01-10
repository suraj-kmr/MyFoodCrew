<div class="page-header">
	<h2>Layouts</h2>
</div>
<?php echo form_open('settings/layout/'.$id, array('class' => 'form-horizontal')); ?>
    <fieldset><legend>Layouts</legend>
    <div class="form-group">
    	<label class="col-sm-2">Layout Name</label>
        <div class="col-sm-5">
        	<input type="text" name="layout_name" value="<?php echo set_value('layout_name', $layout_name); ?>" class="form-control input-sm" />
            <?php echo form_error('layout_name'); ?>
        </div>    
    </div>
    <div class="form-group">
    	<label class="col-sm-2">Layout File</label>
        <div class="col-sm-5">
        	<input type="text" name="layout_page" value="<?php echo set_value('layout_page', $layout_page); ?>" class="form-control input-sm"  />
            <?php echo form_error('layout_page'); ?>
        </div>    
    </div>
    <div class="form-group">
    	<label class="col-sm-2">&nbsp;</label>
        <div class="col-sm-5">
        	<input type="submit" name="submit" value="Save" class="btn btn-primary btn-sm" />
        </div>    
    </div>
<?php echo form_close(); ?>
<div class="clearfix"></div>
<table class="table table-striped">
	<thead>
    	<tr>
        	<th>Layout Name</th>
            <th>Layout File</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
    	<?php foreach ($layouts as $row):?>
    	<tr>
        	<td><?php echo $row['layout_name']; ?></td>
            <td><?php echo $row['layout_page']; ?></td>
            <td>
            	<div class="btn-group pull-right">
                	<a href="<?php echo base_url('settings/layout/'.$row['id']); ?>" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                    <a href="<?php echo base_url('settings/delete_layout/'.$row['id']);?>" class="btn btn-sm btn-danger delete"><i class="glyphicon glyphicon-trash"></i> Delete</a>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
