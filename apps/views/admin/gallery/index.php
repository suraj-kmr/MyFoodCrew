<div class="page-header">
	<h3>Gallery </h3>
</div>
<form method="get" action="<?= admin_url ('gallery'); ?>">
	<div class="row form-search">
		<div class="col-sm-6">
			<div class="input-group">
				<input type="search" name="q" value="" placeholder="e.g Gallery title"
				       class="form-control input-sm"/>

				<div class="input-group-btn">
					<button type="submit" name="btnsearch" value="Search" class="btn btn-sm btn-primary"><i
							class="fa fa-search"></i> Search
					</button>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<a href="<?php echo admin_url('gallery/create'); ?>" class="btn btn-sm btn-primary pull-right"><i class="glyphicon glyphicon-plus-sign"></i> Create New Gallery</a>
		</div>
	</div>
</form>
	<table class="table table-striped">
    	<thead>
        	<th>ID</th>
            <th>Gallery Title</th>
            <th>Shortcodes</th>
            <th>&nbsp;</th>
        </thead>
        <tbody>
        <?php
			if((count($gallery_list) > 0) && is_array($gallery_list)){
				foreach($gallery_list as $row):
				?>
                <tr>
                	<td><?php echo $row -> id; ?></td>
                    <td><a href="<?php echo admin_url('gallery/view/'.$row -> id); ?>"><?php echo $row -> gallery_name; ?></a></td>
                    <td><?php echo '[GALLERY-'.$row -> id.']'; ?></td>
                    <td>
                    	<div class="btn-group pull-right">
                    		<a href="<?php echo admin_url('gallery/view/'.$row -> id); ?>" class="btn btn-sm btn-info "><i class="fa fa-eye"></i> View</a>
                        	<a href="<?php echo admin_url('gallery/multiple/'.$row -> id); ?>" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-plus-sign"></i> Add</a>
                            <a href="<?php echo admin_url('gallery/create/'.$row -> id); ?>" class="btn btn-info btn-sm"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                            <a href="<?php echo admin_url('gallery/delete/'.$row -> id); ?>" class="btn btn-sm btn-danger delete"><i class="glyphicon glyphicon-trash"></i> Delete</a>
                        </div>
                    </td>
                </tr>
                <?php
				endforeach;
			}
		?>
        </tbody>
    </table>
