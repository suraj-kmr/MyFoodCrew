<div class="what-hot">
	<div class="container">
		<h2>Member Tree</h2>
		<hr />
		
		<div class="row">
			
			<div class="col-sm-12">
						<div class="tree_main">
						    <div class="main_user"> 
						    	<?php
						    	if(isset($user_data)){
						    		?>
						      			<img class="img-fluid p_img" src="<?=site_url('img/uploads/'.$user_data->image)?>" id="img" onerror="image1();">
						      			<h2 class="user_name_txt"><?=$user_data->username;?> </h2>  
						    		<?php
						    	}
						    	else
						    	{
						    		?>
						      			<img class="img-fluid p_img" src="<?=site_url('assets/os/images/main.png')?>" > 
						      			<h2 class="user_name_txt">OSG </h2>  
						    		<?php
						    	}
						    	?>
						    </div>
						     
						     <hr style="border-color:#2a5b96;padding-top: 25px;">

						     <ul class="child-user-list">
						     	<?php
						     	if(is_array($tree) && count($tree)>0){
						     		foreach($tree as $tr){
						     			$count = $this->User_model->get_count($tr->id);
						     			?>
						     			 <li> 
								          	<div class="chid_user"> 
								           		<a class="child-tag" href="<?=admin_url('members/membership_tree/'.$tr->id)?>"><img class="img-fluid p_img" src="<?=site_url('img/uploads/'.$tr->image)?>" id="img<?=$tr->id;?>" onerror="image<?=$tr->id;?>();"></a> <br>
								           		<a class="child-tag" href="<?=admin_url('members/membership_tree/'.$tr->id)?>"><label class="ref_name"> <?=ucfirst($tr->username);?></label></a>
								           		 <a class="child-tag" href="<?=admin_url('members/membership_tree/'.$tr->id)?>"><span class="total_users"><?=$count;?> </span></a>
								            </div>
								       	</li>
								       	<script>
											function image<?=$tr->id;?>(){
												document.getElementById('img<?=$tr->id;?>').src="<?=site_url('assets/os/images/child.png')?>";
											}
										</script>
						     			<?php
						     		}
						     	}
						     	?>
						      
						       

						     </ul>

						
				  </div>
			</div>
			
		</div>
	</div>
</div>

<script>
	function image1(){
		document.getElementById('img').src="<?=site_url('assets/os/images/main.png')?>";
	}
</script>