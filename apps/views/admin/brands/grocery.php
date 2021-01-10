<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<script>
$(document).ready(function(){
	$('.btn-save-all').on('click', function(){
         $('#frmsave').submit();
     });
});
</script>
<!-- <div class="row">
	<div class="col-md-12">
		<p class="pull-right">
			<a href="<?php echo site_url('admin/brands/add_grocery_brands'); ?>" class="btn btn-sm btn-primary tooltips" title="Add New"><i class="glyphicon glyphicon-plus">Add</i>
			</a>
			<a href="#" style="margin-left: 5px" class="btn btn-sm btn-warning pull-right btn-save-all"><i class="fa fa-save"></i> Save All</a>
				
			<a href="javascript:void(0);" onclick="submit('publish');" class="btn btn-sm btn-success action tooltips" title="Publish">
				<i class="glyphicon glyphicon-ok-sign"></i>
			</a>
			<a href="javascript:void(0);" onclick="submit('unpublish')" class="btn btn-sm btn-danger action tooltips" title="Unpublish">
				<i class="fa fa-check"></i>
			</a>
			<a href="javascript:void(0);" onclick="submit('delete')" class="btn btn-sm btn-warning delete action tooltips" title="Delete">
				<i class="fa fa-trash"></i>
			</a>
			<a href="<?= admin_url('mobiles/import_files'); ?>" class="btn btn-sm btn-warning">Import File</a>
		<p>
	</div>
</div> --> 
<!--<div class="row">
    <div class="col-sm-5">
        <form method="get" action="<?= admin_url ('brands'); ?>">
            <div class="input-group">
                <input type="search" name="q" value="<?= $q; ?>" placeholder="e.g Mobile Title, ID, about"
                       class="form-control input-sm"/>

                <div class="input-group-btn">
                    <button type="submit" name="btnsearch" value="Search" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Search
                    </button>
                </div>
            </div>
        </form><p>&nbsp;</p>
    </div>
</div>-->
<form id="frmsave" method="post" action="<?= admin_url('mobiles/bulksave'); ?>">
<input type="hidden" name="frmall" value="Save All" />
    <input type="hidden" name="url" value="<?= current_url(); ?>" />
	<div class="box">

		<div class="box-header">
			List of All Cloth Brands
			<a href="<?php echo site_url('admin/brands/add_cloth_brands'); ?>" class="btn btn-sm btn-primary tooltips pull-right" title="Add New"><i class="glyphicon glyphicon-plus " >Add</i>
			</a>
			
		</div>

		<div class="table-responsive">
			<table class="table table-bordered table-hover" id="admin-list-page">
				<thead>
				<tr>
					
					<th class="center">#ID</th>
					<th class="center">Brand</th>
					<th class="center">Description</th>
					<th class="center">Options</th>
				</tr>
				</thead>
				<tbody>
				<?php if (count($data) > 0) { ?>
					<?php foreach($data as $row) { ?>

						<tr>
							<td class="center">
								<?php echo $row ->id; ?>
							</td>
							<td class="center"><?php echo $row -> title; ?></td>
							
							<td class="center">
								<?php echo $row -> description;; ?>
							</td>
							<!-- <td class="center">
								<?php if ($row->status == 1){ ?>
									<a href="<?php echo site_url('admin/mobiles/unpublish/'.$row -> id); ?>" class="btn btn-success btn-xs tooltips" title="Click to Unpublish">Publish</a>
								<?php }else{ ?>
									<a href="<?php echo site_url('admin/mobiles/publish/'.$row -> id); ?>" class="btn btn-warning btn-xs tooltips" title="Click to Publish">Unpublish</a>
								<?php } ?>
							</td> -->
							<td class="center">
								<div class="btn-group">
									<a title="Edit" class="btn btn-xs btn-default" href="<?php echo admin_url('brands/add_grocery_brands') . '/' . $row->id; ?>"><i class="fa fa-pencil"></i> </a>
									<a title="Delete" class="btn btn-xs btn-danger delete" href="<?php echo admin_url('brands/delete_grocery') . '/' . $row->id; ?>"><i class="fa fa-trash"></i></a>
								</div>
							</td>
						</tr>

					<?php } ?>
				<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</form>
<div class="row">
	<div class="dataTables_paginate paging_bootstrap pull-right">
		<div class="col-md-12">
		<?php echo $links;?>
		</div>
	</div>
</div>
<script type="text/javascript">
function submit(type){
	var ids = '';
	$('.checkb').each(function(){
		if (jQuery(this).is(':checked'))
		{
			if (ids == '') ids = jQuery(this).val();
			else ids = ids + '-' + jQuery(this).val();
		}
	});
	if (ids == ''){
		alert('Select Checkbox');
		return;
	}

	var url = '<?php echo admin_url('admin/mobiles'). '/'; ?>' + type;
	$('#adminForm').attr('action', url).submit();
}
</script>
