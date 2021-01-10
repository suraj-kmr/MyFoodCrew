<?php

class Search_model extends Master_model
{

    function __construct()
    {
        parent::__construct();
    }

    function category($id)
    {
        $sql = "SELECT id AS pid FROM products WHERE status = 1 AND id IN(SELECT pid FROM products_categories WHERE cid = $id) ORDER BY sequence DESC";
        //return $this -> db -> get_where('products_categories', array('cid' => $id)) -> result();
        return $this->db->query($sql)->result();
    }

    function color_rule($color)
    {
        $rules = $_GET;
        $rules['color'] = $color;
        return $this->prep_url($rules);
    }

    function sorting_rule($chr)
    {
        $rules = $_GET;
        $rules['sort_by'] = $chr;
        return $this->prep_url($rules);
    }

    function model_rule($model_id)
    {
        $rules = $_GET;
        $rules['model'] = $model_id;
        return $this->prep_url($rules);
    }

    function brand_rule($brand_id)
    {
        $rules = $_GET;
        $rules['brand'] = $brand_id;
        return $this->prep_url($rules);
    }

    function material_rule($material)
    {
        $rules = $_GET;
        $rules['material'] = $material;
        return $this->prep_url($rules);
    }

    function theme_rule($theme)
    {
        $rules = $_GET;
        $rules['theme'] = $theme;
        return $this->prep_url($rules);
    }

    function event_rule($event)
    {
        $rules = $_GET;
        $as = $this -> db -> get_where('ai_event', array('event_name'=>$event))->row();
        $rules['event'] = $as->id;
        return $this->prep_url($rules);
    }

    function discount_rule($base = 0, $dmax = false)
    {
        $rules = $_GET;
        $rules['discount'] = $base . '-' . $dmax;
        if ($base == 0) {
            $rules['discount'] = 'upto' . $dmax . '%';
        }
        if ($dmax == false) {
            $rules['discount'] = 'above' . $base . '%';
        }

        return $this->prep_url($rules);
    }

    function dis_rule($base = 0, $dmax = false)
    {
        $rules = $_GET;
        $rules['base'] = $base;
        $rules['dmax'] = $dmax;
        $url = $this->prep_url($rules);
        return $url;
    }

    function budget_rule($min = 0, $max = false)
    {
        $rules = $_GET;
        $rules['min'] = $min;
        $rules['max'] = $max;
        $url = $this->prep_url($rules);
        return $url;
    }

    function size_rule($str)
    {
        $rules = $_GET;
        $rules['size'] = $str;
        return $this->prep_url($rules);
    }

    function remove_rule($str)
    {
        $rules = $_GET;
        unset($rules[$str]);
        return $this->prep_url($rules);
    }

    function prep_url($get = array())
    {
        $__url = current_url();
        $str = '';
        if (count($get) > 0) {
            foreach ($get as $ind => $val) {
                $str .= $ind . '=' . $val . '&';
            }
        }
        if ($str <> '') {
            $str = '?' . rtrim($str, '&');
        }
        return $__url . $str;
    }

    function search_mobile($limit = 800, $offset = false, $brand, $model=false,$q=false)
    {
        $this -> db -> select('id');
        $this->db->where('status', 1);
        $this->db->order_by('sequence', 'DESC');
        $this->db->order_by('id', 'random');
        $this->db->where("is_printed", 0);
        if ($this->input->get('sort_by')) {
            $this->db->order_by('sale_price', $_GET['sort_by']);
        }
        if($q){
            $this->db->like("ptitle", $q);
        }
        if ($brand) {
            $this->db->where("brand_id", $brand);
        }
        if ($model) {
            $this->db->where("models", $model);
        }
        if($this->input->get("event")){
            $this->db->where("event", $_GET['event']);
        }
        if ($this->input->get('material')) {
            $this->db->where('material', $_GET['material']);
        }
        if ($this->input->get('theme')) {
            $this->db->where('theme', $_GET['theme']);
        }
        if (isset($_GET['discount'])) {
            $base = intval($_GET['base']);
            $dmax = intval($_GET['dmax']);
            if ($base == 0) {
                $this->db->where("discount <= ", $dmax);
            } elseif ($dmax == 0) {
                $this->db->where("discount >=", $base);
            } else {
                $this->db->where("discount BETWEEN $base AND $dmax");
            }
        }
        if (isset($_GET['min']) && isset($_GET['max'])) {
            $min = intval($_GET['min']);
            $max = intval($_GET['max']);
            if ($min == 0) {
                $this->db->where("sale_price <= ", $max);
            } elseif ($max == 0) {
                $this->db->where("sale_price >=", $min);
            } else {
                $this->db->where("sale_price BETWEEN $min AND $max");
            }
        }
        $sql = $this->db->get_compiled_select('products', False);
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $rest = $this->db->get()->result();
        //echo $this -> db -> last_query();
        $data['results'] = $rest;
        $data['total'] = $this->db->query($sql)->num_rows();
        return $data;
    }

    function search_clothe($id, $limit = 100, $offset = false)
    {
        $this->db->select("products.id AS 'pid'");
        $this->db->join("products_categories", 'products_categories.pid=products.id');
        $this->db->where('products_categories.cid', $id);
		$this->db->where('products.status', 1);
        $this->db->where('products.product_type',CLOTHINGS);
        $this->db->order_by('sequence', 'DESC');
        //echo $this -> db -> last_query();
        if ($this->input->get('sort_by')) {
            $this->db->order_by('sale_price', $_GET['sort_by']);
        }
        if ($this->input->get('material')) {
            $this->db->where('material', $_GET['material']);
        }
        if (isset($_GET['discount'])) {
            $base = intval($_GET['base']);
            $dmax = intval($_GET['dmax']);
            if ($base == 0) {
                $this->db->where("discount <= ", $dmax);
            } elseif ($dmax == 0) {
                $this->db->where("discount >=", $base);
            } else {
                $this->db->where("discount BETWEEN $base AND $dmax");
            }
        }
        if (isset($_GET['min']) && isset($_GET['max'])) {
            $min = intval($_GET['min']);
            $max = intval($_GET['max']);
            if ($min == 0) {
                $this->db->where("sale_price <= ", $max);
            } elseif ($max == 0) {
                $this->db->where("sale_price >=", $min);
            } else {
                $this->db->where("sale_price BETWEEN $min AND $max");
            }
        }
        $sql = $this->db->get_compiled_select('products', False);
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $rest = $this->db->get()->result();
        //echo $this -> db -> last_query();
        $data['results'] = $rest;
        $data['total'] = $this->db->query($sql)->num_rows();
        return $data;
    }

}
