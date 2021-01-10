<div class="page-header">
	<h2>Recent Orders</h2>
</div>
<form method="get" action="<?= admin_url ('orders'); ?>">
	<div class="row form-search">
		<div class="col-sm-6">

		</div>
		<div class="col-sm-6">
			<div class="input-group">
				<input type="search" name="q" value="" placeholder="e.g Order ID"
				       class="form-control input-sm"/>

				<div class="input-group-btn">
					<button type="submit" name="btnsearch" value="Search" class="btn btn-sm btn-primary"><i
							class="fa fa-search"></i> Search
					</button>
				</div>
			</div>
		</div>
	</div>
</form>
<div class="box box-header box-status">
    Filters: Order Status
    <label class="checkbox-inline">
        <input name="status" type="radio" value="1" <?php if($filter_status == '1') echo 'checked="checked"'; ?>> Processing
    </label>
    <label class="checkbox-inline">
        <input name="status" type="radio" value="2" <?php if($filter_status == '2') echo 'checked="checked"'; ?>> In Transit
    </label>
    <label class="checkbox-inline">
        <input name="status" type="radio" value="3" <?php if($filter_status == '3') echo 'checked="checked"'; ?>> Canceled
    </label>
    <label class="checkbox-inline">
        <input name="status" type="radio" value="4" <?php if($filter_status == '4') echo 'checked="checked"'; ?>> Order Confirmed
    </label>
    <label class="checkbox-inline">
        <input name="status" type="radio" value="5" <?php if($filter_status == '5') echo 'checked="checked"'; ?>> Pending
    </label>
</div>

<div class="box box-header box-status">
    Filters: Payment Status
    <label class="checkbox-inline">
        <input name="status" type="radio" value="6" <?php if($filter_status == '6') echo 'checked="checked"'; ?>> Pending
    </label>
    <label class="checkbox-inline">
        <input name="status" type="radio" value="7" <?php if($filter_status == '7') echo 'checked="checked"'; ?>> Received
    </label>
    <label class="checkbox-inline">
        <input name="status" type="radio" value="8" <?php if($filter_status == '8') echo 'checked="checked"'; ?>> Aborted
    </label>
    <label class="checkbox-inline">
        <input name="status" type="radio" value="9" <?php if($filter_status == '9') echo 'checked="checked"'; ?>> Failed
    </label>
</div>

<div class="box box-header box-status">
    Filters: Payment Mode
    <label class="checkbox-inline">
        <input name="status" type="radio" value="10" <?php if($filter_status == '10') echo 'checked="checked"'; ?>> COD
    </label>
    <label class="checkbox-inline">
        <input name="status" type="radio" value="11" <?php if($filter_status == '11') echo 'checked="checked"'; ?>> Online
    </label>
</div>

<div class="box box-header box-status">
    <form method="POST" id="frm" action="<?= admin_url('orders/export'); ?>">

                                <div class="row">
                                    <div class="col-sm-2"><label>Date to</label></div>
                                    <div class="col-sm-3"><input type="date" name="to" class="form-control"></div>
                                    <div class="col-sm-2"><label>Date from</label></div>
                                    <div class="col-sm-3"><input type="date" name="from" class="form-control"></div>
                                    <div class="col-sm-2">    <input type="submit" id="export" class="btn btn-success" name="submit" value="Export"> </div>
                                </div>
                        </form>
                                
                               
                        </div>
                       

<script type="text/javascript">
    $(document).ready(function(){
        $('.box-status :radio').click(function(){
            var v = $(this).val();
            get_url(v);
        })
        function get_url(v){
            var url = window.location.href="<?= admin_url('orders?f=');?>" + v;
            return(url);
        }
    });
</script>
<div class="widget">
	<div class="widget-head">
		Recent Orders
	</div>
	<div class="widget-content">
		<table class="table table-bordered table-striped table-text-centerd">
			<thead>
			<tr>
				<th>#ID</th>
				<th>Order Date</th>
				<th>Amount</th>
				<th>Order Status</th>
				<th>Payment Status</th>
                <th>Payment Mode</th>
				<th></th>
			</tr>
			</thead>
			<tbody>
			<?php
			if(is_array($orders) && count($orders) > 0){
				foreach($orders as $ord){
					?>
					<tr>
						<td><?= $ord -> id; ?></td>
						<td><?= date('d M, Y', strtotime($ord -> created_on)); ?></td>
						<td>Rs <?php if($ord->pay_method=='COD'){ echo number_format($ord -> total, 2); } else{ echo number_format($ord -> coupon_total, 2); } ?></td>
						<td><?php echo $ord -> order_status; if($ord->cancel_by=='User') echo " (by User)"; ?></td>
						<td><?= $ord -> pay_status; ?></td>
                        <td><?= $ord -> pay_method; ?></td>
						<td>
							<div class="btn-group pull-right">
                                <a style="margin-right: 30px;" href="<?= admin_url('orders/delete/'. $ord -> id, true); ?>" title="Delete" class="btn btn-xs btn-danger delete"><i class="fa fa-trash"></i> </a>
								<a href="<?= admin_url('orders/details/'. $ord -> id); ?>" title="Edit" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i> Details</a>

                                <?php
                                $checkinv = $this -> Master_model -> getInvoice($ord->id, 'order_invoice');
                                if($checkinv != NULL){
                                    ?>
                                    <a href="<?= admin_url('orders/print_invoice/'.$ord->id); ?>" title="Print" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i> Print</a>
                                    <?php
                                    $id= $this -> Master_model ->getInvoice($ord->id)->id;
                                    ?>
                                    <a href="<?= admin_url('orders/add_invoice/'.$id); ?>" class="btn btn-xs btn-info"><i class="fa fa-edit"></i> Edit </a>
                                <?php
                                }
                                else{
                                    ?>
                                    <button data-whatever="<?= $ord->id; ?>" type="button" data-toggle="modal" data-target="#myModal">Create Invoice</button>
                                <?php
                                }
                                ?>
							</div>
						</td>
					</tr>
				<?php
				}
			}
			?>
			</tbody>
		</table>
	</div>
</div>
<div class="pagination pagination-small">
	<?= $paginate; ?>
</div>

<!------ Model Popup ------------------->
<!-- Trigger the modal with a button -->

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
                <form name="invoice" method="post" action="<?= admin_url('orders/create_invoice'); ?>?redirect_to=<?= current_url(); ?>">
                    <input class="form-control order-id" type="hidden" name="frm[order_id]" />
                    <div class="form-group">
                        <label class="col-sm-3">Invoice Number</label>
                        <input class="form-control" type="text" name="frm[invoice_no]" />
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3">Tax Type</label>
                        <select class="form-control" name="frm[tax_type]" >
                            <option value="CST">CST</option>
                            <option value="GST">GST</option>
                            <option value="VAT">VAT</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3">Tax value</label>
                        <input class="form-control" type="text" name="frm[value]" />
                    </div>
                    <div class="form-group">
                        <input class="btn btn success" type="submit" value="Create" name="submit" />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<script>
    $('document').ready(function () {
        $('#myModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var recipient = button.data('whatever')
            var modal = $(this)
            modal.find('.modal-title').text('Create Invoice for Order Id ' + recipient)
            modal.find('.modal-body input.order-id').val(recipient)
        });

    });

</script>
<!------End Popup ----------------------->