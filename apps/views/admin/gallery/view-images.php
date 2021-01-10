<form method="post" action="<?= admin_url('gallery/save_all'); ?>">
<div class="page-header">
	<h2>Gallery :: <?php echo $gallery_name; ?> <a href="<?php echo admin_url('gallery/multiple/'.$id); ?>" class="pull-right btn btn-primary btn-sm"><i class="glyphicon glyphicon-plus-sign"></i> Upload New</a></h2>
    <input type="submit" name="save" value="Save All" class="btn btn-primary pull-right" />
</div>
<div class="btn-group pull-right">
<input type="hidden" name="url" value="<?= current_url(); ?>" />
</div>
<div class="row-fluid">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>URL</th>
                <th>Sequence</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($image_list as $row): ?>
                <tr>
                    <td><img src="<?php echo base_url(upload_dir($row -> image));  ?>" width="100" class="thumbnail" /></td>
                    <td><?php echo $row -> title; ?></td>
                    <td><?php echo base_url(upload_dir($row -> image));  ?> </td>
                    <td><input type="number" name="sequence[<?= $row -> id; ?>]"  value="<?= $row -> sequence; ?>" class="form-control input-sm" style="width: 60px;"/> </td>
                    <td><div class="pull-right btn-group">
                            <a href="<?php echo admin_url('gallery/edit-image/'.$row -> id); ?>" class="btn btn-default btn-sm"><i class="fa fa-pencil"></i></a>
                            <a href="<?php echo admin_url('gallery/delete-image/'.$id.'/'.$row -> id); ?>" class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i></a></div></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>


</div>
</form>