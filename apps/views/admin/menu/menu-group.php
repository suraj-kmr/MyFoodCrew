<div class="page-header">
	<h2>Menu Group <a class="btn btn-primary btn-sm pull-right" href="<?php echo admin_url('menu/group'); ?>"><i class="glyphicon glyphicon-plus-sign"></i> Add New Group</a></h2>
</div>
<table class="table">
    <thead>
		<tr>
			<th>Menu Group</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php echo (count($menu_group) < 1) ? '<tr><td style="text-align:center;" colspan="3">No Menu Found</td></tr>':''?>
        <tr>
        	<td colspan="2">
            <div class="panel-group" id="accordion">
            <?php foreach($menu_group as $row) : ?>
            	<div class="box">
                	<div class="box-header clearfix">
                    	<h4 class="box-title pull-left"><?php // $row['img_icon']; ?>
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $row['id']; ?>">
                              <strong><?php echo $row['group_name']; ?></strong>
                            </a>
                    	</h4>
                        <div class="btn-group pull-right">
                                <a class="btn btn-xs btn-primary" href="<?php echo admin_url('menu/addlink/'.$row['id']); ?>" title="Add Link"><i class="glyphicon glyphicon-link"></i></a>
                                <a class="btn btn-xs btn-info" href="<?php echo admin_url('menu/group/'.$row['id']); ?>" title="Edit Menu"><i class="glyphicon glyphicon-edit"></i></a>
                                <a class="btn btn-xs btn-danger delete" href="<?php echo admin_url('menu/delgroup/'.$row['id']); ?>" title="Delete Menu"><i class="glyphicon glyphicon-trash"></i></a>
                         </div>
                    </div>
                    <div id="collapse<?php echo $row['id']; ?>" class="accordion-body collapse in">
                      <div class="box-p">
	                      <div class="row">
		                      <div class="col-sm-6">
			                      <table class="table table-bordered nomargin">
				                      <?php list_menus($row['links'], $rowid = $row['id']); ?>
			                      </table>
		                      </div>
		                      <div class="col-sm-6 result-table" id="restable<?php echo $row['id']; ?>">

		                      </div>
	                      </div>
                      </div>
                	</div>
                  </div>
           <?php endforeach; ?>
           <?php function list_menus($cats, $rowid, $scats = ''){?>
					<?php
					if(count($cats) > 0){
						foreach($cats as $r){
							?>
							 <tr>
							 <td><?php
                                 $str = $scats . $r['menu_title'];
								 if($r['use_heading']){
									 echo '<b>'.$str.'</b>';
								 }else{
                                     echo $str;
                                 }
								?>
							 </td>
							 <td class="text-center"><?php echo $r['sequence']; ?></td>
							 <td><div class="btn-group btn-group-xs pull-right">
                             <a href="#" class="btn btn-xs btn-edit btn-info" data-id="<?php echo $r['id']; ?>" data-result="<?php echo $rowid; ?>"><i class="glyphicon glyphicon-search"></i></a>
                                     <a href="<?php echo admin_url('menu/deletelink/' .$r['id']); ?>" class="btn btn-xs btn-danger delete"><i class="glyphicon glyphicon-trash"></i></a>
                             </div></td>
							 </tr>
						<?php
							if(count($r['children']) > 0){
								list_menus($r['children'], $rowid, '&rarr; ');
							}
						}
					}
            	}
			?>
            </div>
            </td>
        </tr>
	</tbody>
</table>
<script>
$(document).ready(function(){
	//$('.collapse').collapse();
	$('.btn-edit').click(function(){
		var mid = $(this).attr('data-id');
		var did = $(this).attr('data-result');
		$.ajax({
            url: '<?php echo admin_url('menu/get_link'); ?>/' + mid,
            type:'POST',
            dataType: 'json',
            success: function(output_string){
                    $('#restable' + did).html(output_string);
                } // End of success function of ajax form
            });
		return false;
	});
});

</script>
