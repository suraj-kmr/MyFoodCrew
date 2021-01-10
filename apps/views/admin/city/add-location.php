<div class="page-header">
	<h2>City Form</h2>
</div>
<?php echo form_open_multipart($this -> config -> item('admin_folder').'city/add_location/'.$id, array('class' => 'form-horizontal')); ?>
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
                <div class="col-sm-3">
                <?php
					$state_arr = array();
					foreach($states as $s){
						$state_arr[$s['id']] = $s['state_name'];	
					}
					echo form_dropdown('state_id', $state_arr, $state_id, 'class="form-control input-sm" id="statedd"');
				?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2">City</label>
                <div class="col-sm-3" id="citydd">
                <?php
					$city_arr = array();
					foreach($cities as $c){
						$city_arr[$c['id']] = $c['city_name'];	
					}
					echo form_dropdown('city_id', $city_arr, $city_id, 'class="form-control input-sm"');
				?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2">Location</label>
                <div class="col-sm-4">
                <input type="text" name="location" value="<?php  echo set_value('location', $location); ?>" class="form-control input-sm" />
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
	$(document).ready(function(){
		$('#statedd').change(function(){
			var v = $(this).val();
			$.ajax({
				url: '<?php echo site_url($this -> config -> item('admin_folder').'city/filter_location'); ?>' + '/' + v,
				type: 'GET',
				dataType: 'html',
				success: function(f){
					$('#citydd').html(f);
				}
			});
		});						   
	});
</script>