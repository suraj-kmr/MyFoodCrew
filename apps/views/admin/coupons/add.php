<div class="page-header">
	<h2>Coupons Form</h2>
</div>
<?php echo validation_errors(); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="box box-p">
            <script src="<?php echo site_url();?>assets/js/jquery.form-validator.min.js"></script>
            <?php //$this -> load -> view('alert'); ?>
            <form id="fr-register" class="form-horizontal" method="POST" action="<?= admin_url('coupons/add/'.$id);?>">
                <div class="form-group">
                    <div class="col-sm-5">
                        <label>Title</label>
                        <input class="form-control" type="text" data-msg="Title is required" data-maxlength="200" data-minlength="2" data-validation="required" data-validation-error-msg="Please enter first name" placeholder="Your name" name="data[title]" value="<?php echo $fr->title; ?>"/>
                    </div>
                    <div class="col-sm-5">
                        <label>Coupon Code</label>
                        <input class="form-control" type="text" data-msg="Coupon Code is required" data-maxlength="200" data-minlength="2" data-validation="required" data-validation-error-msg="Please enter Coupon code" placeholder="Coupon Code" name="data[coupon_code]" value="<?php if($fr->coupon_code) { echo $fr->coupon_code; } else{ echo strtoupper($coupon); } ?>"/>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-5">
                        <label class="col-sm-12">Type</label>
                        <input type="radio" name="data[type]" <?php if($fr->type==0) echo 'checked="checked"'; ?> value="0" /> Discount
                        <input type="radio" name="data[type]" <?php if($fr->type==1) echo 'checked="checked"'; ?> value="1" /> Cashback
                    </div>
                    <div class="col-sm-5">
                        <label class="col-sm-3">Discount</label>
                        <div class="col-sm-6">
                        <input class="form-control" type="text" data-msg="Discount is required" data-maxlength="10" data-minlength="2" data-validation="required" data-validation-error-msg="Please enter Discount value" placeholder="Discount Amount" name="data[discount]" value="<?php echo $fr->discount; ?>"/></div>
                        <div class="col-sm-3">
                        <select name="data[d_type]" class="form-control">
                            <option <?php if($fr->d_type==0) echo "selected='selected'"; ?> value="0">%</option>
                            <option <?php if($fr->d_type==1) echo "selected='selected'"; ?> value="1">Rs</option>
                        </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-5">
                        <label>Max Discount</label>
                        <input class="form-control" type="text" data-msg="Max Discount is required" data-maxlength="200" data-minlength="2" data-validation="required" data-validation-error-msg="Please enter Max Discount value" placeholder="Max Discount Amount" name="data[max_discount]" value="<?php echo $fr->max_discount; ?>"/>
                    </div>
                    <div class="col-sm-5">
                        <label>Expiry Date</label>
                        <div class='input-group date'>
                            <input class="form-control datepickera" placeholder="Coupon Expiry" name="data[validity]" value="<?php echo $fr->validity; ?>">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                        </div>

                    </div>

                </div>

                <div class="form-group" id="email">
                    <div class="col-sm-5">
                        <label>No of Uses</label>
                        <input class="form-control" type="text" data-msg="No of uses is required" placeholder="No of uses" data-validation="required uses" data-validation-error-msg-required="Please enter uses" name="data[no_of_use]" value="<?php echo $fr->no_of_use; ?>"/>
                    </div>
                    <div class="col-sm-5">
                        <label>Site Visibility</label>
                        <label><input <?php if($fr->visibility==0) echo 'checked="checked"'; ?> type="radio" value="0" name="data[visibility]"/> Public</label>
                        <label><input <?php if($fr->visibility==1) echo 'checked="checked"'; ?> type="radio" value="1" name="data[visibility]"/> Personal</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-5">
                        <button class="btn btn-black btn-sm col-sm-12" type="submit" name="save" value="Save">Save</button>
                        <!--<a href="<?php echo site_url();?>" class="btn btn-sm btn-default">Cancel</a>-->
                    </div>
                </div>

            </form>
            <script type="text/javascript">
                $('.datepickera').datepicker({
                    dateFormat: 'yy-mm-dd'
                });
            </script>
            <script type="text/javascript">
                $.validate();
            </script>

        </div>
    </div>
</div>