<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mobile_model extends Master_model {
    function __construct(){
        parent::__construct();
        $this -> table = "cloths_brand";
    }

    function addMobile(){
        $arr_fields = $this -> db -> list_fields('mobile_set');
        $data = new stdClass();
        foreach($arr_fields as $a){
            $data -> $a = '';
        }
        $data -> id = false;
        $data -> status = 1;
        return $data;
    }

    function max_sequence(){
        $this->db->select_max('sequence');
        return $this->db->get('mobile_set')->row();
        //print_r($query);
    }

    function saveMobile($data){
        if($data['id']){
            $this -> db -> update('mobile_set', $data, array('id' => $data['id']));
            return $data['id'];
        }else{
            $this -> db -> insert('mobile_set', $data);
            return $this -> db -> insert_id();
        }
    }

    function getMobile($id){
        return $this -> db -> get_where('mobile_set', array('id' => $id)) -> first_row();
        if($s != NULL)
            return $s -> title;
        return '';
    }

    function brand($id){
        $r =  $this -> db -> get_where('mobile_brand', array('id' => $id)) -> first_row();
        if($r != NULL)
            return $r -> brand;
        return '';
    }


    function delBrands($brand_id){
        $this -> db -> delete('mobile_brand', array('id' => $brand_id));
        $this -> db -> delete('mobile_set', array('brand_id' => $brand_id));
    }

    function allBrands(){
        //$this -> db -> select('id, brand');
        $this -> db -> order_by('brand', 'ASC');
        return $this -> db -> get('mobile_brand') -> result();
        //$result = $this -> db -> get('mobile_brand');
    }

    function allMobile($brand_id=""){
        $this -> db -> order_by('sequence', 'DESC');
        if($brand_id != NULL){
            $this->db->where('brand_id', $brand_id);
        }
        //$this -> db -> order_by('sequence', 'DESC');
        return $this -> db -> get('mobile_set') -> result();
    }

    function get_brand_id($name){
        $row = $this -> db -> get_where('mobile_brand', array('brand' => $name));
        if($row -> num_rows() == 0){
            $this -> db -> insert('mobile_brand', array('brand' => $name));
            $this -> db -> insert('categories', array('name' => $name, 'product_type' => "5"));
            return $this -> db -> insert_id();
        }else{
            $r = $row -> first_row();
            return $r -> id;
        }
    }

    function get_brands_id($name){
        $row = $this -> db -> get_where('mobile_brand', array('brand' => $name));
        if($row -> num_rows() == 0){
            redirect(site_url());
        }else{
            $r = $row -> first_row();
            return $r -> id;
        }
    }

    function get_models($brand_id = null){
        $this->db->select('id, title');
        if($brand_id != NULL){
            $this->db->where('brand_id', $brand_id);
        }
        $query = $this->db->get('mobile_set');
        $models = array();
        if($query->result()){
            foreach ($query->result() as $model) {
                $models[$model->id] = $model->title;
            }
            return $models;
        }else{
            return FALSE;
        }
    }

    function check_duplicate($brand_id, $title){
        $this -> db -> where(array('brand_id' => $brand_id, 'title' => $title));
        $c = $this -> db -> get('mobile_set') -> num_rows();
        if($c > 0){
            return true;
        }else{
            return false;
        }
    }

    function check_dupcat($id, $name){
        $this -> db -> where(array('id' => $id, 'name' => $name));
        $c = $this -> db -> get('categories') -> num_rows();
        if($c > 0){
            return true;
        }else{
            return false;
        }
    }

    function getCover($id){
        return $this -> db -> get_where('mobile_covers', array('id' => $id)) -> first_row();
    }

    function newCover(){
        $arr_fields = $this -> db -> list_fields('mobile_covers');
        $data = new stdClass();
        foreach($arr_fields as $a){
            $data -> $a = '';
        }
        $data -> id = false;
        $data -> status = 1;
        $data -> cover_type = '2D';
        return $data;
    }

    function saveCover($s){
        if($s['id']){
            $this -> db -> update('mobile_covers', $s, array('id' => $s['id']));
            return $s['id'];
        }else{
            $this -> db -> insert('mobile_covers', $s);
            return $this -> db -> insert_id();
        }
    }

    function get_brand_id_by_name($brand_name=false){
        $sql = "SELECT id FROM mobile_brand WHERE LCASE(brand) = '".strtolower($brand_name)."'";
        $r = $this -> db -> query($sql) -> row();
        if(is_object($r)){
            return $r -> id;
        }
        else{
            return 0;
        }
    }

    function get_model_id_by_brand_id($brand_id, $models){
        $this -> db -> where(array('brand_id' => $brand_id, 'LOWER(title)' => strtolower($models)));
        $r = $this -> db -> get('mobile_set') -> row();
        if(is_object($r)){
            return $r;
        }
        else{
            return 0;
        }
    }

    function product_by_brands_models($brand_id, $model_id){
        $this -> db -> limit(12);
        return $this->db->get_where('products', array('brand_id'=>$brand_id, 'models'=>$model_id))->result();
    }

    function relatedProducts($brand_id, $model_id, $theme){
        $this -> db -> limit(12);
        $this -> db -> order_by('id','RANDOM');
        return $this->db->get_where('products', array('brand_id'=>$brand_id, 'models'=>$model_id, 'theme'=>$theme,'status'=>1))->result();
    }

    /* ---------------On scrolling pagination ------------ */
    public function get_all_count($brand, $models)
    {
        if($brand && $models !=''){
            $sql = "SELECT COUNT(*) as tol_records FROM products WHERE product_type=5 AND brand_id='$brand' AND models = '$models'";
        }
        elseif($brand!=''){
            $sql = "SELECT COUNT(*) as tol_records FROM products WHERE product_type=5 AND brand_id='$brand'";
        }
        else{
            $sql = "SELECT COUNT(*) as tol_records FROM products WHERE product_type=5";
        }

        $result = $this->db->query($sql)->row();
        return $result;
    }

    public function get_all_content($start,$content_per_page, $brand, $models)
    {
        if($brand && $models !=''){
            $sql = "SELECT COUNT(*) as tol_records FROM products WHERE product_type=5 AND brand_id='$brand' AND models = '$models' LIMIT $start,$content_per_page";
        }
        elseif($brand!=''){
            $sql = "SELECT COUNT(*) as tol_records FROM products WHERE product_type=5 AND brand_id='$brand' LIMIT $start,$content_per_page";
        }
        else{
            $sql = "SELECT COUNT(*) as tol_records FROM products WHERE product_type=5 LIMIT $start,$content_per_page";
        }
        //$sql = "SELECT * FROM  products WHERE product_type=5 AND brand_id='$brand' AND models = '$models' LIMIT $start,$content_per_page";
        $result = $this->db->query($sql)->result();
        return $result;
    }
    /* -------------------End On Scrolling Pagination ---------*/

    function countMobile($brand, $models, $material){
        $query =  $this -> db -> get_where('products', array('brand_id'=>$brand, 'models'=>$models, 'material'=>$material));
        $data = array();
        $data['total'] = $query->num_rows();
        if($data['total']==1){
            $data['id'] = $query->row()->id;
        }
        return $data;
    }
	
	function getModelByID($id){
        return $this -> Master_model -> getRow($id,'mobile_set')->title;

    }
}
