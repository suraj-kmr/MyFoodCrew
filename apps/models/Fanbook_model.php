<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fanbook_model extends Master_model {
	function __construct(){
		parent::__construct();
		$this -> table = "fanbook";
	}

	function addFanbook(){
		$arr_fields = $this -> db -> list_fields('fanbook');
		$data = new stdClass();
		foreach($arr_fields as $a){
			$data -> $a = '';
		}
		$data -> id = false;
		$data -> status = 1;
		return $data;
	}

	function saveFanbook($data){
		if($data['id']){
			$this -> db -> update('fanbook', $data, array('id' => $data['id']));
			return $data['id'];
		}else{
			$this -> db -> insert('fanbook', $data);
			return $this -> db -> insert_id();
		}
	}

	function getFanbook($id){
		return $this -> db -> get_where('fanbook', array('id' => $id)) -> first_row();
	}

	function delFanbook($fanbook_id){
		$this -> db -> delete('fanbook', array('id' => $fanbook_id));
		$this -> db -> delete('fanbook', array('id' => $fanbook_id));
	}

	function allFanbook(){
		$this -> db -> select('id, title');
		$this -> db -> order_by('title', 'ASC');
		return $this -> db -> get('fanbook') -> result();
	}


	function get_fanbook_id($name){
		$row = $this -> db -> get_where('fanbook', array('brand' => $name));
		if($row -> num_rows() == 0){
			$this -> db -> insert('fanbook', array('brand' => $name));
			return $this -> db -> insert_id();
		}else{
			$r = $row -> first_row();
			return $r -> id;
		}
	}

	function get_frontendlist($limit = 16){
		$this->db->select("title,short_info,image");
		$this->db->where(array('status'=>1));
		$this->db->from('fanbook');
		$query = $this->db->get();
		return $query->result();
	}

}
