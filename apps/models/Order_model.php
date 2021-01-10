<?php
class Order_model extends Master_model{

	function __construct(){
		parent::__construct();
		$this -> table = 'orders';
	}

	function saveOrders($ord){
		$this -> db -> insert($this -> table, $ord);
		return $this -> db -> insert_id();
	}


	function addFiles($files){
        //print_r($files);die;
		$this -> db -> insert('order_items', $files);
	}

	function orderDetails($order_id){
		$row = $this -> db -> get_where('orders', array('id' => $order_id)) -> first_row();
       //print_r($row);die;
		$row -> files = $this -> orderFiles($order_id);
		$row -> user = $this -> User_model -> getUserById($row -> user_id);
		$row -> address = $this -> User_model -> getAddress($row -> shipping_id);
		return $row;
	}

	function orderFiles($order_id){
		return $this -> db -> get_where('order_items', array('order_id' => $order_id)) -> result();
	}

    function orderDetailsAfterCancel($order_id){
        $row = $this -> db -> get_where('orders', array('id' => $order_id)) -> first_row();
        $row -> files = $this -> orderAfterCancel($order_id);
        $row -> user = $this -> User_model -> getUserById($row -> user_id);
        $row -> address = $this -> User_model -> getAddress($row -> shipping_id);
        return $row;
    }

    function orderAfterCancel($order_id){
        $this -> db -> where('order_id', $order_id);
        $this -> db -> where('product_status=', NULL);
        return $this -> db -> get('order_items') -> result();
        //$this -> db -> last_query(); exit;
        //return $this -> db -> get_where('order_items', array('order_id' => $order_id, 'product_status!'=>'Canceled')) -> result();
    }

	function myorders($user_id){
		$this -> db -> order_by('id', 'DESC');
		$rest = $this -> db -> get_where($this -> table, array('user_id' => $user_id)) -> result();
		return $rest;
	}
	
	function cancelCount($oid){
        $rest = $this -> db -> get_where('order_items', array('order_id'=> $oid, 'product_status'=>NULL)) -> num_rows();
        return $rest;
    	}
    function cancel($offset = 0, $limit = 40){
        $this -> db -> where('status', '0');
        $this -> db -> order_by('id', 'DESC');
        $this -> db -> limit($limit, $offset);
        $rest = $this -> db -> get('ai_cancel');
        $data = array();
        $data['results'] = $rest -> result();

        $this -> db -> where('status', '0');
        $data['total'] = $this -> db -> get('ai_cancel') -> num_rows();

        return $data;
    }
    function cancel_order($id){
        $this -> db -> order_by('id', 'DESC');
        return $this -> db -> get_where('ai_cancel', array('id' => $id)) -> result();
    }

    function returnCount($oid){
        $rest = $this -> db -> get_where('order_items', array('order_id'=> $oid, 'product_status'=>NULL)) -> num_rows();
        return $rest;
        }

	function orderForTracking($offset = 0, $limit = 40){
		$this -> db -> where('order_status', 'Processing');
		$this -> db -> or_where('order_status', 'In Transit');
		$this -> db -> where('tracking_code <> ""');
		$this -> db -> order_by('id', 'DESC');
		$this -> db -> limit($limit, $offset);
		$rest = $this -> db -> get('orders');
		$data = array();
		$data['results'] = $rest -> result();

		$this -> db -> where('order_status', 'Processing');
		$this -> db -> or_where('order_status', 'In Transit');
		$this -> db -> where('tracking_code <> ""');
		$data['total'] = $this -> db -> get('orders') -> num_rows();

		return $data;
	}
    function return1($offset = 0, $limit = 40){
        $this -> db -> where('status', '0');
        $this -> db -> order_by('id', 'DESC');
        $this -> db -> limit($limit, $offset);
        $rest = $this -> db -> get('ai_return');
        $data = array();
        $data['results'] = $rest -> result();

        $this -> db -> where('status', 'Processing');
        $data['total'] = $this -> db -> get('ai_return') -> num_rows();

        return $data;
    }
    function saveCancelling($id,$save){
        $this->db->where('id',$id);
        $this -> db -> update('ai_cancel', $save);
    }
	function saveTracking($save){
		$this -> db -> insert('order_tracking', $save);
	}
    function saveReturning($id,$save){
        $this->db->where('id',$id);
        $this -> db -> update('ai_return', $save);
    }

	function orderTrack($trackingid){
		$this -> db -> order_by('id', 'DESC');
		return $this -> db -> get_where('orders', array('tracking_code' => $trackingid)) -> result();
	}
    function Return_prod($id){
        $this -> db -> order_by('id', 'DESC');
        return $this -> db -> get_where('ai_return', array('id' => $id)) -> result();
    }

    function orderTrackDetail($trackingid){
        $this -> db -> order_by('id', 'DESC');
        return $this -> db -> get_where('order_tracking', array('tracking_code' => $trackingid)) -> result();
    }

	function lastUpdateTracking($trackingid){
		return $this -> db -> get_where('order_tracking', array('tracking_code' => $trackingid)) -> last_row();
	}

	function delOrder($id){
		$this -> db -> delete($this -> table, array('id' => $id));
		$this -> db -> delete('order_items', array('order_id' => $id));
	}
	
	function recent_orders(){
        $this -> db -> order_by('id', 'DESC');
        $this -> db -> limit(5);
        $r = $this -> db -> get($this->table)->result();
        return $r;
    }

    function low_inv(){
        $this -> db -> order_by('id', 'DESC');
        $this -> db -> where('qty < 10');
        //$this -> db -> limit(10);
        $r = $this -> db -> get('products')->result();
        return $r;
    }

    function high_selling(){
        $this -> db -> order_by('id', 'DESC');
        $this -> db -> where('qty < 10');
        //$this -> db -> limit(10);
        return $this->db->query('SELECT product_id, SUM(`quantity`) AS TotalQuantity FROM order_items GROUP BY product_id ORDER BY SUM(`quantity`) DESC LIMIT 5 ')->result();
        //print_r($maxid);
        //$r = $this -> db -> get('products')->result();
        //return $r;
    }

    function getAllSearchedByEmail($offset = 0, $limit = 40, $q){
        if(is_numeric($q)){
            $this -> db -> or_like('orders.id', $q);
        }
        $this -> db -> select('*');
        $sql = $this -> db -> get_compiled_select($this -> table, false);
        //$this -> db -> from($this->table);
        $this -> db -> limit($limit, $offset);
        $this -> db -> join('users', 'users.id=orders.user_id');
        $this -> db -> or_like('users.email_id', $q);
        $this -> db -> or_like('users.phone_no', $q);

        $this -> db -> order_by('orders.id', 'DESC');
        $rest = $this -> db -> get();
        //echo $this -> db -> last_query();
        $data['results'] = $rest -> result();
        $data['total'] = $this -> db -> query($sql) -> num_rows();
        return $data;
    }
     function history($offset = 0, $limit = 40){
        //$this -> db -> where('status', '0');
        $this -> db -> order_by('id', 'DESC');
        $this -> db -> limit($limit, $offset);
        $rest = $this -> db -> get('orders');
        $data = array();
        $data['results'] = $rest -> result();

        $this -> db -> where('status', '0');
        $data['total'] = $this -> db -> get('orders') -> num_rows();

        return $data;
    }

    function getTotalprice($uid){
        return $this -> db->get_where('orders',array('user_id'=>$uid,'pay_status'=>'Received'))->result();
    }
    
    function totalOrder(){
        $td = $this->db->get($this->table)->num_rows();
        return $td;
    }


    function monthOrder(){
        $date = strtotime("-30 day");
        $td = $this->db->get_where($this->table,array('created_on >='=>date("Y-m-d", $date),'created_on <='=>date("Y-m-d")))->num_rows();
        //echo $this->db->last_query();
        return $td;
    }
    
}
