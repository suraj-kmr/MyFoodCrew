<div class="page-header">
	<h2>Store</h2>
</div>
<?php echo form_open_multipart(admin_url('city/addstore/'.$id), array('class' => 'form-horizontal')); ?>
<div class="tabbable">

	<ul class="nav nav-tabs">
		<li class="active"><a href="#description_tab" data-toggle="tab">City</a></li>
		<!--<li><a href="#attributes_tab" data-toggle="tab">Menu Settings</a></li>-->
		<!--<li><a href="#seo_tab" data-toggle="tab">SEO</a></li>-->
	</ul>
	<div>&nbsp;</div>
	<div class="tab-content">
		<div class="tab-pane active" id="description_tab">
            <div class="form-group">
                <label class="col-sm-2">State</label>
                <div class="col-sm-4">
                    <select name="form[state_id]" class="form-control" id="state">
                        <option value="">Select State</option>
                        <?php if(is_array($state) && count($state) > 0){
                            foreach($state as $ss){
                                ?>
                                <option <?php if($ss->id==$store->state_id) echo 'selected="selected"'; ?> value="<?php echo $ss -> id; ?>"><?php echo $ss -> state_name; ?></option>
                            <?php
                            }
                        } ?>
                    </select>
                </div>
                <label class="col-sm-2">City</label>
                <div class="col-sm-4">
                    <select name="form[city_id]" class="form-control" id="state">
                        <option value="">Select City</option>
                        <?php if(is_array($cities) && count($cities) > 0){
                            foreach($cities as $ss){
                                ?>
                                <option <?php if($ss->id==$store->city_id) echo 'selected="selected"'; ?> value="<?php echo $ss -> id; ?>"><?php echo $ss -> city; ?></option>
                            <?php
                            }
                        } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2">Store name</label>
                <div class="col-sm-4">
                    <input type="text" name="form[store_name]" value="<?php echo set_value('store', $store->store_name); ?>" class="form-control input-sm" />
                </div>
                <label class="col-sm-2">Address</label>
                <div class="col-sm-4">
                    <input type="text" name="form[address]" value="<?php  echo set_value('store', $store->address); ?>" class="form-control input-sm" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2">Email</label>
                <div class="col-sm-4">
                <input type="text" name="form[email_id]" value="<?php  echo set_value('store', $store->email_id); ?>" class="form-control input-sm" />
                </div>
                <label class="col-sm-2">Mobile</label>
                <div class="col-sm-4">
                    <input type="text" name="form[mobile]" value="<?php  echo set_value('store', $store->mobile); ?>" class="form-control input-sm" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2">Timing</label>
                <div class="col-sm-4">
                    <input type="text" name="form[timing]" value="<?php  echo set_value('store', $store->timing); ?>" class="form-control input-sm" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2">&nbsp;</label>
                <div class="col-sm-4">
                <button type="submit" class="btn btn-primary btn-sm">Save</button>
                </div>
            </div>       
		</div>		
	</div>
</div>
</form>

<script type="text/javascript">
$('form').submit(function() {
	$('.btn').attr('disabled', true).addClass('disabled');
});
</script>