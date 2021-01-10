<?php
Class Page_model extends Master_model{

	function __construct(){
		parent::__construct();
		$this -> table = 'pages';
	}

	function getPage($slug){
		return $this -> db -> get_where($this -> table, array('slug' => $slug)) -> first_row();
	}
	
	function get_unique_url($url, $id = false){
        $this -> db -> select('slug, id');
        $this -> db -> where('slug', $url);
        $rest = $this -> db -> get($this -> table);
        if($rest -> num_rows() == 0){
            return $url;
        }else{
            $cr = $rest -> first_row();
            if($cr -> id == $id){
                return $url;
            }else{
                $url = $url.'1';
                return $this -> get_unique_url($url, $id);
            }
        }
    }
}
