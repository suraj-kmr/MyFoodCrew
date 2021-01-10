<div class="page-header">
	<h2>Location List</h2>
</div>
<div class="pull-right">
	<a class="btn btn-sm btn-primary" href="<?php echo site_url($this -> config -> item('admin_folder').'city/add_location'); ?>"><i class="glyphicon glyphicon-plus-sign"></i> Add New Locations</a>
</div>

<table class="table table-striped">
    <thead>
		<tr>
			<th>State ID</th>
			<th>Location</th>  
            <th>City</th>          
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php echo (count($locations) < 1)?'<tr><td style="text-align:center;" colspan="3">No State Found</td></tr>':''?>
	
		<?php foreach($locations as $row): ?>
        	<tr>
            	<td><?php echo $row['id']; ?></td>
            	<td><?php echo $row['location']; ?></td>
                <td><?php 
					$state_id = $row['state_id'];
					$city_id = $row['city_id'];
					$state = $this -> City_model -> get_state($state_id);
					$city = $this -> City_model -> get_city($city_id);
					echo $state['state_name'].', '.$city['city_name'];
				
				?></td>
                <td>
					<div class="btn-group pull-right">
                    	<a href="<?php echo site_url($this -> config -> item('admin_folder').'city/add_location/'.$row['id']); ?>" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                        <a href="<?php echo  site_url($this -> config -> item('admin_folder').'city/delete_location/'.$row['id']);?>" class="btn btn-sm btn-danger delete"><i class="glyphicon glyphicon-trash"></i> Delete</a>
                    </div>
				<?php
                	
				?></td>
        	</tr>
        <?php endforeach; ?>
	</tbody>
</table>
