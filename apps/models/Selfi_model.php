<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Selfi_model extends Master_model {
	function __construct(){
		parent::__construct();
		$this -> table = "fanbook";
	}

	function addSelfi(){
		$arr_fields = $this -> db -> list_fields('fanbook');
		$data = new stdClass();
		foreach($arr_fields as $a){
			$data -> $a = '';
		}
		$data -> id = false;
		$data -> status = 1;
		return $data;
	}

	function saveSelfi($data){
		if($data['id']){
			$this -> db -> update('fanbook', $data, array('id' => $data['id']));
			return $data['id'];
		}else{
			$this -> db -> insert('fanbook', $data);
			return $this -> db -> insert_id();
		}
	}

	function getSelfi($id){
		return $this -> db -> get_where('fanbook', array('id' => $id)) -> first_row();
	}

	function allSelfi(){
		$this -> db -> select('id, title');
		$this -> db -> order_by('title', 'ASC');
		return $this -> db -> get('fanbook') -> result();
	}

	function get_frontendlist($limit = 16){
		$this->db->select("title,short_info,image");
		$this->db->where(array('status'=>1));
		$this->db->from('fanbook');
		$query = $this->db->get();
		return $query->result();
	}
	function get_front_user_selfi($userid){
		$this->db->select("title,short_info,image,status");
		$this->db->where(array('user_id'=>$userid, 'status'=>1));
		$this->db->from('fanbook');
		$query = $this->db->get();
		return $query->result();
	}

}
