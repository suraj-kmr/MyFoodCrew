<div class="page-header">
	<h2>City Form</h2>
</div>
<?php echo form_open_multipart(admin_url('city/add/'.$id), array('class' => 'form-horizontal')); ?>
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
                <label class="col-sm-2">State name</label>
                <div class="col-sm-4">
                    <select name="form[state_id]" class="form-control" id="state">
                        <option value="">Select State</option>
                        <?php if(is_array($state) && count($state) > 0){
                            foreach($state as $ss){
                                ?>
                                <option <?php if($ss->id==$city->state_id) echo 'selected="selected"'; ?> value="<?php echo $ss -> id; ?>"><?php echo $ss -> state_name; ?></option>
                            <?php
                            }
                        } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2">City name</label>
                <div class="col-sm-4">
                <input type="text" name="form[city]" value="<?php  echo set_value('city', $city->city); ?>" class="form-control input-sm" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2">Top City</label>
                <div class="col-sm-4">
                    <select name="form[top_city]">
                        <option value="0">No</option>
                        <option <?php if($city->top_city==1) echo 'selected="selected"'; ?> value="1">Yes</option>
                    </select>
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