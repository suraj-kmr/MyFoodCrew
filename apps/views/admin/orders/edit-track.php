<div class="page-header">
	<h2>Order Tracking</h2>
</div>
<?php echo validation_errors(); ?>
<?php echo form_open_multipart(admin_url('orders/edit-track/'. $order_id), array('class' => 'form-horizontal')); ?>
<?php
$courier = '';
if(isset($tracks) && count($tracks) > 0){
	$courier = $tracks[0] -> courier;
}
?>
<div class="row">
	<div class="col-sm-4">
		<div class="widget">
			<div class="widget-head">Add New</div>
			<div class="widget-content">
				<table class="table">
					<tbody>
					<tr>
						<td>Courier</td>
						<td><input type="text" name="tr[courier]" value="<?= set_value('tr[courier]', $courier); ?>" class="form-control input-sm" /> </td>
					</tr>
					<tr>
						<td>Notes</td>
						<td><input type="text" name="tr[tracking_notes]" value="<?= set_value('tr[tracking_notes]'); ?>"  class="form-control input-sm" /> </td>
					</tr>
					<tr>
						<td>Status</td>
						<td>
							<?php
							$st = array(
								0 => 'Processing',
								1 => 'In Transit',
								2 => 'Delivered'
							);
							echo form_dropdown('tr[tracking_status]', $st, set_value('tr[tracking_status]'), 'class="form-control input-sm"');
							?>
						</td>
					</tr>
					<tr>
						<td></td>
						<td>
							<input type="submit" name="btn_track" value="Update" class="btn btn-sm btn-info" />
						</td>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="col-sm-8">
		<div class="box">
			<div class="box-header">
				<h4 class="box-title"><b>Tracking Updates</b></h4>
			</div>
			<table class="table margin-0">
				<thead>
				<tr>
					<th>Last Update</th>
					<th>Notes</th>
					<th>Status</th>
				</tr>
				</thead>
				<tbody>
				<?php
				if(is_array($tracks) && count($tracks) > 0){
					foreach($tracks as $tr){
						?>
						<tr>
							<td><?= date('d M, Y h:i', strtotime($tr -> modified_on)); ?></td>
							<td><?= $tr -> client_note; ?></td>
							<td><?php
								if($tr -> order_status == 0) echo "Processing";
								if($tr -> order_status == 1) echo "In Transit";
								if($tr -> order_status == 2) echo "Delivered";
								?></td>
						</tr>
						<?php
					}
				}
				?>
				</tbody>
			</table>
		</div>
	</div>
</div>
</form>
