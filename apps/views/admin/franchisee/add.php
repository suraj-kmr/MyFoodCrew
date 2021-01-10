<div class="page-header">
	<h2>Franchisee Form</h2>
</div>
<?php echo validation_errors(); ?>
<div class="row">
    <div class="col-sm-4 col-sm-offset-4">
        <div class="box box-p">
            <script src="<?php echo site_url();?>assets/js/jquery.form-validator.min.js"></script>
            <?php $this -> load -> view('alert'); ?>
            <form id="fr-register" class="form-horizontal" method="POST" action="<?= admin_url('franchisee/add/'.$id);?>">
                <div class="form-group">
                    <div class="col-sm-12">
                        <label>Your Name</label>
                        <input class="form-control" type="text" data-msg="Name is required" data-maxlength="200" data-minlength="2" data-validation="required" data-validation-error-msg="Please enter first name" placeholder="Your name" name="data[name]" value="<?php echo $fr->name; ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <label>State</label>
                        <select name="data[state_id]" class="form-control" id="state">
                            <option value="">Select State</option>
                            <?php if(is_array($state) && count($state) > 0){
                                foreach($state as $ss){
                                    ?>
                                    <option <?php if($ss->id==$fr->state_id) echo "selected='selected'"; ?> value="<?php echo $ss -> id; ?>"><?php echo $ss -> state_name; ?></option>
                                <?php
                                }
                            } ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12">City</label>
                    <div class="col-md-12">
                        <?php //print_r($cities); ?>

                        <select name="data[city_id]" class="form-control" id="cities">
                            <option selected value="<?php $city = $this->City_model->cityName(1); echo $city->id; ?>"><?php echo $city->city; ?></option>
                            <option value="">Select City</option>
                        </select>

                    </div>
                </div>

                <div class="form-group" id="email">
                    <div class="col-sm-12">
                        <label>Email</label>
                        <input class="form-control" type="text" data-msg="Enter valid email id" data-type="email" placeholder="e.g yourname@mail.com" data-validation="required email" data-validation-error-msg-required="Please enter email id" data-validation-error-msg-email="Please enter valid email id" name="data[email]" value="<?php echo $fr->email; ?>"/>

                    </div>
                </div>
                <div class="form-group mobile" id="mobile">
                    <div class="col-sm-12">
                        <label>Mobile</label>
                        <input class="form-control" type="text" data-msg="Mobile no is required" data-validation="required" data-validation-error-msg="Please enter mobile no" placeholder="Mobile no" name="data[mobile]" value="<?php echo $fr->mobile ?>"/>
                    </div>

                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <label>Available Capital</label>
                        <select name="data[capital]" data-role="none" class="form-control">
                            <option value="0" selected="selected">Available Capital</option>
                            <option <?php if($fr->capital =='Rs. 35 to 50 Lakhs') echo "selected='selected'"; ?> value="Rs. 35 to 50 Lakhs">Rs. 35 to 50 Lakhs</option>
                            <option <?php if($fr->capital =='Rs. 50 Lakhs and above') echo "selected='selected'"; ?> value="Rs. 50 Lakhs and above">Rs. 50 Lakhs and above</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-12">
                        <label>Description</label>
                        <textarea name="data[description]" rows="8" class="form-control"><?php echo $fr->description; ?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-12">
                        <select name="data[hear_from]" data-role="none" class="form-control">
                            <option value="0" selected="selected">How did you hear about us</option>
                            <option <?php if($fr->hear_from =='Google') echo "selected='selected'"; ?> value="Google">Google</option>
                            <option <?php if($fr->hear_from =='Yahoo') echo "selected='selected'"; ?> value="Yahoo">Yahoo</option>
                            <option <?php if($fr->hear_from =='Facebook') echo "selected='selected'"; ?> value="Facebook">Facebook</option>
                            <option <?php if($fr->hear_from =='Blog') echo "selected='selected'"; ?> value="Blog">Blog</option>
                            <option <?php if($fr->hear_from =='News') echo "selected='selected'"; ?> value="News">News</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-12">
                        <button class="btn btn-black btn-sm col-sm-12" type="submit" name="reg" value="Register">Submit</button>
                        <!--<a href="<?php echo site_url();?>" class="btn btn-sm btn-default">Cancel</a>-->
                    </div>
                </div>

            </form>
            <script type="text/javascript">
                $.validate();
            </script>
        </div>
    </div>
</div>
<style>
    .city_drop{
        display: none;
    }
</style>
<script type="text/javascript">
    $('#state').change(function () {
        $('.city_drop').attr('display','block')
        var state_id = $('#state').val();
        //alert(state_id);
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('store_locator/cities'); ?>",
            data: 'state_id=' + state_id,
            success: function (f) {
                $('#cities').empty().append(f);
            }
        });
    });

</script>