<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<form id="adminForm" method="post" name="adminForm" action="<?php echo site_url('/admin/admanager'); ?>">
<div class="row">
	<div class="col-md-12">
		<p class="pull-right">
			<a href="<?php echo site_url('admin/mobile/addcover'); ?>" class="btn btn-sm btn-primary tooltips" title="Add New">
				<i class="glyphicon glyphicon-plus"></i>
			</a>
			<a href="<?php echo site_url('admin/mobile/bulkcoverupload'); ?>" class="btn btn-sm btn-primary tooltips" title="Bulk Upload">
				<i class="glyphicon glyphicon-upload"></i> Bulk Upload
			</a>
			<a href="javascript:void(0);" onclick="submit('delbrand')" class="btn btn-sm btn-bricky delete action tooltips" title="Delete">
				<i class="fa fa-trash-o"></i>
			</a>
		<p>
	</div>
</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<i class="fa fa-external-link-square icon-external-link-sign"></i>
			List Mobile Brands
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-bordered table-hover" id="admin-list-page">
					<thead>
					<tr>
						<th class="center" width="5%">
							<input type="checkbox" onclick="dgUI.checkAll(this)" id="select_all">
						</th>
						<th class="center">#ID</th>
						<th>Product name</th>
						<th>SKU</th>
						<th>Price</th>
						<th class="center">Options</th>
					</tr>
					</thead>
					<tbody>
					<?php if (count($data) > 0) { ?>
						<?php foreach($data as $row) { ?>

							<tr>
								<td class="center">
									<input type="checkbox" class="checkb" value="<?php echo $row->id; ?>" name="ids[]" />
								</td>
								<td class="center">
									<?php echo $row -> id; ?>
								</td>
								<td><?php echo $row -> pname; ?></td>
								<td><?php echo $row -> sku; ?></td>
								<td><?php echo $row -> sell_price; ?></td>
								<td class="center">
									<div class="btn-group">
										<a title="Edit" class="btn btn-xs btn-default" href="<?php echo site_url('admin/mobile/addcover') . '/' . $row->id; ?>"><i class="fa fa-pencil"></i> </a>
										<a title="Delete" class="btn btn-xs btn-danger delete" href="<?php echo site_url('admin/mobile/delcover') . '/' . $row->id; ?>"><i class="glyphicon glyphicon-trash"></i></a>
									</div>
								</td>
							</tr>

						<?php } ?>
					<?php } ?>
					</tbody>
				</table>
			</div>
			<input type="hidden" value="1" name="action" id="submit-action" />
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
		alert('<?php echo lang('check_box_mgs'); ?>');
		return;
	}

	var url = '<?php echo site_url('admin/mobile'). '/'; ?>' + type;
	$('#adminForm').attr('action', url).submit();
}
</script>
