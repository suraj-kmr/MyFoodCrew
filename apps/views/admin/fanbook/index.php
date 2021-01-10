<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<form id="adminForm" method="post" name="adminForm" action="<?php echo site_url('admin/fanbook'); ?>">
<div class="row">
	<div class="col-md-12">
		<p class="pull-right">
			<a href="<?php echo site_url('admin/fanbook/add'); ?>" class="btn btn-sm btn-primary tooltips" title="Add New">
				<i class="glyphicon glyphicon-plus"></i>
			</a>
			<a href="javascript:void(0);" onclick="submit('publish');" class="btn btn-sm btn-success action tooltips" title="Publish">
				<i class="glyphicon glyphicon-ok-sign"></i>
			</a>
			<a href="javascript:void(0);" onclick="submit('unpublish')" class="btn btn-sm btn-danger action tooltips" title="Unpublish">
				<i class="fa fa-check"></i>
			</a>
			<a href="javascript:void(0);" onclick="submit('delete')" class="btn btn-sm btn-warning action tooltips" title="Delete">
				<i class="fa fa-trash"></i>
			</a>
			<a href="<?= admin_url('fanbook/import_files'); ?>" class="btn btn-sm btn-warning">Import File</a>
		<p>
	</div>
</div>
	<div class="box">
		<div class="box-header">
			<i class="fa fa-external-link-square icon-external-link-sign"></i>
			List Fanbook
		</div>
		<div class="table-responsive">
			<table class="table table-bordered table-hover" id="admin-list-page">
				<thead>
				<tr>
					<th class="center" width="5%">
						<input type="checkbox" onclick="dgUI.checkAll(this)" id="select_all">
					</th>
					<th class="center">Sl. No.</th>
					<th>Title</th>
					<th class="center">Short Info</th>
					<th class="center">Image</th>
					<th class="center">Status</th>
					<th class="center">Option</th>
				</tr>
				</thead>
				<tbody>
				<?php $i=0; if (count($data) > 0) { ?>
					<?php foreach($data as $row) { $i++; ?>

						<tr>
							<td class="center">
								<input type="checkbox" class="checkb" value="<?php echo $row->id; ?>" name="ids[]" />
							</td>
							<td class="center">
								<?php echo $i; ?>
							</td>
							<td><a href="<?php echo $row -> url; ?>"><?php echo $row -> title; ?></a></td>
							<td><?php echo $row -> short_info; ?></td>
							<td><img src="<?php echo base_url(upload_dir($row -> image));  ?>" width="50px" /></td>
							
							<td class="center">
								<?php if ($row->status == 1){ ?>
									<a href="<?php echo site_url('admin/fanbook/unpublish/'.$row -> id); ?>" class="btn btn-success btn-xs tooltips" title="Click to Unpublish">Publish</a>
								<?php }else{ ?>
									<a href="<?php echo site_url('admin/fanbook/publish/'.$row -> id); ?>" class="btn btn-warning btn-xs tooltips" title="Click to Publish">Unpublish</a>
								<?php } ?>
							</td>
							<td class="center">
								<div class="btn-group">
									<a title="Edit" class="btn btn-xs btn-default" href="<?php echo admin_url('fanbook/add') . '/' . $row->id; ?>"><i class="fa fa-pencil"></i> </a>
									<a title="Delete" class="btn btn-xs btn-danger delete" href="<?php echo admin_url('fanbook/delete') . '/' . $row->id; ?>"><i class="fa fa-trash"></i></a>
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
	}else{
		if(!confirm("Are you sure to delete?")){
			return false;
		}
		
	}

	var url = '<?php echo admin_url('fanbook'). '/'; ?>' + type;
	$('#adminForm').attr('action', url).submit();
}
</script>
