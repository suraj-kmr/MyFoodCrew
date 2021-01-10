<div class="page-header">
	<h2>Payment History</h2>
</div>

<div class="widget">
	
	<div class="widget-content">
		<table class="table table-bordered table-striped table-text-centerd">
			<thead>
			<tr>
				<td>Order Number</td>
				<td><?= $order->id;?></td>
				</tr>
				<tr>
				<td>User Name</td>
				<td><?php $u=$this -> db -> get_where('users', array('id' => $order->user_id)) -> first_row();
				if($u->first_name!=""){
				echo $u->first_name . " ".   $u->last_name ;
				 //echo $u->last_name;
				}
				?></td>
				</tr>
				<tr>
				<td>Payment Id</td>
				<td><?= $order->payment_id;?></td>
				</tr>
				<tr>
				<td>Shipping Id</td>
				<td><?= $order->shipping_id;?></td>
				</tr>
				<tr>
				<td>Shipping Price</td>
				<td><?= $order->shipping_price;?></td>
				</tr>
				<tr>
				<td>Total</td>
				<td><?= $order->total;?></td>
				</tr>
				<tr>
				<td>Status</td>
				<td><?= $order->status;?></td>
				</tr>
				<tr>
				<td>Created On</td>
				<td><?= $order->created_on;?></td>
				</tr>
				<tr>
				<td>Payment Status</td>
				<td><?= $order->pay_status;?></td>
				</tr>
				<tr>
				<td>Order Status</td>
				<td><?= $order->order_status;?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

