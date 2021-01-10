<div class="page-header">
	<h2>Order Invoice</h2>
</div>
<form name="invoice" method="post" action="<?= admin_url('orders/add_invoice/'.$id); ?>">
    <div class="form-group">
        <label class="col-sm-3">Invoice Number</label>
        <input class="form-control" value="<?= $order->invoice_no; ?>" type="text" name="frm[invoice_no]" />
    </div>
    <div class="form-group">
        <label class="col-sm-3">Tax Type</label>
        <select class="form-control" name="frm[tax_type]" >
            <option <?php if($order->tax_type=='CST') echo "selected='selected'"; ?> value="CST">CST</option>
            <option <?php if($order->tax_type=='GST') echo "selected='selected'"; ?> value="GST">GST</option>
            <option <?php if($order->tax_type=='VAT') echo "selected='selected'"; ?> value="VAT">VAT</option>
        </select>
    </div>
    <div class="form-group">
        <label class="col-sm-3">Tax value</label>
        <input class="form-control" value="<?= $order->value; ?>" type="text" name="frm[value]" />
    </div>
    <div class="form-group">
        <input class="btn btn success" type="submit" value="Update" name="submit" />
        <a href="<?= admin_url('orders/print_invoice/'.$order->order_id); ?>" title="Print" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i> Print</a>
    </div>
</form>