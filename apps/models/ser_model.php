<?php
class User_model extends Master_model{

	function __construct(){
		parent::__construct();
		$this -> table = 'users';
	}



	function createAccount($u){
		$this -> db -> insert($this -> table, $u);
		return $this -> db -> insert_id();
	}

	function validateEmail($email, $act_code){
		$r = $this -> db -> get_where($this -> table, array('email_id' => $email, 'act_code' => $act_code, 'status' => 0));
		if($r -> num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	function loginCheck($username, $pass){
		$this -> db -> where("(users.username='$username' OR users.phone_no = '$username')");
		$this -> db -> where("pass", $pass);
		$this -> db -> where(array('status' => 1));
		$r = $this -> db -> get($this->table);
		if($r -> num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	function getUser($username){
		$rest = $this -> db -> get_where($this -> table, array('username' => $username));
		if($rest -> num_rows() > 0){
			return $rest -> row();
		}else{
			return FALSE;
		}
	}

	
	function getUserById($id){
		$r = $this -> db -> get_where($this -> table, array('id' => $id)) -> first_row();
		return $r;
	}

	function chkref($username) {
		$rest = $this -> db -> get_where("users", array('username' => $username));
		if ($rest -> num_rows() > 0) {
			$user = $rest -> row();
			return $user -> id;
		} else {
			return 0;
		}
	}

	function get_name_mobile($username) {
		$rest = $this -> db -> get_where("users", array('username' => $username));
		if ($rest -> num_rows() > 0) {
			$user = $rest -> row();
			if(is_object($user))
			{
				return 'Refferal user:-'.' '.$user->first_name.' , '.'Refferal phone no.:-'.' '.$user->phone_no;
			}
			else
			{
				return 0;
			}
		} else {
			return 0;
		}
		// if($rest -> num_rows() == 0){
		//     echo "No";
		// }else{
		//     echo "Yes";
		// }
	}
	function saveAddress($ua){
	   
		if(isset($ua['id']) and $ua['id']!=''){
			$this -> db -> update('users_address', $ua, array('id' => $ua['id']));
		}
		else {
		    $ua['id']=false;
			$this->db->insert('users_address', $ua);
			return $this->db->insert_id();
		}
	}

	function makeDefaultAddress($adid, $user_id){
		$s = array();
		$s['default_address'] = $adid;
		$this -> db -> update($this -> table, $s, array('id' => $user_id));
	}

	function getDefaultAddress($user_id){
		//$d = $this -> getUserById($user_id);
		//if($d -> default_address <> ''){
			$ad = $this -> db -> get_where('users_address', array('user_id' => $user_id)) -> first_row();
			return $ad;
		//}
		//return false;
	}

	function getAddress($adid){
		$ad = $this -> db -> get_where('users_address', array('id' => $adid)) -> first_row();
		return $ad;
	}

	function getUserAddresses($user_id){
		return $this -> db -> get_where('users_address', array('user_id' => $user_id)) -> result();
	}

	function myWishlistItems($user_id){
		$this -> db -> order_by('id', "DESC");
		$data = $this -> db -> get_where('ai_wishlist', array('user_id' => $user_id)) -> result();
		return $data;
	}

	function addWishlistItem($data){
		$c = $this -> db -> get_where('ai_wishlist', array('product_id' => $data['product_id'], 'user_id' => $data['user_id'])) -> num_rows();
		if($c == 0){
			$this -> db -> insert('ai_wishlist', $data);
			return TRUE;
		}else{
			return FALSE;
		}
	}

	function itemWishlist($id){
		return $this -> db -> get_where('ai_wishlist', array('id' => $id)) -> row();
	}

	function checkWishlist($pid, $user_id){
		return $this -> db -> get_where('ai_wishlist', array('pid' => $pid, 'user_id'=>$user_id))->num_rows();
	}

	function getAdminUser($id){
		return $this -> db -> get_where("admin", array('id' => $id)) -> row();
	}
	function state_dropdown() {
		$this -> db -> select("id, state_name");
		$this -> db -> from("states");
		$this -> db -> order_by("state_name", "ASC");
		$rest = $this -> db -> get() -> result();
		$data = array();
		foreach ($rest as $ob) {
			$data[$ob -> id] = $ob -> state_name;
		}
		return $data;
	}
	function get_count($id) {
		$cou = $this->db->get_where('users',array('parent_id'=>$id))->num_rows();
		return $cou;
	}
	function checkActive($uid){
        $activated = $this->db->get_where('users',array('id'=>$uid,'activation'=>1))->row();
        if($activated){
            return false;
        }
        else{
            return true;
        }
    }
    function updateActivation($id){
    	$data = array(
				'activation'=> 1,
				'ranking'=>1
			);
		$this->db->where('id',$id);
		$this->db->update('users',$data);
    }
}
