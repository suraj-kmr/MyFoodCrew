<?php
class Stock_model extends Master_model{
	public function __construct(){
		parent::__construct();
		$this -> table = 'stock';
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

    function saveStock($data){
        if($data['id']){
            $this -> db -> update('stock', $data, array('id' => $data['id']));
            return $data['id'];
        }else{
            $this -> db -> insert('stock', $data);
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

    function get_product($brand_id=false){
        return $this -> db -> get_where('products', array('brand_id' => $brand_id)) -> result();
    }

    function ExportCSV()
    {
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');				ini_set('memory_limit','1024M');				set_time_limit ( 30000 );
        $delimiter = ",";
        $newline = "\r\n";
        $filename = "stock.csv";
        $query = "SELECT * FROM stock";
        $result = $this->db->query($query);
        $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
        force_download($filename, $data);
    }

}
