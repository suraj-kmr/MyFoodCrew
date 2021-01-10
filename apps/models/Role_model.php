<?php
class Role_model extends Master_model{

	function __construct(){
		parent::__construct();
		$this -> table = 'orders';
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
				 	 return	$this->team_leader($post['user_id']);
				 	}
				 	else
				 	{
				 		
				 	  return '2';
				 	}

				 }
				 else{
				 
				      return '1';
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
                return $this->get_team_developer($arr1);
              }
              else
              {
                return  '2';
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
                return $this->get_team_motivator($arr1);
              }
              else
              {
                return  '3';
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
                return $this->cdm($arr1);
              }
              else
              {
                  //echo 'TD';
               return   '4';
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
                return $this->sr_cdm($arr1);
              }
              else
              {
                  //echo 'team_motivator';
                return  '5';
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
                return $this->silver_director($arr1);
              }
              else
              {
                return  '6';
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
                return $this->gold_directot($arr1);
              }
              else
              {
                return '7';
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
                return  $this->platinum_director($arr1);
              }
              else
              {
                 // echo 'silver director';
                 return '8';
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
                 return $this->diamond_director($arr1);
              }
              else
              {
                 // echo 'Gold director';
                return  '9';
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
                return $this->crown_director($arr1);
              }
              else
              {
                //  echo 'Platinum director';
                 return '10';
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
                return $this->crown_diamond_director($arr1);
              }
              else
              {
                  //echo 'diamond director';
                 return '11';
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
                 return '13';
              }
              else
              {
                 // echo 'crown director';
                 return '12';
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
        function get_up_level_id($id){
	    	$this->db->select('id,parent_id');
	    	$rs = $this->db->get_where('users',array('id'=>$id,'activation'=>1))->row();
	    
	    	    return $rs;
	    
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
                    
                  return $rs;
                    
                 }
            }
            
    function get_top_user($id,$amount=false,$order_id)
    {
       if($id!=1)
       {    
                if($this->user_role($id)==1){
                  
                  $this->save_bonus($amount,1,$id,$order_id);  
                }
                else if($this->user_role($id)==2){
                    $this->save_bonus($amount,2,$id,$order_id);  
                }
                else if($this->user_role($id)==3){
                  $this->save_bonus($amount,3,$id,$order_id);    
                }
                else if($this->user_role($id)==4){
                    $this->save_bonus($amount,4,$id,$order_id);  
                }
                else if($this->user_role($id)==5){
                    $this->save_bonus($amount,5,$id,$order_id);  
                }
                else if($this->user_role($id)==6){
                    $this->save_bonus($amount,6,$id,$order_id);  
                }
                else if($this->user_role($id)==7){
                    $this->save_bonus($amount,7,$id,$order_id);  
                }
                else if($this->user_role($id)==8){
                   $this->save_bonus($amount,8,$id,$order_id);   
                }
                else if($this->user_role($id)==9){
                  $this->save_bonus($amount,9,$id,$order_id);    
                }
                else if($this->user_role($id)==10){
                 $this->save_bonus($amount,10,$id,$order_id);     
                }
                else if($this->user_role($id)==11){
                   $this->save_bonus($amount,11,$id,$order_id);   
                }
                else if($this->user_role($id)==12){
                    $this->save_bonus($amount,12,$id,$order_id);  
                }
                else if($this->user_role($id)==13){
                 $this->save_bonus($amount,13,$id,$order_id);     
                }
        
          
              $parent_id = $this->get_up_level_id($id);
          
               if(is_object($parent_id))
               {
                   //var_dump($parent_id);
                   
                   if($parent_id->parent_id!=0)
                   {
                            $this->get_top_user($parent_id->parent_id,$amount,$order_id);
                   }
               }
        }
    }
    
    function save_bonus($amt,$position_id,$user_id,$order_id)
    {
        $bonus = $this->db->get_where('post_desc',array('id'=>$position_id))->row();
        $arr = array(
        	'order_id'=>$order_id,
        	'user_id'=>$user_id,
        	'amount'=>$amt,
        	'level_bonus'=>$bonus->level_diff,
        	'percentage_bonus'=>$bonus->repurchase_diff,
        	'created'=>date("y/m/d H:i:s"),
        	'cr_dr'=>'1'
        );
        $this->db->insert('payout',$arr);
        //echo $this->db->last_query();die;
        
    }
    
}
