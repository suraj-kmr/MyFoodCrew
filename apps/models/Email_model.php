<?php
class Email_model extends CI_Model{
	var $error, $status;
	public function __construct(){
		parent::__construct();
		$this -> status = array(
			1 => 'Active',
			0 => 'Pending'
		);
	}
	public function save($email){
		$this -> db -> where('id', $email['id']);
		$this -> db -> update('email', $email);
	}
	function slug($string){
		$slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
		return strtolower($slug);
	}
	public function get_email($id = false){
		return $this -> db -> get_where('emails', "id = '$id'") -> first_row('array');
	}
	public function getAll($limit_from = 1, $nor = ''){
		$data = array();
		if($nor != ''){
			$this -> db -> limit($nor, $limit_from);
		}
		$this -> db -> order_by('id', 'DESC');
		$rest = $this -> db -> get('emails');
		if($rest -> num_rows() > 0){
			foreach($rest -> result_array() as $row){
				$data[] = $row;
			}
		}
		$rest -> free_result();
		return $data;
	}
	public function delete($id){
		$this -> db -> where('id', $id);
		$this -> db -> delete('emails');
	}
}
?>
