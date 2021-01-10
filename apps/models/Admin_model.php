<?php
class Admin_model extends CI_Model {
	var $user_role, $error;

	function __construct () {
		parent::__construct ();
	}

	public function authenticate ($u, $pw) {
		$this->db->select ('id, username, password, role');
		$this->db->where ('email_id', $u);
		$this->db->where ('password', $pw);
		$this->db->where ('status', 1);
		$this->db->limit (1);
		$Q = $this->db->get ('admin');
		if ($Q->num_rows () > 0) {
            $p = $Q -> row();
			return $p;
		} else {
			return FALSE;
		}
	}
}
