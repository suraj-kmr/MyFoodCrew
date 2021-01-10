<?php
class Wallet_model extends Master_model{
	function __construct(){
		parent::__construct();
		$this -> table = 'ai_wallets';
	}

    function getAllBalance($user_id){
        return $this -> db -> get_where($this->table, array('user_id'=>$user_id))->result();
    }

    function getBalance($user_id){
        return $this -> db -> get_where('users', array('id'=>$user_id))->row();
    }

    function history($user_id){
        return $this -> db -> get_where($this->table, array('user_id'=>$user_id))->result();
    }

    function getPointInfo(){
        return $this -> db -> get('point_info')->result();
    }

    function getPointTitle(){
        return $this -> db -> get('point_info') -> row();
    }

}