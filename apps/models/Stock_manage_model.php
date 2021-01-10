<?php
class Stock_manage_model extends Master_model{
	public function __construct(){
		parent::__construct();
		$this -> table = 'stock_manage';
	}

    function isExists($p_id){
        $c = $this -> db -> get_where($this -> table, array('id' => $p_id)) -> num_rows();
        if($c == 0){
            return FALSE;
        }else{
            return TRUE;
        }
    }

	function getNew($table = false){
		$p = parent::getNew();
		$p -> cats = array();
		$p -> sizes = array();
		return $p;
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


    function saveStock($data){
        if($data['id']){
            $this -> db -> update('stock_manage', $data, array('id' => $data['id']));
            return $data['id'];
        }else{
            $this -> db -> insert('stock_manage', $data);
            return $this -> db -> insert_id();
        }
    }

    function ExportCSV()
    {
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";
        $filename = "stock_manage.csv";
        $query = "SELECT * FROM stock_manage";
        $result = $this->db->query($query);
        $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
        force_download($filename, $data);
    }

}
