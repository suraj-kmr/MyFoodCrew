<?php
class AI_Post{
	var $id;
	var $row;
	var $status;
	var $image_src;
	function __construct($id){
		$this -> id = $id;
		$CI =& get_instance();
		$row = $CI -> Post_model -> getRowArray($id, 'post');
		$this -> status = $row['status'];
		$this -> image_src = $row['image'];
		$this -> row = $row;
	}

	function ID(){
		return $this -> id;
	}

	function title(){
		return $this -> row['post_title'];
	}

	function data($key){
		if(isset($this -> row[$key])){
			return $this -> row[$key];
		}else{
			return NULL;
		}
	}

	function hasImage(){
		if(isset($this -> row['image'])){
			return true;
		}else{
			return false;
		}
	}

	function description(){
		return $this -> row['description'];
	}

	function parentName(){
		$parent_id = $this -> row['parent_id'];
		$CI =& get_instance();
		if($this -> isPost()){
			$c = $CI -> Blogcat_model -> getRow($parent_id);
			return $c -> name;
		}else{
			if($parent_id > 0) {
				$p = $CI->Post_model->getRow ($parent_id);
				return $p->post_title;
			}else{
				return 'Top Level Page';
			}
		}

	}

	function isPost(){
		if($this -> row['post_type'] == 'post'){
			return true;
		}else{
			return false;
		}
	}

	function isPage(){
		if($this -> isPost()){
			return false;
		}else{
			return true;
		}
	}

	function excerpt(){
		if($this -> data('excerpt') <> ''){
			return $this -> data('excerpt');
		}else{
			$text = $this -> description();
			$text = strip_tags($text);
			$text = word_limiter($text, 30);
			return $text;
		}
	}

	function metaTitle(){
		return $this -> data('meta_title');
	}

	function metaDescription(){
		return $this -> data('meta_description');
	}

	function metaKeywords(){
		return $this -> data('meta_keywords');
	}

	function permalink(){
		if($this -> isPage())
        {
			$parent = $this -> data('parent_id');
			if($parent == 0){
				$link = site_url($this -> data('slug'));
			}
            else{
				$t = new AI_Post($parent);
				$link = $t -> permalink() .'/'. $this -> data('slug');
			}
		}
        else
        {
			//$parent = $this -> data('parent_id');
			//$cat = new AI_Blogcat($parent);
			$link = site_url() . 'blogs/'. $this -> data('slug'). '-'. $this -> id;
            //$link = '#';
		}
		return $link;
	}

	function image($size = 'sm', $options = array()){
		$str = '<img src="' . base_url(upload_dir($this -> row['image'])) . '" alt="' . $this -> title(). '" title = "' . $this -> title() . '" ' . $this -> __arr_to_str($options) . ' />';
		return $str;
	}

	private function __arr_to_str($arr){
		$str = '';
		foreach($arr as $key => $value){
			$str .= $key . '="' . $value . '" ';
		}
		return $str;
	}

	public static function create($id){
		$p = new AI_Post($id);
		return $p;
	}
}

class AI_Blogcat{
    var $id;
    var $data;
    function __construct($id){
        $this -> id = $id;
        $CI =& get_instance();
        $this -> data = $CI -> Blogcat_model -> getRow($id);
    }

    function ID(){
        return $this -> id;
    }

    function permalink(){
        $link = site_url('/' . $this -> data -> slug . '/' . $this -> ID());
        return $link;
    }

    function title(){
        return $this -> data -> ptitle;
    }

    function image($size = 'sm', $options = array()){
        $str = '<img src="' . $this -> data -> image . '" alt="' . $this -> title(). '" title = "' . $this -> title() . '" ' . $this -> __arr_to_str($options) . ' />';
        return $str;
    }

    private function __arr_to_str($arr){
        $str = '';
        foreach($arr as $key => $value){
            $str .= $key . '="' . $value . '" ';
        }
        return $str;
    }
}