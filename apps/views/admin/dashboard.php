<?php
$role = $this->session->userdata('role');

if($role==1){
?>
<div class="row">
	<div class="col-sm-3">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<center>Total Products</center>
			</div>
			<div class="panel-body">
				<center><h1><?=$total_prod;?></h1></center>
			</div>
		</div>
	</div>
	<div class="col-sm-3">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<center>Total Sales</center>
			</div>
			<div class="panel-body">
				<center><h1><?=$total_sales;?></h1></center>
			</div>
		</div>
	</div>
	<div class="col-sm-3">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<center>Month's Order</center>
			</div>
			<div class="panel-body">
				<center><h1><?=$month;?></h1></center>
			</div>
		</div>
	</div>
	<div class="col-sm-3">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<center>Total Users</center>
			</div>
			<div class="panel-body">
				<center><h1><?=$total_users;?></h1></center>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<div class="widget">
			<div class="widget-head">
				Recent Orders
				<div class="widget-icons pull-right">
					<a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a>
					<a href="#" class="wclose"><i class="fa fa-times"></i></a>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="widget-content">
				<table class="table table-hover table-striped">
					<thead>
					<tr>
						<th>#ID</th>
						<th>Order Date</th>
						<th>Payable Amount</th>
					</tr>
					</thead>
					<tbody>
						<tr>
							<td>1</td>
							<td>12/02/2020</td>
							<td>12000</td>
						</tr>
                    
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="widget">
			<div class="widget-head">
				<i class="fa fa-pencil"></i> Payment Summery
				<div class="widget-icons pull-right">
					<a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a>
					<a href="#" class="wclose"><i class="fa fa-times"></i></a>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="widget-content">
				<table class="table table-hover">
					<tr>
						<th>#ID</th>
						<th>Date</th>
						<th>Amount</th>
					</tr>
					<tbody>
						<tr>
							<td>1</td>
							<td>12/02/2020</td>
							<td>12000</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php } if($role==1) {?>
<div class="row">
	<div class="col-sm-6">
		<div class="widget">
			<div class="widget-head">
				Low Inventory Alerts
				<div class="widget-icons pull-right">
					<a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a>
					<a href="#" class="wclose"><i class="fa fa-times"></i></a>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="widget-content">
				<table class="table table-hover table-striped">
					<thead>
					<tr>
						<th>Product name</th>
						<th>SKU</th>
						<th>Quantity</th>
					</tr>
					</thead>
					<tbody>
					    <tr>
							<td>1</td>
							<td>12/02/2020</td>
							<td>12000</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="widget">
			<div class="widget-head">
				High Selling Products
				<div class="widget-icons pull-right">
					<a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a>
					<a href="#" class="wclose"><i class="fa fa-times"></i></a>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="widget-content">
				<table class="table table-hover table-striped">
					<thead>
					<tr>
						<th>Product name</th>
						<th>SKU</th>
						<th>Quantity</th>
					</tr>
					</thead>
					<tbody>
                    <tr>
							<td>1</td>
							<td>12/02/2020</td>
							<td>12000</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php } ?>