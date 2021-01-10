<?php
class Miscellaneous_model extends Master_model{
	public function __construct(){
		parent::__construct();
		$this -> table = 'miscellaneous';
	}

    function isExists($p_id){
        $c = $this -> db -> get_where($this -> table, array('id' => $p_id)) -> num_rows();
        if($c == 0){
            return FALSE;
        }else{
            return TRUE;
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
		return $p;
	}

	function getNew($table = false){
		$p = parent::getNew();
		$p -> cats = array();
		$p -> sizes = array();
		return $p;
	}

    function get_name($type=false){
        return $this -> db -> get_where($this->table, array('type' => $type)) -> result();
    }

}
