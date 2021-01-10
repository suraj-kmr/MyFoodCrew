<?php
class Product_model extends Master_model{
	public function __construct(){
		parent::__construct();
		$this -> table = 'products';
	}

    function isExists($p_id){
        $c = $this -> db -> get_where($this -> table, array('id' => $p_id)) -> num_rows();
        if($c == 0){
            return FALSE;
        }else{
            return TRUE;
        }
    }

    function delete_p_cat($id){
        $this -> db -> delete('products_categories', array('pid' => $id));
    }

	function resetCategory($pid, $cats = array()){
		$this -> db -> delete('products_categories', array('pid' => $pid));
		foreach($cats as $cid){
			$p = array(
				'pid' => $pid,
				'cid' => $cid
			);
			$this -> db -> insert('products_categories', $p);
		}
	}

	function getProduct($id){
		$p = $this -> getRow($id);
		$cats_arr = $this -> db -> get_where('products_categories', array('pid' => $id)) -> result();
		if(is_array($cats_arr) && count($cats_arr) > 0){
			$temp = array();
			foreach($cats_arr as $c){
				$temp[] = $c -> cid;
			}
		}else{
			$temp = array();
		}
		$p -> cats = $temp;
		if($p -> sizes <> ''){
			$p -> sizes = json_decode($p -> sizes);
		}else{
			$p -> sizes = array();
		}
		if($p -> params <> ''){
			$p -> params = json_decode($p -> params);
		}else{
			$p -> params = array();
		}
		return $p;
	}

	function getNew($table = false){
		$p = parent::getNew();
		$p -> cats = array();
		$p -> sizes = array();
		return $p;
	}

    function check_duplicate($id, $ptitle){
        $this -> db -> where(array('id' => $id, 'ptitle' => $ptitle));
        $c = $this -> db -> get('products') -> num_rows();
        if($c > 0){
            return true;
        }else{
            return false;
        }
    }

    function saveProduct($data){
        if($data['id']){
            $this -> db -> update('products', $data, array('id' => $data['id']));
            return $data['id'];
        }else{
            $this -> db -> insert('products', $data);
            return $this -> db -> insert_id();
        }
    }

    function insert_cat_id($tp){
        $row = $this -> db -> get_where('products', array('id' => $tp));
        if($row -> num_rows() == 0){
            $this -> db -> insert('products_categories', array('pid' => $tp[0], 'cid' => $tp[2]));
            //$this -> db -> insert('categories', array('name' => $name, 'product_type' => "5"));
            return $this -> db -> insert_id();
        }else{
            $r = $row -> first_row();
            return $r -> id;
        }
    }
	function updateAll($data)    {        
		$r = $this-> db -> update('pincode_cod', $data);        
		return $r;    
	}
	
    function get_product($brand_id=false){
        return $this -> db -> get_where('products', array('brand_id' => $brand_id)) -> result();
    }
  
   function get_products($cat_id=false){
        return $this -> db -> get_where('products', array('category' => $cat_id)) -> result();
    }
    function getProductsName()
    {
    	$data = $this -> db -> get_where('products', array('status' => 1)) -> result_array();
    	//echo  $this->db->last_query();
    	return $data;
    }
    function field_dropdown($table)
    {
        $data = array(
            0 => 'Select Brands'
        );
        $this->db->order_by('title', "ASC");
        //$this->db->where('product_type', 3);
        $rest = $this->db->get($table);
        if ($rest->num_rows() > 0) {
            foreach ($rest->result() as $r) {
                $tname = ucwords(strtolower($r->title));
                $data[$r->id] = $tname;
                //$data = $this->sub_child($r->id, $tname, $data);
            }
        }
        return $data;
    }

    function get_price($ptype,$id){
        if($ptype == 2){
            $pr = $this->db->get_where('units',array('pid' =>$id))->first_row();
            return $pr;
        }
        else
        {
            return false;
        }
    }

    function get_unit_price($ptype,$id){
        if($ptype == 2){
            $pr = $this->db->get_where('units',array('pid' =>$id))->result();
            return $pr;
        }
        else
        {
            return false;
        }
    }
    function chkwishlist($pid,$uid){
        $data = $this->db->get_where('ai_wishlist',array('user_id'=>$uid,'pid'=>$pid))->num_rows();
        return $data;
    }

    function get_cloth_price($ptype,$id){
        if($ptype == 1){
            $pr = $this->db->get_where('products',array('id' =>$id))->first_row();
            $attr = json_decode($pr->attr);
                return $attr;
        }
        else
        {
            return false;
        }
    }
    function canceled($uid,$limit=false){

         $this->db->select('ai_cancel.*,products.*');
    $this->db->from('ai_cancel');
    $this->db->join('products', 'ai_cancel.product_id = products.id'); 
    $this->db->where(array('products.user_id'=>$uid, 'ai_cancel.status'=>1));
    $this->db->limit($limit);
    $this->db->order_by('ai_cancel.id','DESC');
    $q = $this->db->get()->result();
    return $q;


    }
 function venderOrder($uid){

         $this->db->select('order_items.*,products.*,orders.*');
    $this->db->from('order_items');
     $this->db->join('orders', 'orders.id = order_items.order_id'); 
    $this->db->join('products', 'products.id = order_items.product_id'); 
     $this->db->where(array('orders.pay_status'=>"Received"));
    $this->db->where(array('products.user_id'=>$uid));
    $q = $this->db->get()->result();
    //echo $this->db->last_query();die;
    return $q;


    }
     function venderPayout($uid){

         $this->db->select('order_items.*,products.*,orders.*');
    $this->db->from('order_items');
     $this->db->join('orders', 'orders.id = order_items.order_id'); 
    $this->db->join('products', 'products.id = order_items.product_id'); 
     $this->db->where(array('orders.pay_status'=>"Received"));
    $this->db->where(array('products.user_id'=>$uid));
    $q = $this->db->get()->result();
    //echo $this->db->last_query();die;
    return $q;


    }
     function todayorder($uid){

         $this->db->select('order_items.*,products.*,orders.*');
    $this->db->from('order_items');
     $this->db->join('orders', 'orders.id = order_items.order_id'); 
    $this->db->join('products', 'products.id = order_items.product_id'); 
    
    $this->db->where(array('products.user_id'=>$uid));
     $this->db->where(array('orders.pay_status'=>"Received"));
    $this->db->where(array(date('d-m-Y',strtotime('orders.created_on')))==date('d-m-Y'));
    $q = $this->db->get()->num_rows();
    //echo $this->db->last_query();die;
    return $q;


    }
     function weekorder($uid){

         $this->db->select('order_items.*,products.*,orders.*');
    $this->db->from('order_items');
     $this->db->join('orders', 'orders.id = order_items.order_id'); 
    $this->db->join('products', 'products.id = order_items.product_id'); 
    
    $this->db->where(array('products.user_id'=>$uid));
     $this->db->where(array('orders.pay_status'=>"Received"));
     $date1 = date('Y-m-d');
    $date2 = date('Y-m-d',strtotime ('-7 day' , strtotime ($date1) )) ;
    $this->db->where('orders.created_on >=', $date2);
     $this->db->where('orders.created_on <=', $date1);
    $q = $this->db->get()->num_rows();
    //echo $this->db->last_query();die;
    return $q;


    }
     function monthorder($uid){

         $this->db->select('order_items.*,products.*,orders.*');
    $this->db->from('order_items');
     $this->db->join('orders', 'orders.id = order_items.order_id'); 
    $this->db->join('products', 'products.id = order_items.product_id'); 
    
    $this->db->where(array('products.user_id'=>$uid));
     $this->db->where(array('orders.pay_status'=>"Received"));
     $datef = date('Y-m-d');
    $datel = date('Y-m-d',strtotime ('-1 month' , strtotime ($datef) )) ;
    $this->db->where('orders.created_on >=', $datel);
     $this->db->where('orders.created_on <=', $datef);
    $q = $this->db->get()->num_rows();
    //echo $this->db->last_query();die;
    return $q;


    }
     function recentOrder($uid){

         $this->db->select('order_items.*,products.*,orders.*');
    $this->db->from('order_items');
     $this->db->join('orders', 'orders.id = order_items.order_id'); 
    $this->db->join('products', 'products.id = order_items.product_id'); 
     $this->db->where(array('orders.pay_status'=>"Received"));
    $this->db->where(array('products.user_id'=>$uid));
    $this->db->limit(5);
         $this->db->order_by('orders.created_on', 'DESC');

    $q = $this->db->get()->result();
    //echo $this->db->last_query();die;
    return $q;


    }

}