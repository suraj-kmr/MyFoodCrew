	<?php

	class Role extends AI_Controller
	{
	   
	    function __construct()
	    {
	        parent::__construct();
	        
	    }

	    function user_role($id)
	    {

	    	$active = $this->db->get_where('users',array('id'=>$id,'activation'=>1))->first_row();
	    	$role   = false;
	    	$position =''; 
	    	//posistion  1 check
	    	if(is_object($active)){
				$post =  $this->get_categories($id);
				
				
				 if($post['total'][0] >= 5)
				 {
				 	

				 	if($post['total'][0] >= 5)
				 	{
				 		$this->team_leader($post['user_id']);
				 	}
				 	else
				 	{
				 		
				 		$this->get_user_position(2);
				 	}

				 }
				 else{
				 
				        $this->get_user_position(1);
				 }
    		
	    		
	    	}

        
	    }


	    function team_leader($user)
	    {
	    	    $i=0;
	    		$arr1=array();
	    		
	    		foreach($user as $rs)
	    		{

	    		 	$five_per = $this->get_parent($rs);
	    			if($five_per >=5){
	    				
	    				$rs1 = $this->get_parent_id($rs);
	    				if(is_array($rs1) and count($rs1)>0)
	    				{  
	    					foreach ($rs1 as $s) {
	    						$arr1[] = $s->id;
	    						//echo $s->id;
	    					}
	    				}
	    				

	    			  $i++;
	    			}

	    		}


              if($i>=5)
              {
                 $this->get_team_developer($arr1);
              }
              else
              {
                  $this->get_user_position(2);
                  //echo 'JPL';
              }
	    	
	    }
	    
	    
	    
	    function get_team_developer($user)
	    {
	    	    $i=0;
	    		$arr1=array();
	    	//	var_dump($user);
	    		foreach($user as $rs)
	    		{

	    		 	$four_per = $this->get_parent($rs);
	    			if($four_per >=4){
	    				
	    				$rs1 = $this->get_parent_id($rs);
	    				if(is_array($rs1) and count($rs1)>0)
	    				{  
	    					foreach ($rs1 as $s) {
	    						$arr1[] = $s->id;
	    						//echo $s->id;
	    					}
	    				}
	    				

	    			  $i++;
	    			}

	    		}


              if($i>=4)
              {
                 $this->get_team_motivator($arr1);
              }
              else
              {
                 $this->get_user_position(3);
              }
	    	
	    }


        function get_team_motivator($user)
	    {
	    	    $i=0;
	    		$arr1=array();
	    		
	    		foreach($user as $rs)
	    		{

	    		 	$four_per = $this->get_parent($rs);
	    			if($four_per >=3){
	    				
	    				$rs1 = $this->get_parent_id($rs);
	    				if(is_array($rs1) and count($rs1)>0)
	    				{  
	    					foreach ($rs1 as $s) {
	    						$arr1[] = $s->id;
	    					
	    					}
	    				}
	    				

	    			  $i++;
	    			}

	    		}


              if($i>=3)
              {
                 $this->cdm($arr1);
              }
              else
              {
                  //echo 'TD';
                  $this->get_user_position(4);
              }
	    	
	    }
	    
	    
	     function cdm($user)
	    {
	    	    $i=0;
	    		$arr1=array();
	    		
	    		foreach($user as $rs)
	    		{

	    		 	$four_per = $this->get_parent($rs);
	    			if($four_per >=3){
	    				
	    				$rs1 = $this->get_parent_id($rs);
	    				if(is_array($rs1) and count($rs1)>0)
	    				{  
	    					foreach ($rs1 as $s) {
	    						$arr1[] = $s->id;
	    						
	    					}
	    				}
	    				

	    			  $i++;
	    			}

	    		}


              if($i>=3)
              {
                 $this->sr_cdm($arr1);
              }
              else
              {
                  //echo 'team_motivator';
                  $this->get_user_position(5);
              }
	    	
	    }
	    
	    
	     function sr_cdm($user)
	    {
	    	    $i=0;
	    		$arr1=array();
	    		
	    		foreach($user as $rs)
	    		{

	    		 	$four_per = $this->get_parent($rs);
	    			if($four_per >=3){
	    				
	    				$rs1 = $this->get_parent_id($rs);
	    				if(is_array($rs1) and count($rs1)>0)
	    				{  
	    					foreach ($rs1 as $s) {
	    						$arr1[] = $s->id;
	    						
	    					}
	    				}
	    				

	    			  $i++;
	    			}

	    		}


              if($i>=3)
              {
                 $this->silver_director($arr1);
              }
              else
              {
                  $this->get_user_position(6);
                 // echo 'cdm';
              }
	    	
	    }
	    
	     function  silver_director($user)
	    {
	    	    $i=0;
	    		$arr1=array();
	    		
	    		foreach($user as $rs)
	    		{

	    		 	$four_per = $this->get_parent($rs);
	    			if($four_per >=3){
	    				
	    				$rs1 = $this->get_parent_id($rs);
	    				if(is_array($rs1) and count($rs1)>0)
	    				{  
	    					foreach ($rs1 as $s) {
	    						$arr1[] = $s->id;
	    						
	    					}
	    				}
	    				

	    			  $i++;
	    			}

	    		}


              if($i>=3)
              {
                 $this->gold_directot($arr1);
              }
              else
              {
                  $this->get_user_position(7);
                  //echo 'sr.cdm';
              }
	    	
	    }
        
        
        function  gold_directot($user)
	    {
	    	    $i=0;
	    		$arr1=array();
	    		
	    		foreach($user as $rs)
	    		{

	    		 	$four_per = $this->get_parent($rs);
	    			if($four_per >=2){
	    				
	    				$rs1 = $this->get_parent_id($rs);
	    				if(is_array($rs1) and count($rs1)>0)
	    				{  
	    					foreach ($rs1 as $s) {
	    						$arr1[] = $s->id;
	    						
	    					}
	    				}
	    				

	    			  $i++;
	    			}

	    		}


              if($i>=2)
              {
                 $this->platinum_director($arr1);
              }
              else
              {
                 // echo 'silver director';
                  $this->get_user_position(8);
              }
	    	
	    }

         function  platinum_director($user)
	    {
	    	    $i=0;
	    		$arr1=array();
	    		
	    		foreach($user as $rs)
	    		{

	    		 	$four_per = $this->get_parent($rs);
	    			if($four_per >=2){
	    				
	    				$rs1 = $this->get_parent_id($rs);
	    				if(is_array($rs1) and count($rs1)>0)
	    				{  
	    					foreach ($rs1 as $s) {
	    						$arr1[] = $s->id;
	    						
	    					}
	    				}
	    				

	    			  $i++;
	    			}

	    		}


              if($i>=2)
              {
                 $this->diamond_director($arr1);
              }
              else
              {
                 // echo 'Gold director';
                  $this->get_user_position(9);
              }
	    	
	    }
	    
	    
	     function  diamond_director($user)
	    {
	    	    $i=0;
	    		$arr1=array();
	    		
	    		foreach($user as $rs)
	    		{

	    		 	$four_per = $this->get_parent($rs);
	    			if($four_per >=2){
	    				
	    				$rs1 = $this->get_parent_id($rs);
	    				if(is_array($rs1) and count($rs1)>0)
	    				{  
	    					foreach ($rs1 as $s) {
	    						$arr1[] = $s->id;
	    						
	    					}
	    				}
	    				

	    			  $i++;
	    			}

	    		}


              if($i>=2)
              {
                 $this->crown_director($arr1);
              }
              else
              {
                //  echo 'Platinum director';
                  $this->get_user_position(10);
              }
	    	
	    }
	    
	    function  crown_director($user)
	    {
	    	    $i=0;
	    		$arr1=array();
	    		
	    		foreach($user as $rs)
	    		{

	    		 	$four_per = $this->get_parent($rs);
	    			if($four_per >=2){
	    				
	    				$rs1 = $this->get_parent_id($rs);
	    				if(is_array($rs1) and count($rs1)>0)
	    				{  
	    					foreach ($rs1 as $s) {
	    						$arr1[] = $s->id;
	    						
	    					}
	    				}
	    				

	    			  $i++;
	    			}

	    		}


              if($i>=2)
              {
                 $this->crown_diamond_director($arr1);
              }
              else
              {
                  //echo 'diamond director';
                  $this->get_user_position(11);
              }
	    	
	    }
	    
	    function  crown_diamond_director($user)
	    {
	    	    $i=0;
	    		$arr1=array();
	    		
	    		foreach($user as $rs)
	    		{

	    		 	$four_per = $this->get_parent($rs);
	    			if($four_per >=2){
	    				
	    				$rs1 = $this->get_parent_id($rs);
	    				if(is_array($rs1) and count($rs1)>0)
	    				{  
	    					foreach ($rs1 as $s) {
	    						$arr1[] = $s->id;
	    						
	    					}
	    				}
	    				

	    			  $i++;
	    			}

	    		}


              if($i>=2)
              {
                // echo 'crown diamond director';
                 $this->get_user_position(13);
              }
              else
              {
                 // echo 'crown director';
                  $this->get_user_position(12);
              }
	    	
	    }
	    
	    
            
            
			function get_categories($parent = 0)
		    {

		        $categories = array();

		        $result = $this->db->get_where('users',array('parent_id'=>$parent,'activation'=>1))->result();
		        $categories['total'][]= $this->db->get_where('users',array('parent_id'=>$parent,'activation'=>1))->num_rows();
				 foreach ($result as $category)
				 {
		            $categories['user_id'][] = $category->id;
           

		        }

		        return $categories;

		    }


	    function get_parent($id)
	    {
	    	return $this->db->get_where('users',array('parent_id'=>$id,'activation'=>1))->num_rows();

	    }
	    function get_sub_id($id){
	    	$this->db->select('id,parent_id');
	    	return $this->db->get_where('users',array('id'=>$id,'activation'=>1))->result();
	    }

	    function get_parent_id($id){
	    	$this->db->select('id,parent_id');
	    	return $this->db->get_where('users',array('parent_id'=>$id,'activation'=>1))->result();
	    }
	    function get_user_position($id)
            {
                
                $rs = $this->db->get_where('post_desc',array('id'=>$id))->row();
                if(is_object($rs))
                {
                    //return $rs;
                }
            }
	}	   
	
	?>
