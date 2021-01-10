<?php
class Post_model extends Master_model{
    var $error, $status;
    public function __construct(){
        parent::__construct();
        $this -> table = 'post';
    }

    public function post($id){
        $p = $this -> db -> get_where('posts', array('id' => $id)) -> first_row('array');
        $p['category'] = $this -> Category_model -> category($p['parent_id']);
        return $p;
    }
    public function page($id){
        $p = $this -> db -> get_where('posts', array('id' => $id)) -> first_row();
        //$p['Layout'] = $this -> Setting_model -> get_layout($p['layout']);
        return $p;
    }

    function slugPost($slug){
        $this -> db -> select('id');
        return $this -> db -> get_where($this -> table, array('slug' => $slug)) -> first_row();
    }

    function getAllPosts($offset = 0, $show_per_page = 10){
        $this -> db -> select('id');
        if($show_per_page){
            $this -> db -> limit($show_per_page, $offset);
        }
        $this -> db -> where('post_type', 'post');
        $this -> db -> order_by('id', 'DESC');
        $rest = $this -> db -> get($this -> table);
        $data['results'] = $rest -> result();
        $data['total'] = $this -> db -> get_where($this -> table, array('post_type' => 'post')) -> num_rows();
        return $data;
    }
    function getAllPages($offset = 0, $show_per_page = 10){
        $this -> db -> select('id');
        if($show_per_page){
            $this -> db -> limit($show_per_page, $offset);
        }
        $this -> db -> where('post_type', 'page');
        $this -> db -> order_by('post_title', 'ASC');
        $data['results'] = $this -> db -> get($this -> table) -> result();
        $data['total'] = $this -> db -> get_where($this -> table, array('post_type' => 'page')) -> num_rows();
        return $data;
    }
    
    function getPublishedPosts($offset = 0, $show_per_page = 1){
        $this -> db -> select('id');
        if($show_per_page){
            $this -> db -> limit($show_per_page, $offset);
        }
        $this -> db -> where('post_type', 'post');
        $this -> db -> where('status', 1);
        $this -> db -> order_by('id', 'DESC');
        $rest = $this -> db -> get($this -> table);
        $data['results'] = $rest -> result();
        $data['total'] = $this -> db -> get_where($this -> table, array('post_type' => 'post', 'status'=>1)) -> num_rows();
        return $data;
    }
    
    function getRecentPosts(){
        //$this -> db -> where('post_type', 'post');
        $this -> db -> order_by('id', 'DESC');
        $this->db->limit(5);
        $rest = $this -> db -> get_where($this -> table, array('post_type'=>'post', 'status'=>1))->result();
        return $rest;
    }

    public function get_page_dd(){
        $data = array(0 => 'Main Page');
        $this -> db -> where('post_type', 'page');
        $this -> db -> order_by('post_title', 'ASC');
        $rest = $this -> db -> get($this->table);
        if($rest -> num_rows() > 0){
            foreach($rest -> result_array() as $row){
                $data[$row['id']] = $row['post_title'];
            }
        }
        $rest -> free_result();
        return $data;
    }
    public function get_post_dd(){
        $data = array(0 => 'Main Page');
        $this -> db -> where('post_type', 'post');
        $this -> db -> order_by('post_title', 'ASC');
        $rest = $this -> db -> get($this->table);
        if($rest -> num_rows() > 0){
            foreach($rest -> result_array() as $row){
                $data[$row['id']] = $row['post_title'];
            }
        }
        $rest -> free_result();
        return $data;
    }

    function pagesDropdown(){
        $data = array(
            0 => 'Main Page'
        );
        $this -> db -> select('id,post_title');
        $this -> db -> order_by('post_title', "ASC");
        $this -> db -> where('parent_id', 0);
        $this -> db -> where('post_type', 'page');
        $rest = $this -> db -> get_where($this -> table);
        if($rest -> num_rows() > 0){
            foreach($rest -> result() as $r){
                $tname = ucwords(strtolower($r -> post_title));
                $data[$r -> id] = $tname;
                $data = $this -> sub_child($r -> id, $tname, $data);
            }
        }
        return $data;
    }

    function sub_child($parent_id, $name, $old_arr = array()){
        $this -> db -> select('id, post_title');
        $this -> db -> where('parent_id', $parent_id);
        $this -> db -> where('post_type', 'page');
        $this -> db -> order_by('post_title', 'ASC');
        $rest = $this -> db -> get($this -> table);
        if($rest -> num_rows() > 0){
            foreach($rest -> result() as $r){
                $fname = $name . ' &#x021D2; ' . ucwords(strtolower($r -> post_title));
                $old_arr[$r -> id] = $fname;
                $old_arr = $this -> sub_child($r -> id, $fname, $old_arr);
            }
        }
        return $old_arr;
    }
}
