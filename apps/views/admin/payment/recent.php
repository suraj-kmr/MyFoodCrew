

<div class="widget">
	<div class="widget-head">
		Recent Payment
	</div>
	<div class="widget-content">
		<table class="table table-bordered table-striped table-text-centerd">
			<thead>
			<tr>
				<th>#ID</th>
				
				<th>User ID</th>
				
				<th>Payment Price</th>
				<th>Total</th>
				
				<th>Payment Status</th>
				<th>Delivery On</th>
				<th></th>
			</tr>
			</thead>
			<tbody>
			<?php
			if(is_array($recent) && count($recent) > 0){
				foreach($recent as $ord){
					?>
					<tr>
						<td><?= $ord -> id; ?></td>
						
						<td><?= $ord -> user_id;?></td>
						
						<td><?= $ord -> payment_price;?></td>
						<td><?= $ord -> total;?></td>
						<td><?= $ord -> pay_status;?></td>
						<td><?= $ord -> delivery_on;?></td>
						
					
					</tr>
				<?php
				}
			}
			?>
			</tbody>
		</table>
	</div>
</div>

