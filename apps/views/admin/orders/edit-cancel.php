<div class="page-header">
	<h2>Product Cancelation</h2>
</div>
<?php echo validation_errors(); ?>
<?php echo form_open_multipart(admin_url('orders/edit-cancel/'. $order_id), array('class' => 'form-horizontal')); ?>
<?php
if(isset($tracks) && count($tracks) > 0){
	$status = $tracks[0] -> status;
}
?>
<div class="row">
	<div class="col-sm-4">
		<div class="widget">
			<div class="widget-head">Add New</div>
			<div class="widget-content">
				<table class="table">
					<tbody>
					<!-- <tr>
						<td>Reason</td>
						<td><textarea name="tr[reason_for_return]" class="form-control input-sm" /><?=$reason ?></textarea> </td>
					</tr> -->
					<tr>
						<td>Status</td>
						<td>
							<select name="tr[status]" class="form-control input-sm">
								<option value="0" <?php if($status == '0') { echo "selected";}?>>Processing</option>
								<option value="1" <?php if($status == '1') { echo "selected";}?>>Canceled</option>
								<option value="2" <?php if($status == '2') { echo "selected";}?>>Delivered</option>
							</select>
							
						</td>
					</tr>
					<tr>
						<td></td>
						<td>
							<input type="submit" name="btn_cancel" value="Update" class="btn btn-sm btn-info" />
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
				<h4 class="box-title"><b>Cancelling Orders</b></h4>
			</div>
			<table class="table margin-0">
				<thead>
				<tr>
					<th>Last Update</th>
					<!-- <th>Reasons</th> -->
					<th>Status</th>
				</tr>
				</thead>
				<tbody>
				<?php
				if(is_array($tracks) && count($tracks) > 0){
					foreach($tracks as $tr){
						?>
						<tr>
							<td><?= date('d M, Y h:i', strtotime($tr -> modified_at)); ?></td>
							<!-- <td><?//= $tr -> reason_for_return; ?></td> -->
							<td><?php
								if($tr -> status == 0) echo "Processing";
								if($tr -> status == 1) echo "Canceled";
								if($tr -> status == 2) echo "Delivered";
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
