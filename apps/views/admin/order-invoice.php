<?php
$inv = $this -> Master_model -> getInvoice($order->id, 'order_invoice');
$order_sm = $this -> Master_model -> getRow($order->id, 'orders');
?>
<html>
<head>
    <title>Print</title>
    <style>
        .table {
            width:99%;
            margin:0px auto;
            border:solid 2px #000;
            font-family: arial;
            font-size: 12px
        }
        table tr td{
            font-size: 12px;
        }

    </style>
</head>
<body>
<table class="table" cellspacing="0px" cellpadding="0px;">

    <!--<tr>
        <td style=" width:350px;">
            <table style="padding:20px 0px 10px 10px;">
                <tr> <td align="center"> <img src="<?php echo base_url ('assets/img/jhingalala_logo.png'); ?>" width="140px" class="img-responsive logo-img"/>  </td></tr>
                <tr> <td style="height:60px;"> <strong>Ship From :-</strong>  </td></tr>
                <tr> <td> <strong>www.os.com</strong>  </td></tr>
                <tr> <td> <strong>B-17, Tokar Number-7</strong>  </td></tr>
                <tr> <td> <strong>shaheenbagh, AFE-2</strong>  </td></tr>
                <tr> <td> <strong>Okhla, New Delhi</strong>  </td></tr>
                <tr> <td> <strong>Pin:- 110025</strong>  </td></tr>
                <tr> <td> <strong>Phone:- 01165091400</strong>  </td></tr>
                <tr> <td> <strong>Email:- care@aldivo.com</strong>  </td></tr>
            </table>
        </td>
        <td style="border-left: solid 2px #000; padding-left: 25px; padding-top:50px;" valign="top">
            <!--<table>
                <tr><td> <address><?php
                            if(count($order) > 0 ){
                            $address = $order -> address;

                             }
                            ?>
                        </address>
                    </td>
                    <td>
                    </td></tr>
                <tr> <td height="60px"> <strong> Ship To:- </strong>  </td></tr>
                <tr> <td> <strong><?php echo $address -> ship_name; ?></strong>  </td></tr>
                <tr> <td> <strong><?php echo 'Landmark: ' . $address -> ship_landmark; ?></strong>  </td></tr>
                <tr> <td> <strong><?php echo $address -> ship_add1 . ', ' . $address -> ship_city . $address -> ship_state; ?>
</strong>  </td></tr>
                <tr> <td> <strong><?php echo 'Pin: ' . $address -> ship_pin; ?></strong>  </td></tr>
            </table>
        </td>
    </tr>-->
    <tr> <td colspan="2" style="border-top:solid 2px #000;"> </td> </tr>
    <tr>
        <td style=" width:70%;">
            <table style="padding:20px 0px 10px 10px;">
                <tr> <td> <h3> Retail/TaxInvoice/Cash Memorandum </h3> </td> </tr>
                <tr> <td> Sold By  </td></tr>
                <tr> <td> raeesworld.com  </td></tr>
                <tr> <td> Ranchi  </td></tr>
                <tr> <td> Jharkhand </td></tr>
                <tr> <td>   </td></tr>
                <tr> <td> Pin:- 830002  </td></tr>
                <tr> <td> Phone:- 06512482626  </td></tr>
                <tr> <td> Email:- info@raeesworld.com  </td></tr>

            </table>
        </td>
        <td style="padding-top:15px;" valign="top">
            <table style="width:100%;">
                <tr> <td  valign="top"> <h2>Raeesworld</h2></td></tr>
                <tr> <td height="60px" > Invoice Number - <?= $inv->invoice_no; ?>  </td></tr>

                <tr> <td> VAT/TIN Number:- 07367185738  </td></tr>
                <tr> <td> CST Number:- 07367185738  </td></tr>
                <tr> <td> GST Number:- 07AAOCA8714E1ZL </td></tr>
            </table>
        </td>
    </tr>
    <tr> <td colspan="2" style="border-top:solid 2px #000; height:15px;"> </td> </tr>
    <tr>
        <td style="width:70%;">
            <table style="padding:0px 0px 10px 10px;">
                <tr> <td height="20px">  <b>Billing Address</b>   </td></tr>
                <tr> <td> <?php echo ucwords($address -> ship_name); ?>  </td></tr>
                <tr> <td> <?php echo 'Landmark: ' . $address -> ship_landmark; ?>  </td></tr>
                <tr> <td> <?php echo $address -> ship_add1 . ', ' . $address -> ship_city . $address -> ship_state; ?>
                          </td></tr>
                <tr> <td> <?php echo 'Pin: ' . $address -> ship_pin; ?>  </td></tr>
                <tr> <td> Nature of Transaction: Sale  </td></tr>
                <tr> <td> Order Number:  ACP<?php echo $order->id; ?>  </td></tr>

            </table>
        </td>
        <td style="padding-left: 0px; width: 250px" valign="top">
            <table>
                <tr> <td> <b> Shipping Address </b>  </td></tr>
                <tr> <td> <?php echo ucwords($address -> ship_name); ?>  </td></tr>
                <tr> <td> <?php echo 'Landmark: ' . $address -> ship_landmark; ?>  </td></tr>
                <tr> <td> <?php echo $address -> ship_add1 . ', ' . $address -> ship_city . $address -> ship_state; ?>
                          </td></tr>
                <tr> <td> <?php echo 'Pin: ' . $address -> ship_pin; ?>  </td></tr>
                <tr><td>&nbsp;</td></tr>
                <tr><td>&nbsp;</td></tr>
                <tr> <td> This is a computer generated invoice  </td></tr>

            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="border-top:solid 2px #000;"> </td>
    </tr>
    <tr>
        <td colspan="2">
            <table style="width:100%; padding:10px;">
                <tr style="font-weight: bold;">
                    <td> QTY </td>
                    <td> Description </td>
                    <td> Price </td>
                    <td> Amount </td>
                    <td> Tax Type </td>
                    <td> Tax Rate </td>
                    <td> Tax Amount (Including in net) </td>
                </tr>
                <?php
                $files = $order -> files;
                $total = 0;
                $ship = 0;
                //print_r($files);
                foreach($files as $f){
                    $tp = new AI_Product($f -> product_id);
                    $dat = $this->db->get_where('orders',array('id'=>$f->order_id))->row();
                    $total += $dat->total;
                    $ship += $f -> ship_charge;
                    ?>
                    <tr>
                       <td> <?= $f -> quantity; ?> </td>
                        <td width="300px"> <?= $tp->title(); ?> (<?= $f->product_sku; ?>) </td>
                        <td> <i class="fa fa-inr"></i> <?= $tp-> price; ?> </td>
                        <!-- <td> <?php echo  ($f -> product_price + $f -> ship_charge) * $f->quantity; ?>  </td> -->
                        <td> <?php echo $tp-> price * $f->quantity; ?>  </td>
                        <td> <?= $inv -> tax_type; ?> </td>
                        <td> <?= $inv -> value; ?> % </td>
                        <td> <?php echo (($f -> product_price * $f->quantity)* $inv -> value) / 100; ?> </td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="border-top:solid 2px #000;"> </td>
    </tr>

    <tr>
        <td colspan="2">
            <table style="width:98%; padding:10px;">
                <tr>
                    
                    <td colspan="4" style="width:70%;"> </td>
                    <td> <b>Net Amount:<br/>Shipping:<br/>Discount<br/>Total Payable Amount: </b></td>
                    <td style="text-align: right"> <b><?= number_format($f -> product_price * $f->quantity,2); ?><br/><?= number_format($ship,2); ?><br/><?php
                    if($tp->discount >0){
                        if($tp->discount_type == 1){
                            echo number_format($tp->discount_rate*$f->quantity,2) ;
                        }
                        elseif($tp->discount_type == 2)
                        {
                            echo number_format($tp->discount_rate,2) ;
                        }
                        else
                        {
                            echo "00.00";
                        }
                    }
                    ?><br/>  <?= number_format($total,2); ?><br/></b></td>
                </tr>
            </table>
        </td>
    </tr>

    <tr> <td colspan="2" style="border-top:solid 2px #000;"> </td> </tr>
    <tr>
        <td width="600px"></td>
        <td width="200px" align="center" style="padding-bottom:30px;">

            <table style="width:80%; border:solid 1px #000; margin:20px;">
                <tr>
                    <td style="text-align: center"><img src="<?= site_url(upload_dir('invoice sing.png')); ?>" /> </td>
                </tr>

            </table>
            <label> Authorised Signatory </label>

        </td>
    </tr>

</table>
</body>
</html>