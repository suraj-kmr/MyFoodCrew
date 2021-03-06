<?php echo form_open(admin_url('orders/details/' . $order -> id), array('class' => 'form-horizontal')); ?>
<div class="row">
    <div class="col-sm-8" id="printableArea">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <h2>Order Number: #RA-<?= $order -> id; ?></h2>
                    <p class="text-muted">Order Date: <?= date('d M, Y', strtotime($order -> created_on)); ?></p>
                </div>
                <div class="col-sm-6 text-right">
                    <h3>Pay Amount: <?= inr_rs($order -> payment_price); ?></h3>
                    <p class="text-muted">Pay Mode: <?= $order -> pay_method; ?><br/>
                        <?php if($order -> pay_method =='Online'){ ?>
                        <b>Use Coupon: <?= $order->coupon_code; ?></b><br/>Amount Off: <i class="fa fa-inr"></i> <?= $order -> total - $order->payment_price; } ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="box box-p">
            <table class="table table-bordered" style="margin-bottom: 0;">
                <thead>
                <tr>
                    <th><div class="text-center">Shipping Address</div> </th>
                    <th><div class="text-center">Customer Information</div> </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <address><?php
                            if(@count($order) > 0 ){

                            $address = $order->address;
                            if(is_object($address) && @count($address) > 0) {
                                echo '<p><b>' . $address->ship_name . '</b></p>';
                                echo '<p>' . $address->ship_add1 . ', ' . $address->ship_city . '<br />' . $address->ship_state . '</p>';
                                echo '<p>Pin: ' . $address->ship_pin . '</p>';
                                echo '<p>Landmark: ' . $address->ship_landmark . '</p>';
                                echo '<p>Mobile: ' . $address->ship_mobile . '</p>';
                            }
                            ?>
                        </address>
                    </td>
                    <td>
                        <address><?php
                            $user = $order->user;
                            if (is_object($user) && @count($user) > 0) {
                                echo '<p><b>' . $user->first_name . ' ' . $user->last_name . '</b></p>';
                                echo '<p>Email: ' . $user->email_id . '</p>';
                                echo '<p>Mobile: ' . $user->phone_no . '</p>';
                            }
                            }
                            ?>
                        </address>

                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="box">
            <div class="box-header">
                <h4 class="box-title">Order Files</h4>
            </div>
            <table class="table table-striped table-bordered nomargin">
                <thead>
                <tr>
                    <th>Status</th>
                    <th>Quanity</th>
                    <th>Thumbnail</th>
                    <th>Unit Price</th>
                    <th>Shipping</th>
                    <th>Item Sub Total</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $files = $order -> files;
                $total = 0;
                $sum = 0;
                $subtotal1 = 0;
                foreach($files as $f){
                    $tp = new AI_Product($f -> product_id);
                    $food_price = $this->Product_model->get_price($tp->product_type,$tp->id);
                    $total += $f -> subtotal_price;
                    $subtotal = $f->quantity * $tp->data('price');
                    $discount = $tp->discount;
                    $d_type = $tp->discount_type;
                    $discount_rate = $tp->discount_rate;
                    if($d_type==2){
                        $sub = $subtotal1 - $subtotal1 * $discount_rate / 100;
                    }
                    elseif($d_type == 1){
                        if(is_numeric($discount_rate)){
                            $sub = $subtotal1 - ($discount_rate*$f -> quantity);
                        }
                        else
                        {
                            $sub = $subtotal1;
                        }
                    }
                    else{
                        $sub = $subtotal1;
                    }
                    $sum += $sub;
                    ?>
                    <tr>
                        <td><?php if($f->product_status==NULL || $f -> product_status == '') echo "Not updated"; else echo $f -> product_status; ?></td>
                        <td><?= $f -> quantity; ?></td>
                        <td>
                            <table>
                                <tr>
                                    <td colspan="2"><a target="_blank" href="<?= $tp->permalink(); ?>"> <?= $tp->title(); ?></a></td>
                                </tr>
                                <tr>
                                    <td><?= $tp -> image('sm', array('class' => 'img-xs')); ?></td>
                                    <td><?= $tp->sku(); ?><br/>ID: <?= $tp->ID(); ?></td>
                                </tr>
                            </table>
                            </td>
                            <td>
                            <?php
                            if($tp->product_type ==2){
                                echo inr_rs($food_price->unit_price);
                            }
                            else{
                                echo inr_rs($tp -> price);
                            }
                            ?></td>
                        <td><?= $f -> ship_charge; ?></td>
                        <td>
                        <?php
                            if($tp->product_type ==2){
                                echo inr_rs(($food_price->unit_price* $f->quantity) + $f->ship_charge);
                            }
                            else{
                                echo inr_rs(($tp -> price * $f->quantity) + $f->ship_charge);
                            }
                            ?>
                        </td>
                    </tr>
                <?php
                }
                ?>
                <tr>
                    <td colspan="5">
                        <div class="text-left"><?php
                                if($discount >0){
                                    if($d_type == 1){
                                        $type = "Rs";
                                        echo "</b>  Discount: " . $discount_rate* $f -> quantity . " " . $type ;
                                    }
                                    else
                                    {
                                        $type = "%";
                                        echo "</b>  Discount: " . $discount_rate . " " . $type ;
                                    }
                                }
                                
                                
                                ?></div>
                        <div class="text-right" style="margin-top: -18px;">Total Amount (Including Shipping Charge) </div>
                    </td>
                    <td><b><?= inr_rs($order->total); ?></b></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="box">
            <div class="box-bb box-p">
                <h4 class="box-title">Order Information</h4>
            </div>
            <div class="box-p clearfix">
                <div class="form-group">
                    <label class="col-sm-4 control-label">Pay Method: </label>
                    <div class="col-sm-8">
                        <label><?= $order -> pay_method; ?></label>
                        <?php
                        /*$arpay = array(
                            'Credit Card' => 'Credit Card',
                            'Debit Card' => 'Debit Card',
                            'Net Banking' => 'Net Banking',
                            'COD' => 'Cash on Delivery'
                        );
                        echo form_dropdown('order[pay_method]', $arpay, set_value('order[pay_method]', $order -> pay_method), 'class="form-control input-sm"'); */ ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Order Status: </label>
                    <div class="col-sm-8">
                        <?php
                        $arpay = array(
                            'Order Confirmed' => 'Order Confirmed',
                            'In Transit' => 'In Transit',
                            'Delivered' => 'Delivered',
                            'Canceled' => 'Cancelled'
                        );
                        echo form_dropdown('order[order_status]', $arpay, set_value('order[order_status]', $order -> order_status), 'class="form-control input-sm"'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Pay Status: </label>
                    <div class="col-sm-8">
                        <?php
                        $arpay = array(
                            'Pending' => 'Pending',
                            'Received' => 'Received',
                        );
                        echo form_dropdown('order[pay_status]', $arpay, set_value('order[pay_status]', $order -> pay_status), 'class="form-control input-sm"'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Courier Partner: </label>
                    <div class="col-sm-8">
                        <input type="text" name="order[courier_partner]" value="<?= set_value('order[courier_partner]', $order -> courier_partner); ?>" class="form-control input-sm" />
                    </div>
                    <!--<label class="col-sm-4 control-label">Delivery on: </label>
                    <div class="col-sm-8">
                        <input data-date-format="mm/dd/yyyy" type="text" name="order[delivery_on]" value="<?= set_value('order[delivery_on]', $order -> delivery_on); ?>" class="form-control input-sm calender datepicker" />
                    </div>-->
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Tracking ID: </label>
                    <div class="col-sm-8">
                        <input type="text" name="order[tracking_code]" value="<?= set_value('order[tracking_code]', $order -> tracking_code); ?>" class="form-control input-sm" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Tracking URL: </label>
                    <div class="col-sm-8">
                        <input type="text" rows="4" class="form-control input-sm" name="order[tracking_url]" value="<?= set_value('order[tracking_url]', $order -> tracking_url); ?>" />
                    </div>
                </div>
            </div>
            <div class="box-footer text-center">
                <input type="submit" name="btn_details" value="ORDER UPDATE" class="btn btn-info" />
            </div>
        </div>
        <?php
        $checkinv = $this -> Master_model -> getInvoice($order->id, 'order_invoice');
        if(@count($checkinv) > 0) {
            ?>
            <a target="_blank" href="<?= admin_url('orders/print_invoice/' . $order->id); ?>"
               class="form-control btn btn-danger">Print Invoice</a>
        <?php
        }
        ?>
    </div>
</div>
<?= form_close(); ?>

<script>
$('.datepicker').datepicker({
    format: 'mm/dd/yyyy',
    startDate: '-3d'
});
</script>