<div class="page-header">
	<h2>City Form</h2>
</div>
<?php echo form_open_multipart(admin_url('city/addtext/'.$id), array('class' => 'form-horizontal')); ?>
<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#description_tab" data-toggle="tab">Text</a></li>
	</ul>
	<div>&nbsp;</div>
	<div class="tab-content">
		<div class="tab-pane active" id="description_tab">
            <div class="form-group">
                <label class="col-sm-2">Text</label>
                <div class="col-sm-4">
                <input type="text" name="form[description]" value="<?php  echo set_value('description', $store_text->description); ?>" class="form-control input-sm" />
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